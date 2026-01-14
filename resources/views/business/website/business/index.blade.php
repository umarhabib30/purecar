@extends('layout.layout')
<meta name="robots" content="noindex, nofollow">

@section('body')
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #fff;
        margin: 0;
        padding: 0;
        color: #111;
    }

    .heading-page {
        text-align: center;
        font-size: 28px;
        margin-top: 40px;
    }

    .subtitle {
        text-align: center;
        color: #666;
        margin-top: 8px;
        font-size: 15px;
    }

    form {
        max-width: 800px;
        margin: 30px auto;
        display: flex;
        justify-content: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    select {
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #ddd;
        background-color: #f9f9f9;
        min-width: 180px;
        width: 100%;
    }

    button {
        padding: 12px 20px;
        background-color: #1f1f1f;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
    }

    button:hover {
        background-color: #333;
    }

    .clear-link {
        align-self: center;
        color: #333;
        text-decoration: none;
        font-weight: bold;
        margin-left: 5px;
    }

    .business-list {
        width: 80%;
        margin: auto;
        padding: 0 20px;
    }

    .business-card {
        background-color: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 12px;
        padding: 20px;
        margin: 16px 0;
        gap: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.03);
        overflow: hidden;
        display: flex;
    }

    .business-card-img {
        height: 100%;
        width: 150px;
        border-radius: 10px;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        flex-shrink: 0;
    }

    .business-info {
        width: 85%;
        gap: 20px;
        display: flex;
        justify-content: space-between;
    }

    .desc-mobile {
        display: none;
    }

    .desc-desktop {
        display: block;
    }

    .no-options {
        color: #666;
        font-style: italic;
    }

    @media screen and (min-width:787px) {
        .input-inner-div {
            width: 300px;
        }
    }

    @media screen and (max-width:786px) {
        .heading-page {
            text-align: center;
            font-size: 28px;
            margin-top: 20px;
        }
        .subtitle {
            text-align: center;
            padding: auto;
        }
        .business-card {
            padding: 10px;
            flex-direction: column;
        }
        .business-card-img {
            width: 100%;
            height: 150px;
            margin-bottom: 10px;
        }
        .business-list {
            width: 98%;
            margin: auto;
            padding: 0 5px;
        }
        .business-info {
            flex-direction: column;
            width: 100%;
            gap: 15px;
        }
        .business-details {
            min-width: auto;
            width: 100%;
        }
        .business-contact {
            min-width: auto;
            width: 100%;
        }
        .business-details h2,
        .business-contact h2 {
            font-size: 16px;
        }
        .business-details p,
        .business-contact p {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        .desc-mobile {
            display: block;
        }
        .desc-desktop {
            display: none;
        }
        .pagination {
            padding: 0px 20px;
        }

        /* Hide close button on mobile */
        .modal-close {
            display: none;
        }
    }

    .business-details {
        min-width: 250px;
    }

    .business-details h2 {
        margin: 0 0 5px;
        font-size: 18px;
        font-weight: 700;
    }

    .business-contact h2 {
        margin: 0 0 5px;
        font-size: 18px;
        font-weight: 700;
    }

    .business-details p {
        margin: 2px 0;
        font-size: 14px;
        color: #333;
    }

    .business-contact {
        min-width: 220px;
    }

    .business-contact p {
        margin: 6px 0;
        font-size: 14px;
    }

    .business-contact i {
        margin-right: 8px;
    }

    .pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin: 40px 0;
        width: 70%;
    }

    .pagination span, .pagination a {
        font-size: 14px;
        color: #555;
    }

    .pagination a {
        text-decoration: none;
        font-weight: bold;
    }

    .business-card-link {
        cursor: pointer;
        text-decoration: none;
        color: black;
    }

    .custom-select-wrapper {
        position: relative;
        width: 100%;
    }

    .custom-select-wrapper select {
        width: 100%;
        padding: 10px 40px 10px 12px;
        font-size: 14px;
        color: #374151;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-color: #F9FAFB;
    }

    .custom-select-wrapper::after {
        content: '';
        position: absolute;
        top: 50%;
        right: 12px;
        width: 0;
        height: 0;
        pointer-events: none;
        transform: translateY(-50%);
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid #6b7280;
    }

    .business-contact i.fas.fa-map-marker-alt {
        margin-right: 14px;
    }

    .fixed-bottom-end {
        position: fixed;
        top: 500px;
        right: 20px;
        z-index: 1000;
    }

    .fixed-bottom-end-mobile {
        position: fixed;
        bottom: 50px;
        right: 20px;
        z-index: 1000;
    }

    .filter-modal {
        display: none; 
       
        position: fixed;
        z-index: 1000;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.5);
   
  align-items: center;
        justify-content: center;
      
    }

    .filter-modal .modal-content {
        background-color: white;
        /* padding: 20px; */
        border-radius: 8px;
        width: 90%;
        max-width: 400px;
        height: 260px;
        position: relative;
        box-sizing: border-box;
         top: 0px !important;
         overflow: hidden;
    }

    .modal-close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 20px;
        cursor: pointer;
    }

    .desktop-form {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .mobile-filter-btn {
        display: none;
        margin-bottom: 10px;
        text-align: right;
    }

    @media (max-width: 768px) {
        .desktop-form {
            display: none;
        }

        .mobile-filter-btn {
            display: block;
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
        }

        .mobile-filter-btn button {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
        }
    }

    button, .filter-submit {
        padding: 8px 14px;
        background-color: black;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .clear-link {
        margin-left: 10px;
        color: black;
        text-decoration: underline;
        cursor: pointer;
    }

    body.no-scroll {
        overflow: hidden;
    }
</style>

<div  style="margin-bottom: -30px !important; padding-bottom: 0px !important;">

    <h1 class="heading-page p-2">Find {{$count}} Automotive Businesses Near You</h1>
    <p class="subtitle p-2">Browse our growing directory of car dealerships, repair shops, and more. Search by location, service, or business name.</p>

   <a href="{{ route('business.create') }}" class="btn btn-success responsivecategorybutton ms-auto mb-2 d-none d-lg-block fixed-bottom-end d-flex justify-content-center align-items-center">
    <i class="fas fa-briefcase me-2"></i> Add Business
</a>

<a href="{{ route('business.create') }}" class="btn btn-success responsivecategorybutton ms-auto mb-2 d-lg-none fixed-bottom-end-mobile d-flex justify-content-center align-items-center">
    <i class="fas fa-briefcase me-2"></i> Add Business
</a>

    <div class="mobile-filter-btn" style="margin-right: 10px;">
        <button onclick="toggleFilterModal()">Search</button>
    </div>

    <form method="GET" action="{{ route('business.index') }}" class="desktop-form" id="desktop-search-form">
        <div class="input-inner-div">
            <div class="custom-select-wrapper">
                <select name="business_location_id" id="desktop-business-location" onchange="updateBusinessTypes('desktop')">
                    <option value="">Select Location</option>
                    @forelse($businessLocations as $location)
                        <option value="{{ $location->id }}" {{ request('business_location_id') == $location->id ? 'selected' : '' }}>
                            {{ $location->name }}
                        </option>
                    @empty
                        <option value="" disabled class="no-options">No locations available</option>
                    @endforelse
                </select>
            </div>
        </div>

        <div class="input-inner-div">
            <div class="custom-select-wrapper">
                <select name="business_type_id" id="desktop-business-type" onchange="updateBusinessLocations('desktop')">
                    <option value="">Select Business Type</option>
                    @forelse($businessTypes as $type)
                        <option value="{{ $type->id }}" {{ request('business_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @empty
                        <option value="" disabled class="no-options">No business types available</option>
                    @endforelse
                </select>
            </div>
        </div>

        <button type="submit">Search</button>
        <a class="clear-link" href="{{ route('business.index') }}">Clear All</a>
    </form>

    <div id="filterModal" class="filter-modal">
        <div class="modal-content">
          
            <form method="GET" action="{{ route('business.index') }}" class="form-search" style="display: flex; flex-direction:column; width:100%;">
                <div style="width:100%;">
                    <div class="input-inner-div" style="margin-bottom: 10px; width:100%;">
                        <div class="custom-select-wrapper">
                            <select name="business_location_id" id="mobile-business-location" onchange="updateBusinessTypes('mobile')">
                                <option value="">Select Location</option>
                                @forelse($businessLocations as $location)
                                    <option value="{{ $location->id }}" {{ request('business_location_id') == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                @empty
                                    <option value="" disabled class="no-options">No locations available</option>
                                @endforelse
                            </select>
                        </div>
                    </div>

                    <div class="input-inner-div">
                        <div class="custom-select-wrapper">
                            <select name="business_type_id" id="mobile-business-type" onchange="updateBusinessLocations('mobile')">
                                <option value="">Select Business Type</option>
                                @forelse($businessTypes as $type)
                                    <option value="{{ $type->id }}" {{ request('business_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @empty
                                    <option value="" disabled class="no-options">No business types available</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                </div>
                <div style="width:100%; display:flex; flex-direction:column; margin-top: 10px;">
                    <button type="submit" class="filter-submit">Search</button>
                    <a class="clear-link" style="margin-top: 10px;" href="{{ route('business.index') }}">Clear All</a>
                </div>
            </form>
        </div>
    </div>

    <div class="business-list">
        @forelse($businesses as $business)
            <a href="{{ route('business.show.seo', [
                'city' => ($business->businessLocation && $business->businessLocation->name)
                    ? ($business->businessLocation->slug ?? Str::slug($business->businessLocation->name))
                    : 'default-city',
                'category' => ($business->businessType && $business->businessType->name)
                    ? ($business->businessType->slug ?? Str::slug($business->businessType->name))
                    : 'default-category',
                'slug' => $business->slug ?? ($business->name ? Str::slug($business->name) : 'default-business')
            ]) }}" class="business-card-link">
                <div class="business-card">
                    @php
                        $imagePath = $business->images->isNotEmpty()
                            ? asset($business->images->first()->image_path)
                            : asset('assets/noimage.jpeg'); 
                    @endphp

                   <div class="business-card-img-container">
    <img src="{{ $imagePath }}" 
         alt="Business Image" 
         class="business-card-img-simple"
         onerror="this.src='{{ asset('assets/noimage.jpeg') }}'"
    >
</div>
<style>
    /* Option 1: Background image approach */
    .business-card-img {
        height: 100%;
        width: 150px;
        border-radius: 10px;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        flex-shrink: 0;
        min-height: 100px;
        position: relative;
        overflow: hidden;
    }

    .image-loader {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    /* Option 2: Simple img tag approach */
    .business-card-img-container {
        height: 120px;
        width: 150px;
        border-radius: 10px;
        flex-shrink: 0;
        overflow: hidden;
    }

    .business-card-img-simple {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        border-radius: 10px;
    }

    @media screen and (max-width:786px) {
        .business-card-img, .business-card-img-container {
            width: 100%;
            height: 150px;
            margin-bottom: 10px;
        }
    }
</style>
                    <div class="business-info">
                        <div class="business-details">
                            <h2>{{ $business->name }}</h2>
                            <p><strong>{{ $business->businessType->name }}</strong></p>
                            @php
                                $shortDescription = \Illuminate\Support\Str::limit($business->description ?? 'Not provided', 70);
                                $longDescription = \Illuminate\Support\Str::limit($business->description ?? 'Not provided', 160);
                            @endphp
                            <p class="desc-mobile">{{ $shortDescription }}</p>
                            <p class="desc-desktop">{{ $longDescription }}</p>
                        </div>
                        <div class="business-contact">
                            <h2>Contact</h2>
                            <p><i class="fas fa-phone"></i>{{ $business->contact_no }}</p>
                            <p><i class="fas fa-map-marker-alt"></i>{{ $business->businessLocation->name }}</p>
                            @if($business->website)
                                <p>
                                    <i class="fas fa-globe"></i>
                                    <a class="business-card-link" href="{{ $business->website }}" target="_blank">Website</a>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <p style="text-align:center;">No business listings found.</p>
        @endforelse
    </div>

<div style="display: flex; justify-content: center; margin: 20px 0; margin-bottom:0px; padding-bottom: 0px;">
    <div class="pagination" style="display: flex; align-items: center; gap: 15px; font-family: Arial, sans-serif; flex-wrap: wrap; justify-content: center;">
        <div class="pagination-buttons" style="display: flex; gap: 10px;">
            @if($businesses->onFirstPage())
                <span style="padding: 8px 16px; color: #999; cursor: not-allowed;">Previous</span>
            @else
                <a href="{{ $businesses->appends(request()->query())->previousPageUrl() }}" 
                   style="padding: 8px 16px; background-color:rgb(8, 8, 8); color: white; text-decoration: none; border-radius: 4px; transition: background-color 0.3s;">
                    Previous
                </a>
            @endif

            @if($businesses->hasMorePages())
                <a href="{{ $businesses->appends(request()->query())->nextPageUrl() }}" 
                   style="padding: 8px 16px; background-color:rgb(8, 8, 8); color: white; text-decoration: none; border-radius: 4px; transition: background-color 0.3s;">
                    Next
                </a>
            @else
                <span style="padding: 8px 16px; color: #999; cursor: not-allowed;">Next</span>
            @endif
        </div>
        <div class="pagination-info" style="font-size: 14px; color: #333;">
            <span>
                {{ $businesses->currentPage() }} of {{ $businesses->lastPage() }}
            </span>
        </div>
    </div>
</div>

<style>
    /* Default styles (for larger screens) - buttons and info side-by-side */
    .pagination {
        flex-direction: row; /* Buttons and info in a row */
    }

    .pagination-buttons {
        order: 1; /* Buttons come first */
    }

    .pagination-info {
        order: 2; /* Info comes second */
        margin-left: 15px; /* Spacing between buttons and info */
    }

    /* Media query for mobile screens (e.g., less than 768px wide) */
    @media (max-width: 767px) {
        .pagination {
            flex-direction: column; /* Stack items vertically */
            gap: 10px; /* Adjust gap for vertical stacking */
        }

        .pagination-buttons {
            order: 1; /* Buttons remain at the top */
        }

        .pagination-info {
            order: 2; /* Info moves below the buttons */
            margin-top: 10px; /* Add some space above the page info */
            margin-left: 0; /* Remove left margin on mobile */
            text-align: center; /* Center the text on mobile */
        }
    }
</style>
</div>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>


<script>
    function toggleFilterModal() {
        // Only allow modal on mobile devices
        if (window.innerWidth > 768) {
            return; // Exit if on desktop
        }

        const modal = document.getElementById('filterModal');
        const isOpen = window.getComputedStyle(modal).display === 'flex';

        if (isOpen) {
            modal.style.display = 'none';
            document.body.classList.remove('no-scroll');
        } else {
            modal.style.display = 'flex';
            document.body.classList.add('no-scroll');
        }
    }

    // Close modal when clicking outside (only on mobile)
    document.addEventListener('click', function(event) {
        if (window.innerWidth > 768) return; // Skip on desktop

        const modal = document.getElementById('filterModal');
        const modalContent = modal.querySelector('.modal-content');
        const mobileFilterBtn = document.querySelector('.mobile-filter-btn button');

        if (window.getComputedStyle(modal).display === 'flex') {
            if (!modalContent.contains(event.target) && !mobileFilterBtn.contains(event.target)) {
                toggleFilterModal();
            }
        }
    });

    // Close modal on window resize to desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            const modal = document.getElementById('filterModal');
            if (window.getComputedStyle(modal).display === 'flex') {
                modal.style.display = 'none';
                document.body.classList.remove('no-scroll');
            }
        }
    });

    function updateBusinessTypes(device) {
        const locationSelect = document.getElementById(`${device}-business-location`);
        const typeSelect = document.getElementById(`${device}-business-type`);
        const locationId = locationSelect.value;
        const currentTypeId = typeSelect.value;

        fetch(`{{ route('business.types-by-location') }}?business_location_id=${locationId}`)
            .then(response => response.json())
            .then(data => {
                typeSelect.innerHTML = '<option value="">Select Business Type</option>';
                if (data.business_types.length === 0) {
                    typeSelect.innerHTML += '<option value="" disabled class="no-options">No business types available</option>';
                } else {
                    data.business_types.forEach(type => {
                        const option = document.createElement('option');
                        option.value = type.id;
                        option.textContent = type.name;
                        if (type.id == currentTypeId) {
                            option.selected = true;
                        }
                        typeSelect.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching business types:', error);
                typeSelect.innerHTML = '<option value="" disabled class="no-options">Error loading types</option>';
            });
    }

    function updateBusinessLocations(device) {
        const typeSelect = document.getElementById(`${device}-business-type`);
        const locationSelect = document.getElementById(`${device}-business-location`);
        const typeId = typeSelect.value;
        const currentLocationId = locationSelect.value;

        fetch(`{{ route('business.locations-by-type') }}?business_type_id=${typeId}`)
            .then(response => response.json())
            .then(data => {
                locationSelect.innerHTML = '<option value="">Select Location</option>';
                if (data.business_locations.length === 0) {
                    locationSelect.innerHTML += '<option value="" disabled class="no-options">No locations available</option>';
                } else {
                    data.business_locations.forEach(location => {
                        const option = document.createElement('option');
                        option.value = location.id;
                        option.textContent = location.name;
                        if (location.id == currentLocationId) {
                            option.selected = true;
                        }
                        locationSelect.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching business locations:', error);
                locationSelect.innerHTML = '<option value="" disabled class="no-options">Error loading locations</option>';
            });
    }

    window.onload = function() {
        const modal = document.getElementById('filterModal');
        modal.style.display = 'none';
        document.body.classList.remove('no-scroll');

        const desktopLocationId = '{{ request('business_location_id') }}';
        const mobileLocationId = '{{ request('business_location_id') }}';
        const desktopTypeId = '{{ request('business_type_id') }}';
        const mobileTypeId = '{{ request('business_type_id') }}';

        if (desktopLocationId) {
            updateBusinessTypes('desktop');
        }
        if (mobileLocationId) {
            updateBusinessTypes('mobile');
        }
        if (desktopTypeId) {
            updateBusinessLocations('desktop');
        }
        if (mobileTypeId) {
            updateBusinessLocations('mobile');
        }
    };
</script>
@endsection