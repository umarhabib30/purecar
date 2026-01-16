@extends('layout.layout')
<title>Used Cars Northern Ireland - Used Cars Ni | Pure Car</title>
<meta name="description" content="Pure Car is the smart way to find your next used car anywhere in Northern Ireland. We offer an extensive range of quality second-hand and nearly-new vehicles across NI">

<meta property="og:image" content="{{ asset('images/page_sections/' . $sections->where('section', 'hero')[0]->value) }}" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="fb:app_id" content="542551481550768" />
<meta property="og:type" content="article" />

@section('body')
<link rel="stylesheet" href="{{asset('css/first_page.css')}}">
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<link rel="stylesheet" href="{{asset('css/post_page.css')}}">
<link rel="stylesheet" href="{{asset('css/news_articles.css')}}">
<link rel="stylesheet" href="{{asset('css/grid_car_cards_layout.css')}}">
<link rel="stylesheet" href="{{asset('css/hero_section.css')}}">
<style>
.selected-option {
    background-color: #e3f2fd !important;
    font-weight: bold;
}
.dropdown-menu {

    width: 100%; /* Set the width to 100% */
    max-height: 400px;
    overflow-y: auto;
    overflow-x: hidden;
    box-sizing: border-box; /* Include padding in the width calculation */
    text-align: left; /* Align text to the left */
    white-space: nowrap; /* Prevent text wrapping */


}

.scrollable-dropdown {
    max-height: 400px;
    overflow-y: auto;
    overflow-x: hidden;
}

#modelList {
    max-height: 400px !important;
    overflow-y: auto !important;
    overflow-x: hidden !important;
}
button[disabled] {
    border: none; /* Remove the border */
    background-color: transparent; /* Optional: Make the background transparent */
    pointer-events: none; /* Ensure it can't be interacted with */
    box-shadow: none; /* Remove any box shadow, if present */

}
.dropdown-toggle[disabled]::after {
    content: none; /* Remove the arrow */
}

.third_container{
    transform: scale(0.9, 1);  
    transform-origin: center;
    
}
.fourth_container{
    transform: scale(0.9, 1);  
    transform-origin: center;
}
.fourth_containercard{
    transform: scale(0.9, 1);  
    transform-origin: center;
}
.blog_container{
    transform: scale(0.9, 1);  
    transform-origin: center;
}
.seventh_container{
    transform: scale(0.9, 1);  
    transform-origin: center;
}

.car_varient{
    margin-bottom: 10px !important;
}
.car_detail{
    padding-top:1px !important;
    justify-content: flex-start !important;
    gap: 6px !important;
}

.car_detail-item{
    padding: 5px 12px 5px;
    border-radius: 5px;
    background-color: #f1f1f1;
    font-size: 14px;
    font-weight: 500;
    color:#000;
}

@media (max-width: 768px) {
    .hero-section-desktop{
        display: none !important;
    }
    .display-desktop-none {
            display: none !important;
        }
        .dropdown-menu.mobile-menu .dropdown-item, .custom-select-list .dropdown-item{
            padding: 18px 16px;
            color: #0E121B !important;
            white-space: normal !important;
            position: relative !important;
            padding-left: 40px !important;
            border-bottom: unset !important;
        }
    
}

.search-btn {
    background-color: #000;
    color: #fff;
    border: none;
    font-size: 16px;
    height: 44px;
    border-radius: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s ease;
    white-space: nowrap;
    flex: 0 0 auto;
}
.clear-all-link {
    border: 1px solid rgba(82, 88, 102, 0.22);
    color: #FB3748;
    font-size: 16px;
    height: 44px;
    border-radius: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    text-align: center;
    display: flex;
    width: 100%;
    justify-content: center;
    align-items: center;
}

</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
    <!-------------First_body---------------->

    <div class="hero-section-desktop">
        <div class="desktop-hero-section">
            <img style="width:100%; height:100%; object-fit:cover; z-index:1; cursor: pointer;" 
                src="{{ asset('images/page_sections/' . $sections->where('section', 'hero')[0]->value) }}" 
                alt="" 
                onclick="window.open('{{ Str::startsWith($sections->where('section', 'hero')->where('name', 'hero_button_link')->first()->value, ['http://', 'https://']) ? $sections->where('section', 'hero')->where('name', 'hero_button_link')->first()->value : 'https://' . $sections->where('section', 'hero')->where('name', 'hero_button_link')->first()->value }}', '_blank')">
        </div>
        <div class="desktop-hero-section-text">
            <div class="desktop-hero-section-innerbox">@include('partials.car_search_form', ['formId' => 'heroSearchForm'])</div>
            
        </div>
    </div>
    
    <div class="hero-section-mobile" style="width: 100%; height:85vh; overflow:hidden;">
        <div style="height:28vh;">
            <img style="width:100%; height:100%; object-fit:cover; z-index:10;"
                src="{{ asset('images/page_sections/' . $sections->where('section', 'hero')[0]->value) }}" alt=""
                onclick="window.open('{{ Str::startsWith($sections->where('section', 'hero')->where('name', 'hero_button_link')->first()->value, ['http://', 'https://']) ? $sections->where('section', 'hero')->where('name', 'hero_button_link')->first()->value : 'https://' . $sections->where('section', 'hero')->where('name', 'hero_button_link')->first()->value }}', '_blank')">
        </div>
        <div style="background-color:#000; padding:10px 10px; max-height:10vh;"></div>
        <div style="background-color: white; margin-right:20px; padding:20px; height:50vh; overflow:hidden; width:100%;">
            @include('partials.car_search_form', ['formId' => 'mobileHeroSearchForm'])
        </div>
    </div>


          
                

<!-- Recently Added Section -->

<section class="text-center pt-4 pt-lg-5" style="">
    <h4 style="font-size: 30px; margin-top: 0px; margin-bottom: 0px; padding: 0;">Recently Added</h4>
    <div class="card-list-container">
        <div class="grid-for-car-cards">
            @if(isset($data) && $data->isNotEmpty())
                @foreach ($data as $car_data)
                    <div class="my-3">
                        <a href="{{ route('advert_detail', ['slug' => $car_data['slug']]) }}" class="d-block text-decoration-none text-dark">
                            <div class="main_car_card">
                                <div>
                                    <div class="car_card_main_img">
                                        <div class="car_card_inner_img">
                                            <div class="car_card_background_img" style="background-image: url('{{ asset('' . e($car_data['image'])) }}');">
                                            </div>
                                
                                            <img src="{{ asset('' . e($car_data['image'])) }}" 
                                                alt="Car Image"
                                                onload="this.naturalWidth > this.naturalHeight ? this.style.objectFit = 'cover' : this.style.objectFit = 'contain'"
                                                onerror="this.src='{{ asset('assets/coming_soon.png') }}'" 
                                                class="car_card_front_img">
                                        </div>
                                
                                    </div>
                                </div>
                                <div class="card-contain">
                                    <p class="car_tittle text-truncate">{{ e($car_data['make'] ?? 'Unknown make') }}
                                        {{ e($car_data['model'] ?? 'N/A') }} {{ e($car_data['year'] ?? 'N/A') }}</p>
                                        <p class="car_varient text-truncate">
                                        @if(empty($car_data['Trim']) || $car_data['Trim'] == 'N/A')
                                            {{ strtoupper($car_data['variant']) }}
                                        @else
                                            {{ strtoupper(e($car_data['Trim'])) }}
                                        @endif
                                        </p>

                                    <div class="car_detail" style="border:none;">

                                        <div class="text-center car_detail-item">
                                            {{ e(isset($car_data['miles']) ? number_format($car_data['miles'], 0, '.', ',').' miles' : 'N/A') }}
                                        </div>

                                        <div class="text-center car_detail-item">
                                            {{ e(ucfirst(strtolower($car_data['fuel_type'])) ?? 'N/A') }}
                                        </div>

                                        <div class="text-center car_detail-item">
                                            {{ e(ucfirst(strtolower($car_data['gear_box'])) ?? 'N/A') }}
                                        </div>

                                    </div>
                                    <div class="car_detail_bottom">
                                        <p class="car_price">
                                        {{ e(isset($car_data['price']) && $car_data['price'] > 0 ? '£' . number_format($car_data['price'], 0, '.', ',') : 'POA') }}
                                        </p>
                                        <a class="view-btn d-flex align-items-center gap-1">
                                            {{ e(isset($car_data['location']) ? $car_data['location'] : (isset($car_data['user']['location']) ? $car_data['user']['location'] : 'N/A')) }}
                                            <svg width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M14.3333 0C6.42933 0 0 6.42933 0 14.3333C0 22.2373 6.42933 28.6667 14.3333 28.6667C22.2373 28.6667 28.6667 22.2373 28.6667 14.3333C28.6667 6.42933 22.2373 0 14.3333 0ZM14.3333 26.6667C7.532 26.6667 2 21.1347 2 14.3333C2 7.532 7.532 2 14.3333 2C21.1347 2 26.6667 7.532 26.6667 14.3333C26.6667 21.1347 21.1347 26.6667 14.3333 26.6667ZM20.5892 14.7161C20.5385 14.8388 20.4654 14.9493 20.3734 15.0413L16.3734 19.0413C16.1787 19.236 15.9227 19.3346 15.6667 19.3346C15.4107 19.3346 15.1546 19.2373 14.96 19.0413C14.5693 18.6507 14.5693 18.0173 14.96 17.6266L17.2533 15.3333H9C8.448 15.3333 8 14.8853 8 14.3333C8 13.7813 8.448 13.3333 9 13.3333H17.252L14.9587 11.04C14.568 10.6494 14.568 10.016 14.9587 9.62533C15.3493 9.23466 15.9827 9.23466 16.3734 9.62533L20.3734 13.6253C20.4654 13.7173 20.5385 13.8279 20.5892 13.9505C20.6905 14.1959 20.6905 14.4708 20.5892 14.7161Z" fill="#002F6C"/>
                                            </svg>
                                        </a>
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
    
    






    <!-- Buying Essentails Section -->
    <style>
@media (max-width: 767px) {
    .buyingessentials .row {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: hidden;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        position: relative;
    }
    
    .buyingessentials .col-sm-12 {
        flex: 0 0 100%;
        max-width: 100%;
        scroll-snap-align: center;
        padding: 0 15px;
    }
    
    .essential-card {
        margin: 0 auto;
        max-width: 300px;
    }
    
    .pagination-dots {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        gap: 8px;
    }
    
    .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #ccc;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    
    .dot.active {
        background-color: #333;
    }
}

/* Preserve desktop styles */
@media (min-width: 768px) {
    .pagination-dots {
        display: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.innerWidth <= 767) {
        const row = document.querySelector('.buyingessentials .row');
        const cards = row?.querySelectorAll('.col-sm-12')??[];
        
        // Add pagination dots
        const paginationContainer = document.createElement('div');
        paginationContainer.className = 'pagination-dots';
        
        for (let i = 0; i < cards.length; i++) {
            const dot = document.createElement('div');
            dot.className = 'dot' + (i === 0 ? ' active' : '');
            dot.addEventListener('click', () => {
                const scrollPosition = row.clientWidth * i;
                row.scrollTo({ left: scrollPosition, behavior: 'smooth' });
                updateDots(i);
            });
            paginationContainer.appendChild(dot);
        }
        
        row.parentElement.appendChild(paginationContainer);
        
        // Touch handling
        let touchStartX = 0;
        let touchEndX = 0;
        
        row.addEventListener('touchstart', e => {
            touchStartX = e.touches[0].clientX;
        });
        
        row.addEventListener('touchend', e => {
            touchEndX = e.changedTouches[0].clientX;
            handleSwipe();
        });
        
        function handleSwipe() {
            const diff = touchStartX - touchEndX;
            const threshold = 50;
            const currentScroll = row.scrollLeft;
            const pageWidth = row.clientWidth;
            
            if (Math.abs(diff) > threshold) {
                if (diff > 0 && currentScroll < (cards.length - 1) * pageWidth) {
                    // Swipe left
                    row.scrollTo({
                        left: currentScroll + pageWidth,
                        behavior: 'smooth'
                    });
                } else if (diff < 0 && currentScroll > 0) {
                    // Swipe right
                    row.scrollTo({
                        left: currentScroll - pageWidth,
                        behavior: 'smooth'
                    });
                }
            }
        }
        
        // Update dots on scroll
        row.addEventListener('scroll', () => {
            const currentPage = Math.round(row.scrollLeft / row.clientWidth);
            updateDots(currentPage);
        });
        
        function updateDots(activePage) {
            const dots = document.querySelectorAll('.dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === activePage);
            });
        }
    }
});
</script>

<style>
       .header-container {
        display: flex !important;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .header-container div {
        display: none;
    }
       .view-all {
        justify-self: center;
        margin-top: 10px;
    }
    @media (max-width: 768px) {
 

    .title {
        font-size: 24px;
        margin-bottom: 10px;
    }

 

}
</style>

    <!--Recently Added Category Section -->
   <section class="text-center" style="margin-top:10px;">
  
    <div class="header-container mb-3 mt-3"
        style="display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; width: 100%; text-align: center;">
        <div></div> <!-- Empty div for centering -->
        <h4 class="title" style="font-size: 30px; margin: 0; padding: 0;">Bargain Buys</h4>
       <a href="{{ route('cheapest.cars') }}" class="view-all no-underline text-black">View more</a>
    </div>
    <div class="card-list-container">
        <div id="loading" class="text-center d-none">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div class="grid-for-car-cards" id="carListingContainer">
            <!-- Car cards will be loaded here -->
        </div>
    </div>
</section>

<script>
    
document.addEventListener('DOMContentLoaded', function() {
    const loadingDiv = document.getElementById('loading');
    const carListingContainer = document.getElementById('carListingContainer');

    function showLoading() {
        loadingDiv.classList.remove('d-none');
        carListingContainer.classList.add('d-none');
    }

    function hideLoading() {
        loadingDiv.classList.add('d-none');
        carListingContainer.classList.remove('d-none');
    }
    
    
    function generateCarCard(car) {
        return `
            <div class="my-3">
                <a href="/car-for-sale/${car.car_slug}" class="d-block text-decoration-none text-dark">
                    <div class="main_car_card">
                        <div>
                            <div class="car_card_main_img">
                                ${car.image ?
                                    `<div class="car_card_inner_img">
                                        <div class="car_card_background_img" style="background-image: url('${car.image}');"></div>
                                        <img src="${car.image}"
                                            alt="Car Image"
                                            onload="this.naturalWidth > this.naturalHeight ? this.style.objectFit = 'cover' : this.style.objectFit = 'contain'"
                                            onerror="this.src='{{ asset('assets/coming_soon.png') }}'" 
                                            class="car_card_front_img">
                                    </div>` :
                                    `<img src="/assets/images/default-car.png"
                                        alt="Default Car Image"
                                        class="default_car_img">`
                                }
                            </div>
                        </div>
                        <div class="card-contain">
                            <p class="car_tittle text-truncate">${car.make || 'Unknown make'} ${car.model || 'N/A'} ${car.year || 'N/A'}</p>
                            <p class="car_varient text-truncate">
                                ${car.Trim ? car.Trim.substring(0, 31) + (car.Trim.length > 31 ? "..." : "") : "Unknown Trim"}
                            </p>

                            <div class="car_detail" style="">
                                <div class="text-center car_detail-item">${car.miles ? car.miles.toLocaleString() : 'N/A'}</div>
                                <div class="text-center car_detail-item">${car.fuel_type || 'N/A'}</div>
                                <div class="text-center car_detail-item">${car.gear_box || 'N/A'}</div>
                            </div>
                            <div class="car_detail_bottom">
                                <p class="car_price">
                                    ${car.price > 0 ? '£' + Number(car.price).toLocaleString('en-GB', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) : 'POA'}
                                </p>
                                <a class="view-btn d-flex align-items-center gap-1" href="/car-for-sale/${car.car_slug}">
                                    View Details
                                    <svg width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.3333 0C6.42933 0 0 6.42933 0 14.3333C0 22.2373 6.42933 28.6667 14.3333 28.6667C22.2373 28.6667 28.6667 22.2373 28.6667 14.3333C28.6667 6.42933 22.2373 0 14.3333 0ZM14.3333 26.6667C7.532 26.6667 2 21.1347 2 14.3333C2 7.532 7.532 2 14.3333 2C21.1347 2 26.6667 7.532 26.6667 14.3333C26.6667 21.1347 21.1347 26.6667 14.3333 26.6667ZM20.5892 14.7161C20.5385 14.8388 20.4654 14.9493 20.3734 15.0413L16.3734 19.0413C16.1787 19.236 15.9227 19.3346 15.6667 19.3346C15.4107 19.3346 15.1546 19.2373 14.96 19.0413C14.5693 18.6507 14.5693 18.0173 14.96 17.6266L17.2533 15.3333H9C8.448 15.3333 8 14.8853 8 14.3333C8 13.7813 8.448 13.3333 9 13.3333H17.252L14.9587 11.04C14.568 10.6494 14.568 10.016 14.9587 9.62533C15.3493 9.23466 15.9827 9.23466 16.3734 9.62533L20.3734 13.6253C20.4654 13.7173 20.5385 13.8279 20.5892 13.9505C20.6905 14.1959 20.6905 14.4708 20.5892 14.7161Z" fill="#002F6C"/>
                                    </svg>
                                </a>
                                <p class="car_location" style="display:none">
                                    ${car.location || 'N/A'}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        `;
    }
    
   
    async function fetchCars() {
        showLoading();

        try {
            const response = await fetch('/search-price', { 
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (data.success) {
            
            carListingContainer.innerHTML = data.car_data.length > 0
                ? data.car_data.slice(0, 4).map(car => generateCarCard(car)).join('')
                : '<p class="text-center">No cars available within the specified price range.</p>';
            } else {
                carListingContainer.innerHTML = `<p class="text-center text-danger">${data.message}</p>`;
            }
        } catch (error) {
            console.error('Error:', error);
            carListingContainer.innerHTML = '<p class="text-center text-danger">An error occurred while fetching cars.</p>';
        } finally {
            hideLoading();
        }
    }
    fetchCars();
});



</script>

<section class="text-center d-none d-md-block" style="background-color: white; margin-top:30px;">
    
        <div class="blog_container">
            <div class="justify-center mb-2  d-flex align-items-center">
                <h4 style="font-size: 30px; margin-top: 10px; margin-bottom: 10px;">Explore Our Premium Brands</h4>
            </div>
            <div class="row">
                @foreach($brands as $index => $brand)
                    <div id="Brands-div" class="mb-4 shadow col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2"
                        onclick="window.open('{{ $brand->link ?? '#' }}', '_blank')"
                        style="cursor: pointer;">
                        <img src="{{ asset($brand->image ? 'images/brands/' . $brand->image : 'images/placeholder.png') }}"
                            class="rounded card-img-top"
                            id="Brands-div-img"
                            alt="{{ $brand->name }}">
                    </div>
                @endforeach
            </div>


        </div>  
</section>
<section class="text-center d-md-none" style="background-color: white; margin-top:30px;">
    <div class="blog_container">
        <div class="justify-center mb-2 d-flex align-items-center">
            <h4 style="font-size: 30px; margin-top: 10px; margin-bottom: 10px;">Explore Our Premium Brands</h4>
        </div>
        <div class="row brands-container">
            @foreach($brands->take(4) as $brand)
                <div id="brand-{{ $brand->id }}" class="col-6 col-md-6 mb-4">
                    <div class="brand-card shadow" 
                        onclick="window.open('{{ $brand->link ?? '#' }}', '_blank')"
                        style="cursor: pointer;">
                        <img src="{{ asset($brand->image ? 'images/brands/' . $brand->image : 'images/placeholder.png') }}"
                            class="rounded card-img-top w-100"
                            alt="{{ $brand->name }}"
                            style="object-fit: contain; height: 200px;">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
@media (max-width: 576px) {
    .brand-card {
        padding: 10px;
        height: 150px !important;
    }
    .brand-card img {
        height: 150px !important;
    }
}
</style>

<script>
let currentIndex = 0;
const allBrands = {!! json_encode($brands) !!};
const totalBrands = allBrands.length;

function updateBrands() {
    if (totalBrands <= 4) return; // Don't rotate if 4 or fewer brands

    const brandsContainer = document.querySelector('.brands-container');
    
    // Get next 4 brands (with wraparound)
    for (let i = 0; i < 4; i++) {
        const brandIndex = (currentIndex + i) % totalBrands;
        const brand = allBrands[brandIndex];
        const brandElement = brandsContainer.children[i];
        
        const img = brandElement.querySelector('img');
        img.src = brand.image ? `/images/brands/${brand.image}` : '/images/placeholder.png';
        img.alt = brand.name;
        
        const card = brandElement.querySelector('.brand-card');
        card.onclick = () => window.open(brand.link || '#', '_blank');
    }
    
    currentIndex = (currentIndex + 4) % totalBrands;
}

// Rotate brands every 5 seconds
setInterval(updateBrands, 5000);
</script>





    

    <div class="counter-container" style="margin-top: 30px; margin-bottom: 30px;">
    <div class="counter-grid">
    <div class="counter-item">
        <h2>{{ number_format($counters['cars'] ?? 0) }}</h2>
        <p>Cars for Sale</p>
    </div>

    <div class="counter-item">
        <h2>{{ number_format($counters['forums'] ?? 0) }}</h2>
        <p>Forum Sections</p>
    </div>

    <div class="counter-item">
        <h2>{{ number_format($counters['visitors'] ?? 0) }}</h2>
        <p>Visitors Per Day</p>
    </div>

    <div class="counter-item">
        <h2>{{ number_format($counters['dealers'] ?? 0) }}</h2>
        <p>Verified Dealers</p>
    </div>
</div>

</div>

<style>
.counter-container {
    padding: 2rem 0;
    background: #F5F6FA
}

.counter-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

.counter-item {
    text-align: center;
}

.counter-item h2 {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.counter-item p {
    margin: 0;
    font-size: 1rem;
}

@media (max-width: 768px) {
    .counter-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        padding: 0 0.5rem;
    }
    
    .counter-item h2 {
        font-size: 1.5rem;
    }
    
    .counter-item p {
        font-size: 0.875rem;
    }
}
</style>



    <!-------------Blog page---------------->
    <div class="blog_containertransform" style="margin-bottom:35px;">
     
            <h4 style="font-size: 30px; margin-top: 10px; margin-bottom: 10px;">Trusted Dealerships</h4>
      
        <div class="blog-container-1">
            <!-- Left Column -->
            <div class="left-column">
                @foreach($dealers->take(2) as $dealer)
                    <div class="blog-card-1" onclick="window.location.href='{{ route('dealer.profile', ['slug' => $dealer->slug]) }}'">
                        <img src="{{ $dealer->image ? asset('images/users/' . $dealer->image) : asset('assets/profilecar.png') }}" alt="{{ $dealer->name }}">
                        <div class="blog-content-1">
                            <h5>{{ $dealer->name }}</h5>
                            <p>{{ \Str::limit(strip_tags($dealer->business_desc), 350) }}</p>
                            {{-- <a class="blog-content-link" href="{{ route('blog.show', ['blog' => $dealer->slug]) }}">Read More</a> --}}
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Right Column -->
            <div class="right-column">
                @foreach($dealers->skip(2)->take(3) as $dealer)
                    <div class="right-column-blog-card" onclick="window.location.href='{{ route('dealer.profile', ['slug' => $dealer->slug]) }}'">
                        <div class="right-column-blog-card-img" style="background-image: url('{{ $dealer->image ? asset('images/users/' . $dealer->image) : asset('assets/profilecar.png') }}');"></div>
                        <div class="right-column-blog-content">
                            <h5>{{ \Str::limit($dealer->name, 20 ) }}</h5>
                            <p>{{ \Str::limit(strip_tags($dealer->business_desc), 70) }}</p>
                            {{-- <a class="blog-content-link" href="{{ route('blog.show', ['blog' => $blog->slug]) }}">Read More</a> --}}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        .blog_containertransform{
            transform: scale(0.9, 1);  
            transform-origin: center;
            margin-top: 20px;
            margin-bottom: 0px;
          

        }

        .blog-container-1 {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 16px;
            padding: 10px 15px;
            
        }

        .left-column {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
           
        }

        .right-column {
            display: grid;
            grid-template-rows: repeat(3, 1fr);
            gap: 16px;
        }

        .blog-card-1 {
            background-color: white;
            border-radius: 8px;
            /* overflow: hidden; */
            cursor: pointer;
           
        }

        .blog-card-1 img {
            width: 100%;
            height: 296px;
            /* object-fit: cover; */
            border-radius: 10px;
        }

        .right-column-blog-card {
            display: flex;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
        }

        
        .right-column-blog-card-img {
        width: 200px;
        height: 150px;
        min-width: 250px;
        min-height: 150px;
        overflow: hidden;
        max-width: 100%; 
        flex-shrink: 0;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        border-radius: 10px;
        }

        .blog-content-1 {
            padding-top: 11px;
            padding-right: 16px;
        }

        .right-column-blog-content {
            padding: 10px;
        }

        .blog-content-1 h5 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .blog-content-1 p {
            font-size: 16px;
            color: #757575;
            margin-bottom: 12px;
        }

        .blog-content-link {
            padding: 5px 10px;
            border-radius: 8px;
            font-weight: bold;
            color: black;
            text-decoration: none;
            font-size: 14px;
        }

        /* Responsive Styles */
        @media (max-width: 1024px) {
            .blog-container-1 {
                grid-template-columns: 1fr;
            }
            .blog-content-1{
                padding-bottom: 5px;
            }
            .left-column {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .blog-card-1 img {
                height: 200px;
            }
            .blog-content-1{
                padding-bottom: 5px;
            }
            .right-column-blog-content {
                padding-left: 0px;
                padding-right: 0px;
            }
            .right-column-blog-card {
                flex-direction: column;
            }

            .right-column-blog-card-img {
                width: 100%;
                height: 200px;
                border-radius: 0;
            }
            .dropdown-menu{
                display: none !important;
            }
        }

        @media (max-width: 480px) {
            .blog-content-1 h5,
            .right-column-blog-content h5 {
                font-size: 16px;
            }

            .blog-content-1 p,
            .right-column-blog-content p {
                font-size: 15px;
            }

            .blog-content-link {
                font-size: 16px;
            }
        }
    </style>

    <!-- Car search form JS removed from landing page (handled by `partials.car_search_form`). -->

<style>
    .clickable-image{
    cursor: pointer; 
}
</style>
<!-- Landing page modal JS removed (handled elsewhere) -->

@endsection

