<?php

namespace App\Http\Controllers;

use App\Models\advert;
use App\Models\Favourite;
use App\Models\Counter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavouriteController extends Controller
{
   

    // public function showFavourite()
    // {
    //     // Get the currently authenticated user
    //     $authUser = Auth::user();
    
    //     $favourite_data = Advert::join('favourites', 'adverts.advert_id', '=', 'favourites.advert_id')
    //         ->join('users', 'adverts.user_id', '=', 'users.id')
    //         ->join('cars', 'adverts.advert_id', '=', 'cars.advert_id')
    //         ->where('favourites.user', $authUser->id)
    //         ->where('favourites.favourite', 1)
    //         ->select('adverts.*', 'users.location', 'cars.*')
    //         ->get();
    

          
    //     // Pass the data to the view
    //     return view('MyFavoritePage', compact('favourite_data'));
    // }
    // public function showFavourite()
    // {
    //     // Get the currently authenticated user
    //     $authUser = Auth::user();
    
    //     $favourite_data = Advert::join('favourites', 'adverts.advert_id', '=', 'favourites.advert_id')
    //         ->join('users', 'adverts.user_id', '=', 'users.id')
            
    //         ->join('cars', 'adverts.advert_id', '=', 'cars.advert_id')
    //         ->leftJoin('counters', 'adverts.advert_id', '=', 'counters.advert_id') // Add counters table
    //         ->where('favourites.user', $authUser->id)
    //         ->where('favourites.favourite', 1)
    //         ->select(

                
    //             'adverts.advert_id',
    //             'adverts.user_id',
    //             'adverts.image',
    //             'adverts.created_at',
    //             'users.location',
    //             'cars.model',
    //             'cars.make',
    //             'cars.variant',
    //             DB::raw("SUM(CASE WHEN counters.counter_type IN ('call', 'email') THEN 1 ELSE 0 END) as total_calls_and_emails"),                DB::raw("SUM(CASE WHEN counters.counter_type = 'email' THEN 1 ELSE 0 END) as total_emails"),
    //             DB::raw("SUM(CASE WHEN counters.counter_type = 'text' THEN 1 ELSE 0 END) as total_texts"),
    //             DB::raw("SUM(CASE WHEN counters.counter_type = 'page_view' THEN 1 ELSE 0 END) as total_ad_views")
    //         )
    //         ->groupBy(
    //             'adverts.advert_id', 
    //             'adverts.user_id', 
    //             'adverts.created_at',
    //             'adverts.image',
    //             'users.location', 
    //             'cars.model',
    //             'cars.make',
    //             'cars.variant',
    //         )
    //         ->get();
    
    //     // Pass the data to the view
    //     return view('MyFavoritePage', compact('favourite_data'));
    // }
    

    public function showFavourite()
    {
 
        $authUser = Auth::user();
    
        $favourite_data = Advert::join('favourites', 'adverts.advert_id', '=', 'favourites.advert_id')
            ->join('users', 'adverts.user_id', '=', 'users.id')
            ->join('cars', 'adverts.advert_id', '=', 'cars.advert_id')
            ->leftJoin('counters', 'adverts.advert_id', '=', 'counters.advert_id') 
            ->where('favourites.user', $authUser->id)
            ->where('favourites.favourite', 1) 
            ->select(
                'adverts.advert_id',
                'adverts.user_id',
                'adverts.image',
                'adverts.created_at',
                'users.location',
                'cars.model',
                'cars.make',
                'cars.variant',
                DB::raw("SUM(CASE WHEN counters.counter_type IN ('call', 'email') THEN 1 ELSE 0 END) as total_calls_and_emails"),
                DB::raw("SUM(CASE WHEN counters.counter_type = 'email' THEN 1 ELSE 0 END) as total_emails"),
                DB::raw("SUM(CASE WHEN counters.counter_type = 'text' THEN 1 ELSE 0 END) as total_texts"),
                DB::raw("SUM(CASE WHEN counters.counter_type = 'page_view' THEN 1 ELSE 0 END) as total_ad_views"),
                DB::raw("(SELECT COUNT(*) FROM favourites WHERE favourites.advert_id = adverts.advert_id AND favourites.favourite = 1) as total_favorites") // Count only where favourite = 1
            )
            ->groupBy(
                'adverts.advert_id',
                'adverts.user_id',
                'adverts.created_at',
                'adverts.image',
                'users.location',
                'cars.model',
                'cars.make',
                'cars.variant'
            )
            ->get();
    
      
        return view('MyFavoritePage', compact('favourite_data'));
    }
    


        public function toggleFavourite(Request $request)
        {
            try {
                $userId = $request->user_id;
                $advertId = $request->advert_id;

                $favourite = Favourite::where('user', $userId)
                    ->where('advert_id', $advertId)
                    ->first();

                if ($favourite) {
                    if ($favourite->favourite == 1) {
                        $favourite->favourite = 0;
                        $message = 'Removed from favourites';
                        $action = 'removed';
                    } else {
                        $favourite->favourite = 1;
                        $message = 'Added to favourites';
                        $action = 'added';
                    }
                    $favourite->save();
                } else {
                    Favourite::create([
                        'user' => $userId,
                        'advert_id' => $advertId,
                        'favourite' => 1,
                    ]);
                    $message = 'Added to favorites';
                    $action = 'added';
                }

                return response()->json([
                    'success' => true,
                    'action' => $action,
                    'message' => $message
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating favorite status'
                ], 500);
            }
        }

        public function deleteFavourite($advertId)
        {
            $userId = Auth::id();
            $favourite = Favourite::where('user', $userId)
                ->where('advert_id', $advertId)
                ->first();

            if ($favourite) {
                $favourite->delete();
                return redirect()->back()->with('success', 'Favourite listing deleted successfully!');
            }

            return redirect()->back()->with('error', 'Favourite listing not found!');
        }

}
