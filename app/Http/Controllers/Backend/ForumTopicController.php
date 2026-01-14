<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogTag;
use App\Models\ForumTopic;
use App\Models\ForumTopicCategory;
use Illuminate\Http\Request;
use App\Models\ForumPost;
use App\Models\User;
use App\Models\Moderator;
use Illuminate\Support\Str;

class ForumTopicController extends Controller
{

    public function index()
    {
        $title = 'Forum Topics';
        $forum_topics = ForumTopic::paginate(10);



        return view('/forum_topics/list_forum_topic', compact('title', 'forum_topics'));
    }
    public function listreports()
    {
      
        $title = 'Reports';


        return view('/forum_topics/list_reports', compact('title'));
    }


    public function create(Request $request)
    {
        $title = 'Create Forum Topic';

        return view('/forum_topics/create_forum_topic', compact('title'));
    }

    public function edit(ForumTopic $forum_topic)
    {
        $title = 'Edit Forum Topic';


        return view('/forum_topics/edit_forum_topic', compact('title', 'forum_topic'));
    }

    public function delete(ForumTopic $forum_topic)
    {
        ForumTopicCategory::where('forum_topic_id', $forum_topic->id)->delete();

        $forum_topic->delete();

        return redirect('list-forum-topics')->with(
            'success',
            'Forum topic has been deleted successfully!'
        );
    }
    
    
    
    
    
    
    

    
    
    

    
    
    

    
    
    
    
    
    
    
    
    
    
    

    

    
    
    
    
    
    
    

    

    
    

    

    
    
    
    
    
    

    
    
    
    
    



















































     












































public function store(Request $request)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'categories' => 'required|array',
        'categories.*.name' => 'required|string|max:255',
        'categories.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
    ]);

    $forum_topic = ForumTopic::create([
        'title' => $validatedData['title'],
    ]);

    foreach ($request->categories as $categoryData) {
        $imagePath = null;
        if (isset($categoryData['image']) && $categoryData['image']->isValid()) {
            $imageName = time() . '_' . Str::random(10) . '.' . $categoryData['image']->getClientOriginalExtension();
            $categoryData['image']->move(public_path('images/forum_category_images'), $imageName);
            $imagePath = 'images/forum_category_images/' . $imageName; 
        }
        ForumTopicCategory::create([
            'forum_topic_id' => $forum_topic->id,
            'category' => $categoryData['name'],
            'image' => $imagePath,
        ]);
    }

    return redirect('list-forum-topics')->with(
        'success',
        'New forum topic has been added.'
    );
}


public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'categories' => 'required|array',
        'categories.*.name' => 'required|string|max:255',
        'categories.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
        'categories_to_delete' => 'nullable|array',
        'categories_to_delete.*' => 'exists:forum_topic_categories,id',
    ]);

    $forum_topic = ForumTopic::findOrFail($id);
    $forum_topic->title = $validatedData['title'];
    $forum_topic->save();

    $existingCategories = ForumTopicCategory::where('forum_topic_id', $id)->pluck('category', 'id');

    foreach ($validatedData['categories'] as $index => $categoryData) {
        $categoryId = array_search($categoryData['name'], $existingCategories->toArray());

        $imagePath = null;
        if (isset($categoryData['image']) && $categoryData['image']->isValid()) {
            $imageName = time() . '_' . Str::random(10) . '.' . $categoryData['image']->getClientOriginalExtension();
            $categoryData['image']->move(public_path('images/forum_category_images'), $imageName);
            $imagePath = 'images/forum_category_images/' . $imageName; 
        }
        if ($categoryId !== false) {
            ForumTopicCategory::where('id', $categoryId)->update([
                'category' => $categoryData['name'],
                'image' => $imagePath,
            ]);
        } else {
            ForumTopicCategory::create([
                'forum_topic_id' => $id,
                'category' => $categoryData['name'],
                'image' => $imagePath,
            ]);
        }
    }

    $newCategories = collect($validatedData['categories'])->pluck('name');
    $categoriesToDelete = $existingCategories->diff($newCategories);

    if ($categoriesToDelete->isNotEmpty()) {
        ForumTopicCategory::whereIn('id', $categoriesToDelete->keys())->delete();
    }

    
    if (!empty($validatedData['categories_to_delete'])) {
        ForumTopicCategory::whereIn('id', $validatedData['categories_to_delete'])->delete();
    }

    return redirect('list-forum-topics')->with(
        'success',
        'Forum Topic has been updated successfully.'
    );
}

    public function show(ForumTopic $forum_topic)
    {
        $forum_topic->load('forumTopicCategories');
    
        return view('forum_topics.post-detail', compact('forum_topic'));
    }
    public function showPosts(ForumTopicCategory $category)
    {
        $posts = ForumPost::where('forum_topic_category_id', $category->id)->get();
        $users = User::all();
        $moderator = Moderator::where('forum_topic_id', $category->id)->get();
        $currentModerator = Moderator::where('forum_topic_id', $category->id)->first();
        return view('forum_topics.posts', compact('category', 'posts','users','moderator','currentModerator'));
    }
    public function addModerator(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'forum_topic_category_id' => 'required|exists:forum_topic_categories,id',
        ]);

        $existingModerator = Moderator::where('forum_topic_id', $validated['forum_topic_category_id'])->first();
        
        if ($existingModerator) {
            $existingModerator->user_id = $validated['user_id'];
            $existingModerator->is_active = true;
            $existingModerator->save();

            return response()->json(['message' => 'Moderator updated successfully.']);
        } else {
            $moderator = new Moderator();
            $moderator->user_id = $validated['user_id'];
            $moderator->forum_topic_id = $validated['forum_topic_category_id'];
            $moderator->is_active = true;  
            $moderator->save();

            return response()->json(['message' => 'Moderator added successfully.']);
        }
    }
  
    
}
