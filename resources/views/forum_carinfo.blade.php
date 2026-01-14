@extends('layout.layout')
<title>{{ $car_info['make'] }} {{ $car_info['model'] }} for Sale in {{ $car_info['user']['location'] }} | Pure Car
</title>
<meta name="description"
    content="Explore the {{ $car_info['year'] }} {{ $car_info['make'] }} {{ $car_info['model'] }} for sale in {{ $car_info['user']['location'] }} on Pure Car.">
<meta property="og:title" content="{{ $meta_title }}" />
<meta property="og:description" content="{{ $meta_description }}" />
<meta property="og:image" content="{{ $meta_image }}" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="fb:app_id" content="542551481550768" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:type" content="article" />
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $meta_title }}">
<meta name="twitter:description" content="{{ $meta_description }}">
<meta name="twitter:image" content="{{ $meta_image }}">

@section('body')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.x.x/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.x.x/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Bundle JS (must be after content & before closing </body>) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/forum_carinfo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/news_articles.css') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Manrope:wght@200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
            *{
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            
            }

            #carinfo-main-container {
                background-color: #F5F6FA;
                font-family: 'Manrope', sans-serif;
                display: flex;
                flex-direction: column;
                overflow-x: hidden;
                padding: 10px;
            }
            #container-2{
                display:flex;
                flex-direction: row;
            }
            .full-img-container{
                background: white; 
                overflow: hidden; 
                margin-bottom: 10px;
                position: relative;
            }
            .full-img{
                height: 500px; 
                overflow: hidden;
            }
            .button-gallery{
                position: absolute;
                z-index: 999;
                bottom: 0px;
                width: 100%;
                
            }
            .total-gallery{
                position: absolute;
                z-index: 999;
                top: 2%;
                left: 2%;
            }
            .first-containe-detail-box{
                width: 64%; 
                margin: 0 auto;
            }
            .car-detail-block{
                width: 35%; 
                overflow:hidden;
                padding: 8px 16px;
            }
            .buttons-home{
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                margin: auto;
                margin-top:20px;
                width: 90%; 
                transform: scale(0.9, 1); 
                transform-origin: center;
            }
            .car-detail-block-desktop{
                display: block;
            }
            .car-detail-block-mobile{
                display: none;
            }
            #personal-details{
                background-color: #F7F7F5; 
                border: none;
                padding: 16px;
            }
            .overview-row{
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-bottom: 1px solid rgba(240, 237, 237, 0.808);
            }
            .overview-row p{
                margin: 0;
                padding: 0;
            }
            .overview-grid{
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 15px;
                column-gap: 70px;
              
            }
            #selected-option-detail{
                width:85%;
                padding-left: 8px;
                padding-right: 8px;
            }
            @media screen and (max-width:1021px){
                .first-containe-detail-box{
                    width: 100%; 
                    margin: 0 auto;
                }
                #container-2{
                    flex-direction: column;
                }
                .car-detail-block{
                    width: 100%; 
                    overflow:hidden;
                    padding: 0px;
                }
                .buttons-home{
                    display: none;
                }
                .car-detail-block-desktop{
                    display: none;
                }
                .car-detail-block-mobile{
                    display: block;
                }
                #personal-details{
                    background-color: #F7F7F5; 
                    border: none;
                    padding: 16px;
                }
            }
            @media screen and (max-width:786px){
                .overview-grid{
                    display: grid;
                    grid-template-columns: 1fr;
                }
                #selected-option-detail{
                    min-width:110%;
                }
            }
    </style>
    <section id="carinfo-main-container" class="" style="padding-bottom: 0px; background: white;">
        <div id="notification" class="alert alert-success notification" style="display: none;" role="alert">
            Advert copied!
        </div>
        <div id="container-4" class="buttons-home">
        <a href="{{ url()->previous() }}" style="color: inherit; text-decoration: none; font-weight: 900;">
            <i class="fas fa-arrow-left"></i> Back to results
        </a>


            <!-- Icon container for desktop-->
            <div class="gap-1 ms-auto d-flex align-items-center">
            <a href="#" id="favourite-btn" class="p-0 border-0 btn d-flex align-items-center" 
                data-id="{{ $car_info['advert']['advert_id'] }}" 
                data-user-id="{{ auth()->id() }}" 
                data-favorite="{{ $car_info['advert']['favourite'] ? '1' : '0' }}">
                    <svg id="heart-icon" width="33.92" height="25.44" viewBox="0 0 34 26" 
                        xmlns="http://www.w3.org/2000/svg" style="cursor: pointer; background: white;" 
                        class="mobileicons">
                        <path id="heart-outline" 
                            d="M17 21.5C17 21.5 3 14.5 3 7.5C3 4.5 5.5 2 8.5 2C11.5 2 14 5 17 5C20 5 22.5 2 25.5 2C28.5 2 31 4.5 31 7.5C31 14.5 17 21.5 17 21.5Z" 
                            stroke="#FF0000" stroke-width="2" fill="none"
                            style="{{ $car_info['advert']['favourite'] ? 'display: none;' : '' }}"/>
                        <path id="heart-filled" 
                            d="M17 21.5C17 21.5 3 14.5 3 7.5C3 4.5 5.5 2 8.5 2C11.5 2 14 5 17 5C20 5 22.5 2 25.5 2C28.5 2 31 4.5 31 7.5C31 14.5 17 21.5 17 21.5Z" 
                            fill="#FF0000"
                            style="{{ $car_info['advert']['favourite'] ? '' : 'display: none;' }}"/>
                    </svg>
                </a>
                            <i class="fas fa-share-from-square" id="shareadvert" style="font-size: 25.44px; width: 33.92px; height: 25.44px; color: black; background: white; display: inline-flex; align-items: center; justify-content: center; cursor: pointer;" class="mobileicons"></i>

            </div>
            <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        if (window.innerWidth <= 768) { 
                            const targetDiv = document.querySelector('.gap-1.ms-auto.d-flex.align-items-center');
                            if (targetDiv) {
                                targetDiv.remove();
                            }
                        }
                    });
                </script>

            <!-- Icon container for mobile-->
        </div>
        <div id="container-2" class="m-auto mt-3 container-fluid"
            style="padding-left:0px; padding-right:0px; width: 90%;
            transform: scale(0.9, 1);
            transform-origin: center;
            ">
           <div class="first-containe-detail-box">
    {{-- Logo + Main Car Image --}}
    @php
        $allImages = collect();
        if ($car_info->main_image) {
            $allImages->push((object) ['image_url' => $car_info->main_image]);
        }
        $allImages = $allImages->concat($car_info['advert_images']->reverse()->values());
        $totalImages = $allImages->count();
    @endphp
    <div class="full-img-container">
        <div id="full-img" style="height: 77%;">
            <img src="{{ asset($car_info->main_image) }}" 
                 onerror="this.src='{{ asset('assets/coming_soon.png') }}'" 
                 alt="Main Car Image" 
                 id="displayed-img" 
                 class="car-pic"
                 style="width: 100%; height: 100%; object-fit: cover; object-position: center; image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;">
        </div>
        <div class="total-gallery">
        </div>
        <div class="button-gallery">
            <div style="display: flex; justify-content: flex-end; padding: 10px 20px;">
                <button class="camera-button"
                        style="background: rgba(0, 0, 0, 0.667); color: white; padding: 6px 16px; border:none; border-radius: 12px; font-size: 14px;">
                    <i class="fas fa-camera"></i> {{ $totalImages }}
                </button>
            </div>
        </div>
    </div>

    <div style="display: flex; gap: 2%; flex-wrap: wrap;">
        @foreach ($allImages as $index => $image)
            <div style="{{ $index < 3 ? '' : 'display: none;' }} flex: 0 0 32%; height: 190px; overflow:hidden; background: #f0f0f0;">
                <img src="{{ asset($image->image_url) }}" 
                     onerror="this.src='{{ asset('assets/coming_soon.png') }}'" 
                     alt="Car Image" 
                     class="car-pic"
                     style="width: 100%; height: 100%; object-fit: cover; object-position: center; image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;">
            </div>
        @endforeach
    </div>


    <!-- Notes Display -->
@if($car_info->advert->notes->isNotEmpty())
    <div class="notes-container d-block d-md-none" style="margin-top: 15px; display: flex; flex-direction: column; gap: 10px;">
        @foreach($car_info->advert->notes as $note)
            <div class="note note-{{ $note->type }}"
                 style="padding: 10px 15px; border-radius: 8px; font-family: 'Manrope', sans-serif; font-size: 14px; font-weight: 600; line-height: 1.4;">
                {{ $note->content }}
            </div>
        @endforeach
    </div>
@endif
</div>
            <div class="car-detail-block">
                <div class="car-detail-block-desktop">
                    <div id="" class="" style="">
                        <div id="c1-sub1">
                            <p style="font-size: 1.45rem; font-weight:600; margin:0px; padding:0px;" id="name"
                                class="dm-font">{{ $car_info['make'] }} {{ $car_info['model'] }}
                                {{ $car_info['year'] }}</p>
                            <p style="font-size: 1.25rem; font-weight:400; margin:0px; padding:0px; color: #666666;" id="detail">
                               @if(isset($car_info['Trim']) && $car_info['Trim'] !== null)
                                    {{ $car_info['Trim'] }}
                                @else
                                     {{ $car_info['advert_variant'] }}
                                @endif

                            
                            
                            </p>
                        </div>
                        <div id="c1-sub2"
                            style="display: flex; align-items:center; margin-top:10px; margin-bottom:10px; gap: 10px;">
                            <div id="c1-sub2-1" style="background-color:#F3F6FD; border-radius:8px; padding:4px 8px;">
                                <p style="margin: 0px; padding:0px;">{{ number_format($car_info['miles'], 0, '.', ',') }}
                                    miles</p>
                            </div>
                            <div id="c1-sub2-2" style="background-color:#F3F6FD; border-radius:4px; padding:4px 8px;">
                                <p style="margin: 0px; padding:0px;">
                                {{ preg_split('/\s+/', trim($car_info['fuel_type'] ?? 'Unknown'))[0] }}
                                </p>
                            </div>
                             @if(!empty($car_info['gear_box']))
                            <div id="c1-sub2-3" style="background-color:#F3F6FD; border-radius:4px; padding:4px 8px;">
                                <p style="margin: 0px; padding:0px;">{{ $car_info['gear_box'] }}</p>
                            </div>
                            @endif
                              @if(!empty($car_info['body_type']))
                            <div id="c1-sub2-3" style="background-color:#F3F6FD; border-radius:4px; padding:4px 8px;">
                                <p style="margin: 0px; padding:0px;">{{ $car_info['body_type'] }}</p>
                            </div>
                              @endif
                           
                        </div>
                        <div id="c1-sub3">
                        <p id="price-val" class="dm-font"
                            style="margin:0; padding:0; font-size:30px; font-weight:900;">
                            {{ e(isset($car_info['price']) && $car_info['price'] > 0 ? '£' . number_format($car_info['price'], 0, '.', ',') : 'POA') }} 
                            <span style="font-weight:900; font-size:20px; position:relative; top:-6px;">(Mention PureCar)</span>
                        </p>



                        </div>
                    </div>
                </div>
                <div class="car-detail-block-mobile">
                    <div id="" class="">
                        <div id="">
                            <div id="">
                                <div
                                    style="display: flex; justify-content:space-between; align-items:center; margin-top:10px;">
                                    <p id="name"
                                        style="font-size: 1.35rem; font-weight:800; margin:0px; padding:0px;"
                                        class="dm-font">{{ $car_info['make'] }} {{ $car_info['model'] }}
                                        {{ $car_info['year'] }}</p>
                                    <div id="" style="width:20%; justify-content:end;" class="d-flex gap-2">
                         
                                        <div class="gap-3 d-flex align-items-center">
                                        <a href="#" id="favourite-btn" class="p-0 border-0 btn d-flex align-items-center" 
                                                data-id="{{ $car_info['advert']['advert_id'] }}" 
                                                data-user-id="{{ auth()->id() }}" 
                                                data-favorite="{{ $car_info['advert']['favourite'] ? '1' : '0' }}">
                                                    <svg id="heart-icon" width="33.92" height="25.44" viewBox="0 0 34 26" 
                                                        xmlns="http://www.w3.org/2000/svg" style="cursor: pointer; background: white;" 
                                                        class="mobileicons">
                                                        <path id="heart-outline" 
                                                            d="M17 21.5C17 21.5 3 14.5 3 7.5C3 4.5 5.5 2 8.5 2C11.5 2 14 5 17 5C20 5 22.5 2 25.5 2C28.5 2 31 4.5 31 7.5C31 14.5 17 21.5 17 21.5Z" 
                                                            stroke="#FF0000" stroke-width="2" fill="none"
                                                            style="{{ $car_info['advert']['favourite'] ? 'display: none;' : '' }}"/>
                                                        <path id="heart-filled" 
                                                            d="M17 21.5C17 21.5 3 14.5 3 7.5C3 4.5 5.5 2 8.5 2C11.5 2 14 5 17 5C20 5 22.5 2 25.5 2C28.5 2 31 4.5 31 7.5C31 14.5 17 21.5 17 21.5Z" 
                                                            fill="#FF0000"
                                                            style="{{ $car_info['advert']['favourite'] ? '' : 'display: none;' }}"/>
                                                    </svg>
                                                </a>
                                       
                                                        <i class="fas fa-share-from-square" id="shareadvertmobile" style="font-size: 20px; width: 20px; height: 20px; color: black; background: white; display: inline-flex; align-items: center; justify-content: center; cursor: pointer;" class="mobileicons"></i>

                                        </div>
                                     
                                    </div>
                                </div>
                                <p style="font-size: 1.25rem; font-weight:400; margin:0px; padding:0px; color: #666666;" id="detail">
                                  
                                    @if(isset($car_info['Trim']) && $car_info['Trim'] !== null)
                                    {{ $car_info['Trim'] }}
                                @else
                                     {{ $car_info['advert_variant'] }}
                                @endif
                                </p>
                            </div>
                        </div>
                        <div id="" style="display: flex; gap:10px; align-items:center;">
                            <div id="c1-sub2-1" style="background-color:#F3F6FD; border-radius:4px; padding:4px 8px;">
                                <p style="margin: 0px; padding:0px;">{{ number_format($car_info['miles'], 0, '.', ',') }}
                                    miles</p>
                            </div>
                            <div id="c1-sub2-2" style="background-color:#F3F6FD; border-radius:4px; padding:4px 8px;">
                                <p style="margin: 0px; padding:0px;">{{ preg_split('/\s+/', trim($car_info['fuel_type'] ?? 'Unknown'))[0] }}</p>
                            </div>
                            <div id="c1-sub2-3" style="background-color:#F3F6FD; border-radius:4px; padding:4px 8px;">
                                <p style="margin: 0px; padding:0px;">{{ $car_info['gear_box'] }}</p>
                            </div>
                           
                        </div>
                        <div style="margin-top:15px; margin-bottom:15px;">
                            <p id="price-val" class="dm-font"
                                style="margin:0px; padding:0px; font-size:30px; font-weight:900;">
                                {{ e(isset($car_info['price']) && $car_info['price'] > 0 ? '£' . number_format($car_info['price'], 0, '.', ',') : 'POA') }} 
                                <span style="font-weight:900; font-size:20px; position:relative; top:-3px;">(Mention PureCar)</span>

                               
                            </p>
                        </div>
                    </div>
                </div>
                <div id="personal-details">
                    <img src="{{ $car_info->user->image ? asset('images/users/' . $car_info->user->image) : asset('assets/profilecar.png') }}"
                        alt="Profile picture" id="pfp"
                        style="margin-bottom:15px; width: 90px !important; height: 80px !important; object-fit: cover; border-radius: 50%; border: 2px solid #ddd;  background-color: white; cursor: pointer;"
                        @if ($car_info->user->role === 'car_dealer') onclick="window.location.href='{{ route('dealer.profile', ['slug' => $car_info->user->slug]) }}'" @endif>
                    <p style="margin:0px; padding:0px; margin-bottom:10px; font-weight: 700; font-size: 1.5rem;" id="name"><a
                            href="{{ route('dealer.profile', ['slug' => $car_info->user->slug]) }}"
                            style="text-decoration: none;color:black;">{{ $car_info['user']['name'] }}</a></p>
                    <div class="details-group" style="margin-bottom:10px;">
                        @if ($car_info['user']['role'] === 'car_dealer')
                            <p style="margin:0px; padding:0px; font-weight: 400;">{{ $total_cars }} Cars for sale</p>
                        @elseif ($car_info['user']['role'] === 'private_seller')
                            <p style="margin:0px; padding:0px; font-weight: 400;">Private Seller</p>
                        @endif
                    </div>
                    <div class="details-group" style="margin-bottom:10px;">
                
                            <p style="margin:0px; padding:0px; font-weight: 400;">Verified user: Yes
                
                    
                            </p>
                      
                    </div>
                    <div class="details-group d-flex" style="align-items: center; gap:10px; margin-bottom:10px;">
                        <img src="data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='black'%3E%3Cpath d='M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011-.27 10.05 10.05 0 003.15.52 1 1 0 011 1v3.34a1 1 0 01-1 1A19 19 0 013 4a1 1 0 011-1h3.34a1 1 0 011 1 10.05 10.05 0 00.52 3.15 1 1 0 01-.27 1z'/%3E%3C/svg%3E"
                            alt="Phone">
                        <p style="margin:0px; padding:0px; font-weight: 400;">{{ $car_info['user']['phone_number'] }}</p>
                    </div>
                    <div class="details-group d-flex" style="align-items: center; gap:10px; margin-bottom:10px;">
                        <img src="data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='black'%3E%3Cpath d='M12 2a7 7 0 00-7 7c0 5.25 7 12.25 7 12.25S19 14.25 19 9a7 7 0 00-7-7zm0 9.5a2.5 2.5 0 112.5-2.5 2.5 2.5 0 01-2.5 2.5z'/%3E%3C/svg%3E"
                            alt="Location">
                        <p style="margin:0px; padding:0px; font-weight: 400;">{{ $car_info['user']['location'] }}</p>
                    </div>
                    <div style="display: flex; justify-content:center; width:100%;">
                        <div id="buttons-group" style="margin-bottom:10px; width:90%;">
                       @if(!empty($car_info['user']['watsaap_number']) && strlen($car_info['user']['watsaap_number']) > 5)
                            <button style="margin-bottom:10px; width:100%;" id="call"
                                data-advert-id="{{ $car_info->advert_id }}"
                                data-contact="{{ $car_info['user']['watsaap_number'] }}" class='btn btn-dark'>
                                Chat Via WhatsApp
                            </button>
                        @endif


                            <button style="margin-bottom:10px; width:100%;" id="text"
                                data-advert-id="{{ $car_info->advert_id }}"
                                data-contact="{{ $car_info['user']['phone_number'] }}"
                                class='btn btn-dark d-block d-md-none'>Call</button>
                            <button style="margin-bottom:10px; width:100%;" id="email"
                                data-advert-id="{{ $car_info->advert_id }}"
                                data-contact="{{ $car_info['user']['inquiry_email'] }}" class='btn btn-dark'>Send Email</button>
                        </div>
                    </div>

                    
                </div>

                @if($car_info->advert->notes->isNotEmpty())
    <div class="notes-container d-none d-md-flex" style="margin-top: 15px; display: flex; flex-direction: column; gap: 10px;">
        @foreach($car_info->advert->notes as $note)
            <div class="note note-{{ $note->type }}"
                 style="padding: 10px 15px; border-radius: 8px; font-family: 'Manrope', sans-serif; font-size: 14px; font-weight: 600; line-height: 1.4;">
                {{ $note->content }}
            </div>
        @endforeach
    </div>
@endif
            </div>
        </div>
        <div id="container-3" class="m-auto mt-3 container-fluid "
            style="padding-left:0px; padding-right:0px; width: 90%;
            transform: scale(0.9, 1);
            transform-origin: center;
            border: none;
            ">
              
            <div id="c3-sub1" style="background: white; margin-bottom:10px;" class="overflow-auto p-1">
                 @if(!empty($car_info['advert']['description']) && strlen(trim($car_info['advert']['description'])) > 1)
                    <h2 id="desc-title" class="" style="font-size: 25px;"></h2>
                @endif
                <div id="desc-wrapper">
                    
  <div id="desc" style="overflow: hidden;">{!! $car_info['advert']['description'] !!}</div>


</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const descEl = document.getElementById("desc");
    const readMoreBtn = document.getElementById("readMoreBtn");
    const originalHTML = descEl.innerHTML;
    

    const isMobile = window.matchMedia("(max-width: 768px)").matches;
    
    if (isMobile) {
        const tempDiv = document.createElement("div");
        tempDiv.innerHTML = originalHTML;
        const plainText = tempDiv.innerText || tempDiv.textContent || "";
        const totalWords = plainText.trim().split(/\s+/);
        
        if (totalWords.length > 20) { 
            readMoreBtn.style.display = "inline-block";
            const lines = plainText.split('\n');
            let wordCountForTwoLines = 0;
            if (lines.length >= 2) {
                wordCountForTwoLines = lines[0].trim().split(/\s+/).length + 
                                    (lines[1] ? lines[1].trim().split(/\s+/).length : 0);
            } else if (lines.length === 1) {
         
                wordCountForTwoLines = Math.min(totalWords.length, 20);
            }
            
            const truncatedHTML = truncateHTML(originalHTML, wordCountForTwoLines);
            descEl.innerHTML = truncatedHTML;
            
            let expanded = false;
            readMoreBtn.addEventListener("click", () => {
                if (!expanded) {
                    descEl.innerHTML = originalHTML;
                    readMoreBtn.textContent = "Read Less";
                    expanded = true;
                } else {
                    descEl.innerHTML = truncatedHTML;
                    readMoreBtn.textContent = "Read More";
                    expanded = false;
                }
            });
        }
    }
    
    function truncateHTML(html, wordLimit) {
        const div = document.createElement("div");
        div.innerHTML = html;
        let wordCount = 0;
        
        function recurse(node) {
            if (wordCount >= wordLimit) {
                node.remove();
                return;
            }
            
            if (node.nodeType === Node.TEXT_NODE) {
                const words = node.textContent.trim().split(/\s+/);
                if (wordCount + words.length > wordLimit) {
                    const remaining = wordLimit - wordCount;
                    node.textContent = words.slice(0, remaining).join(" ") + "...";
                    wordCount = wordLimit;
                } else {
                    wordCount += words.length;
                }
            } else if (node.nodeType === Node.ELEMENT_NODE) {
                const children = Array.from(node.childNodes);
                for (let child of children) {
                    recurse(child);
                }
            }
        }
        
        recurse(div);
        return div.innerHTML;
    }
});
</script>


  
  
    
    
  
 

            </div>
            <h2 id="overview-title" class="dm-font" style="font-size: 25px;"></h2>
          <div id="" class="overview-grid p-1" style="">
    @php
        // Define the fields to consider with their display names and units
        $fields = [
            'ExtraUrban' => ['label' => 'Motorway', 'unit' => ' MPG'],
            'UrbanCold' => ['label' => 'Town', 'unit' => ' MPG'],
            'Combined' => ['label' => 'Combined', 'unit' => ' MPG'],
            'advert_colour' => ['label' => 'Colour', 'unit' => ''],
            'doors' => ['label' => 'Doors', 'unit' => ''],
            'body_type' => ['label' => 'Body Style', 'unit' => ''],
            'fuel_type' => ['label' => 'Fuel Type', 'unit' => ''],
            'engine_size' => ['label' => 'Engine Size', 'unit' => ''],
            'Bhp' => ['label' => 'Power', 'unit' => ' bhp'],
            'Kph' => ['label' => 'Max Speed', 'unit' => ' mph'],
            'NumberOfCylinders' => ['label' => 'Cylinders', 'unit' => ''],
            'DriveType' => ['label' => 'Drive Type', 'unit' => ''],
            'Aspiration' => ['label' => 'Aspiration', 'unit' => ''],
            'registered' => ['label' => 'Registered', 'unit' => ''],
            'owners' => ['label' => 'Owners', 'unit' => ''],
            'origin' => ['label' => 'Origin', 'unit' => ''],
        ];

                $validFields = [];
                foreach ($fields as $key => $info) {
                    if (
                        isset($car_info[$key]) &&
                        !is_null($car_info[$key]) &&
                        trim($car_info[$key]) !== '' && // Exclude empty or whitespace-only strings
                        !in_array(trim($car_info[$key]), ['0', '0.0', '0.00', '0.000']) && // Exclude string representations of zero
                        !(is_numeric($car_info[$key]) && floatval($car_info[$key]) == 0) // Exclude numeric zero
                    ) {
                        $validFields[$key] = $info;
                    }
                }

                // If UrbanCold is excluded for 'api' source_type, remove it
                if (isset($car_info['user']['source_type']) && $car_info['user']['source_type'] === 'api') {
                    unset($validFields['UrbanCold']);
                }

                $fieldCount = count($validFields);
                $limit = 0; // Initialize $limit to avoid undefined variable error
                if ($fieldCount >= 8) {
                    $limit = 8; 
                } elseif ($fieldCount >= 5) {
                    $limit = 6; // Show 6 fields if 5 or 6 are available
                } else {
                    $limit = $fieldCount % 2 === 0 ? $fieldCount : $fieldCount - 1; // Use nearest lower even number
                }

                // Take only the determined number of valid fields
                $validFields = array_slice($validFields, 0, $limit, true);
            @endphp

            @foreach ($validFields as $key => $info)
                <div class="overview-row">
                    <p class="variable" style="font-weight: 700">{{ $info['label'] }}</p>
                    <p class="value dm-font">{{ $car_info[$key] }}{{ $info['unit'] }}</p>
                </div>
            @endforeach
        </div>
        </div>
        <div id="" class="" style="display:flex; justify-content:center; margin-top:10px;">
            <div id="selected-option-detail">
                <!-- <h2 id="financing-title">MOT History</h2> -->
                <div id="" class="" style="">
                    <div id="jsonResponse" style="overflow-y:auto; "></div>
                </div>
            </div>
        </div>
        {{-- <div id="c4-sub2" style="background: white;">
            <h2 id="history-title" class="dm-font" style="font-size: 25px;">Free History Check</h2>
            <div class="overview-row d-flex justify-content-between" style="margin-bottom: 10px;">
                <p class="variable" style="color: black; margin: 0;">Scrapped</p>
                <p class="value dm-font" style="color: black; margin: 0;">{{ $car_info['Scrapped'] ? 'Yes' : 'No' }}
                </p>
            </div>
            <div class="overview-row d-flex justify-content-between" style="margin-bottom: 10px;">
                <p class="variable" style="color: black; margin: 0;">Imported</p>
                <p class="value dm-font" style="color: black; margin: 0;">{{ $car_info['Imported'] ? 'Yes' : 'No' }}
                </p>
            </div>
            <div id="vehicleDetails"
                style="font-family: monospace; margin-top: 0; overflow: auto; max-height: 300px;">
            </div>
        </div> --}}
        <style>
            @media (max-width: 768px) {
                .mobileicons {
                    height: 20px !important;
                    width: 20px !important;
                }
            }
        </style>
        {{-- <div id="container-4" class="gap-2 m-auto mt-4 container-fluid d-flex"
            style="padding-left:0px; padding-right:0px; width: 90%;
        transform: scale(0.9, 1);
        transform-origin: center;">
            <div class="gap-3 ms-auto d-flex align-items-center">
                <a href="#" id="favourite-btn" class="p-0 border-0 btn d-flex align-items-center"
                    data-id="{{ $car_info['advert']['advert_id'] }}" data-user-id="{{ auth()->id() }}"
                    data-favorite="{{ $car_info['advert']['favourite'] ? '1' : '0' }}">
                    <img src="/assets/save.png" alt="Default Bookmark" id="default-bookmark"
                        style="width: 30px; height: 30px; cursor: pointer; background: white;" class="mobileicons">
                    <img src="/assets/save.png" alt="Yellow Bookmark" id="yellow-bookmark"
                        style="width: 30px; height: 30px; cursor: pointer; background: white; display: {{ $car_info['advert']['favourite'] ? 'inline' : 'none' }}"
                        class="mobileicons">
                </a>
                <img src="/assets/share.png" alt="Share" id="shareadvert"
                    style="width: 30px; height: 30px; cursor: pointer; background: white;" class="mobileicons">
            </div>
        </div> --}}
        <div class="modal" id="emailSenderModal" tabindex="-1" aria-labelledby="emailSenderModalLabel"
            aria-hidden="true" style="z-index: 1065; ">
            <div class="modal-dialog modal-dialog-centered" style="z-index: 1066; ">
                <div class="modal-content" style="border-radius: 20px; height: 100%;">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="emailModalLabel"><strong>{{ $car_info['make'] }}
                                {{ $car_info['model'] }}
                                {{ $car_info['year'] }}</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="inquiryForm" method="POST" action="/send-inquiry">
                            @csrf
                            <input type="hidden" id="advertId" name="advert_id">
                            <input type="hidden" id="advert_name" name="advert_name"
                                value="{{ $car_info['make'] }} {{ $car_info['model'] }} {{ $car_info['year'] }}">
                            <input type="hidden" id="sellerEmail" name="seller_email"
                                value="{{ $car_info['user']['inquiry_email'] }}">
                               
                            <div class="mb-3">
                                <label for="fullName" class="form-label fw-bold">Name</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control ps-5" id="fullName" name="full_name"
                                        placeholder="Your Full Name" required style="background-color: #F6F6F6;">
                                    <i class="bi bi-person position-absolute"
                                        style="top: 50%; left: 15px; transform: translateY(-50%); color: #6c757d;"></i>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <div class="position-relative">
                                    <input type="email" class="form-control ps-5" id="emailInput" name="email"
                                        placeholder="Your Email" required style="background-color: #F6F6F6;">
                                    <i class="bi bi-envelope position-absolute"
                                        style="top: 50%; left: 15px; transform: translateY(-50%); color: #6c757d;"></i>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="phoneNumber" class="form-label fw-bold">Phone Number</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control ps-5" id="phoneNumber" name="phone_number"
                                        placeholder="Your Phone Number" required style="background-color: #F6F6F6;">
                                    <i class="bi bi-telephone position-absolute"
                                        style="top: 50%; left: 15px; transform: translateY(-50%); color: #6c757d;"></i>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label fw-bold">Message</label>
                                <textarea class="form-control" id="message" name="message" placeholder="Write your message here..."
                                    rows="4" required style="background-color: #F6F6F6;"></textarea>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-dark" id="submitBtn">
                                    Send Inquiry
                                    <span id="loadingSpinner" class="spinner-border spinner-border-sm text-light"
                                        style="display: none;" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                  
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="text-center modal-body">
                    
                        <p id="successMessage"><strong>Your details have been sent to the seller</strong></p>
                    </div>
                    <div class="text-center modal-body">
                        <img src="{{ asset('assets/cardeal.png') }}" alt="Success"
                            style="width: 100px; height: 100px;">
                        <p>Sellers normally respond within 24 hours but if you want to reach out again sooner you can
                            always give them a call.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Back to advert</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="imageModal" class="modal">
            <div class="modal-content-wrapper">
                <img id="modalImage" class="modalcontentimageoverlay">
                <span class="close-btn">&times;</span>
                <button class="prev-btn">⟨</button>
                <button class="next-btn">⟩</button>
            </div>
        </div>
        <script>
    function closeModal() {
        document.getElementById("imageModal").style.display = "none";
    }
    document.getElementById("imageModal").addEventListener("click", function(e) {
        closeModal();
    });

    document.querySelector(".close-btn").addEventListener("click", function(e) {
        e.stopPropagation(); 
        closeModal();
    });
    document.querySelector(".prev-btn").addEventListener("click", function(e) {
        e.stopPropagation(); 
    
    });

    document.querySelector(".next-btn").addEventListener("click", function(e) {
        e.stopPropagation();
      
    });
</script>
        <div id="favoritePopup" class="popup"
            style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); z-index: 1000; text-align: center; min-width: 300px;">
            <div id="popupContent">
                <div id="popupIcon" style="margin-bottom: 15px; font-size: 40px;">
                    <i class="fa-solid fa-circle-check" style="color: #4CAF50;"></i>
                </div>
                <div id="popupMessage" style="font-size: 18px; margin-bottom: 15px;"></div>
                <button onclick="closePopup()"
                    style="background-color: #4CAF50; color: white; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer;">OK</button>
            </div>
        </div>

     

        <div style=" background: white; 
    margin-bottom: 0; padding-top: 10px;">
            <div class="center-btn-container">
                @if ($car_info['user']['role'] !== 'private_seller')
                    <a href="{{ route('dealer.profile', ['slug' => $car_info->user->slug]) }}" class=""
                        style="background-color:#000; text-decoration: none; color: white; font-size: 20px;  margin-top: 10px; margin-bottom: 10px; border-radius:8px; padding:6px 12px;">
                        <strong> View Dealer Page</strong>
                    </a>
                @endif
            </div>
        </div>
    </section>
    @if (isset($related_cars) && $related_cars->isNotEmpty())
    <section class="text-center" style="margin-top:10px;">
        <div class="card-list-container">
            <div class="grid-for-car-cards">
                
                    @foreach ($related_cars as $car_data)
                        <div class="my-3">
                            <a href="{{ route('advert_detail', ['slug' => $car_data['slug']]) }}"
                                class="text-decoration-none text-dark">
                                <div class="main_car_card">
                                    <div>
                                        <div class="car_card_main_img">
                                            <div class="car_card_inner_img">
                                                <div class="car_card_background_img" style="background-image: url('{{ asset('' . e($car_data['image'])) }}');">
                                                </div>
                                                <img src="{{ asset('' . e($car_data['image'])) }}" alt="Car Image"
                                                    onload="this.naturalWidth > this.naturalHeight ? this.style.objectFit = 'cover' : this.style.objectFit = 'contain'"
                                                    onerror="this.src='{{ asset('assets/coming_soon.png') }}'" 
                                                    class="car_card_front_img">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3 card-contain">
                                        <p class="car_tittle text-truncate">{{ e($car_data['make'] ?? 'Unknown make') }}
                                            {{ e($car_data['model'] ?? 'N/A') }} {{ e($car_data['year'] ?? 'N/A') }}</p>
                                        <p class="car_varient text-truncate">
                                            @if (empty($car_data['Trim']) || $car_data['Trim'] == 'N/A')
                                                         {{ strtoupper($car_data['advert_variant']) }}
                                            @else
                                                 {{ strtoupper(e($car_data['Trim'])) }}
                                            @endif
                                        </p>
                                        <div class="car_detail">
                                            <div class="text-center car_detail-item">
                                                {{ e(isset($car_data['miles']) ? number_format($car_data['miles'], 0, '.', ',') : 'N/A') }}
                                            </div>
                                            <div class="text-center car_detail-item">{{ e($car_data['fuel_type'] ?? 'N/A') }}</div>
                                            <div class="text-center car_detail-item">{{ e($car_data['gear_box'] ?? 'N/A') }}</div>
                                        </div>
                                        <!-- <div class="space"></div>
                                        <div class="row g-0">
                                            <div class="text-center col-4">
                                                <div class="d-flex align-items-start justify-content-start">
                                                    <img src="{{ asset('assets/icons/avrg.svg') }}" alt="Average Icon"
                                                        width="16" height="16">
                                                    <p class="specs ms-2">{{ e($car_data['engine_size'] ?? 'N/A') }}</p>
                                                </div>
                                            </div>
                                            <div class="text-center col-4">
                                                <div class="d-flex align-items-start justify-content-start">
                                                    <img src="{{ asset('assets/icons/auction.svg') }}" alt="Auction Icon"
                                                        width="16" height="16">
                                                    <p class="specs ms-2">
                                                        @php
                                                            $sellerType = $car_data['seller_type'] ?? 'Auction';
                                                            $displaySellerType =
                                                                $sellerType === 'private_seller'
                                                                    ? 'Private'
                                                                    : ($sellerType === 'car_dealer'
                                                                        ? 'Dealer'
                                                                        : 'Auction');
                                                        @endphp
                                                        {{ e($displaySellerType) }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="text-center col-4">
                                                <div class="d-flex align-items-start justify-content-start">
                                                    <img src="{{ asset('assets/icons/person.svg') }}" alt="Location Icon"
                                                        width="16" height="16">
                                                    <p class="specs ms-2">{{ $car_data->user->location ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="height"></div>
                                        <div class="car_detail_bottom">
                                            <p class="car_price">
                                                {{ e(isset($car_data['price']) && $car_data['price'] > 0 ? '£' . number_format($car_data['price'], 0, '.', ',') : 'POA') }}
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
       

    </section>
 
    @endif
      
    <script>
        document.getElementById('shareadvert').addEventListener('click', function() {
       
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {

                const notification = document.getElementById('notification');
                notification.style.display = 'block';
     
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy URL: ', err);
            });
        });
        document.getElementById('shareadvertmobile').addEventListener('click', function() {
  
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
       
                const notification = document.getElementById('notification');
                notification.style.display = 'block';
         
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy URL: ', err);
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const favouriteBtn = document.getElementById('favourite-btn');
            const favoriteForm = document.getElementById('favorite-form');
            const favoriteInput = document.getElementById('favorite-input');
            const defaultBookmark = document.getElementById('default-bookmark');
            const yellowBookmark = document.getElementById('yellow-bookmark');
            const notification = document.getElementById('notification');
          
            function showNotification(message, color) {
                notification.textContent = message;
                notification.style.backgroundColor = color;
                notification.style.color = 'white';
                notification.style.display = 'block';
           
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 3000);
            }
            if (favoriteInput.value === '1') {
                yellowBookmark.style.display = 'inline';
                defaultBookmark.style.display = 'none';
                favouriteBtn.classList.add('btn-warning');
            } else {
                yellowBookmark.style.display = 'none';
                defaultBookmark.style.display = 'inline';
                favouriteBtn.classList.add('btn-primary');
            }
            favouriteBtn.addEventListener('click', function(event) {
                event.preventDefault();
                let isFavorite = favoriteInput.value === '1';
                if (isFavorite) {
                    yellowBookmark.style.display = 'none';
                    defaultBookmark.style.display = 'inline';
                    favouriteBtn.classList.remove('btn-warning');
                    favouriteBtn.classList.add('btn-primary');
                    favoriteInput.value = '0';
                    showNotification('Car removed from favorite', 'orange');
                } else {
                    yellowBookmark.style.display = 'inline';
                    defaultBookmark.style.display = 'none';
                    favouriteBtn.classList.remove('btn-primary');
                    favouriteBtn.classList.add('btn-warning');
                    favoriteInput.value = '1';
                    showNotification('Car added to favorite', 'green');
                }
                favoriteForm.submit();
            });
        });
        document.getElementById('send-msg').addEventListener('click', function() {
            const phoneNumber = this.getAttribute('data-phone');
            if (phoneNumber) {
 
                window.location.href = `sms:${phoneNumber}`;
            } else {
                alert('Phone number not available');
            }
        });
        document.getElementById('chat-whatsapp').addEventListener('click', function() {
            const phoneNumber = this.getAttribute('data-phone');
            if (phoneNumber) {
        
                window.location.href = `https://wa.me/${phoneNumber}`;
            } else {
                alert('Phone number not available');
            }
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#buttons-group button').click(function() {
                const advertId = $(this).data('advert-id');
                const counterType = $(this).attr('id');
                const contact = $(this).data('contact');
                const carLink = '{{ url()->current() }}';
                $.ajax({
                    url: '/counter',
                    method: 'POST',
                    data: {
                        advert_id: advertId,
                        counter_type: counterType,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        let redirectUrl = '';
                        if (counterType === 'call') {
                            let formattedContact = contact.replace(/^0/, '');
                            redirectUrl = 'https://wa.me/' + formattedContact + '?text=PureCar%20Inquiry%3A%20Hi%20is%20this%20car%20still%20available%3F%0A%0A' + encodeURIComponent(carLink);
                        } else if (counterType === 'text') {
                            redirectUrl = 'tel:' + contact;
                        } else if (counterType === 'email') {
                            // redirectUrl = 'mailto:' + contact;
                        }
                        if (redirectUrl) {
                            window.location.href = redirectUrl;
                        }
                    }
                });
            });
        });
    </script>
   

<script>
document.addEventListener('DOMContentLoaded', function() {

    const favouriteBtn = document.getElementById('favourite-btn');

    if (favouriteBtn) {
        const heartOutline = document.getElementById('heart-outline');
        const heartFilled = document.getElementById('heart-filled');
        const modal = document.getElementById('favoriteModal');
        const modalMessage = document.getElementById('modalMessage');

        const advertId = favouriteBtn.getAttribute('data-id');

        const storedFavoriteStatus = localStorage.getItem('favorite_' + advertId);
        
        if (storedFavoriteStatus === '1') {

            favouriteBtn.setAttribute('data-favorite', '1');
        }
        
 
        updateHeartDisplay();

        function updateHeartDisplay() {
            const isFavorite = favouriteBtn.getAttribute('data-favorite') === '1';
            console.log('Favorite status on load:', isFavorite);
            
            if (heartOutline && heartFilled) {
                if (isFavorite) {
                    heartOutline.style.display = 'none';
                    heartFilled.style.display = 'block';
                } else {
                    heartOutline.style.display = 'block';
                    heartFilled.style.display = 'none';
                }
            }
        }
  
        const style = document.createElement('style');
        style.textContent = `
            @keyframes drawTic {
                from { stroke-dashoffset: 100; }
                to { stroke-dashoffset: 0; }
            }
            @keyframes drawCross {
                from { stroke-dashoffset: 100; }
                to { stroke-dashoffset: 0; }
            }
            .modal-tic, .modal-cross {
                width: 106px;
                height: 147px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .modal-tic svg, .modal-cross svg {
                width: 80px;
                height: 80px;
            }
            .modal-tic path {
                stroke: #4CAF50;
                stroke-width: 6;
                fill: none;
                stroke-dasharray: 100;
                stroke-dashoffset: 0;
                animation: drawTic 0.8s ease forwards;
            }
            .modal-cross path {
                stroke: #F44336;
                stroke-width: 6;
                fill: none;
                stroke-dasharray: 100;
                stroke-dashoffset: 0;
                animation: drawCross 0.8s ease forwards;
            }
        `;
        document.head.appendChild(style);
        
        favouriteBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const userId = this.getAttribute('data-user-id');
            if (!userId) {
                window.location.href = '{{ route('login') }}';
                return;
            }
            const advertId = this.getAttribute('data-id');
            const formData = new FormData();
            formData.append('advert_id', advertId);
            formData.append('user_id', this.getAttribute('data-user-id'));
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            
            fetch('/advert/favorite', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const isFavorite = data.action === 'added';
                    
                   
                    this.setAttribute('data-favorite', isFavorite ? '1' : '0');
                    
                  
                    localStorage.setItem('favorite_' + advertId, isFavorite ? '1' : '0');
                    
              
                    if (isFavorite) {
                        heartOutline.style.display = 'none';
                        heartFilled.style.display = 'block';
                    } else {
                        heartOutline.style.display = 'block';
                        heartFilled.style.display = 'none';
                    }
                    
    
                    showModal(data.action, data.message);
                }
            })
            .catch(error => {
                showModal('error', 'Error updating favorite status');
                console.error('Error:', error);
            });
        });

        function showModal(action, message) {
            modalMessage.textContent = message;
            let modalContent = modal.querySelector('.modal-content');

            const existingIcons = modalContent.querySelectorAll('.modal-tic, .modal-cross');
            existingIcons.forEach(icon => icon.remove());
        
            const iconContainer = document.createElement('div');
            iconContainer.id = 'modalIcon';
            if (action === 'added') {
  
                iconContainer.className = 'modal-tic';
                iconContainer.innerHTML = `
                    <svg viewBox="0 0 100 100">
                        <path d="M20,50 L40,70 L80,30" />
                    </svg>
                `;
            } else if (action === 'removed') {
    
                iconContainer.className = 'modal-cross';
                iconContainer.innerHTML = `
                    <svg viewBox="0 0 100 100">
                        <path d="M20,20 L80,80 M80,20 L20,80" />
                    </svg>
                `;
            } else {
          
                iconContainer.className = 'modal-cross';
                iconContainer.innerHTML = `
                    <svg viewBox="0 0 100 100">
                        <path d="M20,20 L80,80 M80,20 L20,80" />
                    </svg>
                `;
            }
   
            if (modalMessage.parentNode === modalContent) {
                modalContent.insertBefore(iconContainer, modalMessage);
            } else {
                modalContent.prepend(iconContainer);
            }

            modal.style.position = 'fixed';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100vw';
            modal.style.height = '100vh';
            modal.style.background = 'rgba(0, 0, 0, 0.5)';
            modal.style.display = 'flex';
            modal.style.alignItems = 'center';
            modal.style.justifyContent = 'center';

            modalContent.style.width = '250px';
            modalContent.style.height = '250px';
            modalContent.style.background = '#fff';
            modalContent.style.borderRadius = '10px';
            modalContent.style.boxShadow = '0px 0px 10px rgba(0, 0, 0, 0.2)';
            modalContent.style.position = 'relative';
            modalContent.style.display = 'flex';
            modalContent.style.flexDirection = 'column';
            modalContent.style.alignItems = 'center';
            modalContent.style.padding = '20px';

            iconContainer.style.marginTop = '10px';
       
            modalMessage.style.marginTop = '14px';
            modalMessage.style.fontWeight = 'bold';
            modal.style.animation = 'modalFadeIn 0.3s';
            modal.style.display = 'flex';
            setTimeout(() => {
                modalContent.style.animation = 'modalFadeOut 0.3s';
                setTimeout(() => {
                    modal.style.display = 'none';
                    modalContent.style.animation = 'modalFadeIn 0.3s';
                }, 300);
            }, 1000);
        }
    }
});
</script>
    
    <div id="favoriteModal" class="modal" style="display: none;">
        <div class="modal-content">
            <p id="modalMessage" style="text-align: center; margin: 15px 0;"></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    // Vehicle features section
    const loadVehicleFeatures = function() {
        const vrm = '{{ $car_info->license_plate }}';
        fetch(`/get-vehicle-features?vrm=${vrm}`)
            .then(response => {
                if (!response.ok) throw new Error(`Server responded with status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                const jsonResponseDiv = document.getElementById('jsonResponse');
                if (!jsonResponseDiv) return; // Skip if element doesn't exist
                
                const factoryEquipmentList = data.FactoryEquipmentList || [];
                let outputHtml = ``;

                if (Array.isArray(factoryEquipmentList) && factoryEquipmentList.length > 0) {
                    const categoriesWithStandardItems = factoryEquipmentList
                        .filter(item => item?.Fitment?.toLowerCase() === 'standard')
                        .reduce((acc, item) => {
                            const cat = item?.Category || 'Other';
                            acc.add(cat);
                            return acc;
                        }, new Set());

                    const categories = Array.from(categoriesWithStandardItems);

                    if (categories.length > 0) {
                        outputHtml += `
                    <div class="equipmentCategory" style="border-radius:0px;">
                        <div class="accordion" id="equipmentCategoryAccordion" style="width:100%; border-radius:0px;">
                `;

                        categories.forEach((category, index) => {
                            const safeId = category.replace(/\s+/g, '-').toLowerCase();
                            outputHtml += `
                        <div class="accordion-item" style="border-radius:0px;">
                            <h2 class="accordion-header" style="border-radius:0px; margin:0px !important; padding-left:9px !important;" id="heading-${safeId}">
                                <button 
                                    class="accordion-button collapsed category-btn" 
                                    type="button" 
                                    style="margin:0px; padding:0px; padding-bottom:5px !important; padding-top:5px !important;"
                                    data-category="${category}">
                                    ${category}
                                </button>
                            </h2>
                            <div 
                               id="collapse-${safeId}" 
                                class="accordion-collapse collapse" 
                                aria-labelledby="heading-${safeId}">
                                <div class="accordion-body" style="border-radius:0px;">
                                    <div id="equipmentList-${safeId}" class=""></div>
                                </div>
                            </div>
                        </div>
                    `;
                        });

                        outputHtml += `
                    </div>
                </div>
                `;
                    } else {
                        outputHtml += '<p>No categorized equipment found.</p>';
                    }
                }

                jsonResponseDiv.innerHTML = outputHtml;
                window.equipmentData = factoryEquipmentList;

                setTimeout(() => {
                    document.querySelectorAll('.category-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const category = this.getAttribute('data-category');
                            const safeId = category.replace(/\s+/g, '-').toLowerCase();
                            const collapseDiv = document.getElementById(`collapse-${safeId}`);
                            const targetDiv = document.getElementById(`equipmentList-${safeId}`);

                            // Toggle collapse manually
                            if (collapseDiv.classList.contains('show')) {
                                collapseDiv.classList.remove('show');
                                // Manually trigger the collapse to update the button state
                                this.classList.add('collapsed');
                            } else {
                                // Close all other accordions
                                document.querySelectorAll('.accordion-collapse')
                                    .forEach(div => div.classList.remove('show'));
                                document.querySelectorAll('.category-btn')
                                    .forEach(btn => btn.classList.add('collapsed'));

                                collapseDiv.classList.add('show');
                                this.classList.remove('collapsed'); // Ensure the button is no longer collapsed

                                // Load content if not already loaded
                                if (targetDiv && targetDiv.getAttribute('data-loaded') !== 'true') {
                                    let listHtml = '<ul class="list-group">';
                                    let displayedItems = 0;

                                    window.equipmentData.forEach(item => {
                                        if (item?.Category === category && item?.Fitment?.toLowerCase() === 'standard') {
                                            displayedItems++;
                                            listHtml += `
                                        <li class="list-group-item">
                                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                                <strong style="grid-column: span 2;">${item.Name || 'N/A'}</strong>
                                                 
                                                    ${item.Fitment ? '<div style="padding-bottom:4px;">Fitment:</div> ' + `<div style="padding-bottom:4px;">${item.Fitment}</div>`: ''}
                                                    ${item.Description ? '<div style="padding-bottom:4px;">Description:</div> ' + `<div style="padding-bottom:4px;">${item.Description}</div>`: ''}
                                                    ${item.Price ? '<div style="padding-bottom:4px;">Price:</div> ' + `<div style="padding-bottom:4px;">£${item.Price}</div>` : ''}
                                            </div>   
                                        </li>
                                    `;
                                        }
                                    });

                                    listHtml += displayedItems === 0 ? '<p>No items found in this category.</p>' : '</ul>';

                                    targetDiv.innerHTML = listHtml;
                                    targetDiv.setAttribute('data-loaded', 'true');
                                }
                            }
                        });
                    });
                    document.querySelectorAll('.accordion-body').forEach(body => {
                        body.addEventListener('click', function(e) {
                            // Prevent closing if clicking on nested interactive elements (optional)
                            if (e.target.tagName !== 'BUTTON' && e.target.tagName !== 'A') {
                                const collapseDiv = this.closest('.accordion-collapse');
                                const button = this.closest('.accordion-item').querySelector('.category-btn');
                                
                                if (collapseDiv.classList.contains('show')) {
                                    collapseDiv.classList.remove('show');
                                    button.classList.add('collapsed');
                                }
                            }
                        });
                    });
                }, 0);
            })
            .catch(error => {
                console.error('Error details:', error);
                const jsonResponseDiv = document.getElementById('jsonResponse');
                if (jsonResponseDiv) {
                    jsonResponseDiv.innerHTML = `
                    <div class="mb-4">
                     
                    </div>
                `;
                }
            });
    };

    // Email sender modal
    const setupEmailModal = function() {
        const emailBtn = document.getElementById('email');
        if (!emailBtn) return; // Skip if element doesn't exist
        
        const emailSenderModalElement = document.getElementById('emailSenderModal');
        if (!emailSenderModalElement) return;
        
        const successModalElement = document.getElementById('successModal');
        if (!successModalElement) return;
        
        const successModal = new bootstrap.Modal(successModalElement);
        const emailSenderModal = new bootstrap.Modal(emailSenderModalElement, {
            backdrop: 'static',
            keyboard: true,
            focus: true
        });
        
        emailBtn.addEventListener('click', async function() {
            try {
                const response = await fetch('/user/details');
                const userData = await response.json();
                
                // Set form values
                const advertIdEl = document.getElementById('advertId');
                const sellerEmailEl = document.getElementById('sellerEmail');
                const fullNameEl = document.getElementById('fullName');
                const emailInputEl = document.getElementById('emailInput');
                const phoneNumberEl = document.getElementById('phoneNumber');
                
                if (advertIdEl) advertIdEl.value = emailBtn.dataset.advertId || '';
                if (sellerEmailEl) sellerEmailEl.value = emailBtn.dataset.contact || '';
                if (fullNameEl) fullNameEl.value = userData.name || '';
                if (emailInputEl) emailInputEl.value = userData.email || '';
                if (phoneNumberEl) phoneNumberEl.value = userData.phone || '';
                
                // Remove any existing backdrops
                const existingBackdrops = document.getElementsByClassName('modal-backdrop');
                Array.from(existingBackdrops).forEach(backdrop => backdrop.remove());
                
                emailSenderModal.show();
                emailSenderModalElement.style.display = 'block';
                emailSenderModalElement.style.zIndex = '1065';
            } catch (error) {
                console.error('Failed to fetch user details:', error);
            }
        });
    };

    // Form submission
    const setupInquiryForm = function() {
        const inquiryForm = document.getElementById('inquiryForm');
        if (!inquiryForm) return; // Skip if form doesn't exist
        
        inquiryForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            console.log("Form submission started");
            
            const formData = new FormData(this);
            const submitBtn = document.getElementById("submitBtn");
            const loadingSpinner = document.getElementById("loadingSpinner");
            
            if (submitBtn) submitBtn.disabled = true;
            if (loadingSpinner) loadingSpinner.style.display = "inline-block";
            console.log("Spinner displayed and button disabled");
            
            try {
                const response = await fetch('/send-inquiry', {
                    method: 'POST',
                    body: formData
                });
                console.log("Fetch response received");
                
                // Handle 500 errors specifically
                if (response.status === 500) {
                    console.error("Server returned 500 error");
                    
                    try {
                        const errorDetails = await response.text();
                        console.error("Server error details:", errorDetails);
                        alert("The server encountered an error. Please try again later or contact support if the problem persists.");
                    } catch (e) {
                        console.error("Could not read error details:", e);
                        alert("The server encountered an error. Please try again later.");
                    }
                    return;
                }
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const result = await response.json();
                console.log("Response JSON parsed:", result);
                
                if (result.status === 'success') {
                    console.log("Form submission successful");
                    const emailSenderModalElement = document.getElementById('emailSenderModal');
                    if (emailSenderModalElement) {
                        const inquiryModalInstance = bootstrap.Modal.getInstance(emailSenderModalElement);
                        if (inquiryModalInstance) inquiryModalInstance.hide();
                    }
                    
                    const successMessage = document.getElementById('successMessage');
                    if (successMessage) successMessage.textContent = result.message;
                    
                    const successModalElement = document.getElementById('successModal');
                    if (successModalElement) {
                        const successModal = new bootstrap.Modal(successModalElement);
                        successModal.show();
                    }
                    
                    this.reset();
                } else {
                    console.warn("Form submission failed:", result.message);
                    alert(result.message || "An error occurred. Please try again.");
                }
            } catch (error) {
                console.error('Error submitting form:', error);
                alert("An error occurred. Please check your network and try again.");
            } finally {
                console.log("Cleaning up: hiding spinner and enabling button");
                const loadingSpinner = document.getElementById("loadingSpinner");
                const submitBtn = document.getElementById("submitBtn");
                
                if (loadingSpinner) loadingSpinner.style.display = "none";
                if (submitBtn) submitBtn.disabled = false;
            }
        });
    };

    // Image gallery
    const setupImageGallery = function() {
        const modal = document.getElementById('imageModal');
        if (!modal) return; // Skip if modal doesn't exist
        
        const modalImg = document.getElementById('modalImage');
        const closeBtn = document.querySelector('.close-btn');
        const prevBtn = document.querySelector('.prev-btn');
        const nextBtn = document.querySelector('.next-btn');
        const fullImgContainer = document.getElementById('full-img');
        const images = document.querySelectorAll('.car-pic');
        const favouriteBtn = document.getElementById('favourite-btn');
        const defaultBookmark = document.getElementById('default-bookmark');
        const yellowBookmark = document.getElementById('yellow-bookmark');
        const cameraButton = document.querySelector('.camera-button');

        let currentImageIndex = 0;

        function openModal(startIndex) {
            modal.style.display = 'flex';
            currentImageIndex = startIndex;
            if (modalImg && images[currentImageIndex]) {
                modalImg.src = images[currentImageIndex].src;
            }
            updateNavigationButtons();
        }

        // Camera button opens modal with first image
        if (cameraButton) {
            cameraButton.addEventListener('click', () => {
                if (images.length > 0) {
                    openModal(0);
                }
            });
        }

        if (fullImgContainer) {
            fullImgContainer.addEventListener('click', function() {
                const fullImg = fullImgContainer.querySelector('img');
                if (!fullImg) return;
                const fullImgSrc = fullImg.src;
                const startIndex = Array.from(images).findIndex(img => img.src === fullImgSrc);
                if (startIndex !== -1) {
                    openModal(startIndex);
                }
            });
        }

        images.forEach((img, index) => {
            img.addEventListener('click', () => openModal(index));
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                modal.style.display = 'none';
            });
        }

        // Control modal closing when clicking outside the image
        modal.addEventListener('click', function(e) {
            // Only close if the click is directly on the modal (background)
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });

        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
                if (modalImg && images[currentImageIndex]) {
                    modalImg.src = images[currentImageIndex].src;
                }
                updateNavigationButtons();
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                currentImageIndex = (currentImageIndex + 1) % images.length;
                if (modalImg && images[currentImageIndex]) {
                    modalImg.src = images[currentImageIndex].src;
                }
                updateNavigationButtons();
            });
        }

        if (modalImg) {
            let touchStartX = 0;
            modalImg.addEventListener('touchstart', function(e) {
                touchStartX = e.touches[0].clientX;
            });

            modalImg.addEventListener('touchend', function(e) {
                const touchEndX = e.changedTouches[0].clientX;
                const diffX = touchEndX - touchStartX;
                if (diffX > 50 && prevBtn) {
                    prevBtn.click();
                } else if (diffX < -50 && nextBtn) {
                    nextBtn.click();
                }
            });
        }

        document.addEventListener('keydown', function(e) {
            if (modal.style.display === 'flex') {
                if (e.key === 'ArrowLeft' && prevBtn) {
                    prevBtn.click();
                } else if (e.key === 'ArrowRight' && nextBtn) {
                    nextBtn.click();
                } else if (e.key === 'Escape' && closeBtn) {
                    closeBtn.click();
                }
            }
        });

        function updateNavigationButtons() {
            if (prevBtn) prevBtn.style.display = images.length > 1 ? 'block' : 'none';
            if (nextBtn) nextBtn.style.display = images.length > 1 ? 'block' : 'none';
        }

        // Blurred background code
        if (fullImgContainer) {
            let mainImg = fullImgContainer.querySelector("img");
            if (mainImg) {
                function addBlurredBackground() {
                    let existingBlur = fullImgContainer.querySelector(".bg-blur");
                    if (existingBlur) existingBlur.remove();
                    let blurredImg = mainImg.cloneNode();
                    blurredImg.classList.add("bg-blur");
                    fullImgContainer.prepend(blurredImg);
                }
                addBlurredBackground();
                
                // Fix for the "next" and "prev" buttons
                const nextBtn = document.getElementById("next");
                const prevBtn = document.getElementById("prev");
                
                if (nextBtn) {
                    nextBtn.addEventListener("click", addBlurredBackground);
                }
                
                if (prevBtn) {
                    prevBtn.addEventListener("click", addBlurredBackground);
                }
            }
        }
    };

    // Run all setup functions
    loadVehicleFeatures();
    setupEmailModal();
    setupInquiryForm();
    setupImageGallery();
    
    // Check favorite status (original code preserved)
    console.log("Favorite status on load: – false");
});
    </script>
    <style>
        .note-success {
    background-color: rgba(46, 125, 50, 0.1);
    border: 1px solid rgba(46, 125, 50, 0.3);
    color: #1B5E20;
    font-size: 16px;
}
.note-warning {
    background-color: rgba(255, 193, 7, 0.1);
    border: 1px solid rgba(255, 193, 7, 0.3);
    color: #5F4B00;
    font-size: 16px;
}
.note-danger {
    background-color: rgba(211, 47, 47, 0.1);
    border: 1px solid rgba(211, 47, 47, 0.3);
    color: #B71C1C;
    font-size: 16px;
}
        .equipmentCategory {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .accordion-item {
            /* border: 1px solid #ddd; */

            min-width: 100%;
            border-radius: 10px;
            margin-bottom: 15px;
            overflow: hidden;
            border-radius: 0px;
        }

        /* .accordion-button {
                font-weight: 600;
            
                color: #333;
                padding: 1rem 1.25rem;
            } */

        .accordion-button:not(.collapsed) {
            border: none !important;
            color: #000;
        }

        .accordion-body {

            margin: 0;
            padding: 0;
            border-radius: 0px !important;
        }

        .list-group-item {
    padding: 10px;
    border: none;
    border-bottom: 1px solid #eee;
}



        /* Remove the blue outline when accordion button is clicked */
        .accordion-button:focus {
            outline: none !important;
            /* Removes the outline */
            box-shadow: none !important;
            /* Removes the box-shadow */
        }

        /* Remove the active background color when the accordion is clicked */
        .accordion-button:not(.collapsed) {
            background-color: transparent !important;
            /* Optional: Set a custom color */
        }

        /* Alternatively, you can set a custom color for the active state if needed */
        .accordion-button:not(.collapsed):active,
        .accordion-button:not(.collapsed):focus {
            background-color: #f8f9fa !important;
            /* Set your desired background color */
        }




        /* Remove all borders except for the bottom border */
        .accordion-button {
            border: none;
            /* Remove all borders */
            border-bottom: 1px solid #dee2e6;
            /* Keep bottom border */
        }

        /* Optional: To keep the bottom border with a specific color */
        .accordion-button:not(.collapsed) {
            /* border-bottom: 1px solid; Or any other color you want for the active state */
        }

        /* Ensure the item border is removed too */
        .accordion-item {
            border: none;
            /* Remove borders around the entire item */
        }

        /* Optionally, customize the bottom border color of the accordion item */
        .accordion-item .accordion-button:not(.collapsed) {
            /* border-bottom: 1px solid #0069d9; Color for expanded accordion */
        }

        /* Remove the blue outline and focus style completely */
        .accordion-button:focus {
            outline: none !important;
            /* Removes the outline */
            box-shadow: none !important;
            /* Removes the box-shadow */
        }

        /* No border on collapsed accordion button */
        .accordion-button.collapsed {
            border-bottom: 1px solid #dee2e6;
            /* Keep the bottom border color when collapsed */
        }

        /* Ensure no background color on active state (expanded) */
        .accordion-button:not(.collapsed):active,
        .accordion-button:not(.collapsed):focus {
            background-color: transparent !important;
            /* Keep background transparent */
            border-bottom: 1px solid #dee2e6;
            /* Keep the bottom border */
        }

        /* Remove the borders around the entire accordion item */
        .accordion-item {
            border: none;
            /* Remove borders around the entire item */
        }

        /* Set a custom color for the bottom border when expanded */
        .accordion-item .accordion-button:not(.collapsed) {
            border-bottom: 1px solid #0069d9;
          
        }
    </style>


  <script>
                    outputHtml += '</div>'; // Close equipmentSection div
                    // Set the HTML content
                    jsonResponseDiv.innerHTML = outputHtml;
                    // Process equipment data if it exists
                    if (Array.isArray(factoryEquipmentList) && factoryEquipmentList.length > 0) {
                        // Store data and initialize display
                        window.equipmentData = factoryEquipmentList;
                        const dropdownElement = document.getElementById('equipmentCategory');
                        if (dropdownElement) {
                            dropdownElement.addEventListener('change', displayEquipment);
                            displayEquipment(); // Show initial list
                        }
                        // Apply desktop-only styling with JavaScript after the content is loaded
                        const applyDesktopStyles = function() {
                            const equipmentCategory = document.querySelector('.equipmentCategory');
                            const heading = document.getElementById('vechicleheading');
                            if (window.innerWidth >= 768) {
                                // Desktop styles
                                heading.style.display = 'block';
                                heading.style.float = 'left';
                                heading.style.marginTop = '5px';
                                equipmentCategory.style.display = 'block';
                                equipmentCategory.style.float = '';
                                equipmentCategory.style.width = '';
                                const select = equipmentCategory.querySelector('select');
                                if (select) {
                                    select.style.width = '';
                                }
                                document.getElementById('equipmentList').style.clear = 'both';
                            } else {
                                // Mobile styles - reset to original
                                heading.style.display =
                                'none'; // This is already done with the d-none d-md-block classes
                                equipmentCategory.style.display = 'block';
                                equipmentCategory.style.float = 'none';
                                equipmentCategory.style.width = '100%';
                                equipmentCategory.style.textAlign = 'right';
                                const select = equipmentCategory.querySelector('select');
                                if (select) {
                                    select.style.width = '100%';
                                }
                                document.getElementById('equipmentList').style.clear = 'none';
                            }
                        };
                        // Apply styles initially
                        applyDesktopStyles();
                        // Update styles when window is resized
                        window.addEventListener('resize', applyDesktopStyles);
                    }
                })
                .catch(error => {
                    console.error('Error details:', error);
                    const errorDiv = document.getElementById('jsonResponse');
                    if (errorDiv) {
                        errorDiv.innerHTML = `
                            <div class="alert alert-danger" style="padding: 15px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px; color: #721c24;">
                                <p>No details avilable for the selected car</p>
                            </div>
                        `;
                    }
                });
            // Function to display equipment based on selected category
            function displayEquipment() {
                if (!window.equipmentData) return;
                const dropdownElement = document.getElementById('equipmentCategory');
                const equipmentListDiv = document.getElementById('equipmentList');
                if (!dropdownElement || !equipmentListDiv) return;
                const selectedCategory = dropdownElement.value;
                let listHtml = '<ul class="list-group" style="list-style: none; padding-left: 0;">';
                let displayedItems = 0;
                window.equipmentData.forEach(item => {
                    if (!item) return;
                    if (!selectedCategory || item.Category === selectedCategory) {
                        displayedItems++;
                        listHtml += `
                            <li class="list-group-item">
                                <strong>${item.Name || 'N/A'}</strong>
                            
                                ${item.Fitment ? '<br>Fitment: ' + item.Fitment : ''}
                                ${item.Description ? '<br>Description: ' + item.Description : ''}
                                ${item.Price ? '<br>Price: £' + item.Price : ''}
                            </li>
                        `;
                    }
                });
                if (displayedItems === 0) {
                    listHtml = '<p>No items found in this category.</p>';
                } else {
                    listHtml += '</ul>';
                }
                equipmentListDiv.innerHTML = listHtml;
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const vrm = '{{ $car_info->license_plate }}';
            fetch(`/get-vehicle-details-db?vrm=${vrm}`)
                .then(response => response.json())
                .then(data => {
                    const vehicleDetailsDiv = document.getElementById('vehicleDetails');
                    if (data.error) {
                        vehicleDetailsDiv.innerHTML = `<p>${data.error}</p>`;
                        return;
                    }
                    const dateFirstRegistered = data.DateFirstRegistered;
                    const keeperChangesList = data.KeeperChangesList;
                    let outputHtml = '';
                    outputHtml += `
                                    <table style="width: 100%; border-collapse: collapse; border: 1px solid black;">
                                        <thead>
                                            <tr>
                                                <th style="border: 1px solid black; padding: 8px;">Keeper Number</th>
                                                <th style="border: 1px solid black; padding: 8px;">Date of Last Keeper Change</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;
                    if (dateFirstRegistered) {
                        outputHtml += `
                                        <tr>
                                            <td style="border: 1px solid black; padding: 8px;">1</td>
                                            <td style="border: 1px solid black; padding: 8px;">${new Date(dateFirstRegistered).toLocaleDateString()}</td>
                                        </tr>`;
                    } else {
                        outputHtml +=
                            '<tr><td colspan="2" style="border: 1px solid black; padding: 8px;">Date First Registered not found.</td></tr>';
                    }
                    if (keeperChangesList.length > 0) {
                        keeperChangesList.sort((a, b) => new Date(a.DateOfLastKeeperChange) - new Date(b
                            .DateOfLastKeeperChange));
                        keeperChangesList.forEach((change, index) => {
                            const keeperNumber = index + 2;
                            outputHtml += `
                                            <tr>
                                                <td style="border: 1px solid black; padding: 8px;">${keeperNumber}</td>
                                                <td style="border: 1px solid black; padding: 8px;">${new Date(change.DateOfLastKeeperChange).toLocaleDateString()}</td>
                                            </tr>`;
                        });
                    } else {
                        outputHtml +=
                            '<tr><td colspan="2" style="border: 1px solid black; padding: 8px;">No Keeper Changes found.</td></tr>';
                    }
                    outputHtml += '</tbody></table>';
                    vehicleDetailsDiv.innerHTML = outputHtml;
                })
                .catch(error => {
                    console.error('Error fetching vehicle details:', error);
                    document.getElementById('vehicleDetails').innerHTML =
                        '<p>An error occurred while fetching vehicle details.</p>';
                });
        }); 

   </script> 
    <style>
        #full-img {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #full-img .bg-blur {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: blur(15px);
            z-index: -1;
        }

        body {
            padding-top: 0 !important;
        }

        @media (max-width: 991px) {
            .dropdown-toggle::after {
                display: none !important;
            }

            .dropdown-menu {
                border: none !important;
                background: rgb(255, 255, 255) !important;
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
            }

            .dropdown-item {
                padding: 0.75rem 1.5rem !important;
                // border-bottom: 1px solid #eee !important;
                color: #333 !important;
            }

            .dropdown-item:last-child {
                border-bottom: none !important;
            }

            .dropdown-item i {
                width: 20px !important;
                text-align: center !important;
                color: #666 !important;
            }

            /* Animation for dropdown */
            .dropdown-menu {
                display: none !important;
                opacity: 0 !important;
                transform: translateY(-10px) !important;
                transition: all 0.3s ease !important;
            }

            .dropdown-menu.show {
                display: block !important;
                opacity: 1 !important;
                transform: translateY(0) !important;
            }

            .mobile-dropdown .nav-link {
                padding: 0.75rem 0rem !important;
            }

            .fa-chevron-down {
                transition: transform 0.3s ease !important;
            }
        }

        @media (max-width: 767px) {
            #container-1 {
                margin: 0 !important;
                width: 100% !important;
                transform: scale(1) !important;
            }

            #container-2 {
                margin: 0 !important;
                margin-top: 10px !important;
                width: 100% !important;
                transform: scale(1) !important;
            }

            #container-3 {
                margin: 0 !important;
                margin-top: 10px !important;
                width: 100% !important;
                transform: scale(1) !important;
            }

            #container-4 {
                margin: 0 !important;
                margin-top: 10px !important;
                width: 100% !important;
                transform: scale(1) !important;
            }

            #c3-sub2 {
                margin-top: 10px !important;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1) !important;
            }

            #c4-sub2 {
                margin-top: 5px !important;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1) !important;
            }
        }

        @media (max-width: 768px) {
            #container-1 {
                display: flex !important;
                flex-direction: column;
                align-items: flex-start;
                width: 90%;
                padding: 10px;
                background: white;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
            }

            #c1-sub1 {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                /* Align items in center */
                width: 100% !important;
            }

            #c1-sub1-left {
                display: flex !important;
                flex-direction: column !important;
                align-items: flex-start !important;
                justify-content: center !important;
            }

            #name {
                font-size: 18px;
                /* Adjust font size if needed */
                margin: 0;
                /* Remove extra spacing */
            }

            #detail {
                margin-top: 2px;
                /* Adjust for better spacing */
                font-size: 14px;
                color: gray;
            }

            .pricevaluemobile {
                margin-top: -22px !important;
            }

            #c1-sub3 {
                display: flex !important;
                justify-content: flex-end !important;
                font-size: 20px !important;
                font-weight: bold;
                color: #000;
            }

            #c1-sub2 {
                display: flex;
                justify-content: space-between;
                width: 100%;
                margin-top: 10px; 
                
               
            }

            #c1-sub2 div {
                display: flex;
                align-items: center;
                gap: 5px;
            }

            #c1-sub2 img {
                width: 20px;
                height: 20px;
            }
        }

        .modal1 {
            display: none;
            position: fixed;
            z-index: 999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
        }

        .modal-content1 {
            max-width: 90%;
            max-height: 90%;
            margin: auto;
            display: block;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .close-btn {
            position: absolute;
            right: 25px;
            top: 15px;
            color: rgb(255, 255, 255);
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            z-index: 1000;
            background: rgb(255, 255, 266);
            color: white;
            border: none;
            font-size: 20px;
            font-weight: bold;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 15px 20px;
            cursor: pointer;
            font-size: 24px;
            transition: background-color 0.3s;
        }

        .nav-btn:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        .prev-btn {
            left: 20px;
        }

        .next-btn {
            right: 20px;
        }

        .car-pic {
            cursor: pointer;
        }

        #emailSenderModal {
            z-index: 1065 !important;
        }

        #emailSenderModal .modal-dialog {
            z-index: 1066 !important;
        }

        .modal-backdrop {
            z-index: 1064 !important;
        }

        #emailSenderModal .modal-content {
            position: relative;
            background-color: #fff;
            opacity: 1 !important;
        }

        #successModal {
            z-index: 1065 !important;
        }

        #successModal .modal-dialog {
            z-index: 1066 !important;
        }

        #successModal .modal-content {
            position: relative;
            background-color: #fff;
            opacity: 1 !important;
        }

        @media screen and (max-width: 768px) {

            .prev-btn,
            .next-btn {
                padding: 12px 16px;
                font-size: 20px;
            }

            .close-btn {
                display: none !important;
                font-size: 32px;
                top: 10px;
                right: 15px;
            }
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            z-index: 1000;
        }

        .modalcontentimageoverlay {
            width: 100%;
            height: 100%;
        }

        .modal-content-wrapper {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modalcontentimageoverlay {
            position: relative;
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            background: transparent;
        }

        .close-btn {
            position: absolute;
            top: 40px;
            right: 70px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            z-index: 1001;
            background: transparent;
            border: none;
            text-shadow: none;
        }

        .prev-btn,
        .next-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            color: white;
            border: none;
            font-size: 35px;
            cursor: pointer;
            padding: 16px;
            z-index: 1001;
            text-shadow: none;
            box-shadow: none;
            outline: none;
        }

        .prev-btn {
            left: 70px;
        }

        .next-btn {
            right: 70px;
        }

        /* Hover effects */
        .close-btn:hover,
        .prev-btn:hover,
        .next-btn:hover {
            color: #bbb;
            cursor: pointer;
        }

        @media screen and (max-width: 900px) {
            .modal-content-wrapper {
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .modalcontentimageoverlay {
                position: relative;
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
                background: transparent;
            }

            .prev-btn {
                left: 10px;
            }

            .next-btn {
                right: 10px;
            }

            .close-btn {
                right: 40px;
                top: 20px;
            }
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        }

        #imageModal {
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
            display: none;
            align-items: center;
            justify-content: center;
        }

        .modal-navigation {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 90%;
        }

        .modal-content1 {
            max-width: 100%;
            max-height: 90vh;
            object-fit: contain;
        }

        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.3);
            border: none;
            color: white;
            font-size: 2rem;
            padding: 10px 15px;
            cursor: pointer;
            z-index: 10;
        }

        /* Mobile touch navigation */
        @media (max-width: 768px) {
            .modal-navigation {
                touch-action: pan-y pinch-zoom;
            }
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            position: relative;
            animation: modalFadeIn 0.3s;
        }

        .modal-icon {
            width: 100px;
            height: 100px;
            margin-bottom: 15px;
            margin: 0 auto;
            display: block;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes modalFadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }

            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

      
      
    </style>
   
@endsection