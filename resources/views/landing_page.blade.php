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
    <!-- <div class="first_car ps-4 pe-4 rounded-3 d-none d-md-block" style="
        display: flex;
        width: 90%;
         margin:10px auto 0 auto;
        justify-content: center;
        align-items: center;">
        <img class="rounded-3" src="{{ asset('images/page_sections/' . $sections->where('section', 'hero')[0]->value) }}" alt="" style="width: 100%; height: 240px; object-fit: cover;">
    </div>
    <div class="first_car-1">
        <img src="{{ asset('images/page_sections/' . $sections->where('section', 'hero')[0]->value) }}" alt="" >
    </div>  -->
<script>
   
    // the below script comments out the form via javascript to avoid hiddeen input
  document.addEventListener('DOMContentLoaded', function () {
    function commentOutDesktopFormOnMobile() {
        if (window.innerWidth < 768) {
            const desktopForm = document.getElementById('desktopform');
            if (desktopForm) {
                console.log('Desktop form found. Commenting it out...');
                const commentStart = document.createComment(' desktopform start ');
                const commentEnd = document.createComment(' desktopform end ');
                desktopForm.parentNode.insertBefore(commentStart, desktopForm);
                desktopForm.parentNode.insertBefore(commentEnd, desktopForm.nextSibling);
                desktopForm.remove();
            } else {
                console.error('Desktop form not found!');
            }
        }
    }
    commentOutDesktopFormOnMobile();
    window.addEventListener('resize', commentOutDesktopFormOnMobile);
});
</script>

    <div class="hero-section-desktop">
        <div class="desktop-hero-section">
            <img style="width:100%; height:100%; object-fit:cover; z-index:1; cursor: pointer;" 
                src="{{ asset('images/page_sections/' . $sections->where('section', 'hero')[0]->value) }}" 
                alt="" 
                onclick="window.open('{{ Str::startsWith($sections->where('section', 'hero')->where('name', 'hero_button_link')->first()->value, ['http://', 'https://']) ? $sections->where('section', 'hero')->where('name', 'hero_button_link')->first()->value : 'https://' . $sections->where('section', 'hero')->where('name', 'hero_button_link')->first()->value }}', '_blank')">
        </div>
        <div class="desktop-hero-section-text">
            <div class="desktop-hero-section-innerbox">@include('partials.car_search_form', ['formId' => 'heroSearchForm'])</div>
            
            <!--@if(false)-->
            <!--<div class="desktop-hero-section-innerbox">-->
            <!--    <h1>{{ $sections->where('section', 'hero')[1]->value }}</h1>-->
                <!-- <p>{{ $sections->where('section', 'hero')[2]->value }}</p> -->
            <!--    <form method="GET" action="{{route('search_car')}}" style="margin-top:30px; pointer-events: auto;" id="desktopform">-->
            <!--        @csrf-->
            <!--            <div class="">-->
                            <!-- make model row  -->
            <!--                <div class="search_box_dropdown_menu">-->
                                <!-- Make Dropdown -->
            <!--                    <div class="dropdown_menu_first_col">-->
            <!--                        <div class="pt-1 pb-1 dropdown rounded-3 search_color">-->
            <!--                            <button class="btn search_color dropdown-toggle w-100 d-flex justify-content-between align-items-center"-->
            <!--                                    type="button" id="makeDropdown" data-bs-toggle="dropdown" >-->
            <!--                                Make-->
            <!--                            </button>-->
            <!--                            <ul class="dropdown-menu scrollable-dropdown">-->
                                            <!-- <li>
            <!--                                    <a class="dropdown-item" href="javascript:void(0)"-->
            <!--                                    onclick="updateDropdownText('Any', 'makeDropdown', 'makeInput')">-->
            <!--                                        Any-->
            <!--                                    </a>-->
            <!--                                </li> -->-->
            <!--                                @foreach($search_field['make'] as $make)-->
            <!--                                    <li>-->
            <!--                                        <a class="dropdown-item" href="javascript:void(0)"-->
            <!--                                        onclick="updateDropdownText('{{ $make->make }}', 'makeDropdown', 'makeInput')">-->
            <!--                                            {{ $make->make }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $make->count }})-->
            <!--                                        </a>-->
            <!--                                    </li>-->
            <!--                                @endforeach-->
            <!--                            </ul>-->
            <!--                        </div>-->
            <!--                        <input type="hidden" name="make" id="makeInput" value="">-->
            <!--                    </div>-->
                                <!-- Model Dropdown -->
            <!--                    <div class="dropdown_menu_second_col">-->
            <!--                        <div class="pt-1 pb-1 dropdown rounded-3 search_color">-->
            <!--                            <button class="btn search_color dropdown-toggle w-100 d-flex justify-content-between align-items-center"-->
            <!--                                    type="button" id="modelDropdown" data-bs-toggle="dropdown" disabled>-->
            <!--                                Model-->
            <!--                            </button>-->
            <!--                            <ul class="dropdown-menu scrollable-dropdown" id="modelList">-->
            <!--                                <li>-->
            <!--                                    <a class="dropdown-item" href="javascript:void(0)"-->
            <!--                                    onclick="updateDropdownText('Any', 'modelDropdown', 'modelInput')">-->
                                                    
            <!--                                    </a>-->
            <!--                                </li>-->
            <!--                            </ul>-->
            <!--                        </div>-->
            <!--                        <input type="hidden" name="model" id="modelInput" value="">-->
            <!--                    </div>-->
            <!--                </div>                                                          -->

                            
                            <!-- Variant Dropdown -->

            <!--                <div class="mb-2">-->
            <!--                    <div class="pt-1 pb-1 dropdown rounded-3 search_color">-->
            <!--                        <button class="btn search_color dropdown-toggle w-100 d-flex justify-content-between align-items-center"-->
            <!--                                type="button" id="variantDropdown" data-bs-toggle="dropdown" disabled>-->
            <!--                            Variant-->
            <!--                        </button>-->
            <!--                        <ul class="dropdown-menu scrollable-dropdown" id="variantList">-->
            <!--                            <li>-->
            <!--                                <a class="dropdown-item" href="javascript:void(0)"-->
            <!--                                onclick="updateDropdownText('Any', 'variantDropdown', 'variantInput')">-->
                                            
            <!--                                </a>-->
            <!--                            </li>-->
            <!--                        </ul>-->
            <!--                    </div>-->
            <!--                    <input type="hidden" name="variant" id="variantInput" value="">-->
            <!--                </div>-->
                            
                            <!-- price to and from row  -->
            <!--                <div class="search_box_dropdown_menu">-->
                                   <!-- Price From Dropdown -->
            <!--                    <div class="dropdown_menu_second_col">-->
            <!--                        <div class="pt-1 pb-1 dropdown rounded-3 search_color">-->
            <!--                            <button class="btn search_color dropdown-toggle w-100 d-flex justify-content-between align-items-center"-->
            <!--                                    type="button" id="pricefromDropdown" data-bs-toggle="dropdown">-->
            <!--                                    Price From-->
            <!--                            </button>-->
            <!--                            <ul class="overflow-auto dropdown-menu" style="max-height: 300px;" id="pricefromDropdownList">-->
                                            <!-- <li>
            <!--                                    <a class="dropdown-item" href="javascript:void(0)"-->
            <!--                                    onclick="updateDropdownText('Any', 'pricefromDropdown', 'pricefromInput', 'Any')">-->
            <!--                                        Any-->
            <!--                                    </a>-->
            <!--                                </li> -->-->
            <!--                                @foreach($price_counts as $price_range)-->
            <!--                                    <li>-->
            <!--                                        <a class="dropdown-item" href="javascript:void(0)"-->
            <!--                                        onclick="updateDropdownText('{{ $price_range['min'] }}', 'pricefromDropdown', 'pricefromInput', '£{{ number_format($price_range['min']) }}')">-->
            <!--                                        £{{ number_format($price_range['min']) }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $price_range['count'] }})-->
            <!--                                        </a>-->
            <!--                                    </li>-->
            <!--                                @endforeach-->
            <!--                            </ul>-->
            <!--                        </div>-->
            <!--                        <input type="hidden" name="price_from" id="pricefromInput" value="">-->
            <!--                    </div>-->
                                <!-- Price To Dropdown -->
            <!--                    <div class="dropdown_menu_first_col">-->
            <!--                        <div class="pt-1 pb-1 dropdown rounded-3 search_color">-->
            <!--                            <button class="btn search_color dropdown-toggle w-100 d-flex justify-content-between align-items-center"-->
            <!--                                    type="button" id="pricetoDropdown" data-bs-toggle="dropdown">-->
            <!--                                Price To-->
            <!--                            </button>-->
            <!--                            <ul class="overflow-auto dropdown-menu" style="max-height: 300px;" id="priceDropdownList">-->
                                        <!-- <li>
            <!--                                    <a class="dropdown-item" href="javascript:void(0)"-->
            <!--                                    onclick="updateDropdownText('Any', 'pricetoDropdown', 'pricetoInput')">-->
            <!--                                        Any-->
            <!--                                    </a>-->
            <!--                                </li> -->-->
            <!--                                @foreach($price_counts as $price_range)-->
            <!--                                    <li>-->
            <!--                                        <a class="dropdown-item" href="javascript:void(0)"-->
            <!--                                        onclick="updateDropdownText('{{ $price_range['max'] }}', 'pricetoDropdown', 'pricetoInput', '£{{ number_format($price_range['max']) }} ({{ $price_range['count'] }})')">-->

            <!--                                        £{{ number_format($price_range['max']) }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $price_range['count'] }})-->
            <!--                                        </a>-->
            <!--                                    </li>-->
            <!--                                @endforeach-->
            <!--                            </ul>-->
            <!--                        </div>-->
            <!--                        <input type="hidden" name="price_to" id="pricetoInput" value="">-->
            <!--                    </div>-->
                             
            <!--                </div>-->
                            
            <!--                <div class="search_box_dropdown_menu">-->
                                  <!-- Year From Dropdown -->
            <!--                    <div class="dropdown_menu_second_col">-->
            <!--                        <div class="pt-1 pb-1 dropdown rounded-3 search_color">-->
            <!--                            <button class="btn search_color dropdown-toggle w-100 d-flex justify-content-between align-items-center"-->
            <!--                                    type="button" id="yearfromDropdown" data-bs-toggle="dropdown">-->
            <!--                                    Year From-->
            <!--                            </button>-->
            <!--                            <ul class="overflow-auto dropdown-menu" style="max-height: 300px;" id="yearfromDropdownList">-->
                                            <!-- <li>
            <!--                                    <a class="dropdown-item" href="javascript:void(0)"-->
            <!--                                    onclick="updateDropdownText('Any', 'yearfromDropdown', 'yearfromInput', 'Any')">-->
            <!--                                        Any-->
            <!--                                    </a>-->
            <!--                                </li> -->-->
            <!--                                @foreach($year_counts as $year_range)-->
            <!--                                    <li>-->
            <!--                                        <a class="dropdown-item" href="javascript:void(0)"-->
            <!--                                        onclick="updateDropdownText('{{ $year_range['year'] }}', 'yearfromDropdown', 'yearfromInput', '{{ $year_range['year'] }}')">-->
            <!--                                        {{ $year_range['year'] }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $year_range['count'] }})-->
            <!--                                        </a>-->
            <!--                                    </li>-->
            <!--                                @endforeach-->
            <!--                            </ul>-->
            <!--                        </div>-->
            <!--                        <input type="hidden" name="year_from" id="yearfromInput" value="">-->
            <!--                    </div>-->
                                <!-- Year To Dropdown -->                        
            <!--                    <div class="dropdown_menu_first_col">-->
            <!--                        <div class="pt-1 pb-1 dropdown rounded-3 search_color">-->
            <!--                            <button class="btn search_color dropdown-toggle w-100 d-flex justify-content-between align-items-center"-->
            <!--                                    type="button" id="yeartoDropdown" data-bs-toggle="dropdown">-->
            <!--                                Year To-->
            <!--                            </button>-->
            <!--                            <ul class="overflow-auto dropdown-menu" style="max-height: 300px;" id="yeartoDropdownList">-->
                                        <!-- <li>
            <!--                                    <a class="dropdown-item" href="javascript:void(0)"-->
            <!--                                    onclick="updateDropdownText('Any', 'yeartoDropdown', 'yeartoInput')">-->
            <!--                                        Any-->
            <!--                                    </a>-->
            <!--                                </li> -->-->
            <!--                                @foreach($year_counts as $year_range)-->
            <!--                                    <li>-->
            <!--                                        <a class="dropdown-item" href="javascript:void(0)"-->
            <!--                                        onclick="updateDropdownText('{{ $year_range['year'] }}', 'yeartoDropdown', 'yeartoInput', '{{ $year_range['year'] }}')">-->
            <!--                                        {{ $year_range['year'] }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $year_range['count'] }})-->
            <!--                                        </a>-->
            <!--                                    </li>-->
            <!--                                @endforeach-->
            <!--                            </ul>-->
            <!--                        </div>-->
            <!--                        <input type="hidden" name="year_to" id="yeartoInput" value="">-->
            <!--                    </div>-->
                              
            <!--                </div>-->

                            
                            
                            
            <!--                <div style="display: flex; flex-direction:column; align-items:center; gap:7px;">-->
            <!--                        <button id="searchButton" class="btn btn-dark mt-3" style="width:100%;">Search</button>-->
            <!--                        <a onclick="clearFilters()" class="text-center" style="cursor: pointer; color: #007bff; font-weight: bold; text-decoration: none;">Clear All</a>-->
            <!--                </div>                                -->
            <!--            </div>-->
            <!--    </form>-->
            <!--    </div>-->
            <!--</div>-->
            <!--@endif-->
        </div>
    </div>
    
    <div class="hero-section-mobile" style="width: 100%; height:85vh; overflow:hidden;">
        <div style="height:28vh;">
            <img style="width:100%; height:100%; object-fit:cover; z-index:10;" src="{{ asset('images/page_sections/' . $sections->where('section', 'hero')[0]->value) }}" alt="" onclick="window.open('{{ Str::startsWith($sections->where('section', 'hero')->where('name', 'hero_button_link')->first()->value, ['http://', 'https://']) ? $sections->where('section', 'hero')->where('name', 'hero_button_link')->first()->value : 'https://' . $sections->where('section', 'hero')->where('name', 'hero_button_link')->first()->value }}', '_blank')">            
        </div>
          <div style="background-color:#000; padding:10px 10px; max-height:10vh;">
            <div>
                <div onclick="window.open('{{ Str::startsWith($sections->where('section', 'hero')->where('name', 'hero_button_link')->first()->value, ['http://', 'https://']) ? $sections->where('section', 'hero')->where('name', 'hero_button_link')->first()->value : 'https://' . $sections->where('section', 'hero')->where('name', 'hero_button_link')->first()->value }}', '_blank')">
                    <!--<h1 style="color:white; font-size:20px; margin:0; padding:0;">-->
                    <!--    {{ $sections->where('section', 'hero')[1]->value }}-->
                    <!--</h1>-->
                    <!-- <p style="color:white; font-size:16px; margin:0; padding:0;">
                        {{ $sections->where('section', 'hero')[2]->value }}
                    </p> -->
                </div>
            </div>
        </div>
        <form method="GET" action="{{ route('search_car') }}">
          @csrf
          <div style="background-color: white; margin-right:20px; padding:20px; height:50vh; overflow:hidden; width:100%;">
            <!-- Make & Model Row -->
            <div class="search_box_dropdown_menu">
              <!-- Make Dropdown -->
              <div class="dropdown_menu_first_col">
                <div class="pt-1 pb-1 dropdown rounded-3" style="background-color:#F5F6FA;">
                  <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center" type="button" id="makeDropdown" data-bs-toggle="dropdown">
                    Make
                  </button>
                  <ul class="dropdown-menu scrollable-dropdown">
                    <!-- <li>
                      <a class="dropdown-item" href="javascript:void(0)" onclick="updateDropdownText('Any', 'makeDropdown', 'makeInput')">Any</a>
                    </li> -->
                    @foreach($search_field['make'] as $make)
                    <li>
                      <a class="dropdown-item" href="javascript:void(0)" onclick="updateDropdownText('{{ $make->make }}', 'makeDropdown', 'makeInput')">
                        {{ $make->make }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $make->count }})
                      </a>
                    </li>
                    @endforeach
                  </ul>
                </div>
                <input type="hidden" name="make" id="makeInput" value="">
              </div>

              <!-- Model Dropdown -->
              <div class="dropdown_menu_second_col">
                <div class="pt-1 pb-1 dropdown rounded-3" style="background-color:#F5F6FA;">
                  <button class="btn  dropdown-toggle w-100 d-flex justify-content-between align-items-center text-truncate" type="button" id="modelDropdown" data-bs-toggle="dropdown" disabled>
                    Model
                  </button>
                  <ul class="dropdown-menu scrollable-dropdown " id="modelList">
                    <!-- <li>
                      <a class="dropdown-item" href="javascript:void(0)" onclick="updateDropdownText('Any', 'modelDropdown', 'modelInput')">Any</a>
                    </li> -->
                  </ul>
                </div>
                <input type="hidden" name="model" id="modelInput" value="">
              </div>
            </div>

            <!-- Variant Dropdown -->
            <div class="mb-2">
              <div class="pt-1 pb-1 dropdown rounded-3" style="background-color:#F5F6FA;">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center text-truncate" type="button" id="variantDropdown" data-bs-toggle="dropdown" disabled>
                  Variant
                </button>
                <ul class="dropdown-menu scrollable-dropdown" id="variantList">
                  <!-- <li>
                    <a class="dropdown-item" href="javascript:void(0)" onclick="updateDropdownText('Any', 'variantDropdown', 'variantInput')">Any</a>
                  </li> -->
                </ul>
              </div>
              <input type="hidden" name="variant" id="variantInput" value="">
            </div>

            <!-- Price Row -->
            <div class="search_box_dropdown_menu">
                   <!-- Price From -->
              <div class="dropdown_menu_second_col">
                <div class="pt-1 pb-1 dropdown rounded-3 " style="background-color:#F5F6FA;">
                  <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center" type="button" id="pricefromDropdown" data-bs-toggle="dropdown">
                    Price From
                  </button>
                  <ul class="overflow-auto dropdown-menu" style="max-height: 300px;" id="pricefromDropdownList">
                    <!-- <li>
                      <a class="dropdown-item" href="javascript:void(0)" onclick="updateDropdownText('Any', 'pricefromDropdown', 'pricefromInput', 'Any')">Any</a>
                    </li> -->
                    @foreach($price_counts as $price_range)
                    <li>
                      <a class="dropdown-item" href="javascript:void(0)" onclick="updateDropdownText('{{ $price_range['min'] }}', 'pricefromDropdown', 'pricefromInput', '£{{ number_format($price_range['min']) }}')">
                        £{{ number_format($price_range['min']) }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $price_range['count'] }})
                      </a>
                    </li>
                    @endforeach
                  </ul>
                </div>
                <input type="hidden" name="price_from" id="pricefromInput" value="">
              </div>
              <!-- Price To -->
              <div class="dropdown_menu_first_col">
                <div class="pt-1 pb-1 dropdown rounded-3" style="background-color:#F5F6FA;">
                  <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center" type="button" id="pricetoDropdown" data-bs-toggle="dropdown">
                    Price To
                  </button>
                  <ul class="overflow-auto dropdown-menu" style="max-height: 300px;" id="priceDropdownList">
                    <!-- <li>
                      <a class="dropdown-item" href="javascript:void(0)" onclick="updateDropdownText('Any', 'pricetoDropdown', 'pricetoInput')">Any</a>
                    </li> -->
                    @foreach($price_counts as $price_range)
                    <li>
                      <a class="dropdown-item" href="javascript:void(0)" onclick="updateDropdownText('{{ $price_range['max'] }}', 'pricetoDropdown', 'pricetoInput', '£{{ number_format($price_range['max']) }} ({{ $price_range['count'] }})')">
                        £{{ number_format($price_range['max']) }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $price_range['count'] }})
                      </a>
                    </li>
                    @endforeach
                  </ul>
                </div>
                <input type="hidden" name="price_to" id="pricetoInput" value="">
              </div>

           
            </div>

            <!-- Year Row -->
            <div class="search_box_dropdown_menu">
                 <!-- Year From -->
              <div class="dropdown_menu_second_col">
                <div class="pt-1 pb-1 dropdown rounded-3" style="background-color:#F5F6FA;">
                  <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center" type="button" id="yearfromDropdown" data-bs-toggle="dropdown">
                    Year From
                  </button>
                  <ul class="overflow-auto dropdown-menu" style="max-height: 300px;" id="yearfromDropdownList">
                    <!-- <li>
                      <a class="dropdown-item" href="javascript:void(0)" onclick="updateDropdownText('Any', 'yearfromDropdown', 'yearfromInput', 'Any')">Any</a>
                    </li> -->
                    @foreach(array_reverse($year_counts) as $year_range)
                    <li>
                      <a class="dropdown-item" href="javascript:void(0)" onclick="updateDropdownText('{{ $year_range['year'] }}', 'yearfromDropdown', 'yearfromInput', '{{ $year_range['year'] }}')">
                        {{ $year_range['year'] }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $year_range['count'] }})
                      </a>
                    </li>
                    @endforeach
                  </ul>
                </div>
                <input type="hidden" name="year_from" id="yearfromInput" value="">
              </div>
              <!-- Year To -->
              <div class="dropdown_menu_first_col">
                <div class="pt-1 pb-1 dropdown rounded-3" style="background-color:#F5F6FA;">
                  <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center" type="button" id="yeartoDropdown" data-bs-toggle="dropdown">
                    Year To
                  </button>
                  <ul class="overflow-auto dropdown-menu" style="max-height: 300px;" id="yeartoDropdownList">
                    <!-- <li>
                      <a class="dropdown-item" href="javascript:void(0)" onclick="updateDropdownText('Any', 'yeartoDropdown', 'yeartoInput')">Any</a>
                    </li> -->
                    @foreach(array_reverse($year_counts) as $year_range)
                    <li>
                      <a class="dropdown-item" href="javascript:void(0)" onclick="updateDropdownText('{{ $year_range['year'] }}', 'yeartoDropdown', 'yeartoInput', '{{ $year_range['year'] }}')">
                        {{ $year_range['year'] }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $year_range['count'] }})
                      </a>
                    </li>
                    @endforeach
                  </ul>
                </div>
                <input type="hidden" name="year_to" id="yeartoInput" value="">
              </div>

             
            </div>

            <!-- Search + Clear All -->
            <div style="display: flex; flex-direction: column; align-items: center; gap: 7px;">
              <button id="searchButton" class="btn btn-dark search-btn mt-3" style="width: 100%;padding: 0.57rem;">Search</button>
              <!--<a onclick="clearFilters()" class="text-center" style="cursor: pointer; color: #007bff; font-weight: bold; text-decoration: none;">Clear All</a>-->
              <a onclick="clearFilters()" class="clear-all-link">Clear all</a>
            </div>
          </div>
        </form>
      
    </div>    
 
 
    <!-- the bellow is for mobile only external model -->
 
 
 <div id="customSelectModal" class="custom-select-modal">
    <div class="custom-select-content">
       
        <ul id="customSelectList" class="custom-select-list"></ul>
    </div>
</div>

<script>
function isMobile() {
    return window.innerWidth <= 768;
}

document.addEventListener('DOMContentLoaded', function () {
    if (isMobile()) {
        const heroForm = document.querySelector('.hero-section-mobile form');
        if (heroForm) {
            const dropdownButtons = heroForm.querySelectorAll('.dropdown-toggle');

            dropdownButtons.forEach(button => {
                button.removeAttribute('data-bs-toggle');

                button.addEventListener('click', function (event) {
                    event.preventDefault();

                    if (this.disabled) return;

                    const dropdownItems = this.nextElementSibling?.querySelectorAll('.dropdown-item');
                    if (dropdownItems && dropdownItems.length) {
                        openCustomSelectModal(dropdownItems);
                    }
                });
            });
        }

        // Add backdrop click handler to close modal
        const customSelectModal = document.getElementById('customSelectModal');
        if (customSelectModal) {
            customSelectModal.addEventListener('click', function (event) {
                if (event.target === customSelectModal) {
                    closeCustomSelectModal();
                }
            });

            // Listen for the popstate event to handle back button
            window.addEventListener('popstate', function (event) {
                if (customSelectModal.style.display === 'flex') {
                    closeCustomSelectModal();
                }
            });
        }
    }
});

function openCustomSelectModal(dropdownItems) {
    const customSelectModal = document.getElementById('customSelectModal');
    const customSelectList = document.getElementById('customSelectList');
    customSelectList.innerHTML = '';

    dropdownItems.forEach(item => {
        const li = document.createElement('li');
        li.innerHTML = item.innerHTML;
        li.addEventListener('click', function () {
            item.click();
            closeCustomSelectModal();
        });
        customSelectList.appendChild(li);
    });

    customSelectModal.style.display = 'flex';
    document.body.classList.add('no-scroll');

    // Push a new state when the modal opens
    history.pushState({ modalOpen: true }, '');
}

function closeCustomSelectModal() {
    const customSelectModal = document.getElementById('customSelectModal');
    customSelectModal.style.display = 'none';
    document.body.classList.remove('no-scroll');

    // Check if the current state indicates the modal was open before closing
    // This prevents going back an extra step if the user closes the modal
    // via another method (e.g., clicking the backdrop)
    if (history.state && history.state.modalOpen) {
        history.back(); // Go back to the previous state (before modal opened)
    }
}
</script>


        <script>
            // const modal = document.getElementById("searchModal");
            // const btn = document.querySelector(".form-search-button button");
            // const span = document.querySelector(".close");            
            // btn.addEventListener("click", function() {
            //     // modal.style.display = "block";
            //     modal.style.display = "flex";
            //     modal.style.justifycontent = "center";
            //     modal.style.alignitems = "center";
            // });
            // span.addEventListener("click", function() {
            //     modal.style.display = "none";
            // });
            // window.addEventListener("click", function(event) {
            //     if (event.target === modal) {
            //         modal.style.display = "none";
            //     }
            // });
            const modal = document.getElementById("searchModal");
            const btn = document.querySelector(".form-search-button button");
            const span = document.querySelector(".close");            
            btn.addEventListener("click", function() {
                // modal.style.display = "block";
                modal.style.display = "flex";
                modal.style.justifycontent = "center";
                modal.style.alignitems = "center";
                handleModalOpen("searchModal"); // Track open
            });
            span.addEventListener("click", function() {
                modal.style.display = "none";
                handleModalClose("searchModal"); 
            });
            window.addEventListener("click", function(event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                    handleModalClose("searchModal"); 
                }
            });
        </script>


          
                

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

                                        <!-- <div class="text-center">  
                                            <svg width="32" height="27" viewBox="0 0 32 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M32 15.8934C32 19.52 30.9333 22.7556 28.8 25.6C28.5867 25.8845 28.3022 26.0445 27.9467 26.08C27.5911 26.1156 27.2711 26.0267 26.9867 25.8134C26.7022 25.6 26.5422 25.3334 26.5067 25.0134C26.4711 24.6934 26.56 24.3911 26.7733 24.1067C28.6222 21.6889 29.5467 18.9511 29.5467 15.8934C29.5467 13.4756 28.9422 11.2356 27.7333 9.17336C26.5244 7.11114 24.8711 5.47558 22.7733 4.2667C20.6756 3.05781 18.4178 2.45336 16 2.45336C13.5822 2.45336 11.3244 3.05781 9.22667 4.2667C7.12889 5.47558 5.47556 7.11114 4.26667 9.17336C3.05778 11.2356 2.45333 13.4756 2.45333 15.8934C2.45333 18.9511 3.37778 21.6889 5.22667 24.1067C5.44 24.3911 5.52889 24.6934 5.49333 25.0134C5.45778 25.3334 5.29778 25.6 5.01333 25.8134C4.72889 26.0267 4.40889 26.1156 4.05333 26.08C3.69778 26.0445 3.41333 25.8845 3.2 25.6C1.06667 22.7556 0 19.52 0 15.8934C0 13.0489 0.711111 10.4 2.13333 7.9467C3.55556 5.49336 5.49333 3.55558 7.94667 2.13336C10.4 0.71114 13.0844 2.86102e-05 16 2.86102e-05C18.9156 2.86102e-05 21.6 0.71114 24.0533 2.13336C26.5067 3.55558 28.4444 5.49336 29.8667 7.9467C31.2889 10.4 32 13.0489 32 15.8934ZM23.8933 8.42669C24.1778 8.64003 24.32 8.92447 24.32 9.28003C24.32 9.63558 24.1778 9.92003 23.8933 10.1334L19.84 14.2934C20.1956 14.9334 20.3733 15.6089 20.3733 16.32C20.3733 17.5289 19.9467 18.56 19.0933 19.4134C18.24 20.2667 17.2089 20.6934 16 20.6934C14.7911 20.6934 13.76 20.2667 12.9067 19.4134C12.0533 18.56 11.6267 17.5289 11.6267 16.32C11.6267 15.1111 12.0533 14.08 12.9067 13.2267C13.76 12.3734 14.7911 11.9467 16 11.9467C16.7111 11.9467 17.3867 12.1245 18.0267 12.48L22.1867 8.42669C22.4 8.14225 22.6844 8.00003 23.04 8.00003C23.3956 8.00003 23.68 8.14225 23.8933 8.42669ZM17.92 16.32C17.92 15.8223 17.7244 15.3956 17.3333 15.04C16.9422 14.6845 16.4978 14.5067 16 14.5067C15.5022 14.5067 15.0578 14.6845 14.6667 15.04C14.2756 15.3956 14.08 15.8223 14.08 16.32C14.08 16.8178 14.2756 17.2622 14.6667 17.6534C15.0578 18.0445 15.5022 18.24 16 18.24C16.4978 18.24 16.9422 18.0445 17.3333 17.6534C17.7244 17.2622 17.92 16.8178 17.92 16.32Z" fill="#1D1F2C"/>
                                            </svg>
                                            <p class="car_detail_type_text">
                                                {{ e(isset($car_data['miles']) ? number_format($car_data['miles'], 0, '.', ',') : 'N/A') }}
                                            </p>
                                        </div>
                                        <div class="text-center">
                                            <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18.0267 5.97333C18.0267 5.68889 17.9378 5.45778 17.76 5.28C17.5822 5.10222 17.3511 5.01333 17.0667 5.01333H7.04C6.75556 5.01333 6.52444 5.10222 6.34667 5.28C6.16889 5.45778 6.08 5.68889 6.08 5.97333V13.9733C6.08 14.2578 6.16889 14.5067 6.34667 14.72C6.52444 14.9333 6.75556 15.04 7.04 15.04H17.0667C17.3511 15.04 17.5822 14.9333 17.76 14.72C17.9378 14.5067 18.0267 14.2578 18.0267 13.9733V5.97333ZM16 13.0133H8V7.04H16V13.0133ZM29.5467 7.04L25.4933 5.12C25.28 4.97778 25.0311 4.94222 24.7467 5.01333C24.4622 5.08444 24.2667 5.24444 24.16 5.49333C24.0533 5.74222 24.0356 6.00889 24.1067 6.29333C24.1778 6.57778 24.3556 6.75555 24.64 6.82667L26.1333 7.68L26.0267 8C26.0267 8.64 26.2222 9.20889 26.6133 9.70667C27.0044 10.2044 27.4844 10.56 28.0533 10.7733V22.9333C28.0533 23.2178 27.9467 23.4667 27.7333 23.68C27.52 23.8933 27.2889 24 27.04 24C26.7911 24 26.56 23.8933 26.3467 23.68C26.1333 23.4667 26.0267 23.2178 26.0267 22.9333V14.9333C26.0267 13.7956 25.6178 12.7644 24.8 11.84C23.9822 10.9156 23.0756 10.3467 22.08 10.1333V3.94667C22.08 2.88 21.6889 1.95555 20.9067 1.17333C20.1244 0.391109 19.2 0 18.1333 0H6.08C5.01333 0 4.07111 0.391109 3.25333 1.17333C2.43556 1.95555 2.02667 2.88 2.02667 3.94667V26.3467L0.64 27.0933C0.213333 27.3067 0 27.5911 0 27.9467V30.9333C0 31.2178 0.106667 31.4667 0.32 31.68C0.533333 31.8933 0.782222 32 1.06667 32H23.04C23.3244 32 23.5556 31.8933 23.7333 31.68C23.9111 31.4667 24 31.2178 24 30.9333V27.9467C24 27.5911 23.8222 27.3067 23.4667 27.0933L22.08 26.3467V12.16C22.5778 12.3733 23.0222 12.7467 23.4133 13.28C23.8044 13.8133 24 14.3644 24 14.9333V22.9333C24 23.7867 24.3022 24.5156 24.9067 25.12C25.5111 25.7244 26.2222 26.0267 27.04 26.0267C27.8578 26.0267 28.5689 25.7244 29.1733 25.12C29.7778 24.5156 30.08 23.7867 30.08 22.9333V8C30.08 7.57333 29.9022 7.25333 29.5467 7.04ZM22.08 29.9733H2.02667V28.5867L3.52 27.84C3.87556 27.6978 4.05333 27.4133 4.05333 26.9867V3.94667C4.05333 3.44889 4.24889 3.00444 4.64 2.61333C5.03111 2.22222 5.51111 2.02667 6.08 2.02667H18.1333C18.6311 2.02667 19.0756 2.22222 19.4667 2.61333C19.8578 3.00444 20.0533 3.44889 20.0533 3.94667V26.9867C20.0533 27.4133 20.2311 27.6978 20.5867 27.84L22.08 28.5867V29.9733Z" fill="#1D1F2C"/>
                                            </svg>
                                            <p class="car_detail_type_text">
                                                {{ e($car_data['fuel_type'] ?? 'N/A') }}
                                            </p>
                                        </div>
                                        <div class="text-center">
                                            <svg width="29" height="27" viewBox="0 0 29 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3.62667 -5.14984e-05C2.63111 -5.14984e-05 1.77778 0.355503 1.06667 1.06661C0.355556 1.77773 0 2.64884 0 3.67995C0 4.71106 0.355556 5.58217 1.06667 6.29328C1.77778 7.00439 2.63111 7.35995 3.62667 7.35995C4.62222 7.35995 5.47556 7.00439 6.18667 6.29328C6.89778 5.58217 7.25333 4.71106 7.25333 3.67995C7.25333 2.64884 6.89778 1.77773 6.18667 1.06661C5.47556 0.355503 4.62222 -5.14984e-05 3.62667 -5.14984e-05ZM3.62667 2.02661C4.05333 2.02661 4.44444 2.18661 4.8 2.50661C5.15556 2.82661 5.33333 3.21773 5.33333 3.67995C5.33333 4.14217 5.15556 4.53328 4.8 4.85328C4.44444 5.17328 4.05333 5.33328 3.62667 5.33328C3.2 5.33328 2.80889 5.17328 2.45333 4.85328C2.09778 4.53328 1.92 4.14217 1.92 3.67995C1.92 3.21773 2.09778 2.82661 2.45333 2.50661C2.80889 2.18661 3.2 2.02661 3.62667 2.02661ZM3.62667 18.6666C2.63111 18.6666 1.77778 19.0222 1.06667 19.7333C0.355556 20.4444 0 21.3155 0 22.3466C0 23.3777 0.355556 24.2488 1.06667 24.9599C1.77778 25.6711 2.63111 26.0266 3.62667 26.0266C4.62222 26.0266 5.47556 25.6711 6.18667 24.9599C6.89778 24.2488 7.25333 23.3777 7.25333 22.3466C7.25333 21.3155 6.89778 20.4444 6.18667 19.7333C5.47556 19.0222 4.62222 18.6666 3.62667 18.6666ZM3.62667 20.6933C4.05333 20.6933 4.44444 20.8533 4.8 21.1733C5.15556 21.4933 5.33333 21.8844 5.33333 22.3466C5.33333 22.8088 5.15556 23.1999 4.8 23.5199C4.44444 23.8399 4.05333 23.9999 3.62667 23.9999C3.2 23.9999 2.80889 23.8399 2.45333 23.5199C2.09778 23.1999 1.92 22.8088 1.92 22.3466C1.92 21.8844 2.09778 21.4933 2.45333 21.1733C2.80889 20.8533 3.2 20.6933 3.62667 20.6933ZM14.2933 -5.14984e-05C13.2978 -5.14984e-05 12.4444 0.355503 11.7333 1.06661C11.0222 1.77773 10.6667 2.64884 10.6667 3.67995C10.6667 4.71106 11.0222 5.58217 11.7333 6.29328C12.4444 7.00439 13.2978 7.35995 14.2933 7.35995C15.2889 7.35995 16.1422 7.00439 16.8533 6.29328C17.5644 5.58217 17.92 4.71106 17.92 3.67995C17.92 2.64884 17.5644 1.77773 16.8533 1.06661C16.1422 0.355503 15.2889 -5.14984e-05 14.2933 -5.14984e-05ZM14.2933 2.02661C14.72 2.02661 15.1111 2.18661 15.4667 2.50661C15.8222 2.82661 16 3.21773 16 3.67995C16 4.14217 15.8222 4.53328 15.4667 4.85328C15.1111 5.17328 14.72 5.33328 14.2933 5.33328C13.8667 5.33328 13.4756 5.17328 13.12 4.85328C12.7644 4.53328 12.5867 4.14217 12.5867 3.67995C12.5867 3.21773 12.7644 2.82661 13.12 2.50661C13.4756 2.18661 13.8667 2.02661 14.2933 2.02661ZM14.2933 18.6666C13.2978 18.6666 12.4444 19.0222 11.7333 19.7333C11.0222 20.4444 10.6667 21.3155 10.6667 22.3466C10.6667 23.3777 11.0222 24.2488 11.7333 24.9599C12.4444 25.6711 13.2978 26.0266 14.2933 26.0266C15.2889 26.0266 16.1422 25.6711 16.8533 24.9599C17.5644 24.2488 17.92 23.3777 17.92 22.3466C17.92 21.3155 17.5644 20.4444 16.8533 19.7333C16.1422 19.0222 15.2889 18.6666 14.2933 18.6666ZM14.2933 20.6933C14.72 20.6933 15.1111 20.8533 15.4667 21.1733C15.8222 21.4933 16 21.8844 16 22.3466C16 22.8088 15.8222 23.1999 15.4667 23.5199C15.1111 23.8399 14.72 23.9999 14.2933 23.9999C13.8667 23.9999 13.4756 23.8399 13.12 23.5199C12.7644 23.1999 12.5867 22.8088 12.5867 22.3466C12.5867 21.8844 12.7644 21.4933 13.12 21.1733C13.4756 20.8533 13.8667 20.6933 14.2933 20.6933ZM24.96 -5.14984e-05C23.9644 -5.14984e-05 23.1111 0.355503 22.4 1.06661C21.6889 1.77773 21.3333 2.64884 21.3333 3.67995C21.3333 4.71106 21.6889 5.58217 22.4 6.29328C23.1111 7.00439 23.9644 7.35995 24.96 7.35995C25.9556 7.35995 26.8089 7.00439 27.52 6.29328C28.2311 5.58217 28.5867 4.71106 28.5867 3.67995C28.5867 2.64884 28.2311 1.77773 27.52 1.06661C26.8089 0.355503 25.9556 -5.14984e-05 24.96 -5.14984e-05ZM24.96 2.02661C25.3867 2.02661 25.7778 2.18661 26.1333 2.50661C26.4889 2.82661 26.6667 3.21773 26.6667 3.67995C26.6667 4.14217 26.4889 4.53328 26.1333 4.85328C25.7778 5.17328 25.3867 5.33328 24.96 5.33328C24.5333 5.33328 24.1422 5.17328 23.7867 4.85328C23.4311 4.53328 23.2533 4.14217 23.2533 3.67995C23.2533 3.21773 23.4311 2.82661 23.7867 2.50661C24.1422 2.18661 24.5333 2.02661 24.96 2.02661ZM24.96 18.6666C23.9644 18.6666 23.1111 19.0222 22.4 19.7333C21.6889 20.4444 21.3333 21.3155 21.3333 22.3466C21.3333 23.3777 21.6889 24.2488 22.4 24.9599C23.1111 25.6711 23.9644 26.0266 24.96 26.0266C25.9556 26.0266 26.8089 25.6711 27.52 24.9599C28.2311 24.2488 28.5867 23.3777 28.5867 22.3466C28.5867 21.3155 28.2311 20.4444 27.52 19.7333C26.8089 19.0222 25.9556 18.6666 24.96 18.6666ZM24.96 20.6933C25.3867 20.6933 25.7778 20.8533 26.1333 21.1733C26.4889 21.4933 26.6667 21.8844 26.6667 22.3466C26.6667 22.8088 26.4889 23.1999 26.1333 23.5199C25.7778 23.8399 25.3867 23.9999 24.96 23.9999C24.5333 23.9999 24.1422 23.8399 23.7867 23.5199C23.4311 23.1999 23.2533 22.8088 23.2533 22.3466C23.2533 21.8844 23.4311 21.4933 23.7867 21.1733C24.1422 20.8533 24.5333 20.6933 24.96 20.6933ZM2.66667 6.29328V19.6266C2.66667 19.9111 2.75556 20.1599 2.93333 20.3733C3.11111 20.5866 3.34222 20.6933 3.62667 20.6933C3.91111 20.6933 4.14222 20.5866 4.32 20.3733C4.49778 20.1599 4.58667 19.9466 4.58667 19.7333V6.29328C4.58667 6.07995 4.49778 5.86661 4.32 5.65328C4.14222 5.43995 3.91111 5.33328 3.62667 5.33328C3.34222 5.33328 3.11111 5.43995 2.93333 5.65328C2.75556 5.86661 2.66667 6.07995 2.66667 6.29328ZM13.3333 6.29328V19.6266C13.3333 19.9111 13.4222 20.1599 13.6 20.3733C13.7778 20.5866 14.0089 20.6933 14.2933 20.6933C14.5778 20.6933 14.8089 20.5866 14.9867 20.3733C15.1644 20.1599 15.2533 19.9466 15.2533 19.7333V6.29328C15.2533 6.07995 15.1644 5.86661 14.9867 5.65328C14.8089 5.43995 14.5778 5.33328 14.2933 5.33328C14.0089 5.33328 13.7778 5.43995 13.6 5.65328C13.4222 5.86661 13.3333 6.07995 13.3333 6.29328ZM24 6.29328V11.6266C24 11.7688 23.9644 11.8755 23.8933 11.9466C23.8222 12.0177 23.7511 12.0533 23.68 12.0533H3.62667C3.34222 12.0533 3.11111 12.1422 2.93333 12.3199C2.75556 12.4977 2.66667 12.7288 2.66667 13.0133C2.66667 13.2977 2.75556 13.5288 2.93333 13.7066C3.11111 13.8844 3.34222 13.9733 3.62667 13.9733H23.68C24.32 13.9733 24.8533 13.7599 25.28 13.3333C25.7067 12.9066 25.92 12.3377 25.92 11.6266V6.39995C25.92 6.1155 25.8311 5.86661 25.6533 5.65328C25.4756 5.43995 25.2444 5.33328 24.96 5.33328C24.6756 5.33328 24.4444 5.43995 24.2667 5.65328C24.0889 5.86661 24 6.07995 24 6.29328Z" fill="#1D1F2C"/>
                                            </svg>
                                            <p class="car_detail_type_text">
                                                {{ e($car_data['gear_box'] ?? 'N/A') }}
                                            </p>
                                        </div> -->
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
    
    
<!-- Recently Added Section -->
    
@if(false)
<section class="text-center" style="">
    <h4 style="font-size: 30px; margin-top: 0px; margin-bottom: 0px; padding: 0;">Recently Added</h4>
    <div class="container">
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
                            
                                        <img src="{{ asset('' . e($car_data['image'])) }}" 
                                            alt="Car Image"
                                            onload="this.naturalWidth > this.naturalHeight ? this.style.objectFit = 'cover' : this.style.objectFit = 'contain'"
                                            onerror="this.src='{{ asset('assets/coming_soon.png') }}'" 
                                            class="car_card_front_img">
                                    </div>
                             
                                </div>
                            </div>
                            <div class="p-3">
                                <p class="car_tittle text-truncate">{{ e($car_data['make'] ?? 'Unknown make') }}
                                    {{ e($car_data['model'] ?? 'N/A') }} {{ e($car_data['year'] ?? 'N/A') }}</p>
                                    <p class="car_varient text-truncate">
                                    @if(empty($car_data['Trim']) || $car_data['Trim'] == 'N/A')
                                         {{ strtoupper($car_data['advert_variant']) }}
                                    @else
                                        {{ strtoupper(e($car_data['Trim'])) }}
                                    @endif
                                    </p>

                                <div class="car_detail">
                                    <div class="text-center">                                        
                                        <div class="car_detail_type">
                                         
                                            <p class="car_detail_type_text">
                                                {{ e(isset($car_data['miles']) ? number_format($car_data['miles'], 0, '.', ',') : 'N/A') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <div class="car_detail_type">
                                         
                                            <p class="car_detail_type_text">{{ e($car_data['fuel_type'] ?? 'N/A') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <div class="car_detail_type">
                                           
                                            <p class="car_detail_type_text">{{ e($car_data['gear_box'] ?? 'N/A') }}</p>
                                        </div>
                                    </div>
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
        @else
            <p class="text-center">No cars available at the moment.</p>
        @endif
    </div>
    </div>
</section>
@endif







    <!-- Buying Essentails Section -->
    <!-- <section class="text-center buyingessentials third_container" style="margin-top:0px;">
        <h4 style="font-size: 30px; margin-top: 10px; margin-bottom: 10px;">Buying Essentials</h4>
        <div class="container">
            <div class="row">
                <div class="my-3 col-lg-3 col-md-4 col-sm-12 clickable-image" data-link="{{ $sections->where('name', 'card_link_1')->first()->value }}">
                    <div class="essential-card">
                        <div class="d-flex flex-column align-items-center">
                            <div class="icon-container">
                                <div class="icon-container-inner" style="background-image: url('{{ asset('images/page_sections/' . $sections->where('name', 'card_image_1')->first()->value) }}');">
                                </div>
                            </div>

                            <p class="primary-text">{{$sections->where('name', 'card_title_text_1')->first()->value }}</p>
                            <p class="secondary-text">{{$sections->where('name', 'card_desc_text_1')->first()->value }}</p>
                        </div>
                    </div>
                </div>
                <div class="my-3 col-lg-3 col-md-4 col-sm-12 clickable-image" data-link="{{ $sections->where('name', 'card_link_2')->first()->value }}">
                    <div class="essential-card">
                        <div class="d-flex flex-column align-items-center">
                            <div class="icon-container">
                                <div class="icon-container-inner" style="background-image: url('{{ asset('images/page_sections/' . $sections->where('name', 'card_image_2')->first()->value) }}');">
                                </div>
                            </div>

                            <p class="primary-text">{{$sections->where('name', 'card_title_text_2')->first()->value }}</p>
                            <p class="secondary-text">{{$sections->where('name', 'card_desc_text_2')->first()->value }}</p>
                        </div>
                    </div>
                </div>
                <div class="my-3 col-lg-3 col-md-4 col-sm-12 clickable-image" data-link="{{ $sections->where('name', 'card_link_3')->first()->value }}">
                    <div class="essential-card">
                        <div class="d-flex flex-column align-items-center">
                            <div class="icon-container">
                                <div class="icon-container-inner" style="background-image: url('{{ asset('images/page_sections/' . $sections->where('name', 'card_image_3')->first()->value) }}');">
                                </div>
                            </div>

                            <p class="primary-text">{{$sections->where('name', 'card_title_text_3')->first()->value }}</p>
                            <p class="secondary-text">{{$sections->where('name', 'card_desc_text_3')->first()->value }}</p>
                        </div>
                    </div>
                </div>
                    <div class="my-3 col-lg-3 col-md-4 col-sm-12 clickable-image" data-link="{{ $sections->where('name', 'card_link_1')->first()->value }}">
                        <div class="essential-card">
                            <div class="d-flex flex-column align-items-center">
                                <div class="icon-container">
                                    <div class="icon-container-inner" style="background-image: url('{{ asset('images/page_sections/' . $sections->where('name', 'card_image_4')->first()->value) }}');">
                                    </div>
                                </div>

                                <p class="primary-text">{{$sections->where('name', 'card_title_text_4')->first()->value }}</p>
                                <p class="secondary-text">{{$sections->where('name', 'card_desc_text_4')->first()->value }}</p>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </section> -->
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
    

    // function generateCarCard(car) {
    //     return `
    //         <div class="my-3">
    //             <a href="/car-for-sale/${car.car_slug}" class="text-decoration-none text-dark">
    //                 <div class="main_car_card">
    //                     <div>
    //                         <div class="car_card_main_img">
    //                             ${car.image ?
    //                                 `<div class="car_card_inner_img">
    //                                     <div class="car_card_background_img" style="background-image: url('${car.image}');"></div>
    //                                     <img src="${car.image}"
    //                                         alt="Car Image"
    //                                         onload="this.naturalWidth > this.naturalHeight ? this.style.objectFit = 'cover' : this.style.objectFit = 'contain'"
    //                                         onerror="this.src='{{ asset('assets/coming_soon.png') }}'" 
    //                                         class="car_card_front_img">
    //                                 </div>` :
    //                                 `<img src="/assets/images/default-car.png"
    //                                     alt="Default Car Image"
    //                                     class="default_car_img">`
    //                             }
    //                         </div>
    //                     </div>
    //                     <div class="p-3">
    //                         <p class="car_tittle text-truncate">${car.make || 'Unknown make'} ${car.model || 'N/A'} ${car.year || 'N/A'}</p>
    //                         <p class="car_varient text-truncate">
    //                             ${car.Trim ? car.Trim.substring(0, 31) + (car.Trim.length > 31 ? "..." : "") : "Unknown Trim"}
    //                         </p>

    //                         <div class="car_detail">
    //                             <div class="text-center">
    //                                 <div class="car_detail_type">                                        
    //                                     <p class="car_detail_type_text">${car.miles ? car.miles.toLocaleString() : 'N/A'}</p>
    //                                 </div>
    //                             </div>
    //                             <div class="text-center">
    //                                 <div class="car_detail_type">                                        
    //                                     <p class="car_detail_type_text">${car.fuel_type || 'N/A'}</p>
    //                                 </div>
    //                             </div>
    //                             <div class="text-center">
    //                                 <div class="car_detail_type">                                        
    //                                     <p class="car_detail_type_text">${car.gear_box || 'N/A'}</p>
    //                                 </div>
    //                             </div>
    //                         </div>
                            
    //                         <div class="height"></div>
    //                         <div class="car_detail_bottom">
    //                             <p class="car_price">
    //                                 ${car.price > 0 ? '£' + Number(car.price).toLocaleString('en-GB', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) : 'POA'}
    //                             </p>
    //                             <p class="car_location">
    //                                 ${car.location || 'N/A'}
    //                             </p>
    //                         </div>
    //                     </div>
    //                 </div>
    //             </a>
    //         </div>
    //     `;
    // }
        // !important note : 2nd row of car_detail_type 
                            // <div class="space"></div>
                            // <div class="row g-0">
                            //     <div class="text-center col-4">
                            //         <div class="d-flex align-items-start justify-content-start">
                            //             <img src="/assets/icons/avrg.svg" alt="Average Icon" width="16" height="16">
                            //             <p class="specs ms-2">${car.engine_size || 'N/A'}</p>
                            //         </div>
                            //     </div>
                            //     <div class="text-center col-4">
                            //         <div class="d-flex align-items-start justify-content-start">
                            //             <img src="/assets/icons/auction.svg" alt="Auction Icon" width="16" height="16">
                            //             <p class="specs ms-2">
                            //             ${car.seller_type === 'Private' ? 'Private' : (car.seller_type === 'Dealer' ? 'Dealer' : 'Auction')}
                                        
                            //             </p>
                            //         </div>
                            //     </div>
                            //     <div class="text-center col-4">
                            //         <div class="d-flex align-items-start justify-content-start">
                            //             <img src="/assets/icons/person.svg" alt="Location Icon" width="16" height="16">
                            //             <p class="specs ms-2">${car.location || 'N/A'}</p>
                            //         </div>
                            //     </div>
                            // </div>
   
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







    <!-------------sixth page content-------------------->
    <!-- <section class="d-none d-md-block">
        <div class="sixth_container" style="
        position: relative;
        padding-bottom: 40px;
        overflow: hidden;
        margin-top:70px;
        ">
        <div style="
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            z-index: 1;">
        </div>
        

        <div style="position: relative; z-index: 2;">
    <h4 class="mb-2 text-center" style="font-size: 30px; margin-top: 10px; margin-bottom: 10px;">Latest Forum Posts</h4>
    <div class="gap-3 row d-flex gap-lg-4 justify-content-center" style="width: calc(100% - 100px); margin: auto 50px;">
        @foreach($forum_posts as $forum_post)
            <div class="text-black col-12 col-md-6 col-lg-3 m-lg-1 card sixth_card p-0" style="overflow: hidden; border: none; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 8px; width: 320px;">
                <div class="card-body clickable-image p-0" onclick="window.location.href='{{ route('forum.topic.show', $forum_post->slug) }}'">
                    @if($forum_post->forumTopicCategory && $forum_post->forumTopicCategory->image)
                        <div class="image-container" style="position: relative; width: 100%; height: 200px; overflow: hidden;">
                            <img src="{{ asset('' . $forum_post->forumTopicCategory->image) }}" alt="Category Image" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover; image-rendering: crisp-edges;">
                            <h5 class="sixth_h5" style="position: absolute; bottom: 3px; left: 10px; color: white; padding: 5px 5px; font-size: 25px; font-weight:500;">
                                {{ $forum_post->forumTopicCategory ? $forum_post->forumTopicCategory->category : 'No title available' }}
                            </h5>
                        </div>
                    @endif

                  
                    <h5 class="pb-2 card-title ps-3" style="font-size: 20px; font-weight:500; padding-top: 20px;">
                        {{ substr($forum_post->topic, 0, 100) }}
                    </h5>

               
                    <div class="d-flex align-items-center gap-3 card-subtitle text-muted ps-3 m-0" style="padding-top: 0;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar-alt calendar_icon" style="color: #000;"></i>
                            <p class="sixth_date ms-2 mb-0">{{ \Carbon\Carbon::parse($forum_post->created_at)->format('M d, Y') }}</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock calendar_icon" style="color: #000;"></i>
                            <p class="sixth_date ms-2 mb-0">{{ \Carbon\Carbon::parse($forum_post->created_at)->format('h:i a') }}</p>
                        </div>
                    </div>

                    @php
                        $topiccontent = html_entity_decode($forum_post->content);
                        $topiccontent = strip_tags($topiccontent);
                    @endphp
                    <p class="card-text ps-3 pb-1" style="padding-top: 0;">
                        {{ strlen($topiccontent) > 191 ? substr($topiccontent, 0, 190) . '...' : $topiccontent }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>




    </div>
</section> -->

<!-- below sectioon is for mobile  -->
    <!-- <section class="d-block d-md-none">
    <div class="mobile_container" style="
        position: relative;
        padding-bottom: 40px;
        padding-left: 30px;
        padding-right: 30px;
        overflow: hidden;
        margin-top: 30px;
        width: 100%;">
        
        <div style="position: relative; z-index: 2; width: 100%;">
            <h4 class="mb-2 text-center" style="font-size: 30px; margin-top: 10px; margin-bottom: 10px;">Latest Forum Posts</h4>
            <div class="row d-flex justify-content-center" style="width: 100%; margin: 0;">
                @foreach($forum_posts->take(3) as $forum_post)
                    <div class="col-12 card mobile_card p-0 mb-3" style="overflow: hidden; border: none; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 8px; width: 100%;">
                        <div class="card-body clickable-image p-0" onclick="window.location.href='{{ route('forum.topic.show', $forum_post->slug) }}'">
                            @if($forum_post->forumTopicCategory && $forum_post->forumTopicCategory->image)
                                <div class="image-container" style="position: relative; width: 100%; height: 200px; overflow: hidden;">
                                    <img src="{{ asset('' . $forum_post->forumTopicCategory->image) }}" alt="Category Image" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                                    <h5 class="mobile_h5" style="position: absolute; bottom: 5px; left: 10px; color: white; padding: 5px; font-size: 20px; font-weight:500;">
                                        {{ $forum_post->forumTopicCategory ? $forum_post->forumTopicCategory->category : 'No title available' }}
                                    </h5>
                                </div>
                            @endif

                            <h5 class="pb-2 card-title ps-3" style="font-size: 18px; font-weight:500; padding-top: 15px;">
                                {{ substr($forum_post->topic, 0, 100) }}
                            </h5>

                            <div class="d-flex align-items-center gap-2 card-subtitle text-muted ps-3 m-0">
                                <i class="fas fa-calendar-alt" style="color: #000;"></i>
                                <p class="mobile_date ms-1 mb-0">{{ \Carbon\Carbon::parse($forum_post->created_at)->format('M d, Y') }}</p>
                                <i class="fas fa-clock" style="color: #000;"></i>
                                <p class="mobile_date ms-1 mb-0">{{ \Carbon\Carbon::parse($forum_post->created_at)->format('h:i a') }}</p>
                            </div>

                            @php
                                $topiccontent = html_entity_decode($forum_post->content);
                                $topiccontent = strip_tags($topiccontent);
                            @endphp
                            <p class="card-text ps-3 pb-1" style="padding-top: 0;">
                                {{ strlen($topiccontent) > 108 ? substr($topiccontent, 0, 108) . '...' : $topiccontent }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section> -->


    <!-- <div class="seventh_container ms-0 ms-lg-5 d-none d-lg-block">
        <div class="p-5 row" style="margin-bottom:40px; padding-top: 0 !important;" >
            <div class="col-12 col-lg-6 ps-lg-5 img_div">
                <div class="row img-div-seventh_container">
                    <div class="col-12 img-1" style="background-image: url('{{ asset('images/page_sections/' . $sections->where('section', 'finance')[3]->value) }}'); background-size: cover; background-position: center;">
                    </div>
                  
                </div>
            </div>
            <div class="gap-1 mt-5 col-12 col-lg-6 d-flex flex-column gap-lg-2 align-items-center text-left">
                <h4 style="font-size: 30px;">
                    {{ $sections->where('section', 'finance')[5]->value }}
                </h4>
                <p>
                    {{ $sections->where('section', 'finance')[6]->value }}
                </p>
                <a href="{{ $sections->where('section', 'finance')->where('name', 'finance_button_link')->first()->value ?? route('blog.index') }}" class="btn btn-dark">Find out more</a>
            </div>

        </div>
    </div> -->



    <!-- <div class="d-block d-lg-none">
    <div  style="margin-bottom: 60px !important; padding-top: 0; padding-bottom: 0; padding-left: 30px !important; padding-right: 30px !important;">
        <div class="d-flex flex-column gap-lg-2">
        <h4 style="font-size: 30px; text-align: center !important;">
            {{ $sections->where('section', 'finance')[5]->value }}
        </h4>
            <p style="text-align: center !important;">{{ $sections->where('section', 'finance')[6]->value }}</p>
            <a href="{{ $sections->where('section', 'finance')->where('name', 'finance_button_link')->first()->value ?? route('blog.index') }}" class="btn btn-dark">Find out more</a>
        </div>
    </div>
    </div> -->


                                <!-- events section -->
        
                                <!-- <div class="container" style="padding: 10px 15px;">   
     <h4 style="font-size: 30px; margin-top: 10px; margin-bottom: 20px; ">Recent Events</h4>

     <div class="event-container">
        @foreach($events->take(3) as $event)
            <div onclick="window.location.href='{{ route('event.details', ['event' => $event->slug]) }}'" 
                style="" class="event-container-box">

                
                <div style="width: 100%; height: 200px; border-radius: 8px; position: relative; overflow: hidden;">
                  
                
              
                    <img src="{{ asset($event->featured_image) }}" 
                         alt="{{ $event->title }}" 
                         style="width: 100%; height: 100%; object-fit: cover; 
                                position: relative; z-index: 2;">
                </div>
                        
    

                    
                <div style="padding: 10px; display: flex; justify-content:space-between; align-items:center;">
                    <h5>{{ $event->title }}</h5>
                    <a href="{{ route('event.details', ['event' => $event->id]) }}" 
                    style="display: inline-block; color: #000000; text-decoration: none; margin-bottom:3px; rotate:45deg;">
                        <h5><i class="fas fa-arrow-up"></i></h5>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    </div>
     <style>
        @media screen and (max-width: 767px) {
            .event-container{
                display: flex; 
                flex-direction: column;
                gap: 10px; j
                ustify-content: space-between; 
                flex-wrap: wrap;
            }
            .event-container-box{
                flex: 1; 
                width: 100%; 
                border-radius: 8px; 
                overflow: hidden; 
                cursor: pointer; 
                text-align: center;
            }
        }
        @media screen and (min-width: 768px) {
            .event-container{
                display: flex; 
                gap: 10px; j
                ustify-content: space-between; 
                flex-wrap: wrap;
            }
            .event-container-box{
                flex: 1; 
                width: 30%; 
                border-radius: 8px; 
                overflow: hidden; 
                cursor: pointer; 
                text-align: center;
            }
        }  
    </style> -->
    

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

    <script>
      

document.addEventListener('DOMContentLoaded', function() {
    window.currentFilters = {
        make: '',
        model: '',
        variant: '',
        pricefrom: '',
        priceto: '',
        yearfrom: '',
        yearto: '',
        bodytype: '',
        enginesize: '',
        fueltype: '',
        gearbox: '',
        doors: '',
        colors: '',
        sellertype: '',
        maxmiles: ''
    };

    const priceFromInput = document.getElementById('pricefromInput');
    const priceToInput = document.getElementById('pricetoInput');
    const yearFromInput = document.getElementById('yearfromInput');
    const yearToInput = document.getElementById('yeartoInput');

    if (priceFromInput && priceFromInput.value) {
        window.currentFilters.pricefrom = priceFromInput.value;
        const formatted = formatPrice(priceFromInput.value, false);
        document.getElementById('pricefromDropdown').textContent = formatted.displayValue;
    }
    if (priceToInput && priceToInput.value) {
        window.currentFilters.priceto = priceToInput.value;
        const formatted = formatPrice(priceToInput.value, true);
        document.getElementById('pricetoDropdown').textContent = formatted.displayValue;
    }
    if (yearFromInput && yearFromInput.value) {
        window.currentFilters.yearfrom = yearFromInput.value;
        document.getElementById('yearfromDropdown').textContent = yearFromInput.value;
    }
    if (yearToInput && yearToInput.value) {
        window.currentFilters.yearto = yearToInput.value;
        document.getElementById('yeartoDropdown').textContent = yearToInput.value;
    }

    initializeDropdowns();
    setupEventListeners(); 
    updateSearchCount(); 
});

function initializeDropdowns() {
    document.getElementById('modelDropdown').disabled = true;
    document.getElementById('variantDropdown').disabled = true;
    updateAllDropdowns();
}

function setupEventListeners() {
    const hiddenInputs = document.querySelectorAll('input[type="hidden"]');
    hiddenInputs.forEach(input => {
        input.addEventListener('change', updateSearchCount);
    });

    const keywordInput = document.getElementById('keywordInput');
    if (keywordInput) {
        keywordInput.addEventListener('input', debounce(updateSearchCount, 300));
    }

    const cards = document.querySelectorAll('.col-lg-3');
    cards.forEach(card => {
        card.addEventListener('click', function() {
            const link = card.getAttribute('data-link');
            if (link) {
                window.location.href = link;
            }
        });
    });
}

function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func(...args), wait);
    };
}

function updateDropdownText(value, dropdownId, inputId, displayLabel = null) {
    
    const finalValue = value === "Any" ? "" : value;
    
    if(inputId == 'makeInput'){
        clearDependentFilters(['model', 'variant']);
        if (finalValue) {
            fetchModels(finalValue);
        }
    }else if(inputId == 'modelInput'){
        clearDependentFilters(['variant']);
        if (finalValue && window.currentFilters.make) {
            fetchVariants(window.currentFilters.make, finalValue);
        }
    }
    
    
    const dropdowns = document.querySelectorAll(`#${dropdownId}`);
    const inputs = document.querySelectorAll(`#${inputId}`);

    if (!dropdowns.length || !inputs.length) {
        console.error(`Missing dropdown or input for ID: ${dropdownId} / ${inputId}`);
        return;
    }

    dropdowns.forEach((item)=>{
        item.textContent = displayLabel || value;
    });
    
    inputs.forEach((item)=>{
        item.value = finalValue;
    });

    const filterName = inputId.replace('Input', '').toLowerCase();
    window.currentFilters[filterName] = finalValue;

    if (dropdownId === 'makeDropdown') {
        clearDependentFilters(['model', 'variant']);
    } else if (dropdownId === 'modelDropdown') {
        clearDependentFilters(['variant']);
    }

    updateAllDropdowns();
    updateSearchCount();
}

// function updateDropdownText(value, dropdownId, inputId, displayLabel = null) {
//     const dropdown = document.getElementById(dropdownId);
//     const input = document.getElementById(inputId);

//     if (!dropdown || !input) {
//         console.error(`Missing dropdown or input for ID: ${dropdownId} / ${inputId}`);
//         return;
//     }

//     dropdown.textContent = displayLabel || value;
//     input.value = value;

//     const filterName = inputId.replace('Input', '').toLowerCase();
//     window.currentFilters[filterName] = input.value;

//     if (dropdownId === 'makeDropdown') {
//         clearDependentFilters(['model', 'variant']);
//     } else if (dropdownId === 'modelDropdown') {
//         clearDependentFilters(['variant']);
//     }

//     updateAllDropdowns();
//     updateSearchCount();
// }

// function clearDependentFilters(filterNames) {
//     const fieldLabels = {
//         make: "Make",
//         model: "Model",
//         variant: "Variant",
//         pricefrom: "Price From",
//         priceto: "Price To",
//         yearfrom: "Year From",
//         yearto: "Year To"
//     };

//     filterNames.forEach(name => {
//         window.currentFilters[name] = '';
//         const inputId = `${name}Input`;
//         const dropdownId = `${name}Dropdown`;
//         const input = document.getElementById(inputId);
//         const dropdown = document.getElementById(dropdownId);
//         const list = document.getElementById(`${name}List`);

//         if (input) input.value = '';
//         if (dropdown) {
//             dropdown.textContent = fieldLabels[name] || name.charAt(0).toUpperCase() + name.slice(1);
//         }
//         if (list) {
//             list.innerHTML = '';
//         }
//         if (name === 'model' || name === 'variant') {
//             if (dropdown) dropdown.disabled = true;
//         }
//     });
// }

function clearDependentFilters(filterNames) {
    const fieldLabels = {
        make: "Make",
        model: "Model",
        variant: "Variant",
        pricefrom: "Price From",
        priceto: "Price To",
        yearfrom: "Year From",
        yearto: "Year To"
    };

    filterNames.forEach(name => {
        // reset global filter
        window.currentFilters[name] = '';

        // all related elements by prefix
        document.querySelectorAll(
            `#${name}Input, #${name}Dropdown, #${name}List`
        ).forEach(el => {

            // input reset
            if (el.id.endsWith('Input')) {
                el.value = '';
            }

            // dropdown reset
            if (el.id.endsWith('Dropdown')) {
                el.textContent =
                    fieldLabels[name] ||
                    name.charAt(0).toUpperCase() + name.slice(1);

                if (name === 'model' || name === 'variant') {
                    el.disabled = true;
                }
            }

            // list clear
            if (el.id.endsWith('List')) {
                el.innerHTML = '';
            }
        });
    });
}


function formatPrice(price, isUpperBound = false) {
    if (!price && price !== 0) return { value: 0, displayValue: "£0" };

    const parsedPrice = parseInt(price);

    const ranges = [
        { max: 5000, increment: 500 },
        { max: 10000, increment: 1000 },
        { max: 50000, increment: 5000 },
        { max: 100000, increment: 10000 }
    ];

    if (isUpperBound) {
        for (const range of ranges) {
            if (parsedPrice <= range.max) {
                const bucket = Math.ceil(parsedPrice / range.increment) * range.increment;
                return {
                    value: bucket,
                    displayValue: `£${bucket.toLocaleString('en-GB')}`
                };
            }
        }
        const highestIncrement = ranges[ranges.length - 1].increment;
        const bucket = Math.ceil(parsedPrice / highestIncrement) * highestIncrement;
        return {
            value: bucket,
            displayValue: `£${bucket.toLocaleString('en-GB')}`
        };
    }
    else {
        for (const range of ranges) {
            if (parsedPrice <= range.max) {
                const bucket = Math.floor(parsedPrice / range.increment) * range.increment;
                return {
                    value: bucket,
                    displayValue: `£${bucket.toLocaleString('en-GB')}`
                };
            }
        }
        const highestIncrement = ranges[ranges.length - 1].increment;
        const bucket = Math.floor(parsedPrice / highestIncrement) * highestIncrement;
        return {
            value: bucket,
            displayValue: `£${bucket.toLocaleString('en-GB')}`
        };
    }
}

function updateDropdownOptions(fieldName, options) {
    // console.log(fieldName, options);
    const fieldLabels = {
        make: "Make",
        model: "Model",
        variant: "Variant",
        pricefrom: "Price From",
        priceto: "Price To",
        yearfrom: "Year From",
        yearto: "Year To",
        bodytype: "Body Type",
        enginesize: "Engine Size",
        fueltype: "Fuel Type",
        gearbox: "Gearbox",
        doors: "Doors",
        colors: "Colors",
        sellertype: "Seller Type",
        maxmiles: "Max Miles",
    };

    const dropdown = document.getElementById(`${fieldName}Dropdown`);
    if (!dropdown) {
        console.error(`Dropdown button not found for ${fieldName}`);
        return;
    }
    
    const dropdownParent = dropdown.closest('.dropdown');
    const dropdownMenu = dropdownParent ? dropdownParent.querySelector('.dropdown-menu') : dropdown.nextElementSibling;
    const input = document.getElementById(`${fieldName}Input`);

    if (!dropdownMenu || !input) {
        console.error(`Dropdown menu or input not found for ${fieldName}`, {dropdownMenu, input});
        return;
    }

    const consolidatedOptions = {};

    if (fieldName === 'pricefrom' || fieldName === 'priceto') {
        const isPriceTo = fieldName === 'priceto';
        options.forEach(option => {
            const rawPrice = option.pricefrom || option.priceto || 0;
            const formattedPrice = formatPrice(rawPrice, isPriceTo);

            if (!consolidatedOptions[formattedPrice.displayValue]) {
                consolidatedOptions[formattedPrice.displayValue] = {
                    value: formattedPrice.value,
                    count: 0,
                    originalRawValue: rawPrice
                };
            }
            consolidatedOptions[formattedPrice.displayValue].count += option.count || 0;
        });
    } else if(fieldName == 'enginesize'){
        
        options.forEach(option => {
            const value = option["engine_size"];
            if (value === null || value === undefined || value === "") return;
            if (!consolidatedOptions[value]) {
                consolidatedOptions[value] = {
                    value: value,
                    count: 0
                };
            }
            consolidatedOptions[value].count += (option.count || 0);
        });
        
    } else if(fieldName == 'bodytype'){
        
        options.forEach(option => {
            const value = option["body_type"];
            if (value === null || value === undefined || value === "") return;
            if (!consolidatedOptions[value]) {
                consolidatedOptions[value] = {
                    value: value,
                    count: 0
                };
            }
            consolidatedOptions[value].count += (option.count || 0);
        });
        
    } else if(fieldName == 'fueltype'){
        
        options.forEach(option => {
            const value = option["fuel_type"];
            if (value === null || value === undefined || value === "") return;
            if (!consolidatedOptions[value]) {
                consolidatedOptions[value] = {
                    value: value,
                    count: 0
                };
            }
            consolidatedOptions[value].count += (option.count || 0);
        });
        
    } else if(fieldName == 'gearbox'){
        
        options.forEach(option => {
            const value = option["gear_box"];
            if (value === null || value === undefined || value === "" || value === "N/A") return;
            if (!consolidatedOptions[value]) {
                consolidatedOptions[value] = {
                    value: value,
                    count: 0
                };
            }
            consolidatedOptions[value].count += (option.count || 0);
        });
        
    } else if(fieldName == 'doors'){
        
        options.forEach(option => {
            const value = option["doors"];
            if (value === null || value === undefined || value === "" || value === 0) return;
            if (!consolidatedOptions[value]) {
                consolidatedOptions[value] = {
                    value: value,
                    count: 0
                };
            }
            consolidatedOptions[value].count += (option.count || 0);
        });
        
    } else if(fieldName == 'colors'){
        
        options.forEach(option => {
            const value = option["colors"];
            if (value === null || value === undefined || value === "" || value === "N/A") return;
            if (!consolidatedOptions[value]) {
                consolidatedOptions[value] = {
                    value: value,
                    count: 0
                };
            }
            consolidatedOptions[value].count += (option.count || 0);
        });
        
    } else if(fieldName == 'sellertype'){
        
        options.forEach(option => {
            const value = option["seller_type"] || option["original_seller_type"];
            if (value === null || value === undefined || value === "") return;
            // Map seller_type values
            const displayValue = value === 'car_dealer' ? 'Dealer' : (value === 'private_seller' ? 'Private' : value);
            if (!consolidatedOptions[displayValue]) {
                consolidatedOptions[displayValue] = {
                    value: value,
                    count: 0
                };
            }
            consolidatedOptions[displayValue].count += (option.count || 0);
        });
        
    } else if(fieldName == 'maxmiles'){
        
        options.forEach(option => {
            const value = option["miles"] || option["label"] || option["value"];
            if (value === null || value === undefined || value === "") return;
            const displayValue = option["label"] || `Up to ${parseInt(value).toLocaleString()} miles`;
            if (!consolidatedOptions[displayValue]) {
                consolidatedOptions[displayValue] = {
                    value: value,
                    count: 0
                };
            }
            consolidatedOptions[displayValue].count += (option.count || 0);
        });
        
    } else if(fieldName == 'yearfrom' || fieldName == 'yearto'){
        
        options.forEach(option => {
            const value = option[fieldName] || option["year"];
            if (value === null || value === undefined || value === "") return;
            if (!consolidatedOptions[value]) {
                consolidatedOptions[value] = {
                    value: value,
                    count: 0
                };
            }
            consolidatedOptions[value].count += (option.count || 0);
        });
        
    } else {
        options.forEach(option => {
            const value = option[fieldName.toLowerCase()] || option;
            if (value === null || value === undefined || value === "") return;
            if (!consolidatedOptions[value]) {
                consolidatedOptions[value] = {
                    value: value,
                    count: 0
                };
            }
            consolidatedOptions[value].count += (option.count || 0);
        });
    }

    const sortedOptions = Object.entries(consolidatedOptions)
        .map(([displayValue, option]) => ({
            displayValue,
            value: option.value,
            count: option.count
        }))
        .filter(option => option.count > 0)
        .sort((a, b) => {
            const numA = parseFloat(a.value);
            const numB = parseFloat(b.value);
            // For year fields, sort in descending order (newest to oldest)
            if ((fieldName === 'yearfrom' || fieldName === 'yearto') && !isNaN(numA) && !isNaN(numB)) {
                return numB - numA;
            }
            return (!isNaN(numA) && !isNaN(numB))
                ? numA - numB
                : a.displayValue.localeCompare(b.displayValue);
        });

    let html = '';

    const currentFilterValue = window.currentFilters[fieldName.toLowerCase()];
    let isCurrentValueStillValid = false;

    if (currentFilterValue) {
        if (fieldName === 'make' || fieldName === 'model' || fieldName === 'variant') {
            isCurrentValueStillValid = sortedOptions.some(option =>
                String(option.value) === String(currentFilterValue)
            );

            if (!isCurrentValueStillValid && fieldName !== 'make') {
                console.log(`Clearing ${fieldName} filter: '${currentFilterValue}' is no longer valid based on current filters.`);
                window.currentFilters[fieldName.toLowerCase()] = '';
                input.value = '';
                dropdown.textContent = fieldLabels[fieldName] || fieldName.charAt(0).toUpperCase() + fieldName.slice(1);

                if (fieldName === 'make') {
                    clearDependentFilters(['model', 'variant']);
                } else if (fieldName === 'model') {
                    clearDependentFilters(['variant']);
                }
            } else {
                const matchedOption = sortedOptions.find(option => String(option.value) === String(currentFilterValue));
                if (matchedOption) {
                    dropdown.textContent = matchedOption.displayValue;
                }
            }
        } else {
            if (fieldName === 'pricefrom' || fieldName === 'priceto') {
                const formattedPrice = formatPrice(currentFilterValue, fieldName === 'priceto');
                dropdown.textContent = formattedPrice.displayValue;
            } else if (fieldName === 'yearfrom' || fieldName === 'yearto') {
                dropdown.textContent = currentFilterValue;
            }
            
            if (!sortedOptions.some(option => String(option.value) === String(currentFilterValue))) {
                const currentDisplayValue = (fieldName === 'pricefrom' || fieldName === 'priceto') ?
                    formatPrice(currentFilterValue, fieldName === 'priceto').displayValue : currentFilterValue;
                // Escape single quotes to prevent JavaScript errors
                const escapedCurrentValue = String(currentFilterValue).replace(/'/g, "\\'");
                const escapedCurrentDisplay = String(currentDisplayValue).replace(/'/g, "\\'");
                html += `
                    <li>
                        <a class="dropdown-item" href="javascript:void(0)"
                           onclick="updateDropdownText('${escapedCurrentValue}', '${fieldName}Dropdown', '${fieldName}Input', '${escapedCurrentDisplay}')">
                            ${escapedCurrentDisplay}&nbsp;&nbsp;&nbsp;&nbsp;(0)
                        </a>
                    </li>
                `;
            }
        }

    } else {
        dropdown.textContent = fieldLabels[fieldName] || fieldName.charAt(0).toUpperCase() + fieldName.slice(1);
    }

    // Start with "Any" option
    html += `
        <li>
            <a class="dropdown-item" href="javascript:void(0)"
               onclick="updateDropdownText('Any', '${fieldName}Dropdown', '${fieldName}Input')">
               Any
            </a>
        </li>
    `;

    sortedOptions.forEach(option => {
        let displayContent = option.displayValue;
        const isSelected = String(option.value) === String(currentFilterValue);
        
        displayContent += `&nbsp;&nbsp;&nbsp;&nbsp;(${option.count})`;
        
        if (isSelected) {
            displayContent = `${displayContent}`;
        }

        // Escape single quotes in values to prevent JavaScript errors
        const escapedValue = String(option.value).replace(/'/g, "\\'");
        const escapedDisplay = String(option.displayValue).replace(/'/g, "\\'");
        html += `
            <li>
                <a class="dropdown-item ${isSelected ? 'selected-option' : ''}" href="javascript:void(0)"
                   onclick="updateDropdownText('${escapedValue}', '${fieldName}Dropdown', '${fieldName}Input', '${escapedDisplay}')">
                    ${displayContent}
                </a>
            </li>
        `;
    });

    dropdownMenu.innerHTML = html;

    if (fieldName === 'make' && window.currentFilters.make && sortedOptions.length > 0) {
        document.getElementById('modelDropdown').disabled = false;
    } else if (fieldName === 'model' && window.currentFilters.model && sortedOptions.length > 0) {
        document.getElementById('variantDropdown').disabled = false;
    }

    if (sortedOptions.length === 0 && (fieldName === 'model' || fieldName === 'variant')) {
        dropdown.disabled = true;
        dropdown.textContent = fieldLabels[fieldName] || fieldName.charAt(0).toUpperCase() + fieldName.slice(1);
        input.value = '';
        window.currentFilters[fieldName] = '';
        if (fieldName === 'model') {
            clearDependentFilters(['variant']);
        }
    }
}

var isMount = false;
function updateAllDropdowns() {
    // Create query string from current filters
    var queryParams = new URLSearchParams('');
    
    // Parameter name mapping for the endpoint (URL params -> endpoint params)
    const paramMapping = {
        'year_from': 'yearfrom',
        'year_to': 'yearto',
        'price_from': 'pricefrom',
        'price_to': 'priceto',
        'yearFrom': 'yearfrom',
        'yearTo': 'yearto',
        'pricefrom': 'pricefrom',
        'priceto': 'priceto'
    };
    
    if(isMount){
        for (const [key, value] of Object.entries(window.currentFilters)) {
            // Include all filters except make, model, variant for filtering other dropdowns
            if (value && key !== 'make' && key !== 'model' && key !== 'variant') { 
                const mappedKey = paramMapping[key] || key;
                queryParams.append(mappedKey, value);
            }
        }
        // Always include make if it exists for filtering other options
        if (window.currentFilters.make) {
            queryParams.append('make', window.currentFilters.make);
        }
    }else{
        isMount = true;
        const urlParams = new URLSearchParams(window.location.search);
        queryParams = new URLSearchParams();

        // Initialize currentFilters from URL and build queryParams with proper mapping
        for (const [key, value] of urlParams.entries()) {
            if (value.trim() == '' || value.trim() == " " || value.trim() === null) {
                continue;
            }
            
            // Map URL parameter names to endpoint parameter names
            const mappedKey = paramMapping[key] || key;
            queryParams.append(mappedKey, value);
            
            // Store in currentFilters with proper key mapping
            if (key === 'year_from') window.currentFilters.yearfrom = value;
            else if (key === 'year_to') window.currentFilters.yearto = value;
            else if (key === 'price_from') window.currentFilters.pricefrom = value;
            else if (key === 'price_to') window.currentFilters.priceto = value;
            else window.currentFilters[key] = value;
        }
    }

    fetch(`/get-filtered-fieldssale?${queryParams.toString()}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.make) {
            updateDropdownOptions('make', data.make);
        }
        updateDropdownOptions('fueltype', data.fuel_type);
        updateDropdownOptions('bodytype', data.body_type);
        updateDropdownOptions('enginesize', data.engine_size);
        updateDropdownOptions('doors', data.doors);
        updateDropdownOptions('colors', data.colors);
        updateDropdownOptions('sellertype', data.seller_type);
        updateDropdownOptions('gearbox', data.gear_box);

        const mileRanges = processeMileRanges(data.miles);
        updateDropdownOptions('maxmiles', mileRanges);

        updateDropdownOptions('yearfrom', data.year);
        updateDropdownOptions('yearto', data.year);
        updateDropdownOptions('pricefrom', data.price);
        updateDropdownOptions('priceto', data.price);
    })
    .catch(error => console.error('Error:', error));
}

// function updateAllDropdowns() {
//     const allFilters = new URLSearchParams();
    
//     // Original filtersForMake, which excludes 'make'
//     const filtersForMake = new URLSearchParams();
//     for (const [key, value] of Object.entries(window.currentFilters)) {
//         if (value && key !== 'make') {
//             filtersForMake.append(key, value);
//         }
//     }
    
//     // New filters object specifically for fetching ALL makes, without applying model/variant/price/year filters
//     const noMakeModelVariantPriceYearFilters = new URLSearchParams();
//     // No parameters added here, meaning it will request all makes.

//     for (const [key, value] of Object.entries(window.currentFilters)) {
//         if (value) {
//             allFilters.append(key, value);
//         }
//     }

//     const fieldsToUpdate = ['pricefrom', 'priceto', 'yearfrom', 'yearto', 'bodytype', 'enginesize'];


//     // Modified makeRequest: Use an empty filters object to get all makes.
//     const makeRequest = fetch(`/get-filtered-fields?${noMakeModelVariantPriceYearFilters.toString()}&field=make`, {
//         method: 'GET',
//         headers: {
//             'X-Requested-With': 'XMLHttpRequest',
//             'Accept': 'application/json',
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
//         }
//     })
//     .then(response => response.json())
//     .then(data => {
//         updateDropdownOptions('make', data.make);
//     })
//     .catch(error => console.error(`Error updating make dropdown:`, error));

//     const otherRequests = fieldsToUpdate.map(fieldName =>
//         fetch(`/get-filtered-fields?${allFilters.toString()}&field=${fieldName}`, {
//             method: 'GET',
//             headers: {
//                 'X-Requested-With': 'XMLHttpRequest',
//                 'Accept': 'application/json',
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
//             }
//         })
//         .then(response => response.json())
//         .then(data => {
            
//             updateDropdownOptions(fieldName, data[fieldName === 'pricefrom' || fieldName === 'priceto' ? 'price' : (fieldName === 'yearfrom' || fieldName === 'yearto' ? 'year' : fieldName == 'bodytype' ? 'body_type' : fieldName == 'enginesize' ? 'engine_size' : fieldName)]);
//         })
//         .catch(error => console.error(`Error updating ${fieldName} dropdown:`, error))
//     );

//     Promise.all([makeRequest, ...otherRequests])
//     .then(() => {
//         if (window.currentFilters.make) {
//             fetchModels(window.currentFilters.make);
//         } else {
//             document.getElementById('modelDropdown').disabled = true;
//             document.getElementById('modelDropdown').textContent = 'Model';
//             document.getElementById('modelInput').value = '';
//             document.getElementById('modelList').innerHTML = '';
//             clearDependentFilters(['variant']);
//         }
//     })
//     .then(() => {
//         if (window.currentFilters.make && window.currentFilters.model) {
//             fetchVariants(window.currentFilters.make, window.currentFilters.model);
//         } else {
//             document.getElementById('variantDropdown').disabled = true;
//             document.getElementById('variantDropdown').textContent = 'Variant';
//             document.getElementById('variantInput').value = '';
//             document.getElementById('variantList').innerHTML = '';
//         }
//     })
//     .catch(error => console.error('Error in overall dropdown update process:', error));
// }






function fetchModels(make) {
    const modelDropdownList = document.getElementById('modelList');
    const modelDropdowns = document.querySelectorAll('#modelList');
    if (!modelDropdownList) return;

    const params = new URLSearchParams();
    params.append('make', make);
    if (window.currentFilters.pricefrom) params.append('pricefrom', window.currentFilters.pricefrom);
    if (window.currentFilters.priceto) params.append('priceto', window.currentFilters.priceto);
    if (window.currentFilters.yearfrom) params.append('yearfrom', window.currentFilters.yearfrom);
    if (window.currentFilters.yearto) params.append('yearto', window.currentFilters.yearto);

    fetch(`/fetch-models?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            modelDropdowns.forEach((item)=>item.innerHTML = '');
            // modelDropdownList.innerHTML = '';
            let validModels = [];
            if (data.models && Array.isArray(data.models)) {
                validModels = data.models.filter(model => model && model.model);
                var html = '';
                validModels.forEach(model => {
                    const isSelected = String(model.model) === String(window.currentFilters.model);
                    const displayContent = isSelected ? `✓ ${model.model}` : model.model;
                    
                    const listItem = document.createElement('li');
                    html += `
                        <li>
                        <a class="dropdown-item ${isSelected ? 'selected-option' : ''}" href="javascript:void(0)"
                           onclick="updateDropdownText('${model.model}', 'modelDropdown', 'modelInput')">
                            ${displayContent}&nbsp;&nbsp;&nbsp;&nbsp;(${model.count || 0})
                        </a> </li>`;
                    // listItem.innerHTML = `
                    //     <a class="dropdown-item ${isSelected ? 'selected-option' : ''}" href="javascript:void(0)"
                    //       onclick="updateDropdownText('${model.model}', 'modelDropdown', 'modelInput')">
                    //         ${displayContent}&nbsp;&nbsp;&nbsp;&nbsp;(${model.count || 0})
                    //     </a>`;
                });
                modelDropdowns.forEach((item)=>{
                    item.innerHTML = html;
                });
            }

            const modelDropdownBtns = document.querySelectorAll('#modelDropdown');
            const modelInputs = document.querySelectorAll('#modelInput');
            modelDropdownBtns.forEach((item, index)=>{
                try{
                    if(modelDropdowns[index] && modelDropdowns[index].children.length > 0){
                        item.disabled = false;
                    }else{
                        item.disabled = true;
                        item.textContent = 'Model';
                        modelInputs[index].value = '';
                        window.currentFilters.model = '';
                        clearDependentFilters(['variant']);
                    }
                }catch(error){
                    
                }
            });
            
            
            const currentSelectedModel = window.currentFilters.model;
            if (currentSelectedModel) {
                const isStillValid = validModels.some(model => String(model.model) === String(currentSelectedModel));
                if (!isStillValid) {
                    console.log(`Clearing model filter: '${currentSelectedModel}' is no longer valid.`);
                    modelDropdownBtns.forEach( item => item.textContent = 'Model');
                    modelInput.value = '';
                    window.currentFilters.model = '';
                    clearDependentFilters(['variant']);
                }
            } else {
                 modelDropdownBtns.forEach( item => item.textContent = 'Model');
            }

        })
        .catch(error => {
            console.error('Error fetching models:', error);
            document.getElementById('modelDropdown').disabled = true;
            document.getElementById('modelDropdown').textContent = 'Model';
            document.getElementById('modelInput').value = '';
            document.getElementById('modelList').innerHTML = '';
            clearDependentFilters(['variant']);
        });
}

function fetchVariants(make, model) {
    const variantDropdownList = document.getElementById('variantList');
    const variantDropdowns = document.querySelectorAll('#variantList');
    if (!variantDropdownList) return;

    const params = new URLSearchParams();
    params.append('make', make);
    params.append('model', model);
    if (window.currentFilters.pricefrom) params.append('pricefrom', window.currentFilters.pricefrom);
    if (window.currentFilters.priceto) params.append('priceto', window.currentFilters.priceto);
    if (window.currentFilters.yearfrom) params.append('yearfrom', window.currentFilters.yearfrom);
    if (window.currentFilters.yearto) params.append('yearto', window.currentFilters.yearto);

    fetch(`/fetch-variants-home?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            variantDropdowns.forEach((item)=>item.innerHTML = '');
            variantDropdownList.innerHTML = '';
            let validVariants = [];
            if (data.variants && Array.isArray(data.variants)) {
                validVariants = data.variants.filter(variant => variant && variant.variant);
                var html = '';
                validVariants.forEach(variant => {
                    const isSelected = String(variant.variant) === String(window.currentFilters.variant);
                    const displayContent = isSelected ? `✓ ${variant.variant}` : variant.variant;
                    
                    const listItem = document.createElement('li');
                    html += `
                        <a class="dropdown-item ${isSelected ? 'selected-option' : ''}" href="javascript:void(0)"
                           onclick="updateDropdownText('${variant.variant}', 'variantDropdown', 'variantInput')">
                            ${displayContent}&nbsp;&nbsp;&nbsp;&nbsp;(${variant.count || 0})
                        </a>`;
                    // variantDropdownList.appendChild(listItem);
                });
                
                variantDropdowns.forEach((item)=>item.innerHTML = html);
            }

            // const variantDropdownBtn = document.getElementById('variantDropdown');
            // const variantInput = document.getElementById('variantInput');

            // if (variantDropdownList.children.length > 0) {
            //     variantDropdownBtn.disabled = false;
            // } else {
            //     variantDropdownBtn.disabled = true;
            //     variantDropdownBtn.textContent = 'Variant';
            //     variantInput.value = '';
            //     window.currentFilters.variant = '';
            // }
            
            
            const variantDropdownBtns = document.querySelectorAll('#variantDropdown');
            const variantInputs = document.querySelectorAll('#variantInput');
            variantDropdownBtns.forEach((item, index)=>{
                try{
                    if(variantDropdowns[index] && variantDropdowns[index].children.length > 0){
                        item.disabled = false;
                    }else{
                        item.disabled = true;
                        item.textContent = 'Variant';
                        variantInputs[index].value = '';
                        window.currentFilters.variant = '';
                    }
                }catch(error){
                    
                }
            });
            
            
            

            const currentSelectedVariant = window.currentFilters.variant;
            if (currentSelectedVariant) {
                const isStillValid = validVariants.some(variant => String(variant.variant) === String(currentSelectedVariant));
                if (!isStillValid) {
                    console.log(`Clearing variant filter: '${currentSelectedVariant}' is no longer valid.`);
                    // variantDropdownBtn.textContent = 'Variant';
                    variantDropdownBtns.forEach((item, index)=> item.textContent = 'Variant');
                    variantInputs.forEach((item, index)=> item.value = 'Variant');
                    window.currentFilters.variant = '';
                }
            } else {
                variantDropdownBtns.forEach((item, index)=> item.textContent = 'Variant');
            }
        })
        .catch(error => {
            console.error('Error fetching variants:', error);
            document.getElementById('variantDropdown').disabled = true;
            document.getElementById('variantDropdown').textContent = 'Variant';
            document.getElementById('variantInput').value = '';
            document.getElementById('variantList').innerHTML = '';
        });
}

function processeMileRanges(milesData) {
    const ranges = [{
            label: 'Up to 10,000 miles',
            value: 10000
        },
        {
            label: 'Up to 20,000 miles',
            value: 20000
        },
        {
            label: 'Up to 30,000 miles',
            value: 30000
        },
        {
            label: 'Up to 40,000 miles',
            value: 40000
        },
        {
            label: 'Up to 50,000 miles',
            value: 50000
        },
        {
            label: 'Up to 60,000 miles',
            value: 60000
        },
        {
            label: 'Up to 70,000 miles',
            value: 70000
        },
        {
            label: 'Up to 80,000 miles',
            value: 80000
        },
        {
            label: 'Up to 90,000 miles',
            value: 90000
        },
        {
            label: 'Up to 100,000 miles',
            value: 100000
        },
        {
            label: 'Over 100,000 miles',
            value: 'over100000'
        }
    ];

    return ranges.map(range => ({
        ...range,
        count: calculateMileRangeCount(milesData, range.value)
    })).filter(range => range.count > 0);
}

function calculateMileRangeCount(milesData, rangeValue) {
    return milesData.reduce((total, item) => {
        const miles = parseInt(item.miles);
        if (rangeValue === 'over100000') {
            return miles > 100000 ? total + item.count : total;
        }
        const prevRange = rangeValue - 10000;
        return miles >= prevRange && miles < rangeValue ? total + item.count : total;
    }, 0);
}

function enableNextDropdown(currentDropdownId) {
    const dropdownOrder = ['makeDropdown', 'modelDropdown', 'variantDropdown'];
    const currentIndex = dropdownOrder.indexOf(currentDropdownId);

    if (currentIndex !== -1 && currentIndex < dropdownOrder.length - 1) {
        const nextDropdownId = dropdownOrder[currentIndex + 1];
        const nextDropdown = document.getElementById(nextDropdownId);
        const currentInput = document.getElementById(currentDropdownId.replace('Dropdown', 'Input'));
        if (nextDropdown && currentInput && currentInput.value !== '') {
            nextDropdown.disabled = false;
        }
    }
}

// function clearFilters() {
//     const fieldLabels = {
//         make: "Make",
//         model: "Model",
//         variant: "Variant",
//         pricefrom: "Price From",
//         priceto: "Price To",
//         yearfrom: "Year From",
//         yearto: "Year To"
//     };

//     for (const key in window.currentFilters) {
//         if (window.currentFilters.hasOwnProperty(key)) {
//             window.currentFilters[key] = '';
//             const dropdown = document.getElementById(`${key}Dropdown`);
//             const input = document.getElementById(`${key}Input`);
//             const list = document.getElementById(`${key}List`);

//             if (dropdown) {
//                 dropdown.textContent = fieldLabels[key] || key.charAt(0).toUpperCase() + key.slice(1);
//             }
//             if (input) {
//                 input.value = '';
//             }
//             if (list) {
//                 list.innerHTML = '';
//             }
//         }
//     }

//     document.getElementById('modelDropdown').disabled = true;
//     document.getElementById('variantDropdown').disabled = true;

//     updateAllDropdowns();
//     updateSearchCount();
// }


function clearFilters() {
    const fieldLabels = {
        make: "Make",
        model: "Model",
        variant: "Variant",
        pricefrom: "Price From",
        priceto: "Price To",
        yearfrom: "Year From",
        yearto: "Year To"
    };

    for (const key in window.currentFilters) {
        if (window.currentFilters.hasOwnProperty(key)) {

            window.currentFilters[key] = '';

            // Dropdowns
            document.querySelectorAll(`#${key}Dropdown`).forEach(dropdown => {
                dropdown.textContent =
                    fieldLabels[key] || key.charAt(0).toUpperCase() + key.slice(1);
            });

            // Inputs
            document.querySelectorAll(`#${key}Input`).forEach(input => {
                input.value = '';
            });

            // Lists
            document.querySelectorAll(`#${key}List`).forEach(list => {
                list.innerHTML = '';
            });
        }
    }

    // Disable model & variant dropdowns
    document.querySelectorAll('#modelDropdown').forEach(d => d.disabled = true);
    document.querySelectorAll('#variantDropdown').forEach(d => d.disabled = true);

    updateAllDropdowns();
    updateSearchCount();
}


// function updateSearchCount() {
//     const allInputs = document.querySelectorAll('input[type="hidden"], input[type="text"]');
//     const formData = new FormData();
//     allInputs.forEach(input => {
//         if (input.name && input.value) {
//             formData.append(input.name, input.value);
//         }
//     });

//     const token = document.querySelector('meta[name="csrf-token"]').content;
//     const searchButton = document.getElementById('searchButton');

//     if (searchButton) {
//         searchButton.textContent = 'Searching...';
//         searchButton.disabled = true;
//         searchButton.classList.add('btn-disabled-custom');
//     }

//     fetch('/count-cars', {
//             method: 'POST',
//             headers: {
//                 'X-CSRF-TOKEN': token,
//                 'Accept': 'application/json',
//                 'X-Requested-With': 'XMLHttpRequest'
//             },
//             body: formData
//         })
//         .then(response => {
//             if (!response.ok) {
//                 throw new Error(`HTTP error! status: ${response.status}`);
//             }
//             return response.json();
//         })
//         .then(data => {
//             const carCount = data.count ?? 0;
//             if (searchButton) {
//                 searchButton.textContent = `Search\u00A0\u00A0(${carCount} cars)`;

//                 if (carCount === 0) {
//                     searchButton.disabled = true;
//                     searchButton.classList.add('btn-disabled-custom');
//                 } else {
//                     searchButton.disabled = false;
//                     searchButton.classList.remove('btn-disabled-custom');
//                 }
//             }
//         })
//         .catch(error => {
//             console.error('Error updating search count:', error);
//             if (searchButton) {
//                 searchButton.disabled = true;
//                 searchButton.textContent = `No cars found`;
//                 searchButton.classList.add('btn-disabled-custom');
//             }
//         });
// }

function updateSearchCount() {
    const allInputs = document.querySelectorAll('input[type="hidden"], input[type="text"]');
    const formData = new FormData();

    allInputs.forEach(input => {
        if (input.name && input.value) {
            formData.append(input.name, input.value);
        }
    });

    const token = document.querySelector('meta[name="csrf-token"]').content;
    const searchButtons = document.querySelectorAll('#searchButton');

    // Searching state
    searchButtons.forEach(btn => {
        btn.textContent = 'Searching...';
        btn.disabled = true;
        btn.classList.add('btn-disabled-custom');
    });

    fetch('/count-cars', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        const carCount = data.count ?? 0;

        searchButtons.forEach(btn => {
            btn.textContent = `Search\u00A0\u00A0(${carCount} cars)`;

            if (carCount === 0) {
                btn.disabled = true;
                btn.classList.add('btn-disabled-custom');
            } else {
                btn.disabled = false;
                btn.classList.remove('btn-disabled-custom');
            }
        });
    })
    .catch(error => {
        console.error('Error updating search count:', error);

        searchButtons.forEach(btn => {
            btn.disabled = true;
            btn.textContent = 'No cars found';
            btn.classList.add('btn-disabled-custom');
        });
    });
}



</script>
<style>
    .clickable-image{
    cursor: pointer; 
}
</style>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const isMobile = window.innerWidth <= 768; 
  // Bootstrap Modals
  document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('show.bs.modal', e => {
      handleModalOpen(e.target.id);
    });

    modal.addEventListener('hide.bs.modal', e => {
      handleModalClose(e.target.id);
    });
  });

  // Custom Mobile Dropdown
  if (document.getElementById('externalDropdown')) {
    const originalOpen = openExternalDropdown;
    openExternalDropdown = function (...args) {
      originalOpen(...args);
      handleModalOpen('externalDropdown');
    };

    const originalClose = closeExternalDropdown;
    closeExternalDropdown = function () {
      originalClose();
      handleModalClose('externalDropdown');
    };
  }

  // Ensure filterModal is correctly handled on page load
  const filterModalElement = document.getElementById('filterModal');
  if (filterModalElement) {
    if (isMobile) {
      const dropdownMenus = filterModalElement.querySelectorAll('.dropdown-menu');
      dropdownMenus.forEach(menu => {
        menu.classList.add('d-none');
      });
    }
    filterModalElement.addEventListener('show.bs.modal', e => {
      handleModalOpen('filterModal');
    });

    filterModalElement.addEventListener('hide.bs.modal', e => {
      handleModalClose('filterModal');
    });
  }
});

window.addEventListener('popstate', e => {
  if (modalStack.length > 0) {
    const lastModalId = modalStack.pop();
    sessionStorage.setItem('modalStack', JSON.stringify(modalStack));

    const modalElement = document.getElementById(lastModalId);
    if (modalElement) {
      if (lastModalId === "searchModal") {
        modalElement.style.display = "none"; 
      }
       else if (modalElement.classList.contains('modal')) {
        const bsModal = bootstrap.Modal.getInstance(modalElement);
        if (bsModal) {
          bsModal.hide();
        }
      }
       else {
        modalElement.style.display = "none";
      }
    }

    if (modalStack.length > 0) {
      history.pushState({ action: 'modal-open' }, '');
    }
  }
});



</script>
@endsection

