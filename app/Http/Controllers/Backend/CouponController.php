<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponUsage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{

    public function index()
    {
        $coupons = Coupon::all();
        return view('coupon.list', compact('coupons'));
    }
    public function create()
    {

        return view('coupon.create_coupon');
    }
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('coupon.update_coupon', compact('coupon')); 
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons',
            'discount' => 'required|numeric',
            'type' => 'required|in:fixed,percentage',
            'usage_limit' => 'nullable|integer',
            'expiry_date' => 'nullable|date',
        ]);

        Coupon::create($request->all());

        return redirect()->route('coupons.index')->with('success', 'Coupon created successfully.');

    }
    public function update(Request $request, $id) {
        $request->validate([
            'code' => 'required|string|unique:coupons,code,'.$id,
            'discount' => 'required|numeric|min:0',
            'type' => 'required|in:fixed,percentage',
            'usage_limit' => 'nullable|integer|min:1',
            'expiry_date' => 'nullable|date|after_or_equal:today',
        ]);
    
        $coupon = Coupon::findOrFail($id);
        $coupon->update($request->all());
    
        return redirect()->route('coupons.index')->with('success', 'Coupon updated successfully.');
    }
    
    public function destroy($id)
    {
        Coupon::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Coupon deleted successfully!');
    }
    public function applyCoupon(Request $request)
{
    $user = Auth::user();
    $coupon = Coupon::where('code', $request->coupon_code)->first();

    if (!$coupon) {
        return response()->json(['success' => false, 'message' => 'Invalid coupon code.']);
    }

    if ($coupon->expiry_date && $coupon->expiry_date < now()) {
        return response()->json(['success' => false, 'message' => 'Coupon has expired.']);
    }


  
    $userCouponUsageCount = CouponUsage::where('user_id', $user->id)
    ->where('coupon_id', $coupon->id)
    ->count();
    if ($coupon->usage_limit !== null && $userCouponUsageCount >= $coupon->usage_limit) {
        return response()->json(['success' => false, 'message' => 'You have reached the usage limit for this coupon.']);
    }

    CouponUsage::create([
        'user_id' => $user->id,
        'coupon_id' => $coupon->id,
    ]);
    $coupon->increment('used_count');

    return response()->json([
        'success' => true,
        'type' => $coupon->type,
        'discount' => $coupon->discount,
        'message' => 'Coupon applied successfully!',
    ]);
}



   
}
