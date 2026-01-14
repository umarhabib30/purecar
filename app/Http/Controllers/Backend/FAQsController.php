<?php

namespace App\Http\Controllers\Backend;

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

        return view('/faqs/list', compact('title', 'faqs'));
    }


    public function create(Request $request)
    {
        $title = 'Create FAQ';

        return view('/faqs/create', compact('title', ));
    }

    public function edit(FAQ $faq)
    {
        $title = 'Edit FAQ';

        return view('/faqs/edit', compact('title', 'faq'));
    }

    public function delete(FAQ $faq)
    {
        $faq->delete();

        return redirect('list-faqs')->with(
            'success',
            'Faq has been deleted successfully!'
        );
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        $faq = FAQ::create([
            'question' => $validatedData['question'],
            'answer' => $validatedData['answer'],

        ]);

        if ($faq) {
            return redirect('list-faqs')->with(
                'success',
                'New faq has been added.'
            );
        } else {
            return redirect('list-faqs')->with(
                'warning',
                'Failed to add a new fas.'
            );
        }

    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        $faq = FAQ::find(1);
        $faq->update($validatedData);


        return redirect('list-faqs')->with(
            'success',
            'FAQ has been updated successfully.'
        );
    }

    public function faqsForSellers()
    {
        $title = 'FAQs';
        $faqs = FAQ::paginate(10);

        return view('/FAQSPage', compact('title', 'faqs'));

    }

}
