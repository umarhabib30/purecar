<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogTag;
use App\Models\ForumPost;
use App\Models\ForumPostMedia;
use App\Models\ForumTopic;
use App\Models\ForumTopicCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ForumPostLike;
use App\Models\ForumBlockedUser;
use App\Models\ForumTopicReply;
use App\Models\ForumReportedUser;
use App\Models\ForumPostDeslike;
use App\Models\Moderator;
use App\Models\ModeratorBlockedUser;
use Illuminate\Support\Facades\Auth;
use App\Models\PinPost;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ForumTopicController extends Controller
{

    public function index()
    {
        $isBlocked = auth()->check() && ModeratorBlockedUser::where('user_id', auth()->id())->exists();
        $title = 'Forum';
        $forum_topics = ForumTopic::all();
        $activities = auth()->check()
            ? ForumPost::where('user_id', auth()->user()->id)->latest()->take(10)->get()
            : '';

        $moderatorPosts = [];
        $moderatedCategories = [];

        if (auth()->check()) {
            $moderatedTopics = Moderator::where('user_id', auth()->user()->id)->pluck('forum_topic_id');

            if ($moderatedTopics->isNotEmpty()) {
                $moderatedCategories = ForumTopicCategory::whereIn('id', $moderatedTopics)->get();
                $moderatorPosts = ForumPost::whereIn('forum_topic_category_id', $moderatedTopics)
                    ->latest()
                    ->take(10)
                    ->get();
            }
        }

        
        $blocked_users = ModeratorBlockedUser::where('status',1)->get();
        $latestPosts = ForumPost::with(['userDetails:id,name,image', 'forumTopicCategory:id,category'])
        ->select('forum_topic_category_id', 'content','topic', 'user_id', 'created_at')
        ->latest()
        ->get()
        ->groupBy('forum_topic_category_id')
        ->map(function ($posts) {
            return $posts->first(); 
        });
       
        $latestReplies = ForumTopicCategory::with(['forumPosts.replies.user', 'forumPosts'])
    ->get()
    ->mapWithKeys(function ($category) {
    
        $latestReply = $category->forumPosts
            ->flatMap(function ($post) {
                return $post->replies;
            })
            ->sortByDesc('created_at')
            ->first();

        return [$category->id => $latestReply];
    });

        


        return view('forum_topics.website_forum', compact('title','latestReplies','latestPosts','forum_topics', 'activities','moderatorPosts','moderatedCategories','blocked_users','isBlocked'));
    }
    public function deleteForumImage($id)
    {
        
        $image = ForumPostMedia::where('id', $id)->firstOrFail();
        $image->delete();
        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully'
        ]);
    }
    public function deleteReplyImage(Request $request, $reply_id)
    {
        $reply = ForumTopicReply::findOrFail($reply_id);
        $imagePath = $request->input('imagePath'); 
    
        if (!$reply->media) {
            return response()->json([
                'success' => false,
                'message' => 'No images found'
            ]);
        }
    
       
        $images = json_decode($reply->media, true);
    
      
        if (!in_array($imagePath, $images)) {
            return response()->json([
                'success' => false,
                'message' => 'Image not found'
            ]);
        }
    
     
        $updatedImages = array_values(array_diff($images, [$imagePath]));

        $imageFullPath = public_path($imagePath);
        if (file_exists($imageFullPath)) {
            unlink($imageFullPath);
        }
    
     
        $reply->update([
            'media' => json_encode($updatedImages),
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully'
        ]);
    }
    
    
    public function showModeratorPosts($id)
    {
        $category = ForumTopicCategory::findOrFail($id);
        $posts = ForumPost::where('forum_topic_category_id', $id)->get();

        return view('forum_topics.moderator-posts', compact('category', 'posts'));
    }
    public function deleteMP(Request $request, $id)
    {
        $post = ForumPost::findOrFail($id);
        $post->delete();
    
        return response()->json(['success' => 'Post deleted successfully']);
    }


    public function updateMP(Request $request, $id)
    {
        $request->validate([
            'topic' => 'required|string|max:500', 
            'content' => 'required|string|max:500', 
        ]);

        $post = ForumPost::find($id);
        if ($post) {
            $post->topic = $request->topic;
            $post->content = $request->content;
            $post->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Post not found'], 404);
    }

//     public function forumTopicCategory(ForumTopicCategory $forum_topic_category)
// {
//     $forum_topic = ForumTopic::where('id', $forum_topic_category->forum_topic_id)->first()->title;
    
//     $forum_posts = ForumPost::where('forum_topic_category_id', $forum_topic_category->id)
//         ->withCount(['likes', 'dislikes']) 
//         ->whereDoesntHave('userDetails', function ($query) {
//             $query->whereIn('id', function ($subQuery) {
//                 $subQuery->select('user_id')
//                     ->from('forum_blocked_user')
//                     ->where('auth_id', auth()->id());
//             });
//         })
//         ->orderBy('created_at', 'desc')
//         ->get();

    
//     $pinnedPostIds = PinPost::where('forum_posts.forum_topic_category_id', $forum_topic_category->id)
//         ->join('forum_posts', 'forum_posts.id', '=', 'pin_posts.forum_post_id')
//         ->pluck('forum_post_id')
//         ->unique()
//         ->toArray();

    
//     $pinnedPosts = ForumPost::whereIn('id', $pinnedPostIds)
//         ->orderBy('created_at', 'desc')
//         ->get();

//     $likedPosts = auth()->check()
//         ? ForumPost::whereIn('id', $forum_posts->pluck('id'))->whereHas('likes', function ($query) {
//             $query->where('auth_id', auth()->id());
//         })->pluck('id')->toArray()
//         : [];

//     $activities = auth()->check()
//                 ? ForumPost::where('user_id', auth()->user()->id)->latest()->take(10)->get()
//                 : '';
            
//             $moderatorPosts = [];
//             $moderatedCategories = [];
            
//             if (auth()->check()) {
//                 $moderatedTopics = Moderator::where('user_id', auth()->user()->id)->pluck('forum_topic_id');
            
//                 if ($moderatedTopics->isNotEmpty()) {
//                     $moderatedCategories = ForumTopicCategory::whereIn('id', $moderatedTopics)->get();
//                     $moderatorPosts = ForumPost::whereIn('forum_topic_category_id', $moderatedTopics)
//                         ->latest()
//                         ->take(10)
//                         ->get();
//                 }
//             }
    

//     $allPosts = $pinnedPosts->merge($forum_posts);
    
//     $page = request()->get('page', 1);
//     $postsPerPage = 10;

//     $paginatedPosts = $allPosts->forPage($page, $postsPerPage);

    
//     foreach ($paginatedPosts as $forum_post) {
//         $latest_reply = ForumTopicReply::where('forum_post_id', $forum_post->id)
//             ->latest('created_at')
//             ->first();

//         $forum_post->latest_reply = $latest_reply;
//         $forum_post->reply_count = ForumTopicReply::where('forum_post_id', $forum_post->id)->count();
//         $forum_post->is_pinned = in_array($forum_post->id, $pinnedPostIds); 

//         if ($latest_reply) {
//             $forum_post->latest_reply_user_id = $latest_reply->auth_id;
//             $forum_post->latest_reply_user = $latest_reply->user;
//         }
//     }

//     $paginatedPosts = new \Illuminate\Pagination\LengthAwarePaginator(
//         $paginatedPosts,
//         $allPosts->count(),
//         $postsPerPage,
//         $page,
//         ['path' => request()->url(), 'query' => request()->query()]
//     );
    
//     return view('forum_topics.forum_forum_topic_category', compact('forum_topic_category', 'paginatedPosts', 'forum_topic', 'allPosts', 'activities', 'likedPosts'));
// }
public function forumTopicCategory(ForumTopicCategory $forum_topic_category)
{
    $forum_topic = ForumTopic::where('id', $forum_topic_category->forum_topic_id)->first()->title;
    
    $forum_posts = ForumPost::where('forum_topic_category_id', $forum_topic_category->id)
        ->withCount(['likes', 'dislikes']) 
        ->whereDoesntHave('userDetails', function ($query) {
            $query->whereIn('id', function ($subQuery) {
                $subQuery->select('user_id')
                    ->from('forum_blocked_user')
                    ->where('auth_id', auth()->id());
            });
        })
        ->orderBy('created_at', 'desc')
        ->get();

    $pinnedPostIds = PinPost::where('forum_posts.forum_topic_category_id', $forum_topic_category->id)
        ->join('forum_posts', 'forum_posts.id', '=', 'pin_posts.forum_post_id')
        ->pluck('forum_post_id')
        ->unique()
        ->toArray();

    $pinnedPosts = ForumPost::whereIn('id', $pinnedPostIds)
        ->orderBy('created_at', 'desc')
        ->get();

    $forum_posts->transform(function ($post) {
        $latest_reply = ForumTopicReply::where('forum_post_id', $post->id)
            ->latest('created_at')
            ->first();
        
        $post->last_reply_time = $latest_reply ? $latest_reply->created_at : $post->created_at;
        return $post;
    });

    $forum_posts = $forum_posts->sortByDesc('last_reply_time');

    $likedPosts = auth()->check()
        ? ForumPost::whereIn('id', $forum_posts->pluck('id'))->whereHas('likes', function ($query) {
            $query->where('auth_id', auth()->id());
        })->pluck('id')->toArray()
        : [];

    $activities = auth()->check()
                ? ForumPost::where('user_id', auth()->user()->id)->latest()->take(10)->get()
                : '';
            
    $moderatorPosts = [];
    $moderatedCategories = [];
    
    if (auth()->check()) {
        $moderatedTopics = Moderator::where('user_id', auth()->user()->id)->pluck('forum_topic_id');
    
        if ($moderatedTopics->isNotEmpty()) {
            $moderatedCategories = ForumTopicCategory::whereIn('id', $moderatedTopics)->get();
            $moderatorPosts = ForumPost::whereIn('forum_topic_category_id', $moderatedTopics)
                ->latest()
                ->take(10)
                ->get();
        }
    }

  
    $allPosts = $pinnedPosts->merge($forum_posts);
    
    $page = request()->get('page', 1);
    $postsPerPage = 10;

    $paginatedPosts = $allPosts->forPage($page, $postsPerPage);

    
    foreach ($paginatedPosts as $forum_post) {
        $latest_reply = ForumTopicReply::where('forum_post_id', $forum_post->id)
            ->latest('created_at')
            ->first();

        $forum_post->latest_reply = $latest_reply;
        $forum_post->reply_count = ForumTopicReply::where('forum_post_id', $forum_post->id)->count();
        $forum_post->is_pinned = in_array($forum_post->id, $pinnedPostIds); 

        if ($latest_reply) {
            $forum_post->latest_reply_user_id = $latest_reply->auth_id;
            $forum_post->latest_reply_user = $latest_reply->user;
        }
    }

   
    $paginatedPosts = new \Illuminate\Pagination\LengthAwarePaginator(
        $paginatedPosts,
        $allPosts->count(),
        $postsPerPage,
        $page,
        ['path' => request()->url(), 'query' => request()->query()]
    );
    $maxFiles = DB::table('settings')->where('key', 'forum_images_limit')->value('value');
    
    return view('forum_topics.forum_forum_topic_category', compact('forum_topic_category','maxFiles', 'paginatedPosts', 'forum_topic', 'allPosts', 'activities', 'likedPosts'));
}

    public function createForumPost(ForumTopicCategory $forum_topic_category, Request $request)
    {
        $validatedData = $request->validate([

            'topic' => 'required|string|max:2000',
            'content' => 'required|string|max:20000',
            'media' => 'nullable|array|max:100',
            'media.*' => 'mimes:jpeg,png,jpg,gif,webp,svg,zip|max:200048',
        ]);

        $forum_post = ForumPost::create([
            'forum_topic_category_id' => $forum_topic_category->id,
            'topic' => $validatedData['topic'],
            'content' => $validatedData['content'],
            'user_id' => auth()->user()->id,
        ]);

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $image) {
                $extension = $image->getClientOriginalExtension();
                $filename = 'forum_post_' . Str::random(8) . '.' . $extension;

                $image->move(public_path('images/forum_posts'), $filename);

                ForumPostMedia::create([
                    'forum_post_id' => $forum_post->id,
                    'media' => $filename,
                ]);
            }
        }

         return redirect()->back();
    }



    public function editForumPost(Request $request, $id)
    {
        try {
            Log::info('Starting forum post update', ['post_id' => $id]);
    
            $forum_post = ForumPost::find($id);
    
            if (!$forum_post) {
                Log::error('Forum post not found', ['post_id' => $id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Forum post not found'
                ], 404);
            }
    
          
            $validatedData = $request->validate([
                'topic' => 'required|string|max:2000',
                'content' => 'required|string|max:20000',
                'media' => 'nullable|array|max:5',
                'media.*' => 'mimes:jpeg,png,webp,jpg,gif,svg,zip|max:20048',
            ]);
    
            Log::info('Validation passed', ['validatedData' => $validatedData]);
    
          
            $updated = $forum_post->update([
                'topic' => $validatedData['topic'],
                'content' => $validatedData['content'],
            ]);
    
            Log::info('Update attempted', ['update_success' => $updated]);
    
        
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $image) {
                    $extension = $image->getClientOriginalExtension();
                    $filename = 'forum_post_' . Str::random(8) . '.' . $extension;
    

                    $image->move(public_path('images/forum_posts'), $filename);
    
                    $media = ForumPostMedia::create([
                        'forum_post_id' => $forum_post->id,
                        'media' => $filename,
                    ]);
    
                    Log::info('Media uploaded successfully', [
                        'file_name' => $filename,
                        'forum_post_id' => $forum_post->id,
                        'db_inserted' => (bool) $media
                    ]);
                }
            } else {
                Log::info('No media files were uploaded');
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Post updated successfully'
            ], 200);
    
        } catch (\Exception $e) {
            Log::error('Forum post update failed', [
                'error' => $e->getMessage(),
                'post_id' => $id
            ]);
    
            return response()->json([
                'success' => false,
                'message' => 'Failed to update post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    
    
    public function editForumReply(ForumTopicReply $forum_replies, Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required|string|max:255',
            'media' => 'nullable|array|max:5',
            'media.*' => 'mimes:jpeg,png,jpg,gif,svg,zip|max:2048',
        ]);
        $forum_replies->update([
            'content' => $validatedData['content'],
        ]);
        if ($request->hasFile('media')) {
            foreach ($forum_replies->forumPostMedia as $media) {
                if (file_exists(public_path('images/forum_posts/' . $media->media))) {
                    unlink(public_path('images/forum_posts/' . $media->media));
                }
                $media->delete();
            }

            foreach ($request->file('media') as $image) {
                $extension = $image->getClientOriginalExtension();
                $filename = 'forum_post_' . Str::random(8) . '.' . $extension;
    
                $image->move(public_path('images/forum_posts'), $filename);
                ForumPostMedia::create([
                    'forum_post_id' => $forum_replies->id,
                    'media' => $filename,
                ]);
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully!',
        ]);
    }
    public function uploadVideo(Request $request) {
        \Log::info('Video upload request received', ['has_file' => $request->hasFile('file')]);
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $destinationPath = public_path('videos/forum_videos');
    
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
    
       
            $allowedExtensions = ['mp4', 'webm', 'ogg','mov'];
            if (!in_array(strtolower($file->getClientOriginalExtension()), $allowedExtensions)) {
                return response()->json(['error' => 'Invalid file type'], 400);
            }
    
            $fileName = time() . '_' . uniqid() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
    
            try {
                $file->move($destinationPath, $fileName);
                $videoUrl = asset('videos/forum_videos/' . $fileName);
    
                \Log::info('Video uploaded successfully', ['location' => $videoUrl]);
    
                return response()->json([
                    'location' => $videoUrl
                ], 200, ['Content-Type' => 'application/json']);
            } catch (\Exception $e) {
                \Log::error('Error moving uploaded video', ['error' => $e->getMessage(), 'file' => $file->getClientOriginalName()]);
                return response()->json(['error' => 'Error saving file: ' . $e->getMessage()], 500);
            }
        }
    
        \Log::error('No file uploaded', ['files' => $request->allFiles()]);
        return response()->json(['error' => 'No file uploaded'], 400);
    }
    
    
    
    public function blockUser(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'You must be logged in to block a user.'], 401);
        }
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $authId = auth()->id();
        $blockedUserId = $request->user_id;

        if ($authId === $blockedUserId) {
            return response()->json(['success' => false, 'message' => 'You cannot block yourself.']);
        }
        $existingBlock = ForumBlockedUser::where('auth_id', $authId)
                                        ->where('user_id', $blockedUserId)
                                        ->first();

        if ($existingBlock) {
            return response()->json(['success' => false, 'message' => 'You have already blocked this user.']);
        }
        ForumBlockedUser::create([
            'auth_id' => $authId,
            'user_id' => $blockedUserId,
            'reason' => 'User blocked by the current user',
        ]);
        return redirect()->route('forum.index')->with('success', 'User successfully blocked.');
    }
    public function uploadImage(Request $request) {
        \Log::info('Upload request received', ['has_file' => $request->hasFile('file')]);
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            \Log::info('File details', ['filename' => $file->getClientOriginalName(), 'size' => $file->getSize()]);
    
            try {
                $destinationPath = public_path('images/forum_reply_images');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
    
                $fileName = time() . '_' . uniqid() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $file->move($destinationPath, $fileName);
    
                $imageUrl = asset('images/forum_reply_images/' . $fileName);
                \Log::info('Image uploaded successfully', ['location' => $imageUrl]);
    
                return response()->json([
                    'location' => $imageUrl
                ], 200, ['Content-Type' => 'application/json']);
            } catch (\Exception $e) {
                \Log::error('Error moving uploaded file', ['error' => $e->getMessage(), 'file' => $file->getClientOriginalName()]);
                return response()->json(['error' => 'Error saving file: ' . $e->getMessage()], 500);
            }
        }
    
        \Log::error('No file uploaded', ['files' => $request->allFiles()]);
        return response()->json(['error' => 'No file uploaded'], 400);
    }
    
    
    
    
    
    
    
    public function unblock(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $blockedUser = ModeratorBlockedUser::where('status', 1)
                                        ->where('user_id', $request->user_id)
                                        ->first();

        if ($blockedUser) {
            $blockedUser->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'User not found']);
        }
    }

   
    public function reportUser(Request $request)
    {
        
    
        $existingReport = ForumReportedUser::where('auth_id', auth()->id())
                                           ->where('user_id', $request->user_id)
                                           ->where('forum_topic_id', $request->forum_topic_id)
                                           ->first();
    
        if ($existingReport) {
            return redirect()->back()->with('message2', 'You have already reported this user in this topic.');
        }
    
        $report = new ForumReportedUser();
        $report->auth_id = auth()->id();
        $report->user_id = $request->user_id;
        $report->forum_topic_id = $request->forum_topic_id;
        $report->category_id = $request->forum_topic_category_id;
        $report->reason = $request->reason;
        $report->save();
    
        return redirect()->back()->with('message', 'User reported successfully.');
    }
    
    
    public function getReports()
    {
        $authId = Auth::id();
        $moderator = Moderator::where('user_id', $authId)->first();
        $isAdmin = Auth::user()->role === 'admin';
    
        if (!$moderator && !$isAdmin) {
            return response()->json(['success' => false, 'message' => 'You are not authorized to view the reports.']);
        }
    
        $query = ForumReportedUser::query();
    
        if ($moderator && !$isAdmin) {
            $forumTopicId = $moderator->forum_topic_id;
            $query->where('category_id', $forumTopicId);
        }
    
       $reports = $query->with(['reporteduser', 'user'])->get();
    
        if ($reports->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No reports found.']);
        }
    
       
        $reports = $reports->map(function ($report) use ($authId) {
            $report->is_blocked = ModeratorBlockedUser::where('auth_id', $authId)
                ->where('user_id', $report->user_id) 
                ->exists();
            return $report;
        });
    
        return response()->json(['success' => true, 'reports' => $reports]);
    }

    public function deleteReport($reportId)
    {
        $report = ForumReportedUser::find($reportId);

        if ($report) {
            $report->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Report not found']);
        }
    }


    
    public function moderatorBlockUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $existingBlockedUser = ModeratorBlockedUser::where('auth_id', auth()->id())
            ->where('user_id', $request->user_id)
            ->first();
    
        if ($existingBlockedUser) {
            return response()->json([
                'success' => false,
                'message' => 'User is already blocked.',
            ]);
        }
        $blockedUser = ModeratorBlockedUser::create([
            'auth_id' => auth()->id(),
            'user_id' => $request->user_id,
            'status' => 1,
            'reason' => $request->reason ?? 'No reason provided',
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'User has been blocked successfully.',
            'data' => $blockedUser,
        ]);
    }
    public function moderatorUnblockUser(Request $request)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);

        $blockedUser = ModeratorBlockedUser::where('auth_id', auth()->id())
            ->where('user_id', $request->user_id)
            ->first();

        if (!$blockedUser) {
            return response()->json(['success' => false, 'message' => 'User is not currently blocked.']);
        }

        $blockedUser->delete();

        return response()->json(['success' => true, 'message' => 'User has been unblocked.']);
    }
    public function like(Request $request, $id)
    {
        if (!auth()->check()) {
            return response()->json([
                'error' => 'You must be logged in to like this post.',
            ], 401);
        }
    
        $forumPost = ForumPost::findOrFail($id);
        $userId = auth()->id();
    
        $like = ForumPostLike::where('post_id', $id)->where('auth_id', $userId)->first();
    
        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            ForumPostLike::create([
                'auth_id' => $userId,
                'post_id' => $id,
                'post_user_id' => $forumPost->user_id,
            ]);
            $liked = true;
        }
    
        $likeCount = ForumPostLike::where('post_id', $id)->count();
    
        return response()->json([
            'liked' => $liked,
            'likeCount' => $likeCount,
        ]);
    }

    public function dislike(Request $request, $id)
    {
        if (!auth()->check()) {
            return response()->json([
                'error' => 'You must be logged in to dislike this post.',
            ], 401);
        }

        $forumPost = ForumPost::findOrFail($id);
        $userId = auth()->id();

        $dislike = ForumPostDeslike::where('post_id', $id)->where('auth_id', $userId)->first();

        if ($dislike) {
            $dislike->delete();
            $disliked = false;
        } else {
            ForumPostDeslike::create([
                'auth_id' => $userId,
                'post_id' => $id,
                'post_user_id' => $forumPost->user_id,
            ]);
            $disliked = true;
        }
        $dislikeCount = ForumPostDeslike::where('post_id', $id)->count();
        return response()->json([
            'disliked' => $disliked,
            'dislikeCount' => $dislikeCount,
        ]);
    }



   
    // public function showTopic($id)
    // {
    //     $forum_post = ForumPost::find($id);

       
    //     if (!$forum_post) {
    //         return response()->view('errors.forum_404', [], 404);
    //     }

    //     $activities = auth()->check()
    //         ? ForumPost::where('user_id', auth()->user()->id)->latest()->take(10)->get()
    //         : '';

    //     $forum_topic_id = $forum_post->forum_topic_category_id;
    //     $replies = ForumTopicReply::where('forum_post_id', $id)
    //         ->join('users', 'forum_topic_replies.auth_id', '=', 'users.id')
    //         ->select('forum_topic_replies.*', 'users.name as user_name', 'users.image as users_profile', 'users.id as user_id', 'users.location as user_location')
    //         ->paginate(10); 

    //     $forum_post->increment('views');
    //     $meta_title = $forum_post->topic;
    //     $meta_description = Str::limit(strip_tags($forum_post->content), 150);
    //     $media_image = ForumPostMedia::where('forum_post_id', $forum_post->id)->first();
    //     $meta_image = $media_image 
    //         ? asset($media_image->media)
    //         : asset('default-image.jpg'); 

    //     $meta_type = 'article';
        
    //     return view('forum_topics.show-topic', compact(
    //         'forum_post', 'replies', 'forum_topic_id', 'activities', 
    //         'meta_title', 'meta_description', 'meta_image', 'meta_type'
    //     ));
    // }
    public function showTopic($slug)
{
   
    $forum_post = ForumPost::where('slug', $slug)->first();
    
  
    if (!$forum_post && is_numeric($slug)) {
        $forum_post = ForumPost::find($slug);
    }
    
    if (!$forum_post) {
        return response()->view('errors.forum_404', [], 404);
    }

    $activities = auth()->check()
        ? ForumPost::where('user_id', auth()->user()->id)->latest()->take(10)->get()
        : '';

    $forum_topic_id = $forum_post->forum_topic_category_id;
    $replies = ForumTopicReply::where('forum_post_id', $forum_post->id)
        ->join('users', 'forum_topic_replies.auth_id', '=', 'users.id')
        ->select('forum_topic_replies.*', 'users.name as user_name', 'users.image as users_profile', 'users.id as user_id', 'users.location as user_location')
        ->paginate(10); 
    $currentPage = $replies->currentPage();

    $forum_post->increment('views');
    $meta_title = $forum_post->topic;
    $meta_description = Str::limit(strip_tags($forum_post->content), 150);
    $media_image = ForumPostMedia::where('forum_post_id', $forum_post->id)->first();
    $meta_image = $media_image 
        ? asset($media_image->media)
        : asset('default-image.jpg'); 

    $meta_type = 'article';
    
    return view('forum_topics.show-topic', compact(
        'forum_post', 'replies', 'forum_topic_id', 'activities', 
        'meta_title', 'meta_description', 'meta_image', 'meta_type','currentPage'
    ));
}



    public function storeTopicReply(Request $request, $forum_post_id)
    {
        $request->validate([
            'reply_content' => 'required|string|max:1000',
            'media.*' => 'image|mimes:jpg,png,webp|max:20048',
        ]);
    
        $forum_post = ForumPost::findOrFail($forum_post_id);
    
        $imagePaths = [];
    
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $filePath = 'images/replies/' . $fileName;
    
              
                $file->move(public_path('images/replies'), $fileName);
    
    
                $imagePaths[] = $filePath;
            }
        }
    
        ForumTopicReply::create([
            'forum_post_id' => $forum_post_id,  
            'auth_id' => auth()->id(), 
            'user_id' => $forum_post->user_id, 
            'content' => $request->reply_content,
            'media' => json_encode($imagePaths), 
        ]);
    
        return redirect()->back()->with('success', 'Your reply has been posted.');
    }
    

    public function updateReply(Request $request, ForumTopicReply $reply)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'media.*' => 'image|mimes:jpg,png,webp|max:20048',
        ]);
    

        $reply->content = $request->content;

        $imagePaths = json_decode($reply->media, true) ?? [];
    
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $filePath = 'images/replies/' . $fileName;
                $file->move(public_path('images/replies'), $fileName);
                $imagePaths[] = $filePath;
            }
        }
    
        $reply->media = json_encode($imagePaths);
        $reply->save();
    
        return response()->json(['success' => true, 'message' => 'Reply updated successfully']);
    }
    
public function deleteReply(ForumTopicReply $reply)
{
    try {
    
        $reply->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reply deleted successfully'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error deleting reply: ' . $e->getMessage()
        ], 500);
    }
}
    public function deleteForumPost($postId)
    {
        try {
            $post = ForumPost::findOrFail($postId);
            $postReplies = ForumTopicReply::where('forum_post_id', $postId)->get();
    
            if ($postReplies->isNotEmpty()) {
                foreach ($postReplies as $reply) {
                    $reply->delete();
                }
            }
    
            $post->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Post and its replies have been deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Post deletion failed. Please try again.'
            ]);
        }
    }
    public function pinPost(Request $request)
    {
    
        $postId = $request->input('post_id');
        $userId = $request->input('user_id');

        $pinPost = PinPost::where('forum_post_id', $postId)->first();

        if ($pinPost) {
            
            $pinPost->delete();
        } else {
            
            PinPost::create([
                'forum_post_id' => $postId,
                'auth_id' => $userId
            ]);
        }

        return redirect()->back();
    }
    

}
