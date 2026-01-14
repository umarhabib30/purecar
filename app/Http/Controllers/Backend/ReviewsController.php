<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\PaymentRecord;
use App\Models\User;
use App\Models\Advert_image;
use App\Models\Package;
use App\Models\advert;
use App\Models\Car;
use App\Models\AdvertReview;
use App\Models\Author;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReviewsController extends Controller
{
    public function delete($id)
    {
        $review = Reviews::findOrFail($id); 
        $review->delete(); 
        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
    public function showAllReviews()
    {
        $all_reviews = DB::table('reviews')
            ->leftJoin('users as sellers', 'reviews.seller_id', '=', 'sellers.id') 
            ->leftJoin('users as authors', 'reviews.auth_id', '=', 'authors.id')  
            ->select(
                'reviews.*',              
                'sellers.name as seller_name', 
                'authors.name as author_name'  
            )
            ->get();

        return view('admin_panel_reviews.reviews', compact('all_reviews'));
    }

    public function update(Request $request, $dealerId)
{
    
    $reviewId = $request->review_id;
    
    
    $review = Reviews::findOrFail($reviewId);
    
    
    $review->reviews = $request->reviews;
    $review->rating = $request->rating;
    $review->save();

    
    return redirect()->back()->with('success', 'Review updated successfully!');
}




}
