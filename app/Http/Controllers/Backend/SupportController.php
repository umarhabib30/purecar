<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
class SupportController extends Controller
{

    public function index()
    {
        $user = Auth::user(); 

        return view('support.support_request', [
            'name' => $user ? $user->name : '',
            'email' => $user ? $user->email : '',
        ]);
    }
    public function sendSupportMessage(Request $request)
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

   
        Mail::to('okconor12@gmail.com')->send(new \App\Mail\SupportMail($data));
        return back()->with('success', 'Your message has been sent successfully!');
    }


}
