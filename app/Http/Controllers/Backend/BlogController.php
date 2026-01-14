<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{

    public function index()
    {
        $title = 'Blogs';
        

        $blogs = Blog::orderBy('created_at', 'desc')->paginate(10); 

        return view('/blogs/list_blogs', compact('title', 'blogs'));
    }


    public function create(Request $request)
    {
        $title = 'Create Blog';
        $authors = Author::all();
        $blog_categories = BlogCategory::all();
        $blog_tags = BlogTag::all();

        return view('/blogs/create_blog', compact('title', 'authors', 'blog_categories', 'blog_tags'));
    }

    // public function edit(Blog $blog)
    // {
    //     $title = 'Edit Blog';
    //     $authors = Author::all();
    //     $blog_categories = BlogCategory::all();
    //     $blog_tags = BlogTag::all();

    //     return view('/blogs/edit_blog', compact('title', 'authors', 'blog', 'blog_categories', 'blog_tags'));
    // }
    public function edit($slug)
{
    $blog = Blog::where('slug', $slug)->firstOrFail();
    $title = 'Edit Blog';
    $authors = Author::all();
    $blog_categories = BlogCategory::all();
    $blog_tags = BlogTag::all();

    return view('/blogs/edit_blog', compact('title', 'authors', 'blog', 'blog_categories', 'blog_tags'));
}

    public function delete(Blog $blog)
    {
        $blog->delete();

        return redirect('list-blogs')->with(
            'success',
            'Blog has been deleted successfully!'
        );
    }

    public function deleteComment($comment_id)
    {
        $blog_comment = BlogComment::where('id', $comment_id)->delete();

        return redirect()->back()->with(
            'success',
            'Blog has been deleted successfully!'
        );
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:blog_categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:blog_tags,name',
        ]);

        $image = $request->file('featured_image');
        $extension = $image->getClientOriginalExtension();
        $filename = 'blog_' . Str::random(8) . '.' . $extension;
        $image->move(public_path('images/blogs'), $filename);

        $tags = $validatedData['tags'] ?? [];
        $tagsString = implode(',', $tags);

        $blog = Blog::create([
            'featured_image' => $filename,
            'author_id' => $validatedData['author_id'],
            'category_id' => $validatedData['category_id'],
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'tags' => $tagsString,
        ]);

        if ($blog) {
            return redirect('list-blogs')->with(
                'success',
                'New blog has been added.'
            );
        } else {
            return redirect('list-blogs')->with(
                'warning',
                'Failed to add a new blog.'
            );
        }

    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'featured_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:blog_categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:blog_tags,name', 
        ]);

        $blog = Blog::findOrFail($id);

        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $extension = $image->getClientOriginalExtension();
            $filename = 'blog_' . Str::random(8) . '.' . $extension;
            $image->move(public_path('images/blogs'), $filename);

            $blog->featured_image = $filename;
        }

       
        $tags = $validatedData['tags'] ?? [];
        $tagsString = implode(',', $tags);

        
        $blog->author_id = $validatedData['author_id'];
        $blog->category_id = $validatedData['category_id'];
        $blog->title = $validatedData['title'];
        $blog->content = $validatedData['content'];
        $blog->tags = $tagsString;

        if ($blog->save()) {
            return redirect('list-blogs')->with(
                'success',
                'Blog has been updated successfully.'
            );
        } else {
            return redirect('list-blogs')->with(
                'warning',
                'Failed to update the blog.'
            );
        }
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $filename = time() . '.' . $file->getClientOriginalExtension();  // Optionally, use a timestamp for uniqueness

            $file->move(public_path('images/blogs'), $filename);

            return response()->json(['url' => asset('images/blogs/' . $filename)]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

}
