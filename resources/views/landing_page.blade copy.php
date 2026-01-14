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
    box-sizing: border-box; /* Include padding in the width calculation */
    text-align: left; /* Align text to the left */
    white-space: nowrap; /* Prevent text wrapping */


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
            <div class="desktop-hero-section-innerbox">
                <h1>{{ $sections->where('section', 'hero')[1]->value }}</h1>
                <!-- <p>{{ $sections->where('section', 'hero')[2]->value }}</p> -->
                <form method="GET" action="{{route('search_car')}}" style="margin-top:30px; pointer-events: auto;" id="desktopform">
                    @csrf
                        <div class="">
                            <!-- make model row  -->
                            <div class="search_box_dropdown_menu">
                                <!-- Make Dropdown -->
                                <div class="dropdown_menu_first_col">
                                    <div class="pt-1 pb-1 dropdown rounded-3 search_color">
                                        <button class="btn search_color dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                                type="button" id="makeDropdown" data-bs-toggle="dropdown" >
                                            Make
                                        </button>
                                        <ul class="dropdown-menu scrollable-dropdown">
                                            <!-- <li>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                onclick="updateDropdownText('Any', 'makeDropdown', 'makeInput')">
                                                    Any
                                                </a>
                                            </li> -->
                                            @foreach($search_field['make'] as $make)
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                    onclick="updateDropdownText('{{ $make->make }}', 'makeDropdown', 'makeInput')">
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
                                    <div class="pt-1 pb-1 dropdown rounded-3 search_color">
                                        <button class="btn search_color dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                                type="button" id="modelDropdown" data-bs-toggle="dropdown" disabled>
                                            Model
                                        </button>
                                        <ul class="dropdown-menu scrollable-dropdown" id="modelList">
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                onclick="updateDropdownText('Any', 'modelDropdown', 'modelInput')">
                                                    
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="model" id="modelInput" value="">
                                </div>
                            </div>                                                          

                            
                            <!-- Variant Dropdown -->

                            <div class="mb-2">
                                <div class="pt-1 pb-1 dropdown rounded-3 search_color">
                                    <button class="btn search_color dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                            type="button" id="variantDropdown" data-bs-toggle="dropdown" disabled>
                                        Variant
                                    </button>
                                    <ul class="dropdown-menu scrollable-dropdown" id="variantList">
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)"
                                            onclick="updateDropdownText('Any', 'variantDropdown', 'variantInput')">
                                            
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <input type="hidden" name="variant" id="variantInput" value="">
                            </div>
                            
                            <!-- price to and from row  -->
                            <div class="search_box_dropdown_menu">
                                   <!-- Price From Dropdown -->
                                <div class="dropdown_menu_second_col">
                                    <div class="pt-1 pb-1 dropdown rounded-3 search_color">
                                        <button class="btn search_color dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                                type="button" id="pricefromDropdown" data-bs-toggle="dropdown">
                                                Price From
                                        </button>
                                        <ul class="overflow-auto dropdown-menu" style="max-height: 300px;" id="pricefromDropdownList">
                                            <!-- <li>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                onclick="updateDropdownText('Any', 'pricefromDropdown', 'pricefromInput', 'Any')">
                                                    Any
                                                </a>
                                            </li> -->
                                            @foreach($price_counts as $price_range)
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                    onclick="updateDropdownText('{{ $price_range['min'] }}', 'pricefromDropdown', 'pricefromInput', '£{{ number_format($price_range['min']) }}')">
                                                    £{{ number_format($price_range['min']) }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $price_range['count'] }})
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <input type="hidden" name="price_from" id="pricefromInput" value="">
                                </div>
                                <!-- Price To Dropdown -->
                                <div class="dropdown_menu_first_col">
                                    <div class="pt-1 pb-1 dropdown rounded-3 search_color">
                                        <button class="btn search_color dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                                type="button" id="pricetoDropdown" data-bs-toggle="dropdown">
                                            Price To
                                        </button>
                                        <ul class="overflow-auto dropdown-menu" style="max-height: 300px;" id="priceDropdownList">
                                        <!-- <li>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                onclick="updateDropdownText('Any', 'pricetoDropdown', 'pricetoInput')">
                                                    Any
                                                </a>
                                            </li> -->
                                            @foreach($price_counts as $price_range)
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                    onclick="updateDropdownText('{{ $price_range['max'] }}', 'pricetoDropdown', 'pricetoInput', '£{{ number_format($price_range['max']) }} ({{ $price_range['count'] }})')">

                                                    £{{ number_format($price_range['max']) }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $price_range['count'] }})
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <input type="hidden" name="price_to" id="pricetoInput" value="">
                                </div>
                             
                            </div>
                            
                            <div class="search_box_dropdown_menu">
                                  <!-- Year From Dropdown -->
                                <div class="dropdown_menu_second_col">
                                    <div class="pt-1 pb-1 dropdown rounded-3 search_color">
                                        <button class="btn search_color dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                                type="button" id="yearfromDropdown" data-bs-toggle="dropdown">
                                                Year From
                                        </button>
                                        <ul class="overflow-auto dropdown-menu" style="max-height: 300px;" id="yearfromDropdownList">
                                            <!-- <li>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                onclick="updateDropdownText('Any', 'yearfromDropdown', 'yearfromInput', 'Any')">
                                                    Any
                                                </a>
                                            </li> -->
                                            @foreach($year_counts as $year_range)
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                    onclick="updateDropdownText('{{ $year_range['year'] }}', 'yearfromDropdown', 'yearfromInput', '{{ $year_range['year'] }}')">
                                                    {{ $year_range['year'] }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $year_range['count'] }})
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <input type="hidden" name="year_from" id="yearfromInput" value="">
                                </div>
                                <!-- Year To Dropdown -->                        
                                <div class="dropdown_menu_first_col">
                                    <div class="pt-1 pb-1 dropdown rounded-3 search_color">
                                        <button class="btn search_color dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                                type="button" id="yeartoDropdown" data-bs-toggle="dropdown">
                                            Year To
                                        </button>
                                        <ul class="overflow-auto dropdown-menu" style="max-height: 300px;" id="yeartoDropdownList">
                                        <!-- <li>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                onclick="updateDropdownText('Any', 'yeartoDropdown', 'yeartoInput')">
                                                    Any
                                                </a>
                                            </li> -->
                                            @foreach($year_counts as $year_range)
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                    onclick="updateDropdownText('{{ $year_range['year'] }}', 'yeartoDropdown', 'yeartoInput', '{{ $year_range['year'] }}')">
                                                    {{ $year_range['year'] }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $year_range['count'] }})
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <input type="hidden" name="year_to" id="yeartoInput" value="">
                                </div>
                              
                            </div>

                            
                            
                            
                            <div style="display: flex; flex-direction:column; align-items:center; gap:7px;">
                                    <button id="searchButton" class="btn btn-dark mt-3" style="width:100%;">Search</button>
                                    <a onclick="clearFilters()" class="text-center" style="cursor: pointer; color: #007bff; font-weight: bold; text-decoration: none;">Clear All</a>
                            </div>                                
                        </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-section-mobile" style="width: 100%; height:85vh; overflow:hidden;">
        <div style="height:28vh;">
            <img style="width:100%; height:100%; object-fit:cover; z-index:10;" src="{{ asset('images/page_sections/' . $sections->where('section', 'hero')[0]->value) }}" alt="" onclick="window.open('{{ Str::startsWith($sections->where('section', 'hero')->where('name', 'hero_button_link')->first()->value, ['http://', 'https://']) ? $sections->where('section', 'hero')->where('name', 'hero_button_link')->first()->value : 'https://' . $sections->where('section', 'hero')->where('name', 'hero_button_link')->first()->value }}', '_blank')">            
        </div>
          <div style="background-color:#000; padding:10px 10px; max-height:10vh;">
            <div>
                <div onclick="window.open('{{ Str::startsWith($sections->where('section', 'hero')->where('name', 'hero_button_link')->first()->value, ['http://', 'https://']) ? $sections->where('section', 'hero')->where('name', 'hero_button_link')->first()->value : 'https://' . $sections->where('section', 'hero')->where('name', 'hero_button_link')->first()->value }}', '_blank')">
                    <h1 style="color:white; font-size:20px; margin:0; padding:0;">
                        {{ $sections->where('section', 'hero')[1]->value }}
                    </h1>
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
                <div class="pt-1 pb-1 dropdown rounded-3 " style="background-color:#F5F6FA;">
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
                    @foreach($year_counts as $year_range)
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
                    @foreach($year_counts as $year_range)
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
              <button id="searchButton" class="btn btn-dark mt-3" style="width: 100%;">Search</button>
              <a onclick="clearFilters()" class="text-center" style="cursor: pointer; color: #007bff; font-weight: bold; text-decoration: none;">Clear All</a>
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
document.addEventListener('DOMContentLoaded', function () {
    if (isMobile()) {
        const heroForm = document.querySelector('.hero-section-mobile form');
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

        // Add backdrop click handler to close modal
        const customSelectModal = document.getElementById('customSelectModal');
        customSelectModal.addEventListener('click', function (event) {
            if (event.target === customSelectModal) {
                closeCustomSelectModal();
            }
        });

        // Listen for the popstate event to handle back button
        window.addEventListener('popstate', function (event) {
            const customSelectModal = document.getElementById('customSelectModal');
            if (customSelectModal.style.display === 'flex') {
                closeCustomSelectModal();
            }
        });
    }
});

function isMobile() {
    return window.innerWidth <= 768;
}

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
        const cards = row.querySelectorAll('.col-sm-12');
        
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
    <div class="container">
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
                <a href="/car-for-sale/${car.car_slug}" class="text-decoration-none text-dark">
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
                        <div class="p-3">
                            <p class="car_tittle text-truncate">${car.make || 'Unknown make'} ${car.model || 'N/A'} ${car.year || 'N/A'}</p>
                            <p class="car_varient text-truncate">
                                ${car.Trim ? car.Trim.substring(0, 31) + (car.Trim.length > 31 ? "..." : "") : "Unknown Trim"}
                            </p>

                            <div class="car_detail">
                                <div class="text-center">
                                    <div class="car_detail_type">                                        
                                        <p class="car_detail_type_text">${car.miles ? car.miles.toLocaleString() : 'N/A'}</p>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="car_detail_type">                                        
                                        <p class="car_detail_type_text">${car.fuel_type || 'N/A'}</p>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="car_detail_type">                                        
                                        <p class="car_detail_type_text">${car.gear_box || 'N/A'}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="height"></div>
                            <div class="car_detail_bottom">
                                <p class="car_price">
                                    ${car.price > 0 ? '£' + Number(car.price).toLocaleString('en-GB', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) : 'POA'}
                                </p>
                                <p class="car_location">
                                    ${car.location || 'N/A'}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        `;
    }
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
     
            <h4 style="font-size: 30px; margin-top: 10px; margin-bottom: 10px;">Blogs</h4>
      
        <div class="blog-container-1">
            <!-- Left Column -->
            <div class="left-column">
                @foreach($blogs->take(2) as $blog)
                    <div class="blog-card-1" onclick="window.location.href='{{ route('blog.show', ['blog' => $blog->slug]) }}'">
                        <img src="{{ asset('images/blogs/'. $blog->featured_image) }}" alt="{{ $blog->title }}">
                        <div class="blog-content-1">
                            <h5>{{ $blog->title }}</h5>
                            <p>{{ \Str::limit(strip_tags($blog->content), 350) }}</p>
                            <a class="blog-content-link" href="{{ route('blog.show', ['blog' => $blog->slug]) }}">Read More</a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Right Column -->
            <div class="right-column">
                @foreach($blogs->skip(2)->take(3) as $blog)
                    <div class="right-column-blog-card" onclick="window.location.href='{{ route('blog.show', ['blog' => $blog->slug]) }}'">
                        <div class="right-column-blog-card-img" style="background-image: url('{{ asset('images/blogs/' . $blog->featured_image) }}');"></div>
                        <div class="right-column-blog-content">
                            <h5>{{ \Str::limit($blog->title, 20 ) }}</h5>
                            <p>{{ \Str::limit(strip_tags($blog->content), 70) }}</p>
                            <a class="blog-content-link" href="{{ route('blog.show', ['blog' => $blog->slug]) }}">Read More</a>
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
        width: 500px;
        height: 300px;
        overflow: hidden;
        max-width: 100%; 
        height: auto; 
        background-size: cover;
        background-position: center;
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
        yearto: ''
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
    const dropdown = document.getElementById(dropdownId);
    const input = document.getElementById(inputId);

    if (!dropdown || !input) {
        console.error(`Missing dropdown or input for ID: ${dropdownId} / ${inputId}`);
        return;
    }

    dropdown.textContent = displayLabel || value;
    input.value = value;

    const filterName = inputId.replace('Input', '').toLowerCase();
    window.currentFilters[filterName] = input.value;

    if (dropdownId === 'makeDropdown') {
        clearDependentFilters(['model', 'variant']);
    } else if (dropdownId === 'modelDropdown') {
        clearDependentFilters(['variant']);
    }

    updateAllDropdowns();
    updateSearchCount();
}

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
        window.currentFilters[name] = '';
        const inputId = `${name}Input`;
        const dropdownId = `${name}Dropdown`;
        const input = document.getElementById(inputId);
        const dropdown = document.getElementById(dropdownId);
        const list = document.getElementById(`${name}List`);

        if (input) input.value = '';
        if (dropdown) {
            dropdown.textContent = fieldLabels[name] || name.charAt(0).toUpperCase() + name.slice(1);
        }
        if (list) {
            list.innerHTML = '';
        }
        if (name === 'model' || name === 'variant') {
            if (dropdown) dropdown.disabled = true;
        }
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
    const fieldLabels = {
        make: "Make",
        model: "Model",
        variant: "Variant",
        pricefrom: "Price From",
        priceto: "Price To",
        yearfrom: "Year From",
        yearto: "Year To"
    };

    const dropdown = document.getElementById(`${fieldName}Dropdown`);
    const dropdownMenu = dropdown.nextElementSibling;
    const input = document.getElementById(`${fieldName}Input`);

    if (!dropdown || !dropdownMenu || !input) {
        console.error(`Dropdown elements not found for ${fieldName}`);
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
                html += `
                    <li>
                        <a class="dropdown-item" href="javascript:void(0)"
                           onclick="updateDropdownText('${currentFilterValue}', '${fieldName}Dropdown', '${fieldName}Input', '${currentDisplayValue}')">
                            ${currentDisplayValue}&nbsp;&nbsp;&nbsp;&nbsp;(0)
                        </a>
                    </li>
                `;
            }
        }

    } else {
        dropdown.textContent = fieldLabels[fieldName] || fieldName.charAt(0).toUpperCase() + fieldName.slice(1);
    }

    sortedOptions.forEach(option => {
        let displayContent = option.displayValue;
        const isSelected = String(option.value) === String(currentFilterValue);
        
        displayContent += `&nbsp;&nbsp;&nbsp;&nbsp;(${option.count})`;
        
        if (isSelected) {
            displayContent = `✓ ${displayContent}`;
        }

        html += `
            <li>
                <a class="dropdown-item ${isSelected ? 'selected-option' : ''}" href="javascript:void(0)"
                   onclick="updateDropdownText('${option.value}', '${fieldName}Dropdown', '${fieldName}Input', '${option.displayValue}')">
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

function updateAllDropdowns() {
    const allFilters = new URLSearchParams();
    
    // Original filtersForMake, which excludes 'make'
    const filtersForMake = new URLSearchParams();
    for (const [key, value] of Object.entries(window.currentFilters)) {
        if (value && key !== 'make') {
            filtersForMake.append(key, value);
        }
    }
    
    // New filters object specifically for fetching ALL makes, without applying model/variant/price/year filters
    const noMakeModelVariantPriceYearFilters = new URLSearchParams();
    // No parameters added here, meaning it will request all makes.

    for (const [key, value] of Object.entries(window.currentFilters)) {
        if (value) {
            allFilters.append(key, value);
        }
    }

    const fieldsToUpdate = ['pricefrom', 'priceto', 'yearfrom', 'yearto'];

    // Modified makeRequest: Use an empty filters object to get all makes.
    const makeRequest = fetch(`/get-filtered-fields?${noMakeModelVariantPriceYearFilters.toString()}&field=make`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        updateDropdownOptions('make', data.make);
    })
    .catch(error => console.error(`Error updating make dropdown:`, error));

    const otherRequests = fieldsToUpdate.map(fieldName =>
        fetch(`/get-filtered-fields?${allFilters.toString()}&field=${fieldName}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            updateDropdownOptions(fieldName, data[fieldName === 'pricefrom' || fieldName === 'priceto' ? 'price' : (fieldName === 'yearfrom' || fieldName === 'yearto' ? 'year' : fieldName)]);
        })
        .catch(error => console.error(`Error updating ${fieldName} dropdown:`, error))
    );

    Promise.all([makeRequest, ...otherRequests])
    .then(() => {
        if (window.currentFilters.make) {
            fetchModels(window.currentFilters.make);
        } else {
            document.getElementById('modelDropdown').disabled = true;
            document.getElementById('modelDropdown').textContent = 'Model';
            document.getElementById('modelInput').value = '';
            document.getElementById('modelList').innerHTML = '';
            clearDependentFilters(['variant']);
        }
    })
    .then(() => {
        if (window.currentFilters.make && window.currentFilters.model) {
            fetchVariants(window.currentFilters.make, window.currentFilters.model);
        } else {
            document.getElementById('variantDropdown').disabled = true;
            document.getElementById('variantDropdown').textContent = 'Variant';
            document.getElementById('variantInput').value = '';
            document.getElementById('variantList').innerHTML = '';
        }
    })
    .catch(error => console.error('Error in overall dropdown update process:', error));
}

function fetchModels(make) {
    const modelDropdownList = document.getElementById('modelList');
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
            modelDropdownList.innerHTML = '';
            let validModels = [];
            if (data.models && Array.isArray(data.models)) {
                validModels = data.models.filter(model => model && model.model);
                validModels.forEach(model => {
                    const isSelected = String(model.model) === String(window.currentFilters.model);
                    const displayContent = isSelected ? `✓ ${model.model}` : model.model;
                    
                    const listItem = document.createElement('li');
                    listItem.innerHTML = `
                        <a class="dropdown-item ${isSelected ? 'selected-option' : ''}" href="javascript:void(0)"
                           onclick="updateDropdownText('${model.model}', 'modelDropdown', 'modelInput')">
                            ${displayContent}&nbsp;&nbsp;&nbsp;&nbsp;(${model.count || 0})
                        </a>`;
                    modelDropdownList.appendChild(listItem);
                });
            }

            const modelDropdownBtn = document.getElementById('modelDropdown');
            const modelInput = document.getElementById('modelInput');

            if (modelDropdownList.children.length > 0) {
                modelDropdownBtn.disabled = false;
            } else {
                modelDropdownBtn.disabled = true;
                modelDropdownBtn.textContent = 'Model';
                modelInput.value = '';
                window.currentFilters.model = '';
                clearDependentFilters(['variant']);
            }

            const currentSelectedModel = window.currentFilters.model;
            if (currentSelectedModel) {
                const isStillValid = validModels.some(model => String(model.model) === String(currentSelectedModel));
                if (!isStillValid) {
                    console.log(`Clearing model filter: '${currentSelectedModel}' is no longer valid.`);
                    modelDropdownBtn.textContent = 'Model';
                    modelInput.value = '';
                    window.currentFilters.model = '';
                    clearDependentFilters(['variant']);
                }
            } else {
                 modelDropdownBtn.textContent = 'Model';
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
            variantDropdownList.innerHTML = '';
            let validVariants = [];
            if (data.variants && Array.isArray(data.variants)) {
                validVariants = data.variants.filter(variant => variant && variant.variant);
                validVariants.forEach(variant => {
                    const isSelected = String(variant.variant) === String(window.currentFilters.variant);
                    const displayContent = isSelected ? `✓ ${variant.variant}` : variant.variant;
                    
                    const listItem = document.createElement('li');
                    listItem.innerHTML = `
                        <a class="dropdown-item ${isSelected ? 'selected-option' : ''}" href="javascript:void(0)"
                           onclick="updateDropdownText('${variant.variant}', 'variantDropdown', 'variantInput')">
                            ${displayContent}&nbsp;&nbsp;&nbsp;&nbsp;(${variant.count || 0})
                        </a>`;
                    variantDropdownList.appendChild(listItem);
                });
            }

            const variantDropdownBtn = document.getElementById('variantDropdown');
            const variantInput = document.getElementById('variantInput');

            if (variantDropdownList.children.length > 0) {
                variantDropdownBtn.disabled = false;
            } else {
                variantDropdownBtn.disabled = true;
                variantDropdownBtn.textContent = 'Variant';
                variantInput.value = '';
                window.currentFilters.variant = '';
            }

            const currentSelectedVariant = window.currentFilters.variant;
            if (currentSelectedVariant) {
                const isStillValid = validVariants.some(variant => String(variant.variant) === String(currentSelectedVariant));
                if (!isStillValid) {
                    console.log(`Clearing variant filter: '${currentSelectedVariant}' is no longer valid.`);
                    variantDropdownBtn.textContent = 'Variant';
                    variantInput.value = '';
                    window.currentFilters.variant = '';
                }
            } else {
                variantDropdownBtn.textContent = 'Variant';
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
            const dropdown = document.getElementById(`${key}Dropdown`);
            const input = document.getElementById(`${key}Input`);
            const list = document.getElementById(`${key}List`);

            if (dropdown) {
                dropdown.textContent = fieldLabels[key] || key.charAt(0).toUpperCase() + key.slice(1);
            }
            if (input) {
                input.value = '';
            }
            if (list) {
                list.innerHTML = '';
            }
        }
    }

    document.getElementById('modelDropdown').disabled = true;
    document.getElementById('variantDropdown').disabled = true;

    updateAllDropdowns();
    updateSearchCount();
}

function updateSearchCount() {
    const allInputs = document.querySelectorAll('input[type="hidden"], input[type="text"]');
    const formData = new FormData();
    allInputs.forEach(input => {
        if (input.name && input.value) {
            formData.append(input.name, input.value);
        }
    });

    const token = document.querySelector('meta[name="csrf-token"]').content;
    const searchButton = document.getElementById('searchButton');

    if (searchButton) {
        searchButton.textContent = 'Searching...';
        searchButton.disabled = true;
        searchButton.classList.add('btn-disabled-custom');
    }

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
            const carCount = data.count ?? 0;
            if (searchButton) {
                searchButton.textContent = `Search\u00A0\u00A0(${carCount} cars)`;

                if (carCount === 0) {
                    searchButton.disabled = true;
                    searchButton.classList.add('btn-disabled-custom');
                } else {
                    searchButton.disabled = false;
                    searchButton.classList.remove('btn-disabled-custom');
                }
            }
        })
        .catch(error => {
            console.error('Error updating search count:', error);
            if (searchButton) {
                searchButton.disabled = true;
                searchButton.textContent = `No cars found`;
                searchButton.classList.add('btn-disabled-custom');
            }
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

