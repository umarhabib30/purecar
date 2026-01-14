<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\CompanyDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyDetailController extends Controller
{

    public function index()
    {
        $title = 'Company Detail';
        $company_details = CompanyDetail::first();

        return view('/company_details/index', compact('title', 'company_details'));
    }


    public function update(Request $request)
    {
      
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'about_us' => 'nullable|string',
            'instagram' => 'nullable|string',
            'youtube' => 'nullable|string',
            'facebook' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'x' => 'nullable|string',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'ad_cost' => 'required|integer',
            'ad_expiry' => 'required|integer',
        ]);

        
        $company = CompanyDetail::first();

        if ($company) {
            
            $company->update($validatedData);
        } else {
            
            CompanyDetail::create($validatedData);
        }

        
        return redirect()->back()->with('success', 'Company details saved successfully.');
    }


}
