@extends('layout.layout')
<title>Cheap Cars in Northern Ireland - Ni Cheap Cars | Pure Car</title>
<meta name="description" content="Here you can find the best selection of cheap cars in Northern Ireland. We display a large range of new and used vehicles to suit your budget.">
@section('body')

<section class="text-center" style="margin-top:20px;">
    <h4 style="font-size: 30px; margin-top: 10px; margin-bottom: 10px; padding: 0;">Bargain Buys</h4>
    <div class="card-list-container">
    <div class="grid-for-car-cards">
        @if(isset($data) && $data->isNotEmpty())
            @foreach ($data as $car_data)
                <div class="my-3">
                <a href="{{ route('advert_detail', ['slug' => $car_data['slug']]) }}" class="text-decoration-none text-dark">
            <div class="main_car_card">
                <div>
                    <div class="car_card_main_img">
                        <div class="car_card_inner_img">
                            <div class="car_card_background_img" style="background-image: url('{{ asset('' . e($car_data['image'])) }}');">
                            </div>
                          
                            <img src="{{ asset('' . e($car_data['image'])) }}" alt="Car Image"
                                onload="this.naturalWidth > this.naturalHeight ? this.style.objectFit = 'cover' : this.style.objectFit = 'contain'"
                                class="car_card_front_img">
                        </div>

                    </div>
                </div>
                <div class="p-3 card-contain">
                    <p class="car_tittle text-truncate">{{ e($car_data['make'] ?? 'Unknown make') }}
                        {{ e($car_data['model'] ?? 'N/A') }} {{ e($car_data['year'] ?? 'N/A') }}</p>
                    <p class="car_varient text-truncate">
                        @if(empty($car_data['Trim']) || $car_data['Trim'] == 'N/A')
                        {{ e($car_data['EngineCapacity']) }}
                        {{ e($car_data['fuel_type']) }}
                        {{ e($car_data['gear_box']) }}
                        @else
                        {{ e($car_data['Trim']) }}
                        @endif
                    </p>
                    <div class="car_detail">
                        <div class="text-center car_detail-item">{{ e(isset($car_data['miles']) ? number_format($car_data['miles'], 0, '.', ',') : 'N/A') }}</div>
                        <div class="text-center car_detail-item">{{ e($car_data['fuel_type'] ?? 'N/A') }}</div>
                        <div class="text-center car_detail-item">{{ e($car_data['gear_box'] ?? 'N/A') }}</div>
                    </div>
                    <!-- <div class="space"></div>
                    <div class="row g-0">
                        <div class="text-center col-4">
                            <div class="d-flex align-items-start justify-content-start">
                                <img src="{{ asset('assets/icons/avrg.svg') }}" alt="Average Icon" width="16"
                                    height="16">
                                <p class="specs ms-2">{{ e($car_data['engine_size'] ?? 'N/A') }}</p>
                            </div>
                        </div>
                        <div class="text-center col-4">
                            <div class="d-flex align-items-start justify-content-start">
                                <img src="{{ asset('assets/icons/auction.svg') }}" alt="Auction Icon" width="16"
                                    height="16">
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
                                <img src="{{ asset('assets/icons/person.svg') }}" alt="Location Icon" width="16"
                                    height="16">
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
        @else
            <p class="text-center">No cars available at the moment.</p>
        @endif
    </div>
</div>
</section>


@endsection