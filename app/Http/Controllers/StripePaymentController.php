<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Charge;
use Stripe\SetupIntent;
use App\Models\Package;
use App\Models\PaymentRecord;
use App\Models\Advert;
use App\Models\Coupon;
use App\Models\CouponUsage;
use Carbon\Carbon;
use App\Mail\StripeRenewMail;
use App\Mail\SubscriptionCancelMail;
use App\Mail\StripeAdvertPublishedMail;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;

class StripePaymentController extends Controller
{
    public function stripe($packageId)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $package = Package::findOrFail($packageId);
        $setupIntent = SetupIntent::create();
        $userEmail = auth()->user()->email;
        Session::put('package_duration', $package->duration);
        return view('stripe.stripe-payment', [
            'clientSecret' => $setupIntent->client_secret,
            'package' => $package,
            'packagePrice' => $package->price,
            'userEmail' => $userEmail,
        ]);
    }
    public function stripePost(Request $request, $packageId)
{
    $validated = $request->validate([
        'email' => 'required|email',
        'name' => 'required|string',
        'stripeToken' => 'required',
        'coupon_applied' => 'nullable',
        'coupon_code_input' => 'nullable|string',
        'coupon_discount' => 'nullable|numeric',
        'final_price' => 'nullable|numeric'
    ]);

    try {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $package = Package::findOrFail($packageId);
        $duration = $package->duration;
        $user = auth()->user();
        $customer = null;
        $originalPrice = $package->price;
        $finalPrice = $originalPrice;
        $couponCode = null;
        $couponDiscount = 0;
        
        if ($request->coupon_applied == 'true' && $request->coupon_code_input) {
            $coupon = Coupon::where('code', $request->coupon_code_input)->first();
            
       
            
            if ($coupon && 
                (!$coupon->expiry_date || $coupon->expiry_date >= now())) {

                    $couponCode = $coupon->code;
                    $couponDiscount = $request->coupon_discount;
                    $finalPrice = $request->final_price;
                    // setting a session  veriable for facebook coupon 
                    if (strtolower($couponCode) === 'share') {
                        Session::put(['facebook_coupon_used' => 'share']);
                    }
            }
        }
        
       
        if (!$user->stripe_customer_id) {
            $customer = \Stripe\Customer::create([
                'email' => $request->email,
                'name' => $request->name,
                'source' => $request->stripeToken, 
            ]);
        
            $user->stripe_customer_id = $customer->id;
            $user->save();
        } else {
            try {
                $customer = \Stripe\Customer::retrieve($user->stripe_customer_id);
                
                $card = \Stripe\Customer::createSource(
                    $customer->id,
                    ['source' => $request->stripeToken]
                );
                
                $customer = \Stripe\Customer::retrieve($user->stripe_customer_id);
            } catch (\Exception $e) {
                $customer = \Stripe\Customer::create([
                    'email' => $request->email,
                    'name' => $request->name,
                    'source' => $request->stripeToken, 
                ]);
                
                $user->stripe_customer_id = $customer->id;
                $user->save();
            }
        }
       
            if ($finalPrice <= 0) {
              
                $paymentRecord = PaymentRecord::create([
                    'user_id' => $user->id,
                    'package_id' => $package->id,
                    'payment_method' => 'coupon',
                    'amount' => 0,
                    'original_amount' => $originalPrice,
                    'discount_amount' => $couponDiscount,
                    'coupon_code' => $couponCode,
                    'email' => $request->email,
                    'name' => $request->name,
                    'stripe_payment_id' => 'free-' . uniqid(), 
                    'stripe_customer_id' => $user->stripe_customer_id ?? null, 
                    'package_duration' => $duration,
                ]);
                if ($coupon) {
                    CouponUsage::create([
                        'user_id' => $user->id,
                        'coupon_id' => $coupon->id,
                    ]);
                    Coupon::where('id', $coupon->id)->increment('used_count');
                }
                
                Session::flash('success', 'Your package has been activated with 100% discount');
                Session::put('payment_id', $paymentRecord->id);
                
              
                return back();
            }
        $charge = \Stripe\Charge::create([
            'amount' => round($finalPrice * 100),
            'currency' => 'gbp',
            'customer' => $customer->id,
            'description' => "Payment for package: " . $package->name,
            'metadata' => [
                'user_id' => $user->id,
                'package_id' => $package->id,
                'package_name' => $package->name,
                'coupon_code' => $couponCode,
                'discount_amount' => $couponDiscount,
                'original_price' => $originalPrice
            ]
        ]);

     
        $paymentRecord = PaymentRecord::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'payment_method' => 'stripe',
            'amount' => $finalPrice,
            'original_amount' => $originalPrice,
            'discount_amount' => $couponDiscount,
            'coupon_code' => $couponCode,
            'email' => $request->email,
            'name' => $request->name,
            'stripe_payment_id' => $charge->id,
            'stripe_customer_id' => $customer->id,
            'package_duration' => $duration,
        ]);
        
      
        if (isset($couponId) && $couponCode) {
            CouponUsage::create([
                'user_id' => $user->id,
                'coupon_id' => $couponId,
            ]);
            
         
            Coupon::where('id', $couponId)->increment('used_count');
        }
        
        Session::flash('success', 'Your Payment was Successful');
        Session::put('payment_id', $paymentRecord->id);
        
        

        return back();
            
        } catch (\Stripe\Exception\CardException $e) {
        
          
            
            $declineCode = $e->getDeclineCode();
            $errorMessage = $this->getCardErrorMessage($declineCode, $e->getMessage());
            
            Session::flash('error', $errorMessage);
            return back()->withInput();
        } catch (\Stripe\Exception\RateLimitException $e) {
           
            Session::flash('error', 'Payment system busy. Please try again later.');
            return back()->withInput();
        } catch (\Stripe\Exception\InvalidRequestException $e) {
           
            Session::flash('error', 'Please check your information and try again.');
            return back()->withInput();
        } catch (\Stripe\Exception\AuthenticationException $e) {
            
            Session::flash('error', 'Payment system error. Please contact support.');
            return back()->withInput();
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            
            Session::flash('error', 'Network error. Please try again.');
            return back()->withInput();
        } catch (\Stripe\Exception\ApiErrorException $e) {
           
            Session::flash('error', 'Payment processing error. Please try again or contact support.');
            return back()->withInput();
        } catch (\Exception $e) {
            
            Session::flash('error', 'An error occurred during payment processing. Please try again or contact support.');
            return back()->withInput();
        }
    }
    


    private function getCardErrorMessage($declineCode, $defaultMessage)
    {
        switch ($declineCode) {
            case 'incorrect_cvc':
                return 'CVC Code Is Wrong';
            case 'expired_card':
                return 'Card Expired.';
            case 'card_declined':
                return 'Card Declined';
            case 'insufficient_funds':
                return 'Insufficient Funds';
            case 'invalid_number':
                return 'Invalid Card Number';
            case 'processing_error':
                return 'Please Try Again';
            case 'invalid_expiry_month':
                return 'The card\'s expiration month is invalid.';
            case 'invalid_expiry_year':
                return 'The card\'s expiration year is invalid.';
            case 'incorrect_number':
                return 'The card number is incorrect.';
            case 'incorrect_zip':
                return 'The card\'s ZIP code failed validation.';
            case 'authentication_required':
                return 'The card requires authentication. Please try again and follow the authentication steps.';
            case 'approve_with_id':
                return 'The payment cannot be authorized. Please contact your card issuer for more information.';
            case 'call_issuer':
                return 'The card has been declined. Please contact your card issuer for more information.';
            case 'do_not_honor':
                return 'The card issuer declined this transaction. Please try another payment method.';
            case 'do_not_try_again':
                return 'Your card was declined';
            case 'generic_decline':
                return 'Your card was declined';
            case 'fraudulent':
                return 'This transaction has been flagged as potentially fraudulent. Please try a different payment method.';
            case 'lost_card':
            case 'stolen_card':
                return 'This card has been reported lost or stolen and cannot be used.';
            case 'pickup_card':
                return 'This card cannot be used for this transaction. Please try a different card.';
            case 'try_again_later':
                return 'Your card was declined';
            default:
                return 'Payment failed: ' . $defaultMessage;
        }
    }

    public function stripeRenew(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentRecord = PaymentRecord::where('advert_id', $request->advert_id)
                                    ->where('user_id', auth()->user()->id)
                                    

                                    ->first();

        if ($paymentRecord) {
            $package = Package::find($paymentRecord->package_id);
            
            if ($package) {
                try {
                    $user = auth()->user();
                    $customer = \Stripe\Customer::retrieve($user->stripe_customer_id);

                    if (!$customer->default_source) {
                        Session::flash('error', 'No default payment method found for the customer.');
                        return back();
                    }

                    $paymentIntent = \Stripe\PaymentIntent::create([
                        'amount' => $package->price * 100,
                        'currency' => 'gbp',
                        'customer' => $customer->id,
                        'payment_method' => $customer->default_source,
                        'off_session' => true,
                        'confirm' => true,
                    ]);
                    if ($paymentIntent->status == 'succeeded') {
                        $paymentRecord = PaymentRecord::create([
                            'user_id' => $user->id,
                            'package_id' => $package->id,
                            'payment_method' => 'stripe',
                            'amount' => $paymentIntent->amount_received / 100,
                            'email' => $user->email,
                            'name' => $user->name,
                            'stripe_payment_id' => $paymentIntent->id,
                            'stripe_customer_id' => $customer->id,
                            'advert_id' => $request->advert_id,
                        ]);
                    $packageDuration = (int) $package->duration;
                    $newExpiryDate = now()->addDays($packageDuration);
                 
                    $advert = Advert::where('advert_id', $request->advert_id)->first();
                    $advert->update([
                        'expiry_date' => $newExpiryDate,
                        'status' => 'active',
                        'subscription'=>true,
                    ]);
                       
                        Mail::to($user->email)->send(new StripeRenewMail(
                            $advert->name, 
                            $newExpiryDate, 
                            $paymentIntent->amount_received / 100, 
                            $package->title
                        ));
                        Session::flash('success', 'Payment successful!');
                        return redirect()->route('some.route');
                    } else {
                        Session::flash('error', 'Payment failed. Please try again.');
                        return back();
                    }

                } catch (\Exception $e) {
                    Session::flash('error', 'An error occurred: ' . $e->getMessage());
                    return back();
                }
            }
        }
        Session::flash('error', 'Payment record not found!');
        return back();
    }
    public function autoRenewPayment(Request $request)
    {
        $advertId = $request->advert_id;
        $paymentRecord = PaymentRecord::where('advert_id', $advertId)
            ->where('user_id', auth()->user()->id)
            ->first();
        if ($paymentRecord) {
            $package = Package::where('id', $paymentRecord->package_id)
                ->where('recovery_payment', 'yes') 
                ->first();

            if ($package) {
                return $this->stripeRenew($request);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Recovery payment not enabled or payment record/package not found.',
        ]);
    }
    public function cancelSubscription(Request $request)
    {
        $advertId = $request->input('advert_id');

        $advert = Advert::where('advert_id', $advertId)
                        ->where('user_id', auth()->id())
                        ->first();
        if ($advert) {
            $advert->update([
                'status' => 'inactive',
                'expiry_date' => Carbon::now()->subDays(365),
                'subscription'=>false,
            ]);
            Mail::to(auth()->user()->email)->send(new SubscriptionCancelMail(
                $advert->name,
                now() 
            ));
            return redirect()->back();
        }

        return response()->json([
            'success' => false,
            'message' => 'Advert not found or you do not have permission to cancel it.',
        ]);
    }



}