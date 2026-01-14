<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthorController extends Controller
{

    public function index()
    {
        $title = 'Author';
        $authors = Author::paginate(10);

        return view('list_authors', compact('title', 'authors'));
    }

    public function show(Blog $blog)
    {
        $title = $blog->title;
        return view('single_blog', compact('title', 'blog'));
    }

    public function create(Request $request)
    {
        $title = 'Create Author';

        return view('create_author', compact('title', ));
    }

    public function edit(Author $author)
    {
        $title = 'Edit Author';

        return view('edit_author', compact('title', 'author'));
    }

    public function delete(Author $author)
    {
        $author->delete();

        return redirect('list-authors')->with(
            'success',
            'Author has been deleted successfully!'
        );
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
        ]);

        $image = $request->file('image');
        $extension = $image->getClientOriginalExtension();
        $filename = 'blog_' . Str::random(8) . '.' . $extension;
        $image->move(public_path('images/authors'), $filename);

        $blog = Author::create([
            'image' => $filename,
            'name' => $validatedData['name'],
        ]);

        if ($blog) {
            return redirect('list-authors')->with(
                'success',
                'New author has been added.'
            );
        } else {
            return redirect('list-authors')->with(
                'warning',
                'Failed to add a new author.'
            );
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
        ]);

        $author = Author::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = 'blog_'.Str::random(8).'.'.$extension;
            $image->move(public_path('images/authors'), $filename);

            $author->image = $filename;
        }

        $author->name = $validatedData['name'];

        if ($author->save()) {
            return redirect('list-authors')->with(
                'success',
                'Author has been updated successfully.'
            );
        } else {
            return redirect('list-authors')->with(
                'warning',
                'Failed to update the Author.'
            );
        }
    }

}
