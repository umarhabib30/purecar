<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\advert;
use App\Models\Author;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationReminder;
use App\Mail\WelcomeMail; 
class UserController extends Controller
{
    public function index()
    {
        $title = 'Users';
        $users = User::whereNotNull('email_verified_at')  
                    ->where('email_verified_at', '!=', '')  
                    ->where('role', '!=', 'admin')  
                    ->withCount(['adverts as active_adverts_count' => function ($query) {
                        $query->where('status', 'active');
                    }])
                    ->orderBy('created_at', 'desc')  
                    ->get();  
        return view('/users/list_users', compact('title', 'users'));
    }
    public function AddDealer()
    {
        return view('/users/add_dealer');
    }
    public function SaveDealer(Request $request)
    {
        \Log::info('SaveDealer method started');
        \Log::info('Request data received:', $request->all());
        try {
            \Log::info('Starting validation');
            $validated_data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'phone_number' => 'required|string',
                'watsaap_number' => 'nullable|string',
                'location' => 'required|string',
                'role' => 'required|string|in:private_seller,car_dealer', 
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'background_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            \Log::info('Basic validation passed successfully');
    
            $filename = null;
            if ($request->hasFile('image')) {
                \Log::info('Processing image upload');
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $filename = 'user_' . Str::random(8) . '.' . $extension;
                \Log::info('Image will be saved as: ' . $filename);
                try {
                    $image->move(public_path('images/users'), $filename);
                    \Log::info('Image moved successfully');
                } catch (\Exception $e) {
                    \Log::error('Failed to move image: ' . $e->getMessage());
                }
            } else {
                \Log::info('No image uploaded');
            }
    
            $background_image = null;
            if ($request->hasFile('background_image')) {
                \Log::info('Processing background image upload');
                $bg_image = $request->file('background_image');
                $extension = $bg_image->getClientOriginalExtension();
                $background_image = 'bg_' . Str::random(8) . '.' . $extension;
                \Log::info('Background image will be saved as: ' . $background_image);
                try {
                    $bg_image->move(public_path('images/users'), $background_image);
                    \Log::info('Background image moved successfully');
                } catch (\Exception $e) {
                    \Log::error('Failed to move background image: ' . $e->getMessage());
                }
            } else {
                \Log::info('No background image uploaded');
            }
    
            $user_data = [
                'name' => $validated_data['name'],
                'email' => $validated_data['email'],
                'inquiry_email' => $validated_data['email'],
                'password' => Hash::make($validated_data['password']),
                'phone_number' => $validated_data['phone_number'],
                'watsaap_number' => $validated_data['watsaap_number'],
                'location' => $validated_data['location'],
                'role' => $validated_data['role'],
                'image' => $filename,
                'background_image' => $background_image,
                'email_verified_at' => now(),
                'plain_password' => $validated_data['password'],
                'welcome_email_sent' => false, 
            ];
            \Log::info('User data prepared:', array_merge(
                array_diff_key($user_data, ['password' => '']), 
                ['password' => '[HASHED]']
            ));
    
            if ($validated_data['role'] === 'car_dealer') {
                \Log::info('Role is car_dealer, validating additional fields');
                try {
                    $dealer_validation = $request->validate([
                        'business_desc' => 'required|string|max:300',
                        'website' => 'nullable|string|max:300',
                    ]);
                    \Log::info('Dealer validation passed');
    
                    $user_data['business_desc'] = $dealer_validation['business_desc'];
                    $user_data['website'] = $dealer_validation['website'];
                } catch (\Exception $e) {
                    \Log::error('Dealer validation failed: ' . $e->getMessage());
                    throw $e;
                }
            } else {
                \Log::info('Role is not car_dealer, setting business fields to null');
                $user_data['business_desc'] = null;
                $user_data['website'] = null;
            }
    
            \Log::info('Attempting to create user in database');
            try {
                $user = User::create($user_data);
                \Log::info('User created successfully with ID: ' . $user->id);
            } catch (\Exception $e) {
                \Log::error('Database error while creating user: ' . $e->getMessage());
                \Log::error('SQL: ' . $e->getTraceAsString());
                throw $e;
            }
            try {
                if (!$user->welcome_email_sent) {
                    Mail::to($user->email)->send(new WelcomeMail($user));
                    $user->welcome_email_sent = true;
                    $user->save();
                    \Log::info('Welcome email sent successfully to ' . $user->email);
                }
            } catch (\Exception $e) {
                \Log::error('Failed to send welcome email: ' . $e->getMessage());
            }
            return back()->with('status', 'Profile Added successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['general_error' => 'Failed to create user: ' . $e->getMessage()]);
        }
    }
    public function nonVerifiedUsers()
    {
        $title = 'Non Verified Users';
        
        $users = User::whereNull('email_verified_at')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('users.list_users_non', compact('title', 'users'));
    }
    public function show(Blog $blog)
    {
        $title = $blog->title;
        return view('single_blog', compact('title', 'blog'));
    }
    public function create(Request $request)
    {
        $title = 'Create User';
        return view('/users/create_user', compact('title', ));
    }
    public function edit(User $user)
    {
        $title = 'Edit Blog';
        return view('/users/edit_user', compact('title', 'user'));
    }
    public function delete(User $user)
    {
        $user->delete();
        return back()->with('success', 'User has been deleted successfully!');
    }
    public function removeadvert(User $user)
    {
        $user->adverts()->each(function ($advert) {
            $advert->delete(); 
        });
        return back()->with('success', 'Adverts have been deleted successfully!');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'role' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'inquiry_email' =>'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'watsaap_number' => 'nullable|string|max:15',
            'location' => 'required|string|max:255',
            'business_desc' => 'nullable|string|max:500',
            'website' => 'nullable|string|max:255',
            'password' => 'required|string|min:8',
        ]);
        $image = $request->file('image');
        $extension = $image->getClientOriginalExtension();
        $filename = 'user_' . Str::random(8) . '.' . $extension;
        $image->move(public_path('images/users'), $filename);
        $user = User::create([
            'role' => $validatedData['role'],
            'image' => $filename,
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'inquiry_email'=> $validatedData['inquiry_email'],
            'phone_number' => $validatedData['phone_number'],
            'watsaap_number' => $validatedData['watsaap_number'],
            'location' => $validatedData['location'],
            'business_desc' => $validatedData['business_desc'],
            'website' => $validatedData['website'] ,
            'password' => Hash::make($validatedData['password']),
        ]);
        if ($user) {
            return redirect('list-users')->with('success', 'New user has been added successfully.');
        } else {
            return redirect('list-users')->with('error', 'Failed to add a new user.');
        }
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'role' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif', 
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'inquiry_email' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'watsaap_number' => 'nullable|string|max:15',
            'location' => 'nullable|string|max:255',
            'business_desc' => 'nullable|string|max:500',
            'website' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8',
        ]);
        $user = User::findOrFail($id);
       
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = 'user_' . Str::random(8) . '.' . $extension;
            $image->move(public_path('images/users'), $filename);
            $user->image = $filename;
        }
        if ($request->hasFile('background_image')) {
            $backgroundImage = $request->file('background_image');
            $extension = $backgroundImage->getClientOriginalExtension();
            $filename = 'background_' . Str::random(8) . '.' . $extension;
            $backgroundImage->move(public_path('images/users'), $filename);
            $user->background_image = $filename;
        }
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }
        $user->role = $validatedData['role'];
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
         $user->inquiry_email = $validatedData['inquiry_email'];
        $user->phone_number = $validatedData['phone_number'];
        $user->watsaap_number = $validatedData['watsaap_number'];
        $user->location = $validatedData['location'];
        $user->business_desc = $validatedData['business_desc'] ?? 'N/A';
        $user->website = $validatedData['website'] ?? 'N/A';
        $user->save();
        return redirect()->route('list-users.index')->with('success', 'User updated successfully.');
    }
    public function adverts()
    {
        return $this->hasMany(advert::class, 'user_id');
    }
    public function verify(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        if (!$user->email_verified_at) {
            $user->email_verified_at = now();
            $user->save();
            return redirect()->back()->with('success', 'User verified successfully.');
        }
        return redirect()->back()->with('error', 'User is already verified.');
    }
}