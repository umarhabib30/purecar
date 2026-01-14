@extends('layout.layout')

@section('body')
    <title>{{ $dealer->name }} - {{ $dealer->location }} | Pure Car Dealer Page</title>
    <meta name="description" content="Browse {{$totaladverts}} available cars from {{ $dealer->name }} located in {{ $dealer->location }}">
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
     

        .dealer-profile-card, .map-advert {
            flex: 1; 
            min-width: 300px; 
            display: flex;
            flex-direction: column;
        }
        .car-card, .advert-card {
            height: 100%; 
            
        }
        .advert-card > div {
            height: 100%; 
        }
        .dealer-page-container{
            padding:20px 70px;
        }
        .main-div-delear-page {
    display: flex;
    gap: 1%;
    padding: 0px 15px;
    align-items: stretch; /* height dono div same */
}

.dealer-profile-card {
    width: 40%;
    background: #f1f1f1;
    box-sizing: border-box;
}

.dealer-profile-big-img {
    width: 100%;
    height: 100px;
    overflow: hidden;
    position: relative;
    display: block;
}

.img-wrapper {
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* ya object-fit: contain; try kar sakta */
}
        @media screen and (max-width:786px){
            .main-div-delear-page{
                display: flex; 
                gap:1%;
                flex-direction: column;
            }
            .dealer-profile-card{
                width:100%;
            }
            .dealer-profile-big-img{
                display: none;
            }
            .map-advert{ 
                display: none;
            }
            .dealer-page-container{
                padding:10px 6px;
            }
        }
        .car-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr); /* default: mobile */
            gap: 1.5rem;
            padding: 1rem;
        }

        @media (min-width: 768px) {
            .car-grid {
                grid-template-columns: repeat(3, 1fr); /* medium screens */
            }
        }

        @media (min-width: 1200px) {
            .car-grid {
                grid-template-columns: repeat(4, 1fr); /* large screens */
            }
        }

        @media (min-width: 1600px) {
            .car-grid {
                grid-template-columns: repeat(5, 1fr); /* extra large screens */
            }
        }

        .car-card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
            transition: transform 0.3s ease;
        }

        .custom-card-inner {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
        }

        .image-wrapper {
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-container {
            position: relative;
            width: 100%;
            height: 100%;
            border-radius: 10px 10px 0 0;
            overflow: hidden;
        }

        .blurred-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            filter: blur(10px);
            z-index: 1;
        }

        .main-image {
            position: relative;
            width: 100%;
            height: 100%;
            object-position: center;
            z-index: 2;
        }

        .icon-row {
            display: flex;
            justify-content: space-between;
            margin-top: 0.5rem;
        }

        .icon-col {
            display: flex;
            align-items: center;
            gap: 4px;
            flex: 1 1 33%;
        }
       

        
@media screen and (min-width: 787px) {
    .main-div-delear-page {
        display: flex;
        flex-direction: row;
        gap: 1%;
        align-items: stretch; 
        height: auto; 
    }
    .dealer-profile-card {
        width: 30% !important; 
        flex: 0 0 30%;
        min-width: 0; 
        height: auto; 
        display: flex;
        flex-direction: column;
    }
    .map-advert {
        width: 69% !important; 
        flex: 0 0 69%; 
        height: 100% !important; 
        margin-top: 1px;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
    }
    .car-card {
        height: 100% !important; 
        display: flex;
        flex-direction: column;
    }
    .advert-card {
        height: 100% !important;
        display: flex;
        flex-direction: column;
    }
    .advert-card > div {
        height: 100% !important;
        display: flex;
        flex-direction: column;
    }
    .image-wrapper {
        height: 100% !important; 
        width: 100% !important;
        display: flex;
        flex: 1; 
        align-items: center;
        justify-content: center;
    }
    .image-container {
        height: 100% !important; 
        width: 100% !important; 
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden; 
        border-radius: 10px 10px 0 0;
    }
    .main-image {
        width: 100% !important; 
        height: 100% !important; 
        max-width: 100% !important; 
        max-height: 100% !important; 
        object-fit: cover !important;
        display: block;
        position: relative;
        z-index: 2;
    }
}
   
    </style>
    {{-- img card height for dealer card height --}}
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            const dealerProfileCard = document.querySelector('.dealer-profile-card');
            const secondDiv = document.querySelector('.main-div-delear-page > div:nth-child(2)');    
            function updateHeight() {
                const dealerProfileHeight = dealerProfileCard.offsetHeight;
                secondDiv.style.height = `${dealerProfileHeight}px`;
            }    
            updateHeight();
            window.addEventListener('resize', updateHeight);
        });
    </script>
    <link rel="stylesheet" href="{{ asset('css/dealerPage.css') }}">
    <div class="">
        <h1 class="mb-0 text-center heading d-none d-md-block"></h1>
        <div class="dealer-page-container" style="background:rgb(255, 255, 255)">
            <div class="">               
                <div class="main-div-delear-page" style="">
                    <div class="card dealer-profile-card" style="">
                        <div class="card-upper">
                            <img src="{{ $dealer->background_image ? asset('images/users/' . $dealer->background_image) : asset('assets/logo.png') }}"
                                alt="Background Image" style="width: 100%; height: 200px;">
                        </div>
                        <div class="p-4">
                            <div class="mb-3 profile-image-container">
                                <img class="profile-image"
                                    src="{{ $dealer->image ? asset('images/users/' . $dealer->image) : asset('assets/profilecar.png') }}"
                                    alt="Dealer Profile Image"
                                    style="width: 5rem !important; height: 5rem !important; object-fit: cover; border-radius: 50%; border: 2px solid #ddd; margin-top: -40px; background-color: white;">
                            </div>
                            <h5 class="card-title">{{ $dealer->name }}</h5>
                              <p class="mb-2 card-text">
                                <i class="bi bi-envelope-fill"></i>
                                <a href="javascript:void(0)" style="text-decoration: none; color:black;" id="emailbutton">Click to email</a>
                            </p>
                            <p class="mb-2 card-text"><i class="bi bi-telephone-fill"></i> {{ $dealer->phone_number }}</p>
                            <p class="mb-2 card-text"><i class="bi bi-geo-alt-fill"></i> {{ $dealer->location }}</p>
                            <p class="mb-2 ">
                           @if (!empty($dealer->website))
                                <a href="{{ preg_match('/^https?:\/\//', $dealer->website) ? $dealer->website : 'https://' . $dealer->website }}"
                                target="_blank" 
                                rel="noopener noreferrer"
                                style="text-decoration: none; color: inherit;">
                                    <i class="bi bi-globe"></i> Visit site
                                </a>
                            @else
                                <i class="bi bi-globe"></i> No Website
                            @endif
                            </p>
                            <br>
                            <h5><strong>Description</strong></h5>
                            <p class="mb-2 card-text"> {{ $dealer->business_desc }}</p>
        
                           
                            @if(!empty($dealer->watsaap_number))
                                <div class="d-block d-md-none text-center">
                                    <a href="https://wa.me/{{ $dealer->watsaap_number }}" 
                                    class="btn btn-dark" 
                                    style="border-radius: 10px; width: 100%; margin-bottom:15px;" 
                                    target="_blank">
                                        Chat Via WhatsApp
                                    </a>
                                </div>
                            @endif

        
                            <div class="d-block d-md-none text-center">
                                <a href="tel:<?php echo $dealer->phone_number; ?>" 
                                class="btn btn-dark" 
                                style="border-radius: 10px; width: 100%; margin-bottom:15px;">
                                    Call
                                </a>
                            </div>
        
                            <div class="d-block d-md-none text-center">
                                <a href="mailto:<?php echo $dealer->inquiry_email; ?>" 
                                class="btn btn-dark" 
                                style="border-radius: 10px; width: 100%; margin-bottom:15px;">
                                    Send Email
                                </a>
                            </div>    
                        </div>
                    </div>
                    <div class="dealer-profile-big-img">
                        <div class="img-wrapper">
                            @if ($adverts->isNotEmpty())
                            @php
                                $car_data = $adverts->first();
                            @endphp
                            <div class="car-card">
                              @if(isset($car_data->car) && $car_data->car->slug)
                                    <a href="{{ route('advert_detail', ['slug' => $car_data->car->slug]) }}" class="card advert-card text-decoration-none">
                                @else
                                    <a href="#" class="card advert-card text-decoration-none">
                                @endif

                                    <div style="position: relative; width: 100%; height: 100%;">
                                        <img src="{{ asset('' . e($car_data['main_image'])) }}" alt="Car Image"
                                            onload="this.naturalWidth > this.naturalHeight ? this.style.objectFit = 'cover' : this.style.objectFit = 'contain'"
                                            onerror="this.onerror=null; this.src='{{ asset('assets/coming_soon.png') }}';"

                                            class="main-image" style="width: 100%; height: 100%; display: block;">
                                        <div style="position: absolute; bottom: 0; left: 0; width: 100%; background-color: rgba(0, 0, 0, 0.8); color: white; text-align: start; padding: 10px; z-index: 10; font-size: 25px; overflow: hidden;">
                                        {{ e($car_data['car']['make'] ?? 'Unknown make') }}
                                                    {{ e($car_data['car']['model'] ?? 'N/A') }}
                                                    {{ e($car_data['car']['year'] ?? 'N/A') }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                        </div>
                    </div>
                </div>
<!-- email model pop up -->


 <div class="modal" id="emailSenderModal" tabindex="-1" aria-labelledby="emailSenderModalLabel" aria-hidden="true" style="z-index: 1065;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; height: auto !important;">
               
                <div class="modal-body">
                    <form id="inquiryForm" method="POST" action="/send-inquiry-dealer">
                        <!-- Hidden field for dealer email -->
                        <input type="hidden" name="dealer_email" value="{{ $dealer->inquiry_email }}">
                        
                        <div class="mb-3">
                            <label for="fullName" class="form-label fw-bold">Name</label>
                            <div class="position-relative">
                                <input type="text" class="form-control ps-5" id="fullName" name="full_name" placeholder="Your Full Name" required style="background-color: #F6F6F6;">
                                <i class="bi bi-person position-absolute" style="top: 50%; left: 15px; transform: translateY(-50%); color: #6c757d;"></i>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="emailInput" class="form-label fw-bold">Email</label>
                            <div class="position-relative">
                                <input type="email" class="form-control ps-5" id="emailInput" name="email" placeholder="Your Email" required style="background-color: #F6F6F6;">
                                <i class="bi bi-envelope position-absolute" style="top: 50%; left: 15px; transform: translateY(-50%); color: #6c757d;"></i>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label fw-bold">Phone Number</label>
                            <div class="position-relative">
                                <input type="text" class="form-control ps-5" id="phoneNumber" name="phone_number" placeholder="Your Phone Number" required style="background-color: #F6F6F6;">
                                <i class="bi bi-telephone position-absolute" style="top: 50%; left: 15px; transform: translateY(-50%); color: #6c757d;"></i>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label fw-bold">Message</label>
                            <textarea class="form-control" id="message" name="message" placeholder="Write your message here..." rows="4" required style="background-color: #F6F6F6;"></textarea>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-dark" id="submitBtn">
                                Send Inquiry
                                <span id="loadingSpinner" class="spinner-border spinner-border-sm text-light" style="display: none;" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true" style="z-index: 10000;">
        <div class="modal-dialog">
            <div class="modal-content" style="height: auto !important;">
             
                <div class="text-center modal-body">
                    <p id="successMessage"><strong>Your inquiry has been sent successfully</strong></p>
                </div>
                <div class="text-center modal-body">
                    <img src="/assets/cardeal.png" alt="Success" style="width: 100px; height: 100px;">
                    <p>We'll get back to you as soon as possible!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

  

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const setupEmailModal = function() {
                const emailBtn = document.getElementById('emailbutton');
                if (!emailBtn) {
                    console.error('Email button not found');
                    return;
                }

                const emailSenderModalElement = document.getElementById('emailSenderModal');
                if (!emailSenderModalElement) {
                    console.error('Email modal not found');
                    return;
                }

                const emailSenderModal = new bootstrap.Modal(emailSenderModalElement, {
                    backdrop: true,
                    keyboard: true,
                    focus: true
                });

                emailBtn.addEventListener('click', function() {
                    console.log('Email button clicked');
                    emailSenderModal.show();
                });
            };

            const setupInquiryForm = function() {
                const inquiryForm = document.getElementById('inquiryForm');
                if (!inquiryForm) {
                    console.error('Inquiry form not found');
                    return;
                }

                inquiryForm.addEventListener('submit', async function(event) {
                    event.preventDefault();
                    console.log('Form submission started');

                    const formData = new FormData(this);
                    const submitBtn = document.getElementById('submitBtn');
                    const loadingSpinner = document.getElementById('loadingSpinner');

                    // Add CSRF token if available
                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (csrfToken) {
                        formData.append('_token', csrfToken.getAttribute('content'));
                    }

                    if (submitBtn) submitBtn.disabled = true;
                    if (loadingSpinner) loadingSpinner.style.display = 'inline-block';

                    try {
                        const response = await fetch('/send-inquiry-dealer', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                            }
                        });

                        if (response.status === 500) {
                            const errorDetails = await response.text();
                            console.error('Server error details:', errorDetails);
                            alert('The server encountered an error. Please try again later or contact support.');
                            return;
                        }

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const result = await response.json();
                        if (result.status === 'success') {
                            console.log('Form submission successful');
                            
                            // Hide the inquiry modal
                            const emailSenderModalElement = document.getElementById('emailSenderModal');
                            if (emailSenderModalElement) {
                                const inquiryModalInstance = bootstrap.Modal.getInstance(emailSenderModalElement);
                                if (inquiryModalInstance) inquiryModalInstance.hide();
                            }

                            // Show success message
                            const successMessage = document.getElementById('successMessage');
                            if (successMessage) successMessage.innerHTML = `<strong>${result.message}</strong>`;

                            const successModalElement = document.getElementById('successModal');
                            if (successModalElement) {
                                const successModal = new bootstrap.Modal(successModalElement);
                                successModal.show();
                            }

                            // Reset form
                            this.reset();
                        } else {
                            console.warn('Form submission failed:', result.message);
                            alert(result.message || 'An error occurred. Please try again.');
                        }
                    } catch (error) {
                        console.error('Error submitting form:', error);
                        alert('An error occurred. Please check your network and try again.');
                    } finally {
                        console.log('Cleaning up: hiding spinner and enabling button');
                        if (loadingSpinner) loadingSpinner.style.display = 'none';
                        if (submitBtn) submitBtn.disabled = false;
                    }
                });
            };

            setupEmailModal();
            setupInquiryForm();
        });
    </script>

                <div class="" style="padding:0px 15px;">
                    <div class="container-">
                        <div class="grid-for-car-cards">
                            @foreach ($adverts as $car_data)
                                <div class="my-3">
                                   @if(isset($car_data->car) && $car_data->car->slug)
                                        <a href="{{ route('advert_detail', ['slug' => $car_data->car->slug]) }}" class="text-decoration-none text-dark">
                                    @else
                                        <a href="#" class="text-decoration-none text-dark">
                                    @endif

                                        <div class="main_car_card">
                                            <div class="car_card_main_img">
                                                <div class="car_card_inner_img">
                                                    <!-- Blurred background -->
                                                    <div class="car_card_background_img" style="background-image: url('{{ asset('' . e($car_data['image'])) }}');"></div>
                        
                                                    <!-- Actual image -->
                                                    <img src="{{ asset('' . e($car_data['image'])) }}" alt="Car Image"
                                                        onload="this.naturalWidth > this.naturalHeight ? this.style.objectFit = 'cover' : this.style.objectFit = 'contain'"
                                                                    onerror="this.onerror=null; this.src='{{ asset('assets/coming_soon.png') }}';"
                                                        class="car_card_front_img">
                                                </div>
                                            </div>
                                            <div class="p-3 card-contain">
                                                <p class="car_tittle text-truncate">{{ e($car_data['car']['make'] ?? 'Unknown make') }}
                                                    {{ e($car_data['car']['model'] ?? 'N/A') }}
                                                    {{ e($car_data['car']['year'] ?? 'N/A') }}
                                                </p>
                                                <p class="car_varient text-truncate">
                                                   @if (empty($car_data['car']['Trim']) || $car_data['car']['Trim'] == 'N/A')
                                                        {{ strtoupper(e($car_data['car']['advert_variant'] ?? '')) }}
                                                    @else
                                                        {{ strtoupper(e($car_data['car']['Trim'])) }}
                                                    @endif

                                                </p>
                        
                                                <div class="car_detail">
                                                    <div class="text-center car_detail-item">{{ e(isset($car_data['car']['miles']) ? number_format($car_data['miles'], 0, '.', ',') : 'N/A') }}</div>
                                                    <div class="text-center car_detail-item">{{ e($car_data['car']['fuel_type'] ?? 'N/A') }}</div>
                                                    <div class="text-center car_detail-item">{{ e($car_data['car']['gear_box'] ?? 'N/A') }}</div>
                                                </div>
                        
                                                <div class="height"></div>
                                                <div class="car_detail_bottom">
                                                    <p class="car_price">
                                                        {{ e(isset($car_data['car']['price']) && $car_data['car']['price'] > 0 ? '£' . number_format($car_data['car']['price'], 0, '.', ',') : 'POA') }}
                                                    </p>
                                                    <p class="car_location">
                                                        {{ $car_data['user']['location'] }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>                        
                    </div>
                </div>


            </div>
        </div>
    </div>

    <style>
        .scrollable-container-vertical {
            max-height: 800px;

            overflow-y: auto;

            overflow-x: hidden;
            padding-right: 10px;
        }

        .sold-label {
            position: absolute;
            top: 5px;
            right: -25px;
            background: black;
            color: white;
            font-weight: bold;
            padding: 5px 10px;
            transform: rotate(45deg);
            font-size: 18px;
            border-radius: 4px;
            z-index: 10;
            width: 90px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .header-container {
                display: flex !important;
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .header-container div {
                display: none;
            }

            .title {
                font-size: 24px;
                margin-bottom: 10px;
            }

            .view-all {
                justify-self: center;
                margin-top: 10px;
            }

        }

        @media (max-width: 767px) {
            .articles-grid>div:nth-child(n+2) {
                display: none !important;
            }

            .recentlyadded {
                margin-top: 20px !important;
            }
            .review-section-mainDiv{
                display: flex;
                flex-direction: column;
                padding:10px 20px !important;
            }
            .review-form-leftSide{
                width: 100% !important;
            }
        }
        .review-section-mainDiv{
            display: flex;
            padding:20px 70px;
            gap: 2%;
        }
        .review-form-leftSide{
            width: 49%;
        }
    </style>

    <!-- <div class="">
        <div class="" style="margin-top: 10px;                
            width: 100%;
            height: auto;
            margin-bottom: 0;">
            <h1 class="mb-4 text-center heading col-12">Reviews</h1>
            @if (session('success'))
                <style>
                    .custom-swal-popup {
                        background-color: white !important;
                        width: 250px !important;
                        height: 300px !important;
                    }

                    .custom-swal-image {
                        margin-top: 40px !important;
                    }

                    .custom-swal-popup .swal2-html-container {
                        font-weight: bold !important;
                        /* margin-top: 24px !important;  */
                    }

                    @media (max-width: 768px) {
                        .custom-swal-popup {
                            width: 90% !important;
                        }
                    }
                </style>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        @if (session('success'))
                            Swal.fire({
                                imageUrl: '{{ asset('
                                            assets / reviewsmodel.png ') }}',
                                html: "<strong>{{ session('success') }}</strong>",
                                imageWidth: 150,
                                imageHeight: 130,
                                imageAlt: 'Success',
                                showConfirmButton: false,
                                timer: 2000,
                                customClass: {
                                    popup: 'custom-swal-popup',
                                    image: 'custom-swal-image'

                                }
                            });
                        @endif
                    });
                </script>
            @endif

            <script>
                @if (session('error'))
                    console.log('error fired')
                    Swal.fire({
                        imageUrl: '{{ asset('
                                assets / loginiconmodel.png ') }}',
                        text: '{{ session('
                                error ') }}',
                        imageWidth: 150,
                        imageAlt: 'Login Required',
                        showConfirmButton: false,
                        timer: 2000,
                        customClass: {
                            popup: 'custom-swal-popup'
                        }
                    });
                @endif
            </script>
            <div class="review-section-mainDiv">
                <div class="review-form-leftSide" id="new-review-form">
                    <h6 style="font-weight: 600;">Add your reviews</h6>
    
                    <form action="{{ route('submit1.review', ['dealerId' => $dealer->id]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea name="reviews" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="rating">Rating:</label>
                            <div class="star-rating" style="display: flex;">
                                <span data-value="1" class="star">&#9733;</span>
                                <span data-value="2" class="star">&#9733;</span>
                                <span data-value="3" class="star">&#9733;</span>
                                <span data-value="4" class="star">&#9733;</span>
                                <span data-value="5" class="star">&#9733;</span>
                            </div>
                            <input type="hidden" name="rating" value="0">
                        </div>
                        @auth
                        <div style="display: flex; justify-content:end;">
                            <button type="submit" class="mt-4 custom-btndealer"
                                style="
                                    height: 45px;
                                    color: #ffffff;
                                    background-color: #000;
                                    border: none;
                                    outline: none;
                                    border-radius: 12px;
                                    font-size: 16px;
                                    font-weight: 500;
                                    cursor: pointer;
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                    text-decoration: none;
                                    padding-left: 30px;
                                    padding-right: 30px;
                                ">Submit Review
                            </button>
                        </div>
                        @endauth
                    </form>
    
    
                    <div class="mt-4 d-none d-md-flex align-items-center justify-content-between">
    
    
                        <div>
                            <h2 class="font-weight-bold" style="font-size: 36px;">
                                {{ round($reviews->avg('rating'), 1) }}
                                <span style="font-size: 20px; font-weight: normal;">/ 5</span>
                            </h2>
    
                            <p class="text-muted" style="font-size: 14px;">Based on {{ $reviews->count() }} total reviews</p>
                            <div class="mt-2">
                                @php
                                    $averageRating = round($reviews->avg('rating'), 1);
                                    $fullStars = floor($averageRating);
                                    $halfStar = $averageRating - $fullStars >= 0.5 ? 1 : 0;
                                    $emptyStars = 5 - ($fullStars + $halfStar);
                                @endphp
    
                             
                                @for ($i = 1; $i <= $fullStars; $i++)
                                    <span class="fa fa-star" style="color: gold; font-size: 30px;"></span>
                                @endfor
    
                           
                                @if ($halfStar)
                                    <span class="fa fa-star-half-alt" style="color: gold; font-size: 30px;"></span>
                                @endif
    
               
                                @for ($i = 1; $i <= $emptyStars; $i++)
                                    <span class="fa fa-star" style="color: lightgray; font-size: 30px;"></span>
                                @endfor
                            </div>
                        </div>
    
    
                        <div>
                            @for ($i = 5; $i >= 1; $i--)
                                <div class="d-flex align-items-center">
                                    <span class="mr-2 font-weight-bold">{{ $i }} ★</span>
                                    <div style="width: 150px; background: lightgray; border-radius: 5px; overflow: hidden;">
                                        <div
                                            style="width: {{ ($reviews->where('rating', $i)->count() / max($reviews->count(), 1)) * 100 }}%; background: gold; height: 10px;">
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
    
                    </div>
    
                    <div class="mt-4 d-flex d-md-none flex-row align-items-center justify-content-between w-100">
                 
                        <div class="d-flex flex-column align-items-start">
                            <h2 class="font-weight-bold" style="font-size: 28px;">
                                {{ round($reviews->avg('rating'), 1) }}
                                <span style="font-size: 16px; font-weight: normal;">/ 5</span>
                            </h2>
                            <p class="text-muted" style="font-size: 12px;">Based on {{ $reviews->count() }} total reviews</p>
    
                            @php
                                $averageRating = round($reviews->avg('rating'), 1);
                                $fullStars = floor($averageRating);
                                $halfStar = $averageRating - $fullStars >= 0.5 ? 1 : 0;
                                $emptyStars = 5 - ($fullStars + $halfStar);
                            @endphp
    
            
                            <div>
                                @for ($i = 1; $i <= $fullStars; $i++)
                                    <span class="fa fa-star" style="color: gold; font-size: 24px;"></span>
                                @endfor
    
                                @if ($halfStar)
                                    <span class="fa fa-star-half-alt" style="color: gold; font-size: 24px;"></span>
                                @endif
    
                                @for ($i = 1; $i <= $emptyStars; $i++)
                                    <span class="fa fa-star" style="color: lightgray; font-size: 24px;"></span>
                                @endfor
                            </div>
                        </div>
    
                        <div class="d-flex flex-column align-items-start">
                            @for ($i = 5; $i >= 1; $i--)
                                <div class="d-flex align-items-center">
                                    <span class="mr-2 font-weight-bold">{{ $i }} ★</span>
                                    <div style="width: 100px; background: lightgray; border-radius: 5px; overflow: hidden;">
                                        <div
                                            style="width: {{ ($reviews->where('rating', $i)->count() / max($reviews->count(), 1)) * 100 }}%; background: gold; height: 8px;">
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
    
    
    
                </div>    
                <div class="review-form-leftSide" id="update-review-form" style="display: none;">
                    <h6 style="font-weight: 600;">Update your review</h6>
                    <form action="{{ route('submit.review', ['dealerId' => $dealer->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="review_id" id="update-review-id">
                        <div class="form-group">
                            <textarea name="reviews" id="update-reviews" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="rating">Rating:</label>
                            <div class="star-rating">
                                <span data-value="1" class="star">&#9733;</span>
                                <span data-value="2" class="star">&#9733;</span>
                                <span data-value="3" class="star">&#9733;</span>
                                <span data-value="4" class="star">&#9733;</span>
                                <span data-value="5" class="star">&#9733;</span>
                            </div>
                            <input type="hidden" name="rating" id="update-rating" value="0">
                        </div>
                        <button type="submit" class="mt-4 custom-btn">Update Review</button>
                        <button type="button" class="mt-4 ml-2 btn btn-secondary" onclick="cancelUpdate()">Cancel</button>
                    </form>
                </div>
                <div class="p-4 reviews-show review-form-leftSide" style="max-height: 400px; overflow-y: auto;">
                    @foreach ($reviews->sortByDesc('created_at') as $review)
                        <div class="mb-3 review-item">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $review->user ? asset('images/users/' . $review->user->image) : asset('assets/forum-author-pic.png') }}"
                                        alt="User Avatar"
                                        style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%; margin-right: 10px;">
                                    <div>
                                        <h6 class="mb-0">
                                            {{ $review->auth_id == 0 ? 'Guest' : ($review->user ? $review->user->name : 'Unknown') }}
                                        </h6>
                                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                @if (Auth::check() && Auth::id() === $review->auth_id)
                                    <button class="btn btn-sm btn-dark edit-review"
                                        onclick="showUpdateForm('{{ $review->id }}', '{{ $review->reviews }}', {{ $review->rating }})">
                                        Edit
                                    </button>
                                @endif
                            </div>
                            <div class="mt-1 rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="star"
                                        style="color: {{ $i <= $review->rating ? 'gold' : 'gray' }};">&#9733;</span>
                                @endfor
                            </div>
                            <p class="mt-2">{{ $review->reviews }}</p>
                            <hr>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Star rating functionality for both forms
            document.querySelectorAll('.star-rating').forEach(ratingGroup => {
                const stars = ratingGroup.querySelectorAll('.star');
                const ratingInput = ratingGroup.parentElement.querySelector('input[name="rating"]');

                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const value = this.getAttribute('data-value');
                        ratingInput.value = value;

                        // Update stars visual
                        stars.forEach(s => {
                            s.style.color = s.getAttribute('data-value') <= value ?
                                'gold' : 'gray';
                        });
                    });
                });
            });
        });

        function showUpdateForm(reviewId, reviewText, rating) {
            document.getElementById('new-review-form').style.display = 'none';
            document.getElementById('update-review-form').style.display = 'block';
            document.getElementById('update-review-id').value = reviewId;
            document.getElementById('update-reviews').value = reviewText;
            document.getElementById('update-rating').value = rating;
            const stars = document.getElementById('update-review-form').querySelectorAll('.star');
            stars.forEach(star => {
                star.style.color = star.getAttribute('data-value') <= rating ? 'gold' : 'gray';
            });
            document.getElementById('update-review-form').scrollIntoView({
                behavior: 'smooth'
            });
        }

        function cancelUpdate() {
            // Hide update form and show new review form
            document.getElementById('update-review-form').style.display = 'none';
            document.getElementById('new-review-form').style.display = 'block';

            // Reset update form
            document.getElementById('update-review-form').reset();
            const stars = document.getElementById('update-review-form').querySelectorAll('.star');
            stars.forEach(star => star.style.color = 'gray');
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const stars = document.querySelectorAll('#star-rating .star');
            const ratingInput = document.getElementById('rating');
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.getAttribute('data-value'));
                    ratingInput.value = rating;
                    stars.forEach(star => {
                        star.classList.remove('selected');
                    });
                    for (let i = 0; i < rating; i++) {
                        stars[i].classList.add('selected');
                    }
                });
                star.addEventListener('mouseover', function() {
                    const rating = parseInt(this.getAttribute('data-value'));
                    stars.forEach((star, index) => {
                        if (index < rating) {
                            star.style.color = 'gold';
                        } else {
                            star.style.color = 'gray';
                        }
                    });
                });
                star.addEventListener('mouseout', function() {
                    const currentRating = parseInt(ratingInput.value);
                    stars.forEach((star, index) => {
                        if (index < currentRating) {
                            star.style.color = 'gold';
                        } else {
                            star.style.color = 'gray';
                        }
                    });
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if (Session::has('error'))
                Swal.fire({
                    imageUrl: '{{ asset('
                            assets / loginiconmodel.png ') }}',
                    text: '{{ session('
                            error ') }}',
                    imageWidth: 150,
                    imageAlt: 'Login Required',
                    showConfirmButton: false,
                    timer: 2000,
                    customClass: {
                        popup: 'custom-swal-popup'
                    }
                });
            @endif
        });
</script> -->



@endsection 
