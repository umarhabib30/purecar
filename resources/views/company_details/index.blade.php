@extends('layout.superAdminDashboard')
@section('body')

<link rel="stylesheet" href="{{ asset('css/company_details.css') }}">

<section class="company-details-body">
    <form action="{{ route('company-details-update') }}" method="POST">
        @csrf
        <div class="card-grid">
            <!-- Company Details Card -->
            <div class="card">
                <h2 class="card-title">Company Details</h2>
                <div class="card-content">
                    <label for="name">Company Name</label>
                    <input type="text" name="name" id="name" class="form-input" value="{{ $company_details->name ?? '' }}">

                    <label for="about_us">About Us</label>
                    <textarea id="about_us" name="about_us" class="form-textarea">{{ $company_details->about_us ?? '' }}</textarea>
                </div>
            </div>

            <!-- Social Links Card -->
            <div class="card">
                <h2 class="card-title">Social Links</h2>
                <div class="card-content">
                    @php
                        $socialLinks = [
                            ['name' => 'instagram', 'placeholder' => 'Instagram', 'logo' => 'insta-logo.png'],
                            ['name' => 'youtube', 'placeholder' => 'YouTube', 'logo' => 'yt-logo.png'],
                            ['name' => 'facebook', 'placeholder' => 'Facebook', 'logo' => 'fb-logo.png'],
                            ['name' => 'linkedin', 'placeholder' => 'Tiktok', 'logo' => 'tiktok.png'],
                            ['name' => 'x', 'placeholder' => 'X', 'logo' => 'x-logo.png']
                        ];
                    @endphp
                    @foreach($socialLinks as $link)
                        <div class="social-link-row">
                            <div class="logo">
                                <img src="assets/adminPanelAssets/ps/{{ $link['logo'] }}" alt="{{ $link['placeholder'] }} Logo">
                            </div>
                            <input type="text" name="{{ $link['name'] }}" class="form-input" placeholder="Enter {{ $link['placeholder'] }} URL" value="{{ $company_details->{$link['name']} ?? '' }}">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Contact Details Card -->
            <div class="card">
                <h2 class="card-title">Contact Details</h2>
                <div class="card-content">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-input" value="{{ $company_details->email ?? '' }}">

                    <label for="phone">Phone Number</label>
                    <input type="tel" name="phone" id="phone" class="form-input" value="{{ $company_details->phone ?? '' }}">

                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" class="form-input" value="{{ $company_details->address ?? '' }}">
                </div>
            </div>

            <!-- Ad Cost Card -->
            <div class="card">
                <h2 class="card-title">Ad Cost</h2>
                <div class="card-content">
                    <label for="ad_cost">Ad Cost</label>
                    <input type="number" name="ad_cost" id="ad_cost" class="form-input" value="{{ $company_details->ad_cost ?? '' }}">
                </div>
                <h2 class="card-title">Ad Expiry days</h2>
                <div class="card-content">
                    <label for="ad_expiry">Ad Expiry</label>
                    <input type="number" name="ad_expiry" id="ad_expiry" class="form-input" value="{{ $company_details->ad_expiry ?? '' }}">
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div id="btn-container">
            <button type="button" id="cancel-btn">Cancel</button>
            <button type="submit">Save</button>
        </div>
    </form>
</section>

@endsection
