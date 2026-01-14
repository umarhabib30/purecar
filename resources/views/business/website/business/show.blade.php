<!-- resources/views/website/business/show.blade.php -->
@extends('layout.layout')
<meta name="description"
    content="Need {{ $business->businessType->name }} in {{ $business->businessLocation->name }}? Search for local businesses offering {{ $business->businessLocation->name }} {{ $business->businessType->name }}. Get connected with local businesses on Purecar today!">



    <meta name="robots" content="noindex, nofollow">
@section('body')
    <style>
        .business-show-detail{
            padding: 30px 100px;
            padding-top: 0px !important;
        }
        .business-name {
            text-align: center;
            font-weight: 600;
            margin-top: 40px;
            margin-bottom: 20px;
        }
        .business-desc {
            text-align: center;
            width: 90%;
        }
        .business-data-detail{
            display: flex;  
            align-items: center;
            flex-direction: row;    
        }
        .business-data-card{
            width: 50%;
        }
        .business-data-img{
            width: 50%; 
            height: 300px;       
            border-radius: 20px;
            overflow: hidden;
            object-fit: cover;
        }
        .business-detail-card{
            display: flex;
            font-size: 18px;
            padding: 10px 0px
        }
        .business-detail-span-1{
            width: 35%;
            font-weight: 800;        
        }
        .business-detail-span{
            width: 60%;
        }
        .gallery{
            display: none;
        }
        .gallery-div{
            margin-top: 30px;
        }
        .gallery-inner-div{
            display: grid;
            grid-template-columns: repeat(5,1fr);
            gap: 10px;
        }
        .gallery-img-div{
            width: 100%;
            height: 100%;
            overflow: hidden;
            object-fit: cover;
            border-radius: 10px;
        }
        @media screen and (max-width:786px) {
            .business-show-detail{
                padding: 15px 20px;
            }
            .business-name {
                font-size: 24px;
                margin-top: 20px;
                margin-bottom: 15px;
                word-wrap: break-word;
                hyphens: auto;
            }
            .business-desc {
                text-align: center;
                width: 100%;
                font-size: 16px;
                line-height: 1.5;
                word-wrap: break-word;
            }
            .business-data-detail{
                flex-direction: column;      
            }
            .business-data-card{
                width: 100%;
                margin-bottom: 20px;
            }
            .business-data-img{
                width: 100%;
            }
            .business-detail-card{
                flex-direction: column;
                font-size: 16px;
                padding: 8px 0px;
                /* border-bottom: 1px solid #f0f0f0; */
            }
           
            .business-detail-span{
                width: 100%;
                word-wrap: break-word;
                word-break: break-all;
                hyphens: auto;
                font-size: 16px;
                line-height: 1.4;
            }
            .gallery{
                display: block;
                text-align: center;
                margin-top: 15px;
                font-size: 18px;
            }
            .gallery-div{
                margin-top: 20px;
            }
            .gallery-inner-div{
                display: grid;
                grid-template-columns: repeat(2,1fr);
                gap: 10px;
            }
              .mobilecontainer{
                margin-top:30px !important;
            }
           
        }
       
    </style>
    <div class="business-show-detail">
        <h1 class="business-name" style="font-weight: 500; font-size: 34px;">{{ $business->name }}</h1>
        <div style="display: flex; justify-content:center;">
            <p class="business-desc">{{ $business->description ?? 'No description provided.' }}</p>
        </div>
        <div class="business-data-detail">
            <div class="business-data-card">
                <div  class="business-detail-card"><div class="business-detail-span-1">Business Name</div><div class="business-detail-span">{{ $business->name }}</div></div>
                <div  class="business-detail-card"><div class="business-detail-span-1">Business Type</div><div class="business-detail-span">{{ $business->businessType->name }}</div></div>
                <div  class="business-detail-card"><div class="business-detail-span-1">Phone</div><div class="business-detail-span">{{ $business->contact_no }}</div></div>
                <div  class="business-detail-card"><div class="business-detail-span-1">Email</div><div class="business-detail-span">{{ $business->email }}</div></div>
                @if ($business->website)
                    <div  class="business-detail-card">
                        <div class="business-detail-span-1">Website</div><div class="business-detail-span"><a href="{{ $business->website }}" class="text-blue-500 text-decoration-none"
                            target="_blank">Visit website</a></div>
                    </div>
                @endif
               <div class="business-detail-card">
                    <div class="business-detail-span-1">Address</div>
                    <div class="business-detail-span" style="white-space: normal; word-break: keep-all; overflow-wrap: break-word;">
                        {{ $business->address }}
                    </div>
                    </div>

            </div>
        
           <div class="business-data-img">
                @php
                    $imagePath = $business->images->first()?->image_path;
                @endphp

                @if ($imagePath && !Str::contains($imagePath, 'https://purecar.co.uk/public/'))
                    <img src="{{ asset($imagePath) }}" 
                        alt="{{ $business->name }}"
                        style="width: 100%; height: 100%; object-fit: cover;"
                        onerror="this.onerror=null;this.src='{{ asset('assets/noimage.jpeg') }}';">
                @else
                    <img src="{{ asset('assets/noimage.jpeg') }}" 
                        alt="No Image Available"
                        style="width: 100%; height: 100%; object-fit: cover;">
                @endif
            </div>
        </div>

        
    </div>


     <section class="text-center mobilecontainer" style="margin-top:10px;">
             <h1 class="business-name">Browse Cars for Sale</h1>
        <div class="card-list-container">
            <div class="grid-for-car-cards">
                
                    @foreach ($data as $car_data)
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
                                                         {{ strtoupper($car_data['variant']) }}
                                            @else
                                                 {{ strtoupper(e($car_data['Trim'])) }}
                                            @endif
                                        </p>
                                        <div class="car_detail">
                                            <div class="text-center car_detail-item">{{ e(isset($car_data['miles']) ? number_format($car_data['miles'], 0, '.', ',') : 'N/A') }}</div>
                                            <div class="text-center car_detail-item">{{ e($car_data['fuel_type'] ?? 'N/A') }}</div>
                                            <div class="text-center car_detail-item">{{ e($car_data['gear_box'] ?? 'N/A') }}</div>
                                        </div>
                                     
                                
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
@endsection