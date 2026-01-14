<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\advert;
use App\Models\Car;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CarController;
use App\Mail\AdvertCreatedMail;
use App\Mail\AdvertDeletedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\MotData;
use App\Models\VehicleKeeperData;
use Illuminate\Support\Facades\Storage;
use App\Models\Counter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarSoldController extends Controller
{
    public function index()
    {
        $authUser = Auth::user();

        $sold_data = Advert::with('car')
        ->where('user_id', $authUser->id)
        ->where('status', 'sold')
        ->orderBy('created_at', 'desc') 
        ->paginate(1000);
        foreach ($sold_data as $advert) {
            $advert->page_views = DB::table('counters')
                ->where('advert_id', $advert->advert_id)
                ->where('counter_type', 'page_view') 
                ->count(); 
          
            $advert->recover_payment = DB::table('payment_records')
            ->join('packages', 'payment_records.package_id', '=', 'packages.id')
            ->where('payment_records.advert_id', $advert->advert_id)
            ->value('packages.recovery_payment'); 

            $advert->total_favorites = DB::table('favourites')
            ->where('advert_id', $advert->advert_id)
            ->count();
        }

        return view('soldcars/MySolds', compact('sold_data'));
    }

    public function Soldlisting(int $advert_id)
    {
       
        $advert = Advert::where('advert_id', $advert_id)->first();

      
        if (!$advert) {
            return back()->withErrors(['message' => 'Advert not found']);
        }
        $advert->status = 'sold';
        $advert->save();

        return back()->with(['message' => 'Advert marked as sold']);
    }
    public function Reselllisting(int $advert_id)
    {
       
        $advert = Advert::where('advert_id', $advert_id)->first();

      
        if (!$advert) {
            return back()->withErrors(['message' => 'Advert not found']);
        }
        $advert->status = 'active';
        $advert->save();

        return back()->with(['message' => 'Advert placed for sale again']);
    }
    
    
  

    

}

    