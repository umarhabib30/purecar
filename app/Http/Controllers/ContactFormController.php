<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactFormController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        $data = [
            'name'    => $request->input('name'),
            'email'   => $request->input('email'),
            'message' => $request->input('message'),
        ];

   
        Mail::to('hello@purecar.co.uk')->send(new \App\Mail\SupportMail($data));
        return back()->with('success', 'Your message has been sent successfully!');
    }
}
