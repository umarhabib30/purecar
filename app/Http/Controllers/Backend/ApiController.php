<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserFeedSource;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
        // Get users with each source type
        $apiusers = User::whereHas('feedSources', function($q) {
            $q->where('source_type', 'api');
        })->with(['feedSources' => function($q) {
            $q->where('source_type', 'api');
        }])->get();

        $clickdealers = User::whereHas('feedSources', function($q) {
            $q->where('source_type', 'ftp_feed');
        })->with(['feedSources' => function($q) {
            $q->where('source_type', 'ftp_feed');
        }])->get();

        $urlfeedusers = User::whereHas('feedSources', function($q) {
            $q->where('source_type', 'feed');
        })->with(['feedSources' => function($q) {
            $q->where('source_type', 'feed');
        }])->get();

        $blueskyusers = User::whereHas('feedSources', function($q) {
            $q->where('source_type', 'bluesky');
        })->with(['feedSources' => function($q) {
            $q->where('source_type', 'bluesky');
        }])->get();

        $mazdausers = User::whereHas('feedSources', function($q) {
            $q->where('source_type', 'mazda');
        })->with(['feedSources' => function($q) {
            $q->where('source_type', 'mazda');
        }])->get();

        return view('admin.api.index', compact(
            'apiusers',
            'clickdealers',
            'urlfeedusers',
            'blueskyusers',
            'mazdausers'
        ));
    }

    public function connectDealer(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'dealer_id' => 'required|string|max:255',
            'source_type' => 'required|in:api,ftp_feed,feed,bluesky,mazda',
            'dealer_feed_url' => 'nullable|string|max:65535',
            'dealer_api_field' => 'nullable|string|max:65535',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Check if this source already exists
            $existingSource = UserFeedSource::where('user_id', $user->id)
                ->where('source_type', $request->source_type)
                ->where('dealer_id', $request->dealer_id)
                ->first();

            if ($existingSource) {
                // Update existing
                $existingSource->update([
                    'dealer_feed_url' => $request->dealer_feed_url,
                    'api_key' => $request->dealer_api_field,
                    'is_active' => true
                ]);
                $message = 'Dealer source updated successfully!';
            } else {
                // Create new source
                UserFeedSource::create([
                    'user_id' => $user->id,
                    'source_type' => $request->source_type,
                    'dealer_id' => $request->dealer_id,
                    'dealer_feed_url' => $request->dealer_feed_url,
                    'api_key' => $request->dealer_api_field,
                    'is_active' => true
                ]);
                $message = 'Dealer source connected successfully!';
            }

            return redirect()->back()->with('success', $message);
        }

        return redirect()->back()->with('error', 'User not found');
    }

    public function disconnectSource(Request $request)
    {
        $request->validate([
            'source_id' => 'required|exists:user_feed_sources,id'
        ]);

        $source = UserFeedSource::findOrFail($request->source_id);
        $source->delete();

        return redirect()->back()->with('success', 'Feed source disconnected successfully!');
    }
}