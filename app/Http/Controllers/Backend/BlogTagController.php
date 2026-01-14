<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogTagController extends Controller
{

    public function index()
    {
        $title = 'Blog Tags';
        $blog_tags = BlogTag::paginate(10);

        return view('blog_tag.list', compact('title', 'blog_tags'));
    }

    public function create(Request $request)
    {
        $title = 'Create Blog Tag';

        return view('blog_tag.create', compact('title', ));
    }

    public function delete(BlogTag $id)
    {
        $id->delete();

        return redirect('list-blog-tags')->with(
            'success',
            'Blog tag has been deleted successfully!'
        );
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $blog_tag = BlogTag::create([
            'name' => $validatedData['name'],
        ]);

        if ($blog_tag) {
            return redirect('list-blog-tags')->with(
                'success',
                'New blog tag has been added.'
            );
        } else {
            return redirect('list-blog-tags')->with(
                'warning',
                'Failed to add a new blog tag.'
            );
        }
    }
}
