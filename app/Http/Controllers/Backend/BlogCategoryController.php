<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{

    public function index()
    {
        $title = 'Blog Categories';
        $blog_categories = BlogCategory::paginate(10);

        return view('blog_category.list', compact('title', 'blog_categories'));
    }

    public function create(Request $request)
    {
        $title = 'Create Blog Category';

        return view('blog_category.create', compact('title', ));
    }

    public function delete(BlogCategory $id)
    {
        $id->delete();

        return redirect('list-blog-categories')->with(
            'success',
            'Blog category has been deleted successfully!'
        );
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $blog_category = BlogCategory::create([
            'name' => $validatedData['name'],
        ]);

        if ($blog_category) {
            return redirect('list-blog-categories')->with(
                'success',
                'New blog category has been added.'
            );
        } else {
            return redirect('list-blog-categories')->with(
                'warning',
                'Failed to add a new blog category.'
            );
        }
    }

}
