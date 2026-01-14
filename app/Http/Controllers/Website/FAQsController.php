<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\CompanyDetail;
use App\Models\FAQ;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FAQsController extends Controller
{

    public function index()
    {
        $title = 'FAQs';
        $faqs = FAQ::paginate(10);

        return view('/faqs_website', compact('title', 'faqs'));
    }


}
