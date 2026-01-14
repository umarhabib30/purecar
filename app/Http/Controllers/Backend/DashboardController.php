<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\advert;
use App\Models\Reviews;
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
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{

    public function index()
    {
        $title = 'Dashboard';

        $user_id = auth()->user()->id;
        $user_slug = auth()->user()->slug;

        $counters = Counter::whereHas('advert', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->get();

        $activities_statistics =Counter::whereIn('counter_type', ['call', 'text', 'emailsu'])
            ->where('created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->where('created_at', '<=', Carbon::now()->endOfMonth())
            ->get();


            $page_views = Counter::whereIn('counter_type', ['page_view'])
            ->where('created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->where('created_at', '<=', Carbon::now()->endOfMonth())
            ->whereHas('advert', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })
            ->get();

            $advertname = Advert::where('user_id', $user_id)
            ->with(['car' => function ($query) {
                $query->select('advert_id', 'make', 'model', 'year'); 
            }])
            ->get(['advert_id', 'name']);
            

        $ads_published = advert::where('user_id', $user_id)
        ->where('status', '=' ,'active')
        ->count();
        $favorite_ads = \DB::table('favourites')
        ->where('user', $user_id)
        ->where('favourite', 1)
        ->count();
        $total_reviews = Reviews::where('seller_id', $user_id)->count();
        $total_forum_posts = ForumTopicReply::where('auth_id', $user_id)->count();
        $total_topic_started = ForumPost::where('user_id', $user_id)
        ->distinct('forum_topic_category_id')
        ->count();
        
        $past_forum_posts = ForumTopicReply::where('auth_id', $user_id)
        ->where('created_at', '>=', now()->subDays(7))
        ->count();
        $past_topic_started = ForumPost::where('user_id', $user_id)
        ->distinct('forum_topic_category_id')
        ->where('created_at', '>=', now()->subDays(7))
        ->count();

        
        $forum_posts_percentage = 0;
        if ($past_forum_posts > 0) {
        $forum_posts_percentage = (($total_forum_posts - $past_forum_posts) / $past_forum_posts) * 100;
        }

        
        $topic_started_percentage = 0;
        if ($past_topic_started > 0) {
        $topic_started_percentage = (($total_topic_started - $past_topic_started) / $past_topic_started) * 100;
        }

        
        $forum_graph_class = $forum_posts_percentage >= 0 ? 'growth' : 'decline';
        $forum_graph_icon = $forum_posts_percentage >= 0 ? 'Arrow-gr.png' : 'Arrow-red.png';
        $forum_graph_image = $forum_posts_percentage >= 0 ? 'Graph-gr.png' : 'Graph-red.png';
        $forum_percentage = number_format(abs($forum_posts_percentage), 2) . '%';

        $topic_graph_class = $topic_started_percentage >= 0 ? 'growth' : 'decline';
        $topic_graph_icon = $topic_started_percentage >= 0 ? 'Arrow-gr.png' : 'Arrow-red.png';
        $topic_graph_image = $topic_started_percentage >= 0 ? 'Graph-gr.png' : 'Graph-red.png';
        $topic_percentage = number_format(abs($topic_started_percentage), 2) . '%';






        $user = User::find($user_id);
        $role = $user->role;
        $email = $user->email;
        $email_verified_at = $user->email_verified_at;
        $forum_activities = \DB::table('forum_topic_replies')
        ->join('forum_posts', 'forum_topic_replies.forum_post_id', '=', 'forum_posts.id') 
        ->join('users', 'forum_topic_replies.auth_id', '=', 'users.id')
        ->where('forum_posts.user_id', $user_id) 
        ->where('forum_topic_replies.auth_id', '!=', $user_id) 
        ->select(
            'forum_topic_replies.created_at',
            'users.name as replier_name',
            'forum_posts.content as topic_title',  
            'forum_posts.slug as post_slug',  
            'forum_posts.id as post_id',
            \DB::raw("'forum_reply' as activity_type")
        )
        ->get();


      

            
            $expiredAds = Advert::where('user_id', $user_id) 
            ->where('expiry_date', '<', now()) 
            ->join('cars', 'adverts.advert_id', '=', 'cars.advert_id') 
            ->select(
                'adverts.created_at',
                'adverts.name',
                'adverts.advert_id',
                'adverts.expiry_date', 
                'cars.make as car_make',
                'cars.model as car_model',
                'cars.year as car_year',
                'cars.slug as car_slug', 
                'cars.car_id',
                \DB::raw("'adexpired' as activity_type")
            )
            ->get();
        
        $ads = Advert::where('user_id', $user_id)
        ->join('cars', 'adverts.advert_id', '=', 'cars.advert_id') 
        ->select(
            'adverts.created_at', 
            'adverts.name', 
            'adverts.advert_id', 
            'cars.make as car_make', 
            'cars.model as car_model', 
            'cars.year as car_year', 
            'cars.slug as car_slug', 
            'cars.car_id', 
            \DB::raw("'ad' as activity_type") 
        )
        ->get();

        
        $favorited_by_users = \DB::table('favourites')
            ->join('adverts', 'favourites.advert_id', '=', 'adverts.advert_id')
            ->join('users', 'favourites.user', '=', 'users.id')
            ->join('cars', 'favourites.advert_id', '=', 'cars.advert_id')
            ->where('adverts.user_id', $user_id)
            ->select(
                'favourites.created_at',
                'users.name as user_name',
                'cars.make as car_make',
                'cars.model as car_model',
                'cars.year as car_year',
                'cars.slug as car_slug', 
                'cars.car_id',
                \DB::raw("'favorite' as activity_type")
            )->get();

        
        $reviews = \DB::table('reviews')
            ->join('users', 'reviews.auth_id', '=', 'users.id')
            ->where('reviews.seller_id', $user_id)
            ->select(
                'reviews.created_at',
                'reviews.reviews as review_content',
                'reviews.seller_id as review_seller_id',
                'users.name as reviewer_name',
                'users.id as user_id',
                'users.slug as user_slug',
                \DB::raw("'review' as activity_type")
            )->get();
           

        
        $all_activities = collect()
            ->concat($forum_activities)
            
            ->concat($expiredAds)
            ->concat($ads)
            ->concat($favorited_by_users)
            ->concat($reviews)
            ->sortByDesc('created_at');

        
            
            return view('dashboard', compact(
            
                'all_activities',
                'title',
                'ads_published',
                'favorite_ads',
                'total_reviews',
                'total_forum_posts',
                'total_topic_started',
                'counters',
                'activities_statistics',
                'page_views',
                'role',
                'user_id',
                'user_slug',
                'email_verified_at',
                'email',
                'forum_posts_percentage',
                'topic_started_percentage',
                'forum_graph_class',
                'forum_graph_icon',
                'forum_graph_image',
                'forum_percentage',
                'topic_graph_class',
                'topic_graph_icon',
                'topic_graph_image',
                'topic_percentage',
                'advertname',
                
            ));
            
    }
    public function fetchPageViews($advert_id)
{
    $page_views = Counter::where('counter_type', 'page_view')
        ->where('created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
        ->where('created_at', '<=', Carbon::now()->endOfMonth())
        ->whereHas('advert', function ($query) use ($advert_id) {
            $query->where('advert_id', $advert_id);
        })
        ->get();

    return response()->json($page_views);
}
public function getDailyCounters(Request $request)
{
    $advertId = $request->query('advert_id');
    
    if (!$advertId) {
        return response()->json([
            'error' => 'Advert ID is required'
        ], 400);
    }

    $counters = Counter::where('advert_id', $advertId)->get();

    
    $callsData = [];
    $textsData = [];
    $emailsData = [];
    $days = [];

    for ($i = 13; $i >= 0; $i--) {
        $dayStart = now()->subDays($i)->startOfDay();
        $dayEnd = now()->subDays($i)->endOfDay();

        $callsData[] = $counters->where('counter_type', 'call')
            ->whereBetween('created_at', [$dayStart, $dayEnd])
            ->count();

        $textsData[] = $counters->where('counter_type', 'text')
            ->whereBetween('created_at', [$dayStart, $dayEnd])
            ->count();

        $emailsData[] = $counters->where('counter_type', 'emailsu')
            ->whereBetween('created_at', [$dayStart, $dayEnd])
            ->count();

        $days[] = $dayStart->format('Y-m-d'); 
    }

    return response()->json([
        'calls' => $callsData,
        'texts' => $textsData,
        'emails' => $emailsData,
    ]);
}
public function getAllDailyCounters()
{
 
    $userId = auth()->id();
    
    $counters = Counter::whereHas('advert', function($query) use ($userId) {
        $query->where('user_id', $userId);
    })->get();
    
    $callsData = [];
    $textsData = [];
    $emailsData = [];

    for ($i = 13; $i >= 0; $i--) {
        $dayStart = now()->subDays($i)->startOfDay();
        $dayEnd = now()->subDays($i)->endOfDay();

        $callsData[] = $counters->where('counter_type', 'call')
            ->whereBetween('created_at', [$dayStart, $dayEnd])
            ->count();

        $textsData[] = $counters->where('counter_type', 'text')
            ->whereBetween('created_at', [$dayStart, $dayEnd])
            ->count();

        $emailsData[] = $counters->where('counter_type', 'emailsu')
            ->whereBetween('created_at', [$dayStart, $dayEnd])
            ->count();
    }

    return response()->json([
        'calls' => $callsData,
        'texts' => $textsData,
        'emails' => $emailsData,
    ]);
}

public function fetchAllPageViews()
{
  
    $userId = auth()->id();

    $page_views = Counter::where('counter_type', 'page_view')
        ->where('created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
        ->where('created_at', '<=', Carbon::now()->endOfMonth())
        ->whereHas('advert', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->get();

    return response()->json($page_views);
}

}
