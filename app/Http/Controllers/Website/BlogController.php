<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Car;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{

    public function index()
    {
        $title = 'Top Career Advice, News & Articles';
        $blog_most_recent_one = Blog::latest()->first();
        
        if (!$blog_most_recent_one) {
    
            $blogs = collect();
        } else {
            $blogs = Blog::where('id', '!=', $blog_most_recent_one->id)->latest()->paginate(8);
        }
        $blog_categories = BlogCategory::all();
        $blog_tags = BlogTag::all();

        return view('blogs/website_blogs', compact('title', 'blog_most_recent_one', 'blogs', 'blog_categories', 'blog_tags'));
    }

    
 

// public function show(Blog $blog)
// {
//     $title = $blog->title;
//     $meta_title = $blog->title;
//     $meta_description = Str::limit(strip_tags($blog->content), 150);
//     $meta_image = $blog->featured_image 
//         ? asset('' . $blog->featured_image) 
//         : asset('default-image.jpg');
//     $meta_type = 'article';

//     return view('blogs.website_single_blog', compact('blog','title', 'meta_title', 'meta_description', 'meta_image', 'meta_type'));
// }
public function show($slugOrId)
{
    
    $blog = Blog::where('slug', $slugOrId)->first();
    
   
    if (!$blog && is_numeric($slugOrId)) {
        $blog = Blog::find($slugOrId);
    }
    
    if (!$blog) {
        abort(404);
    }
    
    $title = $blog->title;
    $meta_title = $blog->title;
    $meta_description = Str::limit(strip_tags($blog->content), 150);
    $meta_image = $blog->featured_image 
        ? asset('' . $blog->featured_image) 
        : asset('default-image.jpg');
    $meta_type = 'article';

       $data = Car::whereHas('advert', function ($query) {
            $query->where('status', 'active');
        })->inRandomOrder()->take(4)->get();

    return view('blogs.website_single_blog', compact('blog','title', 'meta_title', 'meta_description', 'meta_image', 'meta_type','data'));
}
    public function categoryWise(BlogCategory $category)
    {
        $title = $category->name;
        $blogs = Blog::where('category_id', $category->id)->paginate(10);

        return view('blogs/website_blogs_category_wise', compact('title', 'blogs'));
    }

    public function tagWise($tag)
    {
        $title = $tag;
        $blogs = Blog::where('tags', 'LIKE', "%$tag%")->paginate(10);

        return view('blogs/website_blogs_category_wise', compact('title', 'blogs'));
    }


    public function storeComment(Request $request, Blog $blog)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $comment = new BlogComment();
        $comment->blog_id = $blog->id;
        $comment->comment = $request->input('comment');
        $comment->save();

        return response()->json(['message' => 'Comment submitted successfully!']);
    }
}
