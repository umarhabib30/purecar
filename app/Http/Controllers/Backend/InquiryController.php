<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\advert;
use Illuminate\Http\Request;
use App\Models\Counter;
use Illuminate\Support\Facades\Log;
use App\Models\Car;
use App\Models\User;
use App\Models\Inquiry;
use Carbon\Carbon;

class InquiryController extends Controller
{
    public function index(Request $request)
       {
      
              
     $dealers = User::whereHas('adverts')->get();

  
    $dealerId = $request->input('dealer_id');
    $timePeriod = $request->input('time_period', 'all');


    $timeFilter = null;
    switch ($timePeriod) {
        case '24hours':
            $timeFilter = Carbon::now()->subHours(24);
            break;
        case '7days':
            $timeFilter = Carbon::now()->subDays(7);
            break;
        case '1month':
            $timeFilter = Carbon::now()->subMonth();
            break;
        case 'all':
        default:
            $timeFilter = null;
            break;
    }

  
    $inquiriesQuery = Inquiry::with('advert.user', 'advert.car');
  


    if ($dealerId) {
        $inquiriesQuery->whereHas('advert', function ($query) use ($dealerId) {
            $query->where('user_id', $dealerId);
        });
    }


    if ($timeFilter) {
        $inquiriesQuery->where('created_at', '>=', $timeFilter);
     
    }


    $inquiries = $inquiriesQuery->orderBy('created_at', 'desc')->get();
 
    
    $combined = $inquiries->sortByDesc(function ($item) {
        return $item->created_at ?? now();
    });

    $userInquiryCounts = [];
    $advertIds = array_merge(
        $inquiries->pluck('advert_id')->toArray(),
    
    );
    $uniqueAdvertIds = array_unique($advertIds);

    foreach ($uniqueAdvertIds as $advertId) {
        $advert = Advert::find($advertId);
        if ($advert && $advert->user) {
            $userId = $advert->user_id;
            $inquiryCount = $inquiries->where('advert_id', $advertId)->count();
            $userInquiryCounts[$userId] = ($userInquiryCounts[$userId] ?? 0) + $inquiryCount;
        }
    }


    $adminInquiryQuery = Inquiry::with('advert.user', 'advert.car');
    if ($dealerId) {
        $adminInquiryQuery->whereHas('advert', function ($query) use ($dealerId) {
            $query->where('user_id', $dealerId);
        });
    }
    if ($timeFilter) {
        $adminInquiryQuery->where('created_at', '>=', $timeFilter);
    }
    $admininquiry = $adminInquiryQuery->orderBy('created_at', 'desc')->get();
           return view('inquiries.index', compact('admininquiry','dealers'));
       }
}