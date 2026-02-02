<style>
    .car_varient {
        margin-bottom: 10px !important;
    }

    .car_detail {
        padding-top: 1px !important;
        justify-content: flex-start !important;
        gap: 6px !important;
    }

    .car_detail-item {
        padding: 5px 12px 5px;
        border-radius: 5px;
        background-color: #f1f1f1;
        font-size: 14px;
        font-weight: 500;
        color: #000;
    }
</style>

@forelse ($cars as $car_data)
    <div class="my-3">
        <a href="{{ route('advert_detail', ['slug' => $car_data['slug']]) }}"
            class="d-block text-decoration-none text-dark">
            <div class="main_car_card">
                <div>
                    <div class="car_card_main_img">
                        <div class="car_card_inner_img">
                            <div class="car_card_background_img"
                                style="background-image: url('{{ asset('' . e($car_data['image'])) }}');"></div>
                            <img src="{{ asset('' . e($car_data['image'])) }}" alt="Car Image"
                                onload="this.naturalWidth > this.naturalHeight ? this.style.objectFit = 'cover' : this.style.objectFit = 'contain'"
                                onerror="this.src='{{ asset('assets/coming_soon.png') }}'" class="car_card_front_img">
                        </div>
                    </div>
                </div>

                <div class="card-contain">
                    <p class="car_tittle text-truncate">
                        {{ e($car_data['make'] ?? 'Unknown make') }}
                        {{ e($car_data['model'] ?? 'N/A') }}
                        {{ e($car_data['year'] ?? 'N/A') }}
                    </p>

                    <p class="car_varient">
                        @if (empty($car_data['Trim']) || $car_data['Trim'] == 'N/A')
                            {{ strtoupper($car_data['variant'] ?? '') }}
                        @else
                            {{ strtoupper(e($car_data['Trim'])) }}
                        @endif
                    </p>

                    <div class="car_detail" style="border:none;">
                        <div class="text-center car_detail-item">
                            {{ e(isset($car_data['miles']) ? number_format($car_data['miles'], 0, '.', ',') . ' miles' : 'N/A') }}
                        </div>

                        <div class="text-center car_detail-item">
                            {{ e(isset($car_data['fuel_type']) ? ucfirst(strtolower($car_data['fuel_type'])) : 'N/A') }}
                        </div>

                        <div class="text-center car_detail-item">
                            {{ e(isset($car_data['gear_box']) ? ucfirst(strtolower($car_data['gear_box'])) : 'N/A') }}
                        </div>
                    </div>

                    <div class="car_detail_bottom">
                        <p class="car_price">
                            {{ e(isset($car_data['price']) && $car_data['price'] > 0 ? '£' . number_format($car_data['price'], 0, '.', ',') : 'POA') }}
                        </p>

                        <a class="view-btn d-flex align-items-center gap-1">
                            {{ e(isset($car_data['location']) ? $car_data['location'] : (isset($car_data['user']['location']) ? $car_data['user']['location'] : 'N/A')) }}
                            <svg width="29" height="29" viewBox="0 0 29 29" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14.3333 0C6.42933 0 0 6.42933 0 14.3333C0 22.2373 6.42933 28.6667 14.3333 28.6667C22.2373 28.6667 28.6667 22.2373 28.6667 14.3333C28.6667 6.42933 22.2373 0 14.3333 0ZM14.3333 26.6667C7.532 26.6667 2 21.1347 2 14.3333C2 7.532 7.532 2 14.3333 2C21.1347 2 26.6667 7.532 26.6667 14.3333C26.6667 21.1347 21.1347 26.6667 14.3333 26.6667ZM20.5892 14.7161C20.5385 14.8388 20.4654 14.9493 20.3734 15.0413L16.3734 19.0413C16.1787 19.236 15.9227 19.3346 15.6667 19.3346C15.4107 19.3346 15.1546 19.2373 14.96 19.0413C14.5693 18.6507 14.5693 18.0173 14.96 17.6266L17.2533 15.3333H9C8.448 15.3333 8 14.8853 8 14.3333C8 13.7813 8.448 13.3333 9 13.3333H17.252L14.9587 11.04C14.568 10.6494 14.568 10.016 14.9587 9.62533C15.3493 9.23466 15.9827 9.23466 16.3734 9.62533L20.3734 13.6253C20.4654 13.7173 20.5385 13.8279 20.5892 13.9505C20.6905 14.1959 20.6905 14.4708 20.5892 14.7161Z"
                                    fill="#002F6C" />
                            </svg>
                        </a>
                    </div>

                </div>
            </div>
        </a>
    </div>
@empty
    <div class="my-4 text-center">
        <p class="mb-0">No cars found.</p>
    </div>
@endforelse
