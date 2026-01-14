<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Advert;
use App\Models\Car;
use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DealerController extends Controller
{
    // public function index($id = null)
    // {
    //     if (!$id) {
    //         return redirect()->route('/')->with('error', 'Dealer not found.');
    //     }
    //     $dealer = User::find($id);
    //     if (!$dealer) {
    //         return redirect()->route('/')->with('error', 'Dealer not found.');
    //     }
        
    //     // $adverts = Advert::where('user_id', $id)->with('advert_images')->get();
    //     $adverts = Advert::where('user_id', $id)
    //     ->where('status', 'active') // Filter only active adverts
    //     ->with('advert_images')
    //     ->latest() 
    //     ->get();
    //     $reviews = Reviews::where('seller_id', $id)->get();
    //     return view('dealer.profile', compact('dealer','adverts', 'reviews'));
    // }
    public function index($slugOrId)
    {
        $dealer = User::where('slug', $slugOrId)->first();
    
        
        if (!$dealer && is_numeric($slugOrId)) {
            $dealer = User::find($slugOrId);
        }
        
        if (!$dealer) {
             return response()->view('errors.dealer_404', [], 404);
        }
        
        $adverts = Advert::where('user_id', $dealer->id)
            ->where('status', 'active')
            ->with('advert_images')
            ->latest()
            ->get();
         $totaladverts = Advert::where('user_id', $dealer->id)
            ->where('status', 'active')
            ->count();
        $soldcars = Advert::where('user_id', $dealer->id)
        ->where('status', 'sold')
        ->with('advert_images')
        ->latest()
        ->take(4)
        ->get();
        $reviews = Reviews::where('seller_id', $dealer->id)->get();
        return view('dealer.profile', compact('dealer', 'adverts', 'reviews', 'soldcars','totaladverts'));
    }
    public function DealerSoldCars($slugOrId)
    {
        $dealer = User::where('slug', $slugOrId)->first();
        
        if (!$dealer && is_numeric($slugOrId)) {
            $dealer = User::find($slugOrId);
        }
        
        if (!$dealer) {
            return response()->view('errors.dealer_404', [], 404);
        }
        $soldcars = Advert::where('user_id', $dealer->id)
            ->where('status', 'sold')
            ->with('advert_images')
            ->latest()
            ->get();
            $countSoldCars = $soldcars->count();
        return view('soldcars.DealerSoldCars', compact('soldcars','countSoldCars'));
    }
    public function submitReview1(Request $request, $dealerId)
    {
        if (!auth()->check()) {
                return redirect()->back()->with('error', 'Login to Review');
            }
    
        Reviews::create([
            'seller_id' => $dealerId,
            'auth_id' => auth()->id(),
            'reviews' => $request->reviews,
            'rating' => $request->rating,
        ]);
    
        return redirect()->back()->with('success', 'Review Added');
    }
    
    
    public function submitReview(Request $request, $dealerId)
{
    $request->validate([
        'reviews' => 'required|string|max:1000',
        'rating' => 'required|integer|min:1|max:5',
        'review_id' => 'nullable|exists:reviews,id'
    ]);
    try {
        if ($request->filled('review_id')) {
            $review = Reviews::findOrFail($request->review_id);
            
            if ($review->auth_id !== auth()->id()) {
                return redirect()->back()->with('error', 'Unauthorized to update this review.');
            }
            
            $review->reviews = $request->reviews;
            $review->rating = $request->rating;
            $review->save();
            return redirect()->back()->with('success', 'Review updated successfully!');
        } else {
            $review = Reviews::create([
                'reviews' => $request->reviews,
                'rating' => $request->rating,
                'dealer_id' => $dealerId,
                'auth_id' => auth()->id() ?? 0,
            ]);
            return redirect()->back()->with('success', 'Review submitted successfully!');
        }
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Error processing review: ' . $e->getMessage())
            ->withInput();
    }
}
    
}
