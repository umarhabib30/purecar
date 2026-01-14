
@extends('layout.dashboard')
@section('body')
    <section class="ProfilePage2">
    <div id="outer-container">
        <h2>Profile</h2>
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
          @endif
        <form action="{{ route('user_profile', ['id' => 2]) }}" method="POST">
            @csrf
            <div id="profile-container">
                <div id="second-container">
                    <div class="p-row">
                        <div class="input-group">
                            <label for="name">Name</label>
                            <input type="text" placeholder="Muhammad Sheraz" name="name" value="{{ old('name', auth()->user()->name ?? '') }}">
                            @error('name')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="input-group">
                            <label for="email">Email</label>
                            <input type="text" placeholder="sheraz12@gmail.com" name="email" value="{{ old('email', auth()->user()->email ?? '') }}">
                            @error('email')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="p-row">
                            <div class="input-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" placeholder="xxxxxxxxxxx" name="phone_number" value="{{ old('phone_number', auth()->user()->phone_number ?? '') }}">
                                @error('phone_number')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="input-group">
                                <label for="whatsapp">Whatsapp Number</label>
                                <input type="tel" placeholder="xxxxxxxxxx" name="watsaap_number" value="{{ old('watsaap_number', auth()->user()->watsaap_number ?? '') }}">
                                @error('watsaap_number')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                    </div>
                    <div class="p-row">
                        <div class="input-group">
                            <label for="location">Location</label>
                            <input type="text" placeholder="Write" name="location" value="{{ old('location', auth()->user()->location ?? '') }}">
                            @error('location')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="p-row">
                        <div class="input-group">
                            <label for="business-desc">Business Description</label>
                            <textarea name="business_desc" id="business-desc"  placeholder="Write" >{{ old('business_desc', auth()->user()->business_desc ?? '') }}</textarea>
                            @error('business_desc')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="p-row">
                        <div class="input-group">
                            <label for="website">Website</label>
                            <input type="text" placeholder="www.carking.com" value="{{ old('website', auth()->user()->website ?? '') }}" name="website">
                            @error('website')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="p-row" id="p-row-last">
                        <h2>I am:</h2>

                        <!-- Single Form for Radio Buttons -->
                       <!-- Private Seller Radio Button -->
                       <div class="selection-group">
                        <input type="radio" name="seller-type" id="private-seller" class="custom-radio"
                               onclick="handleSellerTypeClick('private_seller')"
                               {{ request()->is('private_seller') ? 'checked' : '' }}>
                        <label for="private-seller">Private Seller</label>
                    </div>

                    <!-- Car Dealer Radio Button -->
                    <div class="selection-group">
                        <input type="radio" name="seller-type" id="car-dealer" class="custom-radio"
                               onclick="handleSellerTypeClick('car_dealer')"
                               {{ request()->is('car_dealer') ? 'checked' : '' }}>
                        <label for="car-dealer">Car Dealer</label>
                    </div>

                    </div>

                    <div id="button-container">
                        <button type="submit">Save</button>
                    </div>
                </div>
            </div>
    </div>
</section>
@endsection
