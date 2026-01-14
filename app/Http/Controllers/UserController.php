<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\User_Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Mail\WelcomeMail; 
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function signup(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'honeypot' => ['nullable', 'string', 'max:0'], 
     
        ];
        $signup_data = $request->validate($rules);
        if (!empty($data['honeypot'])) {
            return redirect()->back()->withErrors(['honeypot' => 'Invalid submission detected.']);
        }

    
        $user = User::create([
            'name' => $signup_data['name'],
            'email' => $signup_data['email'],
            'inquiry_email' => $signup_data['email'],
            'password' => bcrypt($signup_data['password']), 
            'plain_password' => $signup_data['password'],
            'role' => 'private_seller',
        ]);
    
        if ($user->role === 'car_dealer') {
            User_Rating::create([
                'user_id' => $user->id,
            ]);
        }
    
    
        Auth::login($user);
 
        return redirect()->route('private_seller');
    }
    

    public function login(Request $request)
{

    $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];
    $login_data = $request->validate($rules);


    $remember = $request->has('rememberMe');

    
    if (Auth::attempt($login_data, $remember)) {
        $user = Auth::user();

      
        if ($user->role == 'admin') {
            Auth::logout();
            return redirect()->route('login')->with('message1', 'ACCESS DENIED. NOT A VALID USER.');
        }

       
        if ($user->role !== 'admin') {

        
            if ($user->email_verified_at !== null) {

                $user->update(['last_login_at' => now()]);
                if (session()->has('postadvert')) {
                    // Clear the session value after using it
                    session()->forget('postadvert');
                    return redirect()->route('packages.select');
                }
                if ($user->phone_number === null) {
                    return redirect()->route('private_seller');
 
                }
                else
                {
                    return redirect()->route('dashboard');

                }
            } else {
       
                $user->sendEmailVerificationNotification();
                return redirect()->route('dashboard');
            }
        }
    }


    return redirect()->route('login')->with('message1', 'INVALID CREDENTIALS.');
}
public function Adminlogin(Request $request)
{
    $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];
    $login_data = $request->validate($rules);

    $remember = $request->has('rememberMe');

    if (Auth::attempt($login_data, $remember)) {
        $user = Auth::user();

  
        if ($user->role == 'admin') {
            return redirect()->route('admin_dashboard');
        } else {
           
            
        }
    }

    return redirect()->route('login')->with('message1', 'INVALID CREDENTIALS.');
}


    function change_password(Request $request){

        $request->validate([
            'old_password' => 'required', 
            'new_password' => 'required|min:6|confirmed', 
        ], [
            'new_password.confirmed' => 'The new password and confirmation password do not match.', 
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }
        else {
        $user->password = Hash::make($request->new_password);
        $user->save();
        return back()->with('status', 'Password changed successfully!');
        }


    }



    function update_profile(Request $request, $id)
    {
        $validated_data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
             'inquiry_email' => 'required|email',
            'phone_number' => 'nullable|string',
            'watsaap_number' => 'nullable|string',
            'location' => 'nullable|string',
            'role' => 'required|string|in:private_seller,car_dealer', 
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $filename = auth()->user()->image;
       
        if ($id == 1 && $request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = 'user_' . Str::random(8) . '.' . $extension;
            $image->move(public_path('images/users'), $filename);
        }
        
        if ($request->hasFile('background_image')) {
            if (auth()->user()->background_image) {
                $old_path = public_path('images/users/' . auth()->user()->background_image);
                if (file_exists($old_path)) {
                    unlink($old_path);
                }
            }
    
            $bg_image = $request->file('background_image');
            $extension = $bg_image->getClientOriginalExtension();
            $background_image = 'bg_' . Str::random(8) . '.' . $extension;
            $bg_image->move(public_path('images/users'), $background_image);
        } else {
            $background_image = auth()->user()->background_image;
        }

        $data = [
            'name' => $validated_data['name'],
            'email' => $validated_data['email'],
            'inquiry_email' =>$validated_data['inquiry_email'],
            'phone_number' => $validated_data['phone_number'],
            'watsaap_number' => $validated_data['watsaap_number'],
            'location' => $validated_data['location'],
            'role' => $validated_data['role'],
            'image' => $filename,
            'background_image' => $background_image,
        ];
    
        if ($validated_data['role'] === 'car_dealer') {
            $data['business_desc'] = $request->input('business_desc');
            $data['website'] = $request->input('website');
           
        } else {
            $data['business_desc'] = null;
            $data['website'] = null;
         
        }
    
        User::find(Auth::id())->update($data);
        try {
          
            $user = User::find(Auth::id());
        
            if (!$user->welcome_email_sent) {

                Mail::to($user->email)->send(new WelcomeMail($user));
                $user->welcome_email_sent = true;
                $user->save();

            }
        } catch (\Exception $e) {
           
        }
          if (auth()->user()->welcome_email_sent==0) {
            return redirect()->route('packages.select')->with('status', 'Profile updated successfully');
           
        } else {
            return redirect()->back()->with('status', 'Profile updated successfully');
         
        }
    
       

    }
    


    function logout() {
        Auth::logout();
        return redirect('/');
    }
    
}
