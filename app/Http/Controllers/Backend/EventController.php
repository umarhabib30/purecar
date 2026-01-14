<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{

    public function index()
    {
        $events = Event::orderBy('created_at', 'desc')->paginate(10); 
        return view('/event/list_event', compact('events'));
    }
    public function edit($eventSlug)
    {
        $event = Event::where('slug', $eventSlug)->first();
        if (!$event && is_numeric($eventSlug)) {
            $event = Event::find($eventSlug);
        }
        
        if (!$event) {
            abort(404);
        }
        
        return view('/event/edit_event', compact('event'));
    }

    public function create()
    {
        return view('/event/create_event'); 
    }
   
    public function destroy($eventSlug)
    {
       
        $event = Event::where('slug', $eventSlug)->first();
        
      
        if (!$event && is_numeric($eventSlug)) {
            $event = Event::find($eventSlug);
        }
        
        if (!$event) {
            abort(404);
        }
        
        $event->delete();
    
        return redirect()->back()->with('success', 'Event deleted successfully!');
    }
    public function update(Request $request, $eventSlug)
    {
        $event = Event::where('slug', $eventSlug)->first();
        if (!$event && is_numeric($eventSlug)) {
            $event = Event::find($eventSlug);
        }
        
        if (!$event) {
            abort(404);
        }
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20048',
        'gallery_images' => 'nullable|array',
        'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:200048',
    ]);

    if ($request->hasFile('featured_image')) {
      
        if ($event->featured_image && file_exists(public_path($event->featured_image))) {
            unlink(public_path($event->featured_image));
        }

        $featuredImage = $request->file('featured_image');
        $featuredImageName = Str::random(20) . '.' . $featuredImage->getClientOriginalExtension();
        $featuredImage->move(public_path('images/event'), $featuredImageName);
        $event->featured_image = 'images/event/' . $featuredImageName;
    } elseif ($request->input('remove_featured_image') === 'true') {

        if ($event->featured_image && file_exists(public_path($event->featured_image))) {
            unlink(public_path($event->featured_image));
        }
        $event->featured_image = null;
    }

 
    if ($request->hasFile('gallery_images')) {
        $galleryImagesPaths = $event->gallery_images ?? [];

        foreach ($request->file('gallery_images') as $image) {
            $galleryImageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/event'), $galleryImageName);
            $galleryImagesPaths[] = 'images/event/' . $galleryImageName;
        }

        $event->gallery_images = $galleryImagesPaths;
    }


    if ($request->has('remove_gallery_images')) {
        $galleryImages = $event->gallery_images ?? [];
        $removeImages = $request->input('remove_gallery_images');

        foreach ($removeImages as $imagePath) {
            $fullPath = public_path($imagePath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
            
            $key = array_search($imagePath, $galleryImages);
            if ($key !== false) {
                unset($galleryImages[$key]);
            }
        }

        $event->gallery_images = array_values($galleryImages);
    }

 
    $event->update([
        'title' => $request->title,
        'content' => $request->content,
    ]);

    return redirect()->route('list-event.index')->with('success', 'Event updated successfully!');
}

    public function store(Request $request)
    {
 
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'required|image|mimes:webp,jpeg,png,jpg,gif|max:20048',
            'gallery_images' => 'required|array',
            'gallery_images.*' => 'image|mimes:webp,jpeg,png,jpg,gif|max:200048',
        ]);


        $featuredImage = $request->file('featured_image');
        $featuredImageName = Str::random(20) . '.' . $featuredImage->getClientOriginalExtension();
        $featuredImage->move(public_path('images/event'), $featuredImageName);
        $featuredImagePath = 'images/event/' . $featuredImageName;

  
        $galleryImagesPaths = [];
        foreach ($request->file('gallery_images') as $image) {
            $galleryImageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/event'), $galleryImageName);
            $galleryImagesPaths[] = 'images/event/' . $galleryImageName;
        }

     
        $event = Event::create([
            'title' => $request->title,
            'content' => $request->content,
            'featured_image' => $featuredImagePath,
            'gallery_images' => $galleryImagesPaths,
        ]);

        return redirect()->route('list-event.index', $event->id)->with('success', 'Event updated successfully!');

    }
    public function removeGalleryImage(Request $request, Event $event)
{
    $imageSrc = $request->input('imageSrc');

    $galleryImages = $event->gallery_images ?? [];

    $index = array_search($imageSrc, $galleryImages);

    if ($index !== false) {
       
        unset($galleryImages[$index]);

        $event->gallery_images = array_values($galleryImages);

        $event->save();

       
        if (Storage::exists($imageSrc)) {
            Storage::delete($imageSrc);
        }

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'message' => 'Image not found.']);
}


}
