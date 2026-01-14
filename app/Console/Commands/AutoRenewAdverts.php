<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Advert;
use App\Models\Package;
use App\Models\PaymentRecord;
use App\Models\User;
use Carbon\Carbon;
use Stripe\Stripe;
use Illuminate\Support\Facades\Mail;
use App\Mail\StripeAutoRenewMail;
use Illuminate\Support\Facades\Log;

class AutoRenewAdverts extends Command
{
    protected $signature = 'adverts:auto-renew';
    protected $description = 'Auto renew adverts that are about to expire';

    public function handle()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $adverts = Advert::where('subscription', true)
            
            ->where('expiry_date', '<', Carbon::now())
            ->get();

        $this->info("Found " . $adverts->count() . " adverts to process");

        foreach ($adverts as $advert) {
            $this->info("Checking Advert ID: " . $advert->advert_id);

            try {
              
                $user = User::find($advert->user_id);
                
                if (!$user || !$user->stripe_customer_id) {
                    $this->error("No Stripe customer ID found for user ID: {$advert->user_id}");
                    continue;
                }

               
                $paymentRecord = PaymentRecord::where('advert_id', $advert->advert_id)
                    ->where('user_id', $advert->user_id)
                    ->latest()
                    ->first();

                if (!$paymentRecord) {
                    $this->error("No payment record found for advert ID: {$advert->advert_id}");
                    continue;
                }

                $package = Package::where('id', $paymentRecord->package_id)
                    ->where('recovery_payment', 'yes')
                    ->first();

                if (!$package) {
                    $this->error("No eligible package found for advert ID: {$advert->advert_id}");
                    continue;
                }

            
                $customer = \Stripe\Customer::retrieve($user->stripe_customer_id);

                if (!$customer->default_source) {
                    $this->error("No default payment method found for advert ID: {$advert->advert_id}");
                    continue;
                }

              
                $charge = \Stripe\Charge::create([
                    'amount' => $package->price * 100,
                    'currency' => 'usd',
                    'customer' => $user->stripe_customer_id,
                    'source' => $customer->default_source,
                    'description' => "Auto-renewal for advert ID: " . $advert->advert_id,
                ]);

                if ($charge->status === 'succeeded') {
                  
                    $newPaymentRecord = PaymentRecord::create([
                        'user_id' => $advert->user_id,
                        'package_id' => $package->id,
                        'payment_method' => 'stripe',
                        'amount' => $charge->amount / 100,
                        'email' => $user->email,
                        'name' => $user->name,
                        'stripe_payment_id' => $charge->id,
                        'stripe_customer_id' => $user->stripe_customer_id,
                        'advert_id' => $advert->advert_id,
                        'package_duration' => $package->duration,
                    ]);

                   
                    $packageDuration = (int) $package->duration;
                    $newExpiryDate = Carbon::now()->addDays($packageDuration);
                    
                    $advert->update([
                        'expiry_date' => $newExpiryDate,
                        'status' => 'active',
                    ]);

                 
                    Mail::to($user->email)->send(new StripeAutoRenewMail(
                        $advert->title ?? $advert->name ?? "Advert #" . $advert->advert_id, // Fallback if title/name is null
                        $newExpiryDate,
                        $charge->amount / 100,
                        $package->title ?? $package->name ?? "Package #" . $package->id // Fallback if title/name is null
                    ));

                    $this->info("Successfully renewed advert ID: {$advert->advert_id}");
                   
                }

            } catch (\Exception $e) {
                $this->error("Error processing advert ID {$advert->advert_id}: {$e->getMessage()}");
               
                continue;
            }
        }
    }
}