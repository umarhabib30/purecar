<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{


    
    public function index()
    {
        $event_most_recent_one = Event::latest()->first();
        
        if (!$event_most_recent_one) {
    
            $events = collect();
        } else {
         
            $events = Event::where('id', '!=', $event_most_recent_one->id)
                       ->orderBy('created_at', 'desc') 
                       ->paginate(18);
        }

        return view('/event/event', compact('event_most_recent_one', 'events'));
    }
   

    // public function detail(Event $event)
    // {
    //     $meta_title = $event->title;
    //     $meta_description = Str::limit(strip_tags($event->content), 150);
    //     $meta_image = $event->featured_image 
    //         ? asset('' . $event->featured_image) 
    //         : asset('default-image.png'); 
    //     $meta_type = 'article';
    //     return view('/event/event_detail', compact('event', 'meta_title', 'meta_description', 'meta_image', 'meta_type'));
    // }
    
    public function detail($eventSlug)
    {
        // Try to find by slug first
        $event = Event::where('slug', $eventSlug)->first();
        
        // If not found by slug, try by ID (for backward compatibility)
        if (!$event && is_numeric($eventSlug)) {
            $event = Event::find($eventSlug);
        }
        
        if (!$event) {
            abort(404);
        }
        
        $meta_title = $event->title;
        $meta_description = Str::limit(strip_tags($event->content), 150);
        $meta_image = $event->featured_image 
            ? asset('' . $event->featured_image) 
            : asset('default-image.png'); 
        $meta_type = 'article';
        
        return view('/event/event_detail', compact('event', 'meta_title', 'meta_description', 'meta_image', 'meta_type'));
    }
   
   
}
