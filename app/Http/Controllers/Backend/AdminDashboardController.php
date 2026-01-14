<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
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
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogTag;
use App\Models\Counter;
use App\Models\ForumPost;
use App\Models\ForumTopic;
use App\Models\ForumTopicReply;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Inquiry;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $timeRange = $request->input('timeRange', '24_hours');
        
        $query = match($timeRange) {
            '24_hours' => Carbon::now()->subHours(24),
            '7_days' => Carbon::now()->subDays(7),
            '1_month' => Carbon::now()->subMonth(),
            'all_time' => null,
        };

        $baseQuery = function ($model) use ($query) {
            return $query ? $model->where('created_at', '>=', $query) : $model;
        };


        $data = [
            'ads_published' => $baseQuery(new Advert)->count(),
            'ads_expired' => $this->getExpiredAdsCount($query),
            'total_users' => $baseQuery(new User)->where('role', '!=', 'admin')->count(),
            'total_forum_posts' => $baseQuery(new ForumTopicReply)->count(),
            'total_topic_started' => $baseQuery(new ForumPost)->count(),
            'total_payments' => $baseQuery(new PaymentRecord)->count(),
            'total_amount' => $baseQuery(new PaymentRecord)->sum('amount'),
            'total_dealers' => $baseQuery(new User)->where('role', 'car_dealer')->count(),
            'total_private' => $baseQuery(new User)->where('role', 'private_seller')->count(),
            'total_enquiries' => $this->getTotalEnquiries($query),
            'total_whatsapp_call_enquiries' => $this->getTotalWhatsappCallEnquiries($query),
            'total_emails_enquiries' => $this-> getTotalEmailEnquiries($query),
            'total_email_enquiries' => $this-> getTotalEmailsEnquiries($query),
           
            
        ];
        $data['paymentChartData'] = $this->getPaymentChartData($timeRange);
        $data['monthlyTrendData'] = $this->getMonthlyTrendData($timeRange);
       
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
    $countersQuery = Counter::with('advert.user', 'advert.car')
        ->whereIn('counter_type', ['text', 'call']);

    if ($dealerId) {
        $inquiriesQuery->whereHas('advert', function ($query) use ($dealerId) {
            $query->where('user_id', $dealerId);
        });
        $countersQuery->whereHas('advert', function ($query) use ($dealerId) {
            $query->where('user_id', $dealerId);
        });
    }

    if ($timeFilter) {
        $inquiriesQuery->where('created_at', '>=', $timeFilter);
        $countersQuery->where('created_at', '>=', $timeFilter);
    }

    $inquiries = $inquiriesQuery->orderBy('created_at', 'desc')->get();
    $counters = $countersQuery->orderBy('created_at', 'desc')->get();
    
    $combined = $inquiries->merge($counters)->sortByDesc(function ($item) {
        return $item->created_at ?? now();
    });

    $userInquiryCounts = [];
    $advertIds = array_merge(
        $inquiries->pluck('advert_id')->toArray(),
        $counters->pluck('advert_id')->toArray()
    );
    $uniqueAdvertIds = array_unique($advertIds);

    foreach ($uniqueAdvertIds as $advertId) {
        $advert = Advert::find($advertId);
        if ($advert && $advert->user) {
            $userId = $advert->user_id;
            $inquiryCount = $inquiries->where('advert_id', $advertId)->count();
            $counterCount = $counters->where('advert_id', $advertId)->count();
            $userInquiryCounts[$userId] = ($userInquiryCounts[$userId] ?? 0) + $inquiryCount + $counterCount;
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
        return view('admin_dashboard.dashboard', $data, compact('timeRange','combined','userInquiryCounts','admininquiry','dealers'));
    }

    private function getExpiredAdsCount($query)
    {
        $advertQuery = Advert::where('expiry_date', '<', Carbon::now());

        if ($query) {
            $advertQuery->where('expiry_date', '>=', $query);
        }

        return $advertQuery->count();
    }

    private function getTotalEnquiries($query)
    {
        return [
            'call' => Counter::where('counter_type', 'call')
                ->when($query, function($q) use ($query) {
                    return $q->where('created_at', '>=', $query);
                })
                ->count(),
            'text' => Counter::where('counter_type', 'text')
                ->when($query, function($q) use ($query) {
                    return $q->where('created_at', '>=', $query);
                })
                ->count(),
            'email' => Counter::where('counter_type', 'email')
                ->when($query, function($q) use ($query) {
                    return $q->where('created_at', '>=', $query);
                })
                ->count(),
            'total' => Counter::whereIn('counter_type', ['call', 'text', 'email'])
                ->when($query, function($q) use ($query) {
                    return $q->where('created_at', '>=', $query);
                })
                ->count()
        ];
    }
    private function getTotalWhatsappCallEnquiries($query)
    {
        return [
            'call' => Counter::where('counter_type', 'call')
                ->when($query, function($q) use ($query) {
                    return $q->where('created_at', '>=', $query);
                })
                ->count(),
            'text' => Counter::where('counter_type', 'text')
                ->when($query, function($q) use ($query) {
                    return $q->where('created_at', '>=', $query);
                })
                ->count(),
            
            'total' => Counter::whereIn('counter_type', ['call', 'text'])
                ->when($query, function($q) use ($query) {
                    return $q->where('created_at', '>=', $query);
                })
                ->count()
        ];
    }
    private function getTotalEmailEnquiries($query)
    {
        return [
          
            'emailsu' => Counter::where('counter_type', 'emailsu')
            ->when($query, function($q) use ($query) {
                return $q->where('created_at', '>=', $query);
            })
            ->count(),
            
            'total' => Counter::whereIn('counter_type', ['emailsu'])
                ->when($query, function($q) use ($query) {
                    return $q->where('created_at', '>=', $query);
                })
                ->count()
        ];
    }
    private function getTotalEmailsEnquiries($query)
    {
        return [
          
            'email' => Counter::where('counter_type', 'email')
            ->when($query, function($q) use ($query) {
                return $q->where('created_at', '>=', $query);
            })
            ->count(),
            
            'total' => Counter::whereIn('counter_type', ['email'])
                ->when($query, function($q) use ($query) {
                    return $q->where('created_at', '>=', $query);
                })
                ->count()
        ];
    }

    private function getPaymentChartData($timeRange)
    {
        $period = $this->getChartPeriod($timeRange);
        $labels = [];
        $revenue = [];
        $paymentCount = [];

        foreach ($period as $date) {
      
            $carbonDate = $date instanceof Carbon ? $date : Carbon::instance($date);
            
            $dayString = $carbonDate->format('M d');
            $labels[] = $dayString;

            $startDate = Carbon::parse($carbonDate->format('Y-m-d')." 00:00:00");
            $endDate = Carbon::parse($carbonDate->format('Y-m-d')." 23:59:59");

      
            $dayRevenue = PaymentRecord::whereBetween('created_at', [$startDate, $endDate])
                ->sum('amount');
            
            $dayCount = PaymentRecord::whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $revenue[] = $dayRevenue;
            $paymentCount[] = $dayCount;
        }

        return [
            'labels' => $labels,
            'revenue' => $revenue,
            'count' => $paymentCount
        ];
    }

    private function getMonthlyTrendData($timeRange)
    {
      
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subMonths(5)->startOfMonth();
        
        $period = new \DatePeriod(
            $startDate,
            new \DateInterval('P1M'),
            $endDate
        );

        $labels = [];
        $userData = [];
        $advertData = [];
        $revenueData = [];

        foreach ($period as $date) {
      
            $carbonDate = Carbon::instance($date);
            $monthLabel = $carbonDate->format('M Y');
            $labels[] = $monthLabel;
            
            $monthStart = Carbon::parse($carbonDate->format('Y-m-01'));
            $monthEnd = Carbon::parse($carbonDate->format('Y-m-t'));

            $userData[] = User::where('role', '!=', 'admin')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();


            $advertData[] = Advert::whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();

            $revenueData[] = PaymentRecord::whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('amount');
        }

        return [
            'labels' => $labels,
            'users' => $userData,
            'adverts' => $advertData,
            'revenue' => $revenueData,
        ];
    }

    private function getChartPeriod($timeRange)
    {
        $endDate = Carbon::now();
        
        $startDate = match($timeRange) {
            '24_hours' => Carbon::now()->subHours(24),
            '7_days' => Carbon::now()->subDays(7),
            '1_month' => Carbon::now()->subDays(30),
            'all_time' => Carbon::now()->subMonths(6),
        };

        $interval = match($timeRange) {
            '24_hours' => 'PT4H', 
            '7_days' => 'P1D',   
            '1_month' => 'P3D',  
            'all_time' => 'P1M',  
        };

        return new \DatePeriod(
            $startDate,
            new \DateInterval($interval),
            $endDate
        );
    }
}