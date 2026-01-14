<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{

    public function index()
    {
        $title = 'Brands';
        $brands = Brand::paginate(10);

        return view('brands.list', compact('title', 'brands'));
    }

    public function create(Request $request)
    {
        $title = 'Add Brand';

        return view('brands.create', compact('title', ));
    }

    public function delete(Brand $id)
    {
        $id->delete();

        return redirect('list-brands')->with(
            'success',
            'Brand has been deleted successfully!'
        );
    }

    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $image = $request->file('image');
    //     $extension = $image->getClientOriginalExtension();
    //     $filename = 'brand_' . Str::random(8) . '.' . $extension;
    //     $image->move(public_path('images/brands'), $filename);

    //     $brand = Brand::create([
    //         'image' => $filename,
    //     ]);

    //     if ($brand) {
    //         return redirect('list-brands')->with(
    //             'success',
    //             'New brand has been added.'
    //         );
    //     } else {
    //         return redirect('list-brands')->with(
    //             'warning',
    //             'Failed to add a new brand.'
    //         );
    //     }
    // }
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'link' => 'nullable|url|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $image = $request->file('image');
    $extension = $image->getClientOriginalExtension();
    $filename = 'brand_' . Str::random(8) . '.' . $extension;
    $image->move(public_path('images/brands'), $filename);

    $brand = Brand::create([
      
        'link' => $request->input('link'),
        'image' => $filename,
    ]);

    if ($brand) {
        return redirect('list-brands')->with(
            'success',
            'New brand has been added.'
        );
    } else {
        return redirect('list-brands')->with(
            'warning',
            'Failed to add a new brand.'
        );
    }
}

}
