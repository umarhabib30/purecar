@extends('layout.layout')
@section('body')
<style>
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
</style>




   

<section class="text-center recentlyadded second_container" style="margin-top:20px;">
    <h4 style="font-size: 30px; margin-top: 10px; margin-bottom: 10px; padding: 0;">Recently Sold Cars</h4>
    <div class="container">
    <div class="row justify-content-center articles-grid">
        @if(isset($soldcars) && $soldcars->isNotEmpty())
            @foreach ($soldcars as $car_data)
                <div class="my-3 articles-grid">
                <a href="{{ route('advert_detail', ['slug' => $car_data['car']['slug']]) }}" class="text-decoration-none text-dark">
            <div class="card" style="border: none; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 8px;">
                <div>
                    <div
                        style="overflow: hidden; height: 200px; display: flex; justify-content: center; align-items: center; background-color: inherit; position: relative;">

                        <div
                            style="position: relative; width: 100%; height: 100%; border-radius: 10px 10px 0 0; overflow: hidden;">
                            <div
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('{{ asset('' . e($car_data['image'])) }}'); background-size: cover; filter: blur(10px);">
                            </div>
                            <div class="sold-label">Sold</div>
                            <img src="{{ asset('' . e($car_data['image'])) }}" alt="Car Image"
                                onload="this.naturalWidth > this.naturalHeight ? this.style.objectFit = 'cover' : this.style.objectFit = 'contain'"
                                style="position: relative; width: 100%; height: 100%; object-position: center; z-index: 2;">
                        </div>

                    </div>
                </div>
                <div class="p-3">
                    <p class="first text-truncate">{{ e($car_data['car']['make'] ?? 'Unknown make') }}
                        {{ e($car_data['car']['model'] ?? 'N/A') }} {{ e($car_data['car']['year'] ?? 'N/A') }}</p>
                    <p class="second text-truncate">
                        @if(empty($car_data['car']['Trim']) || $car_data['car']['Trim'] == 'N/A')
                        {{ e($car_data['car']['EngineCapacity']) }}
                        {{ e($car_data['car']['fuel_type']) }}
                        {{ e($car_data['car']['gear_box']) }}
                        @else
                        {{ e($car_data['car']['Trim']) }}
                        @endif
                    </p>
                    <div class="row g-0">
                        <div class="text-center col-4">
                            <div class="d-flex align-items-start justify-content-start">
                                <img src="{{ asset('assets/icons/speed.svg') }}" alt="Mileage Icon" width="16"
                                    height="16">
                                <p class="specs ms-2">
                                    {{ e(isset($car_data['miles']) ? number_format($car_data['miles'], 0, '.', ',') : 'N/A') }}
                                </p>
                            </div>
                        </div>
                        <div class="text-center col-4">
                            <div class="d-flex align-items-start justify-content-start">
                                <img src="{{ asset('assets/icons/fuel.svg') }}" alt="Fuel Type Icon" width="16"
                                    height="16">
                                <p class="specs ms-2">{{ e($car_data['car']['fuel_type'] ?? 'N/A') }}</p>
                            </div>
                        </div>
                        <div class="text-center col-4">
                            <div class="d-flex align-items-start justify-content-start">
                                <img src="{{ asset('assets/icons/gear.svg') }}" alt="Transmission Icon" width="16"
                                    height="16">
                                <p class="specs ms-2">{{ e($car_data['car']['gear_box'] ?? 'N/A') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="space"></div>
                    <div class="row g-0">
                        <div class="text-center col-4">
                            <div class="d-flex align-items-start justify-content-start">
                                <img src="{{ asset('assets/icons/avrg.svg') }}" alt="Average Icon" width="16"
                                    height="16">
                                <p class="specs ms-2">{{ e($car_data['car']['engine_size'] ?? 'N/A') }}</p>
                            </div>
                        </div>
                        <div class="text-center col-4">
                            <div class="d-flex align-items-start justify-content-start">
                                <img src="{{ asset('assets/icons/auction.svg') }}" alt="Auction Icon" width="16"
                                    height="16">
                                <p class="specs ms-2">
                                    @php
                                    $sellerType = $car_data['car']['seller_type'] ?? 'Auction';
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
                    </div>
                    <div class="space"></div>
                    <p class="first">
                    {{ e(isset($car_data['car']['price']) && $car_data['car']['price'] > 0 ? '£' . number_format($car_data['car']['price'], 0, '.', ',') : 'POA') }}
                    </p>
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