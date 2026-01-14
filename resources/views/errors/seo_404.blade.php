@extends('layout.layout')

@section('body')

<style>
    @media (max-width: 768px) {
    .filteritems .btn:not([style*="background-color: #D6DDF5"]) {
        display: none !important;
    }
    .filteritems .btn[style*="background-color: #D6DDF5"] {
        display: inline-flex !important;
    }
    .filteritems {
        gap: 0.5rem !important;
    }
   

}
@media (min-width: 769px) {
    .dropdown-menu.show {
    max-height: 250px;       
  overflow-y: auto;       

}
   

}
.scrollable-dropdown {
    max-height: 200px;
    overflow-y: auto;
    border: 1px solid #ccc;
    padding: 0;
    margin: 0;
}

.dropdown-menu {

    width: 100%;

    box-sizing: border-box;
    text-align: left;
    white-space: nowrap;

}
.filter-scroll-container {
    position: fixed;
    left: 50%;
    bottom: 20px;
    transform: translateX(-50%);
    z-index: 997;
    display: flex;

}

.filter-scroll-button {
    background-color: #D6DDF5;
    color: black;
    border: 2px solid #D6DDF5;
    border-radius: 10px;
    padding: 10px 20px;
    cursor: pointer;
}
.filter-scroll-container .filter-scroll-button:first-child {
    border-bottom-right-radius: 0;
    border-top-right-radius: 0;
    border-right: 2px solid white;

}
.filter-scroll-container .filter-scroll-button:last-child {
    border-bottom-left-radius: 0;
    border-top-left-radius: 0;

}

button[disabled] {
    border: none;
    background-color: transparent;
    pointer-events: none;
    box-shadow: none;
}

.dropdown-toggle[disabled]::after {
    content: none;
}

form {
    padding-bottom: 20px;
}
.search_color {
    background-color:rgb(255, 255, 255) !important;
}

@media (max-width: 768px) {
    #searchButton {
        padding-bottom: 0;
    }
}
@media (min-width: 999px) {
    #topbarpadding {
    position: sticky;
    top: 0;
    z-index: 1000; /* Ensures it stays on top */
    background: white; /* Add a background to avoid transparency issues */
    border: none;
    box-shadow: none; /* Removes any shadow */
    height: 70px !important;
}
.desktopfooter{
    padding-top: 30px;
}

}
.scroll-to-top {
        display: none;
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: white;
        color: black;
        border: 2px solid black;
        border-radius: 10px;
        padding: 10px 15px;
        cursor: pointer;
        font-size: 16px;
        z-index: 1000;
    }

    /* Show the button only on small screens */
    @media (max-width: 768px) {
        .scroll-to-top {
            display: block;
        }
    }

    
    @media screen and (max-width: 990px) {
    
        .filteritems {
            display: flex !important;
            flex-wrap: nowrap !important;
            /* Prevent wrapping */
            align-items: center !important;
            /* Align vertically */
            justify-content: flex-start !important;
            /* Align to left */
            overflow-x: auto !important;
            /* Enable horizontal scrolling if needed */
            white-space: nowrap !important;
            padding: 10px !important;
            padding-left: 0px !important;
            gap: 10px !important;
        }
    
        .filteritems button:not(:has(span)) {
            display: none !important;
        }
    
        .filteritems div {
            display: inline-block !important;
            min-width: 100px !important;
            text-align: center !important;
            background: #eee !important;
            padding: 10px !important;
            border-radius: 5px !important;
        }
    
        #usedcarsfound {
    
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }
    
        #mobilelayout {
    
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
    
        .filter-button {
            display: block !important;
            
        }
        .filter-button {
            display: none !important;
        }
    
        #filterModal {
            padding: 0 !important;
            background: white !important;
        }
    
        #filterModal .modal-dialog {
            margin: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
            height: 100vh !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
        }
    
        #filterModal .modal-content {
            border-radius: 0 !important;
            margin-top: -50px !important;
           padding-top:0 !important;
                 
            background: white !important;
            border: none !important;
            height: 100vh !important;
            display: flex !important;
            flex-direction: column !important;
            box-shadow: none !important;
         
        }
    
        #filterModal .modal-header {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            background: white !important;
            z-index: 1000 !important;
            padding: 1rem !important;
            border: none !important;
      
     
        }
    
        #filterModal .modal-body {
            
            flex: 1 !important;
            overflow-y: auto !important;
            padding: 1rem !important;
            /* margin-top: 20px !important; */
            margin-bottom: 100px !important;
            padding-top: 0px !important;
            margin-top: 0px !important;
                
           
        }
    
        #filterModal .modal-footer {
            position: fixed !important;
            bottom: 5% !important;
            left: 0 !important;
            right: 0 !important;
            background: white !important;
            z-index: 1000 !important;
            padding: 1rem !important;
            border: none !important;
        }
        .bottonbuttons{
            margin-bottom: 20px !important;
        }
     
       
    
    }
    .paddingmobile{
            margin-bottom: 5px !important;
           
        }
    
        .paddingmobile {
        position: relative;
        padding-bottom: 10px; /* Space before the line */
    }
    
    .paddingmobile::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 5%;
        width: 90% !important;
        height: 1px;
        background-color: #ccc; /* Light grey separator */
    }
    @media screen and (max-width: 990px) {
        #externalDropdownList {
            list-style: none;
            padding: 30px !important;
            margin: 0;
        }

        #externalDropdownList li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd; 
            font-size: 16px;
            position: relative;
        }

        
        #externalDropdownList li:last-child {
            border-bottom: none;
        }

        /* Adding an unfilled black circle at the end of each list item */
        #externalDropdownList li::after {
            content: "";
            width: 12px; /* Adjust size of the circle */
            height: 12px;
            border: 2px solid black; /* Black border for unfilled effect */
            border-radius: 50%;
            margin-left: 10px;
        }

        .search-form-modal {
            display: none;
            position: fixed;
            z-index: 1002;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.775);
            padding-top: 60px;
        }


        .closemobile {
            color: #aaa;
            float: right !important;
            font-size: 35px;
            font-weight: bold;
            cursor: pointer;
            top: 20px;
            margin-left: auto;
         
            margin-right: 10px;

        }

        .closemobile:hover,
        .closemobile:focus {
            color: black;
            text-decoration: none;
        }

        .modal-contentmobile {
            width: 300px;
            height: 400px;
            overflow-y: auto;
            border: 2px solid red;
            background-color: #fefefe;
            border: 1px solid #888;
            border-radius: 10px;
            position: relative;
            top: 14%;
            left: 8%;
        }

}

.dropdown-toggle::after {
    display: none;
}

.dropdown-toggle .fa-chevron-down {
    font-size: 12px;
    color: #888;
    transition: transform 0.2s ease;

}

.modal.fade .modal-dialog {
    transform: translateY(100%);
    transition: transform 0.3s ease-out;
}

.modal.show .modal-dialog {
    transform: translateY(0);
}

.modal-dialog {
    transform: translateX(-50%);
}

@media screen and (min-width: 991px) {
    .filter-button {
        position: static;
        transform: none;
      
    }
}
</style>
 <form id="filterForm" action="{{ route('search_car') }}" method="GET" style="display: none;">
     <!-- Filter inputs -->
     <input type="text" id="make" name="make" />
     <input type="text" id="model" name="model" />
     <input type="text" id="variant" name="variant" />
     <input type="text" id="fuel_type" name="fuel_type" />
     <input type="text" id="miles" name="miles" />
     <input type="text" id="seller_type" name="seller_type" />
     <input type="text" id="gear_box" name="gear_box" />
     <input type="text" id="body_type" name="body_type" />
     <input type="text" id="doors" name="doors" />
     <input type="text" id="engine_size" name="engine_size" />
     <input type="text" id="colors" name="colors" />
     <input type="text" id="price_from" name="price_from" />
     <input type="text" id="price_to" name="price_to" />
     <input type="text" id="year" name="year" />
     <input type="text" id="year_from" name="year_from" />
 </form>
 <section class="text-center" style="margin-top:10px;">
     <div class="container">
         <div class="d-flex justify-content-between align-items-center" id="topbarpadding">
             <div class="filteritems d-flex flex-wrap gap-2" id="selectedFilters" style="">
             <?php if (!empty($makeselected)) : ?>
    <button style="background-color: #D6DDF5"
        class="btn btn-sm d-inline-flex align-items-center w-auto px-2" id="makeFilterButton" data-bs-toggle="modal"
        data-bs-target="#filterModal" data-filter-name="make">
        <?= htmlspecialchars($makeselected) ?>
        <span class="ms-1" onclick="clearFilters()" style="cursor: pointer;">&times;</span>
    </button>
<?php else : ?>
    <button style="background-color: white; color:black; border:2px solid black; border-radius:10px;"
        class="btn btn-sm d-inline-flex align-items-center w-auto px-2" data-bs-toggle="modal"
        data-bs-target="#filterModal" data-filter-name="make">
        + Make
    </button>
<?php endif; ?>

<?php if (!empty($makeselected)) : ?>
    <?php if (!empty($modelselected)) : ?>
        <button style="background-color: #D6DDF5"
            class="btn btn-sm d-inline-flex align-items-center w-auto px-2" id="modelFilterButton" data-bs-toggle="modal"
            data-bs-target="#filterModal" data-filter-name="model">
            <?= htmlspecialchars($modelselected) ?>
            <span class="ms-1" onclick="removeFilter('modelFilterButton', 'modelInput')"
                style="cursor: pointer;">&times;</span>
        </button>
    <?php else : ?>
        <button style="background-color: white; color:black; border:2px solid black; border-radius:10px;"
            class="btn btn-sm d-inline-flex align-items-center w-auto px-2" data-bs-toggle="modal"
            data-bs-target="#filterModal" data-filter-name="model">
            + Model
        </button>
    <?php endif; ?>
<?php endif; ?>

<?php if (!empty($makeselected) && !empty($modelselected)) : ?>
    <?php if (!empty($variantselected)) : ?>
        <button style="background-color: #D6DDF5"
            class="btn btn-sm d-inline-flex align-items-center w-auto px-2" id="variantFilterButton" data-bs-toggle="modal"
            data-bs-target="#filterModal" data-filter-name="variant">
            <?= htmlspecialchars($variantselected) ?>
            <span class="ms-1" onclick="removeFilter('variantFilterButton', 'variantInput')"
                style="cursor: pointer;">&times;</span>
        </button>
    <?php else : ?>
        <button style="background-color: white; color:black; border:2px solid black; border-radius:10px;"
            class="btn btn-sm d-inline-flex align-items-center w-auto px-2" data-bs-toggle="modal"
            data-bs-target="#filterModal" data-filter-name="variant">
            + Variant
        </button>
    <?php endif; ?>
<?php endif; ?>




<?php
function formatPrice($price) {
    return '£' . number_format($price, 0, '.', ',');
}

if (!empty($pricefromselected)) {
    $displayText = formatPrice($pricefromselected);
    ?>
    <button style="background-color: #D6DDF5"
        class="btn btn-sm d-inline-flex align-items-center w-auto px-2" id="priceFromFilterButton"  data-bs-toggle="modal"
        data-bs-target="#filterModal" data-filter-name="pricefrom">
        <?= htmlspecialchars($displayText) ?>
        <span class="ms-1" onclick="removeFilter('priceFromFilterButton', 'pricefromInput')"
            style="cursor: pointer;">&times;</span>
    </button>
<?php } else { ?>
    <button style="background-color: white; color:black; border:2px solid black; border-radius:10px;"
        class="btn btn-sm d-inline-flex align-items-center w-auto px-2" data-bs-toggle="modal"
        data-bs-target="#filterModal" data-filter-name="pricefrom" >
        + Price From
    </button>
<?php }

if (!empty($pricetoselected)) {
    $displayText = formatPrice($pricetoselected);
    ?>
    <button style="background-color: #D6DDF5"
        class="btn btn-sm d-inline-flex align-items-center w-auto px-2" id="priceToFilterButton" data-bs-toggle="modal"
        data-bs-target="#filterModal" data-filter-name="priceto">
        <?= htmlspecialchars($displayText) ?>
        <span class="ms-1" onclick="removeFilter('priceToFilterButton', 'pricetoInput')"
            style="cursor: pointer;">&times;</span>
    </button>
<?php } else { ?>
    <button style="background-color: white; color:black; border:2px solid black; border-radius:10px;"
        class="btn btn-sm d-inline-flex align-items-center w-auto px-2" data-bs-toggle="modal"
        data-bs-target="#filterModal" data-filter-name="priceto">
        + Price To
    </button>
<?php } ?>



                 <?php
    $other_filters = [
        'yearfrom' => ['label' => 'Year From', 'selected' => $yearfromselected ?? null, 'input_id' => 'yearFromInput', 'button_id' => 'yearFromFilterButton'],
        'yearto' => ['label' => 'Year To', 'selected' => $yeartoselected ?? null, 'input_id' => 'yearToInput', 'button_id' => 'yearToFilterButton'],
        'fuel_type' => ['label' => 'Fuel Type', 'selected' => $fuel_typeselected ?? null, 'input_id' => 'fuel_typeInput', 'button_id' => 'fuelTypeFilterButton'],
        'miles' => ['label' => 'Miles', 'selected' => $milesselected ?? null, 'input_id' => 'milesInput', 'button_id' => 'milesFilterButton'],
        'colors' => ['label' => 'Color', 'selected' => $colorsselected ?? null, 'input_id' => 'colorsInput', 'button_id' => 'colorsFilterButton'],
       
    ];

    foreach ($other_filters as $filter_key => $filter_data) {
        if (!empty($filter_data['selected'])) {
            echo '<button style="background-color: #D6DDF5" class="btn btn-sm d-inline-flex align-items-center w-auto px-2" id="' . $filter_data['button_id'] . '" data-filter-name="' . $filter_key . '">';
            echo htmlspecialchars($filter_data['selected']);
            echo '<span class="ms-1" onclick="removeFilter(\'' . $filter_data['button_id'] . '\', \'' . $filter_data['input_id'] . '\')" style="cursor: pointer;">&times;</span>';
            echo '</button>';
        } else {
            echo '<button style="background-color: white; color:black; border:2px solid black; border-radius:10px;" class="btn btn-sm d-inline-flex align-items-center w-auto px-2" data-bs-toggle="modal" data-bs-target="#filterModal" data-filter-name="' . $filter_key . '">';
            echo '+ ' . $filter_data['label'];
            echo '</button>';
        }
    }
?>


                 <?php if (!empty($makeselected) || !empty($modelselected) || (!empty($pricefromselected) && !empty($pricetoselected))) : ?>
                 <button style="background-color: white; color:red; border:2px solid red; border-radius:10px;"
                     class="btn btn-sm d-inline-flex align-items-center w-auto px-2" onclick="clearFilters()">
                     Clear All
                 </button>
                 <?php endif; ?>
             </div>

                <!-- For desktop -->
                <button style="background-color: white; color:black; border:2px solid black; border-radius:10px;"
                    type="button" class="btn btn-sm d-none d-md-block"
                    onclick="window.location.href='/searchcar'">
                    Filter & Sort <i class="fas fa-filter"></i>
                </button>

                <!-- For mobile -->
                <div class="filter-scroll-container d-md-none">
                    <button class="filter-scroll-button" onclick="window.location.href='/searchcar'">
                        <strong>Filter</strong>
                    </button>
                    <button class="filter-scroll-button" onclick="scrollToTop()">
                        <i class="fas fa-arrow-up"></i>
                    </button>
                </div>


        

               

         </div>
         <div class="d-flex justify-content-start align-items-center">
            <h1 style="font-size: 18px; font-weight: bold; padding-left: 0 !important;">Sorry no cars are currently available for your search</h1>
         </div>
         
         <div class="col-12 col-md-4 col-lg-3 column1" style="text-align:start; margin-top:5px; font-weight: bold; ">
           
             <p>0 used cars found</p>
         </div>
    

        <section class="text-center mobilecontainer" style="margin-top:10px;">
             <h1 class="business-name" style="font-size: 34px;">More Cars for Sale</h1>
        <div class="container">
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
                                    <div class="p-3">
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
                
            </div>
            
        </div>
       

    </section>

        <div id="loading" style="display: none; text-align: center; margin-top: 20px;">
            <p>Loading more cars...</p>
        </div>
     </div>
 </section>
 <script>
    let isLoading = false;
    let nextPageUrl = document.getElementById('mobilelayout').dataset.nextPageUrl;

    window.addEventListener('scroll', function () {
        if (isLoading || !nextPageUrl) return;

        const scrollPosition = window.scrollY + window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight;

        if (scrollPosition > documentHeight - 1200) { // Trigger 200px before bottom
            isLoading = true;
            document.getElementById('loading').style.display = 'block';

            fetch(nextPageUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('mobilelayout').insertAdjacentHTML('beforeend', data.html);
                nextPageUrl = data.next_page_url;
                document.getElementById('mobilelayout').dataset.nextPageUrl = nextPageUrl;
                isLoading = false;
                document.getElementById('loading').style.display = 'none';
            })
            .catch(error => {
                console.error('Error loading more cars:', error);
                isLoading = false;
                document.getElementById('loading').style.display = 'none';
            });
        }
    });

    // Update filter form submission to use AJAX
    document.querySelector('#filterModal form').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch(this.action, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('mobilelayout').innerHTML = data.html;
            document.getElementById('usedcarsfound').textContent = `${data.current_page * 20} cars found`;
            nextPageUrl = data.next_page_url;
            document.getElementById('mobilelayout').dataset.nextPageUrl = nextPageUrl;
            bootstrap.Modal.getInstance(document.getElementById('filterModal')).hide();
        })
        .catch(error => console.error('Error applying filters:', error));
    });

    // Update clearFilters function to reset via AJAX
    function clearFilters() {
        fetch('{{ route('search_car') }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('mobilelayout').innerHTML = data.html;
            document.getElementById('usedcarsfound').textContent = `${data.current_page * 20} cars found`;
            nextPageUrl = data.next_page_url;
            document.getElementById('mobilelayout').dataset.nextPageUrl = nextPageUrl;
            // Reset filter buttons
            document.querySelectorAll('.filteritems button').forEach(btn => {
                if (btn.textContent.includes('×')) {
                    btn.remove();
                }
            });
        })
        .catch(error => console.error('Error clearing filters:', error));
    }

    // Update removeFilter function to use AJAX
    function removeFilter(buttonId, inputId) {
        document.getElementById(inputId).value = '';
        const form = document.querySelector('#filterModal form');
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('mobilelayout').innerHTML = data.html;
            document.getElementById('usedcarsfound').textContent = `${data.current_page * 20} cars found`;
            nextPageUrl = data.next_page_url;
            document.getElementById('mobilelayout').dataset.nextPageUrl = nextPageUrl;
            document.getElementById(buttonId).remove();
        })
        .catch(error => console.error('Error removing filter:', error));
    }
</script>




 

 </div>
 </div>
<script>
    function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// the below function is in debugging mode to check on fileds 
function removeFilter(buttonId, inputId) {
    // Prevent event propagation (using window.event as fallback)
    const evt = event || window.event;
    if (evt) {
        evt.stopPropagation();
    }
    
    console.log("Removing filter:", buttonId, inputId); // Debug logging
    
    // Remove the filter button from UI
    const filterButton = document.getElementById(buttonId);
    if (filterButton) {
        filterButton.remove();
    } else {
        console.log("Filter button not found:", buttonId);
    }
    
    // Clear the hidden input value
    const inputElement = document.getElementById(inputId);
    if (inputElement) {
        inputElement.value = '';
        console.log("Cleared input:", inputId);
    } else {
        console.log("Input element not found:", inputId);
    }
    
    // Find and submit the form
    const form = document.querySelector('form[method="GET"][action*="search_car"]');
    if (form) {
        console.log("Form found, submitting...");
        
        // Special handling for price and year filters
        const specialFilterMappings = {
            'pricefromInput': 'price_from',
            'pricetoInput': 'price_to',
            'yearFromInput': 'year_from',
            'yearToInput': 'year'  // Note the change here to 'year'
        };
        
        // If it's a special filter, ensure we clear both related inputs
        if (specialFilterMappings[inputId]) {
            const relatedInputId = inputId === 'pricefromInput' ? 'pricetoInput' : 
                                   inputId === 'pricetoInput' ? 'pricefromInput' : 
                                   inputId === 'yearFromInput' ? 'yearToInput' : 
                                   'yearFromInput';
            
            const relatedInputElement = document.getElementById(relatedInputId);
            if (relatedInputElement) {
                relatedInputElement.value = '';
            }
        }
        
        setTimeout(() => {
            form.submit();
        }, 100); // Small delay to ensure input clearing is complete
    } else {
        console.log("Form not found!");
        // Fallback: redirect with current URL parameters minus the removed filter
        const url = new URL(window.location.href);
        const filterName = inputId.replace('Input', '').toLowerCase();
        url.searchParams.delete(filterName);
        
        // Special handling for price and year
        const specialFilterMappings = {
            'pricefrom': ['price_from'],
            'priceto': ['price_to'],
            'yearfrom': ['year_from'],  
            'yearto': [ 'year']    
        };
        
        if (specialFilterMappings[filterName]) {
            specialFilterMappings[filterName].forEach(param => {
                url.searchParams.delete(param);
            });
        }
        
        window.location.href = url.toString();
    }
}



function removeFilterAlternative(buttonId, inputId) {
    // Prevent event propagation
    if (event) event.stopPropagation();
    
    // Remove the filter button from UI
    const filterButton = document.getElementById(buttonId);
    if (filterButton) {
        filterButton.remove();
    }
    
    // Clear the hidden input value
    const inputElement = document.getElementById(inputId);
    if (inputElement) {
        inputElement.value = '';
    }
    
    // Get all active inputs and build a query string
    const queryParams = new URLSearchParams();
    
    // Map of input IDs to parameter names
    const inputMapping = {
        'makeInput': 'make',
        'modelInput': 'model',
        'variantInput': 'variant',
        'pricefromInput': 'pricefrom',
        'pricetoInput': 'priceto',
        'yearFromInput': 'yearfrom', 
        'yearToInput': 'yearto',
        'fuel_typeInput': 'fuel_type',
        'milesInput': 'miles',
        'colorsInput': 'colors',
        'doorsInput': 'doors',
        'body_typeInput': 'body_type'
    };
    
    Object.keys(inputMapping).forEach(id => {
        const input = document.getElementById(id);
        if (input && input.value) {
            queryParams.append(inputMapping[id], input.value);
        }
    });
    
 
    const searchUrl = `${window.location.pathname}?${queryParams.toString()}`;
    window.location.href = searchUrl;
}
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector("[data-filter-name='make']").addEventListener("click", function() {
        setTimeout(function() {
            document.getElementById("makeDropdown").click();
        }, 300);
    });

    document.querySelector("[data-filter-name='pricefrom']").addEventListener("click", function() {
        setTimeout(function() {
            document.getElementById("pricefromDropdown").click();
        }, 300);
    });
    document.querySelector("[data-filter-name='priceto']").addEventListener("click", function() {
        setTimeout(function() {
            document.getElementById("pricetoDropdown").click();
        }, 300);
    });

    document.querySelector("[data-filter-name='miles']").addEventListener("click", function() {
        setTimeout(function() {
            document.getElementById("milesDropdown").click();
        }, 300);
    });

    document.querySelector("[data-filter-name='yearfrom']").addEventListener("click", function() {
        setTimeout(function() {
            document.getElementById("yearFromDropdown").click();
        }, 300);
    });

    document.querySelector("[data-filter-name='yearto']").addEventListener("click", function() {
        setTimeout(function() {
            document.getElementById("yearToDropdown").click();
        }, 300);
    });

    document.querySelector("[data-filter-name='fuel_type']").addEventListener("click", function() {
        setTimeout(function() {
            document.getElementById("fuel_typeDropdown").click();
        }, 300);
    });

    document.querySelector("[data-filter-name='colors']").addEventListener("click", function() {
        setTimeout(function() {
            document.getElementById("colorsDropdown").click();
        }, 300);
    });

    document.querySelector("[data-filter-name='doors']").addEventListener("click", function() {
        setTimeout(function() {
            document.getElementById("doorsDropdown").click();
        }, 300);
    });

    document.querySelector("[data-filter-name='body_type']").addEventListener("click", function() {
        setTimeout(function() {
            document.getElementById("body_typeDropdown").click();
        }, 300);
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const dropdownButtons = document.querySelectorAll('.dropdown-toggle');

    dropdownButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            if (isMobile()) {
                event.preventDefault();
                const dropdownId = this.getAttribute('id');
                const dropdownItems = this.nextElementSibling.querySelectorAll(
                '.dropdown-item');
                openExternalDropdown(dropdownId, dropdownItems);
            }
        });
    });

    
});

function isMobile() {
    return window.innerWidth <= 768; // Adjust the breakpoint as needed
}

function openExternalDropdown(dropdownId, dropdownItems) {
    const externalDropdownList = document.getElementById('externalDropdownList');
    externalDropdownList.innerHTML = '';

    dropdownItems.forEach(item => {
        const listItem = document.createElement('li');
        listItem.innerHTML = item.innerHTML;
        listItem.addEventListener('click', function() {
            item.click();
            closeExternalDropdown();
        });
        externalDropdownList.appendChild(listItem);
    });

    document.getElementById('externalDropdown').style.display = 'block';

}

function closeExternalDropdown() {
    document.getElementById('externalDropdown').style.display = 'none';
}



function updateMilesDropdown(fieldName, options) {
    const dropdown = document.getElementById(`${fieldName}Dropdown`).nextElementSibling;
    const dropdownButton = document.getElementById(`${fieldName}Dropdown`);

    if (!dropdownButton) {
        console.error(`Dropdown button not found for ${fieldName}`);
        return;
    }

    if (dropdown) {
        let html = `
           <li>
               <a class="dropdown-item" href="javascript:void(0)"
                  onclick="updateDropdownText('Any', '${fieldName}Dropdown', '${fieldName}Input')">
                   Any
               </a>
           </li>
       `;

        options.forEach(option => {
            html += `
               <li>
                   <a class="dropdown-item" href="javascript:void(0)"
                      data-value="${option.value}"
                      onclick="updateDropdownText('${option.value}', '${fieldName}Dropdown', '${fieldName}Input', '${option.label}')">
                       ${option.label} (${option.count})
                   </a>
               </li>
           `;
        });

        dropdown.innerHTML = html;
    }
}



document.addEventListener('DOMContentLoaded', function() {

    window.currentFilters = {
        make: '',
        model: '',
        variant: '',
        fuel_type: '',
        body_type: '',
        engine_size: '',
        doors: '',
        colors: '',
        seller_type: '',
        gear_box: '',
        miles: '',
        yearFrom: '',
        yearTo: '',
        pricefrom: '',
        priceto: ''
    };
    const formatDisplayPrice = (price) => {
        if (!price || price === 'Any') return 'Any';


        const parsedPrice = parseFloat(price.toString().replace(/[,£]/g, ''));
        if (isNaN(parsedPrice)) return 'Any';


        return `£${parsedPrice.toLocaleString('en-GB')}`;
    };
    window.onload = function() {


        const makeselected = "{{ $makeselected ?? '' }}";
        const modelselected = "{{ $modelselected ?? '' }}";
        const variantselected = "{{ $variantselected ?? '' }}";
        const engine_sizeselected = "{{ $engine_sizeselected ?? '' }}";
        const doorsselected = "{{ $doorsselected ?? '' }}";
        const colorsselected = "{{ $colorsselected ?? '' }}";
        const body_typeselected = "{{ $body_typeselected ?? '' }}";
        const gear_boxselected = "{{ $gear_boxselected ?? '' }}";
        const fuel_typeselected = "{{ $fuel_typeselected ?? '' }}";
        const seller_typeselected = "{{ $seller_typeselected ?? '' }}";
        const milesselected = "{{ $milesselected ?? '' }}";
        const yeartoselected = "{{ $yeartoselected ?? '' }}";
        const yearfromselected = "{{ $yearfromselected ?? '' }}";
        const pricetoselected = "{{ $pricetoselected ?? '' }}";
        const pricefromselected = "{{ $pricefromselected ?? '' }}";




        if (makeselected) {
            if (document.getElementById('makeDropdown').textContent !== makeselected) {
                updateDropdownText(makeselected, 'makeDropdown', 'makeInput');
            }
        }






        if (modelselected) {

            if (document.getElementById('modelDropdown').textContent !== modelselected) {
                updateDropdownText(modelselected, 'modelDropdown', 'modelInput');
            }
        }

        if (variantselected) {

            if (document.getElementById('variantDropdown').textContent !== variantselected) {
                updateDropdownText(variantselected, 'variantDropdown', 'variantInput');
            }
        }

        if (engine_sizeselected) {

            if (document.getElementById('engine_sizeDropdown').textContent !== engine_sizeselected) {
                updateDropdownText(engine_sizeselected, 'engine_sizeDropdown', 'engine_sizeInput');
            }
        }
        if (doorsselected) {

            if (document.getElementById('doorsDropdown').textContent !== doorsselected) {
                updateDropdownText(doorsselected, 'doorsDropdown', 'doorsInput');
            }
        }
        if (colorsselected) {

            if (document.getElementById('colorsDropdown').textContent !== colorsselected) {
                updateDropdownText(colorsselected, 'colorsDropdown', 'colorsInput');
            }
        }
        if (body_typeselected) {

            if (document.getElementById('body_typeDropdown').textContent !== body_typeselected) {
                updateDropdownText(body_typeselected, 'body_typeDropdown', 'body_typeInput');
            }
        }
        if (gear_boxselected) {

            if (document.getElementById('gear_boxDropdown').textContent !== gear_boxselected) {
                updateDropdownText(gear_boxselected, 'gear_boxDropdown', 'gear_boxInput');
            }
        }
        if (fuel_typeselected) {

            if (document.getElementById('fuel_typeDropdown').textContent !== fuel_typeselected) {
                updateDropdownText(fuel_typeselected, 'fuel_typeDropdown', 'fuel_typeInput');
            }
        }
        if (seller_typeselected) {

            if (document.getElementById('seller_typeDropdown').textContent !== seller_typeselected) {
                updateDropdownText(seller_typeselected, 'seller_typeDropdown', 'seller_typeInput');

            }
        }
      
        if (yeartoselected) {
            if (document.getElementById('yearToDropdown').textContent !== yeartoselected) {
                updateDropdownText(yeartoselected, 'yearToDropdown', 'yearToInput');
            }
        }
        if (yearfromselected) {
            if (document.getElementById('yearFromDropdown').textContent !== yearfromselected) {
                updateDropdownText(yearfromselected, 'yearFromDropdown', 'yearFromInput');
            }
        }

        if (pricetoselected) {
            const formattedPrice = formatDisplayPrice(pricetoselected);
            if (document.getElementById('pricetoDropdown').textContent !== formattedPrice) {
                updateDropdownText(pricetoselected, 'pricetoDropdown', 'pricetoInput', formattedPrice);
            }
        }

        if (pricefromselected) {
            const formattedPrice = formatDisplayPrice(pricefromselected);
            if (document.getElementById('pricefromDropdown').textContent !== formattedPrice) {
                updateDropdownText(pricefromselected, 'pricefromDropdown', 'pricefromInput',
                    formattedPrice);
            }
        }



    };
  

    window.updateDropdownText = function (value, dropdownId, inputId, displayLabel = null) {
    const dropdown = document.getElementById(dropdownId);
    const input = document.getElementById(inputId);
    const labelMapping = {
        "car_dealer": "Dealer",
        "private_seller": "Private"
    };
    let displayText = labelMapping[value] || displayLabel || value;
    if (value !== "Any" && 
        dropdownId !== "pricetoDropdown" && 
        dropdownId !== "pricefromDropdown" &&
        displayText.length > 27) {
        displayText = displayText.substring(0, 27) + '...';
    }

    if (dropdown && input) {
        dropdown.textContent = displayText;
        input.value = value === "Any" ? "" : value;

        const filterName = inputId.replace("Input", "").toLowerCase();
        window.currentFilters[filterName] = input.value;
        enableNextDropdown(dropdownId);
        updateAllDropdowns();
        updateSearchCount();

        if (dropdownId === "makeDropdown") {
            if (value === "Any") {
                clearModelAndVariant();
                delete window.currentFilters.make;
                delete window.currentFilters.model;
                delete window.currentFilters.variant;
            } else {
                fetchModels(value);
            }
        } else if (dropdownId === "modelDropdown") {
            if (value === "Any") {
                clearVariant();
            } else {
                fetchVariants(value);
            }
        } else if (dropdownId === "variantDropdown") {
            if (value === "Any") {
                clearVariantValues();
            }
        } else if (dropdownId === "pricefromDropdown" || dropdownId === "pricetoDropdown") {
            const displayValue = displayLabel || formatDisplayPrice(value);
            dropdown.textContent = displayValue;
            input.value = value === "Any" ? "" : value.toString().replace(/[,£]/g, "");
            // Refresh models if a make is selected
            if (window.currentFilters.make) {
                fetchModels(window.currentFilters.make);
            }
        }
    }
};

   
    function clearModelAndVariant() {
    const modelDropdown = document.getElementById('modelDropdown');
    const variantDropdown = document.getElementById('variantDropdown');
    const modelInput = document.getElementById('modelInput');
    const variantInput = document.getElementById('variantInput');

    // Ensure dropdown text is reset
    modelDropdown.textContent = 'Model';
    variantDropdown.textContent = 'Variant';

    // Ensure input values are properly cleared
    modelInput.value = '';
    variantInput.value = '';

    // Clear from filters immediately
    delete window.currentFilters.model;
    delete window.currentFilters.variant;

    // Ensure dropdowns are fully disabled in one go
    modelDropdown.setAttribute('disabled', 'disabled');
    variantDropdown.setAttribute('disabled', 'disabled');

    // Force re-render if needed
    updateAllDropdowns();  
    updateSearchCount();
}

    function clearVariant() {
        const variantDropdown = document.getElementById('variantDropdown');
        const variantInput = document.getElementById('variantInput');
        variantDropdown.textContent = 'Variant';
        variantInput.value = '';
        variantDropdown.setAttribute('disabled', 'disabled');
    }
    function clearVariantValues() {
        const variantDropdown = document.getElementById('variantDropdown');
        const variantInput = document.getElementById('variantInput');
        variantDropdown.textContent = 'Variant';
        variantInput.value = '';
    }



    function formatPrice(price, isUpperBound = false) {
    if (!price) return { value: 0, displayValue: "£0" };
    
    const parsedPrice = parseInt(price);
    
    // Define price buckets
    const ranges = [
        { max: 5000, increment: 500 },
        { max: 10000, increment: 1000 },
        { max: 50000, increment: 5000 },
        { max: 100000, increment: 10000 }
    ];
    
    // For "Price To" (upper bound), we want to round up to the next bucket
    // to ensure we include all vehicles in that price range
    if (isUpperBound) {
        // Find the appropriate bucket where the price falls
        for (const range of ranges) {
            if (parsedPrice <= range.max) {
                // For upper bound, round up to next bucket to be inclusive
                const bucket = Math.ceil(parsedPrice / range.increment) * range.increment;
                
                return {
                    value: bucket,
                    displayValue: `£${bucket.toLocaleString('en-GB')}`
                };
            }
        }
        
        // Fallback for prices above defined ranges
        const highestIncrement = ranges[ranges.length - 1].increment;
        const bucket = Math.ceil(parsedPrice / highestIncrement) * highestIncrement;
        
        return {
            value: bucket,
            displayValue: `£${bucket.toLocaleString('en-GB')}`
        };
    } 
    // Original behavior for "Price From" (lower bound)
    else {
        // Find the appropriate bucket where the price falls
        for (const range of ranges) {
            if (parsedPrice <= range.max) {
                // Calculate which bucket this price falls into
                const bucket = Math.floor(parsedPrice / range.increment) * range.increment;
                
                return {
                    value: bucket,
                    displayValue: `£${bucket.toLocaleString('en-GB')}`
                };
            }
        }
        
        // Fallback for prices above defined ranges
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
        fuel_type: "Fuel Type",
        body_type: "Body Type",
        engine_size: "Engine Size",
        doors: "Doors",
        colors: "Colors",
        seller_type: "Seller Type",
        gear_box: "Gearbox",
        yearFrom: "Year From",
        yearTo: "Year To",
        pricefrom: "Price From",
        priceto: "Price To"
    };

    const sellerTypeLabels = {
        car_dealer: "Dealer",
        private_seller: "Private"
    };

    const dropdown = document.getElementById(`${fieldName}Dropdown`);
    const dropdownMenu = dropdown.nextElementSibling;

    if (!dropdown || !dropdownMenu) {
        console.error(`Dropdown elements not found for ${fieldName}`);
        return;
    }

    // Consolidate options
    const consolidatedOptions = {};

    if (fieldName === 'pricefrom' || fieldName === 'priceto') {
        const isPriceTo = fieldName === 'priceto';
        options.forEach(option => {
            const price = option.pricefrom || option.priceto;
            const formattedPrice = formatPrice(price, isPriceTo);
            if (!consolidatedOptions[formattedPrice.displayValue]) {
                consolidatedOptions[formattedPrice.displayValue] = {
                    value: formattedPrice.value,
                    count: 0
                };
            }
            consolidatedOptions[formattedPrice.displayValue].count += option.count;
        });
    } else {
        options.forEach(option => {
            let value = option[fieldName.toLowerCase()] || option;
            let displayValue = value;

            // Apply seller_type label mapping
            if (fieldName === 'seller_type') {
                // Use seller_type from backend if available, else map original_seller_type
                displayValue = option.seller_type || sellerTypeLabels[value] || value;
                value = option.original_seller_type || value; // Use original_seller_type for backend
            }

            if (!consolidatedOptions[displayValue]) {
                consolidatedOptions[displayValue] = {
                    value: value,
                    count: 0
                };
            }
            consolidatedOptions[displayValue].count += (option.count || 0);
        });
    }

    // Start with "Any" option
    let html = `
        <li>
            <a class="dropdown-item" href="javascript:void(0)"
               onclick="updateDropdownText('Any', '${fieldName}Dropdown', '${fieldName}Input')">
               Any
            </a>
        </li>
    `;

    // Convert to array and sort
    const sortedOptions = Object.entries(consolidatedOptions)
        .map(([displayValue, option]) => ({
            displayValue,
            ...option
        }))
        .filter(option => option.count > 0)
        .sort((a, b) => {
            const numA = parseFloat(a.value);
            const numB = parseFloat(b.value);
            return !isNaN(numA) && !isNaN(numB)
                ? numA - numB
                : a.displayValue.localeCompare(b.displayValue);
        });

    // Add sorted options to dropdown
    sortedOptions.forEach(option => {
        html += `
            <li>
                <a class="dropdown-item" href="javascript:void(0)"
                   onclick="updateDropdownText('${option.value}', '${fieldName}Dropdown', '${fieldName}Input', '${option.displayValue}')">
                    ${option.displayValue} (${option.count})
                </a>
            </li>
        `;
    });

    dropdownMenu.innerHTML = html;

    // Update dropdown button text if no value is selected
    if (!window.currentFilters[fieldName.toLowerCase()]) {
        const label = fieldLabels[fieldName] || fieldName;
        dropdown.textContent = label;
    }
}

function applyPriceFilter() {
    const priceFromInput = document.getElementById('priceFromInput');
    const priceToInput = document.getElementById('priceToInput');
    
    const priceFrom = priceFromInput ? priceFromInput.value : null;
    const priceTo = priceToInput ? priceToInput.value : null;
    
    // Format prices with appropriate rounding based on whether it's an upper or lower bound
    const formattedPriceFrom = formatPrice(priceFrom, false).value;
    const formattedPriceTo = formatPrice(priceTo, true).value;
    
    // Send to server with precise values
    fetchCars({
        priceFrom: formattedPriceFrom,
        priceTo: formattedPriceTo
    });
}

        
  
    function updateAllDropdowns() {

        // const queryParams = new URLSearchParams();
        // for (const [key, value] of Object.entries(window.currentFilters)) {
        //     if (value) {
        //         queryParams.append(key, value);
        //     }
        // }

        // Create query string from current filters
    const queryParams = new URLSearchParams();
    
    const nonMakeFilters = new URLSearchParams();
    for (const [key, value] of Object.entries(window.currentFilters)) {
        if (value && key !== 'make') { // Exclude make filter for this request
            nonMakeFilters.append(key, value);
        }
    }
    
    // Second request: Get other dropdowns with all filters including make
    const allFilters = new URLSearchParams();
    for (const [key, value] of Object.entries(window.currentFilters)) {
        if (value) {
            allFilters.append(key, value);
        }
    }


        fetch(`/get-filtered-fields?${queryParams.toString()}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(makeData => {

                updateDropdownOptions('make', makeData.make);
                
                // Now fetch other dropdown data with all filters including make
                return fetch(`/get-filtered-fields?${allFilters.toString()}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
            })
            .then(response => response.json())
            .then(data => {

                // updateDropdownOptions('make', data.make);
                updateDropdownOptions('fuel_type', data.fuel_type);
                updateDropdownOptions('body_type', data.body_type);
                updateDropdownOptions('engine_size', data.engine_size);
                updateDropdownOptions('doors', data.doors);
                updateDropdownOptions('colors', data.colors);
                updateDropdownOptions('seller_type', data.seller_type);
                updateDropdownOptions('gear_box', data.gear_box);


                const mileRanges = processeMileRanges(data.miles);
                updateMilesDropdown('miles', mileRanges);


                updateDropdownOptions('yearFrom', data.year);
                updateDropdownOptions('yearTo', data.year);
                updateDropdownOptions('pricefrom', data.price);
                updateDropdownOptions('priceto', data.price);
            })
            .catch(error => console.error('Error:', error));
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

    function fetchModels(make) {
    const modelDropdown = document.getElementById('modelList');
    const variantDropdown = document.getElementById('variantList');
    const priceFrom = document.getElementById('pricefromInput').value;
    const priceTo = document.getElementById('pricetoInput').value;

    // Build query string with make and price filters
    let query = `make=${encodeURIComponent(make)}`;
    if (priceFrom) query += `&price_from=${encodeURIComponent(priceFrom)}`;
    if (priceTo) query += `&price_to=${encodeURIComponent(priceTo)}`;

    fetch(`/fetch-models?${query}`)
        .then(response => response.json())
        .then(data => {
            modelDropdown.innerHTML = '';

            // Add "Any" option
            const anyOption = document.createElement('li');
            anyOption.innerHTML = `
                <a class="dropdown-item" href="javascript:void(0)"
                   onclick="updateDropdownText('Any', 'modelDropdown', 'modelInput')">
                    Clear filter
                </a>`;
            modelDropdown.appendChild(anyOption);

            // Add model options
            data.models.forEach(model => {
                const listItem = document.createElement('li');
                listItem.innerHTML = `
                    <a class="dropdown-item" href="javascript:void(0)"
                       onclick="updateDropdownText('${model.model}', 'modelDropdown', 'modelInput'); fetchVariants('${model.model}')">
                        ${model.model} (${model.count})
                    </a>`;
                modelDropdown.appendChild(listItem);
            });

            // Reset variant dropdown
            variantDropdown.innerHTML = `
                <li>
                    <a class="dropdown-item" href="javascript:void(0)"
                       onclick="updateDropdownText('Any', 'variantDropdown', 'variantInput')">
                        Clear filter
                    </a>
                </li>`;
            document.getElementById('variantDropdown').disabled = true;
            document.getElementById('modelDropdown').disabled = false;
        })
        .catch(error => console.error('Error fetching models:', error));
}

function fetchVariants(model) {
    const variantDropdown = document.getElementById('variantList');
    const priceFrom = document.getElementById('pricefromInput').value;
    const priceTo = document.getElementById('pricetoInput').value;

    let query = `model=${encodeURIComponent(model)}`;
    if (priceFrom) query += `&price_from=${encodeURIComponent(priceFrom)}`;
    if (priceTo) query += `&price_to=${encodeURIComponent(priceTo)}`;

    fetch(`/fetch-variants?${query}`)
        .then(response => response.json())
        .then(data => {
            variantDropdown.innerHTML = '';

            const anyOption = document.createElement('li');
            anyOption.innerHTML = `
                <a class="dropdown-item" href="javascript:void(0)"
                   onclick="updateDropdownText('Any', 'variantDropdown', 'variantInput')">
                    Clear filter
                </a>`;
            variantDropdown.appendChild(anyOption);

            data.variants.forEach(variant => {
                const listItem = document.createElement('li');
                listItem.innerHTML = `
                    <a class="dropdown-item" href="javascript:void(0)"
                       onclick="updateDropdownText('${variant.variant}', 'variantDropdown', 'variantInput')">
                        ${variant.variant} (${variant.count})
                    </a>`;
                variantDropdown.appendChild(listItem);
            });

            document.getElementById('variantDropdown').disabled = false;
        })
        .catch(error => console.error('Error fetching variants:', error));
}

});
document.addEventListener('DOMContentLoaded', function() {

    updateSearchCount();
});

window.onload = function() {
    console.log('starting function...');
    updateSearchCount();
};


function updateSearchCount() {
    console.log('Updating search count...');
    
    // Count the number of cards in the grid
    const cardElements = document.querySelectorAll('#mobilelayout .articles-grid .card');
    const count = cardElements.length;
    
    console.log('Card count:', count);
    
    // Update the search button and count display
    const searchButton = document.getElementById('searchButton');
    const searchcount = document.getElementById('usedcarsfound');
    
    if (searchButton) {
        searchButton.textContent = `Search (${count} cars)`;
    }
    if (searchcount) {
        searchcount.textContent = `${count} used cars found`;
    }
}
function enableNextDropdown(currentDropdownId) {
    let nextDropdownId = null;


    const dropdownOrder = ['makeDropdown', 'modelDropdown', 'variantDropdown'];


    const currentIndex = dropdownOrder.indexOf(currentDropdownId);
    if (currentIndex !== -1 && currentIndex < dropdownOrder.length - 1) {
        nextDropdownId = dropdownOrder[currentIndex + 1];
    }


    if (nextDropdownId) {
        document.getElementById(nextDropdownId).disabled = false;
    }
}
function clearFilters() {
    document.getElementById('make').value = '';
    document.getElementById('model').value = '';
    document.getElementById('variant').value = '';
    document.getElementById('fuel_type').value = '';
    document.getElementById('miles').value = '';
    document.getElementById('seller_type').value = '';
    document.getElementById('gear_box').value = '';
    document.getElementById('body_type').value = '';
    document.getElementById('doors').value = '';
    document.getElementById('engine_size').value = '';
    document.getElementById('colors').value = '';
    document.getElementById('price_from').value = '';
    document.getElementById('price_to').value = '';
    document.getElementById('year').value = '';
    document.getElementById('year_from').value = '';


    document.getElementById('filterForm').submit();
}
function clearFiltersModel() {

document.getElementById('makeDropdown').textContent = 'Make';
document.getElementById('modelDropdown').textContent = 'Model';
document.getElementById('variantDropdown').textContent = 'Variant';
document.getElementById('yearFromDropdown').textContent = 'Year From';
document.getElementById('yearToDropdown').textContent = 'Year To';
document.getElementById('pricefromDropdown').textContent = 'Price From';
document.getElementById('pricetoDropdown').textContent = 'Price To';
document.getElementById('fuel_typeDropdown').textContent = 'Fuel Type';
document.getElementById('milesDropdown').textContent = 'Miles';
document.getElementById('gear_boxDropdown').textContent = 'Gearbox';
document.getElementById('seller_typeDropdown').textContent = 'Seller Type';
document.getElementById('body_typeDropdown').textContent = 'Body Type';
document.getElementById('doorsDropdown').textContent = 'Doors';
document.getElementById('engine_sizeDropdown').textContent = 'Engine Size';
document.getElementById('colorsDropdown').textContent = 'Engine Size';


document.getElementById('makeInput').value = '';
document.getElementById('modelInput').value = '';
document.getElementById('variantInput').value = '';
document.getElementById('yearFromInput').value = '';
document.getElementById('yearToInput').value = '';
document.getElementById('pricefromInput').value ='' ;
document.getElementById('pricetoInput').value = '';
document.getElementById('fuel_typeInput').value = '';
document.getElementById('milesInput').value = '';
document.getElementById('gear_boxInput').value = '';
document.getElementById('seller_typeInput').value = '';
document.getElementById('body_typeInput').value = '';
document.getElementById('doorsInput').value = '';
document.getElementById('engine_sizeInput').value = '';
document.getElementById('colorsInput').value = '';


document.getElementById('modelDropdown').setAttribute('disabled', true);
document.getElementById('variantDropdown').setAttribute('disabled', true);


window.currentFilters = {
    make: '',
    model: '',
    variant: '',
    fuel_type: '',
    body_type: '',
    engine_size: '',
    doors: '',
    colors: '',
    seller_type: '',
    gear_box: '',
    miles: '',
    yearFrom: '',
    yearTo: '',
    pricefrom: '',
    priceto: ''
};
let makeAnyOption = document.querySelector('#makeDropdown + .dropdown-menu a');
if (makeAnyOption) {
    makeAnyOption.click(); 
}
updateAllDropdowns();
updateSearchCount();
}
function clearFiltersMake() {

document.getElementById('makeDropdown').textContent = 'Make';
document.getElementById('modelDropdown').textContent = 'Model';
document.getElementById('variantDropdown').textContent = 'Variant';



document.getElementById('makeInput').value = '';
document.getElementById('modelInput').value = '';
document.getElementById('variantInput').value = '';



document.getElementById('modelDropdown').setAttribute('disabled', true);
document.getElementById('variantDropdown').setAttribute('disabled', true);


window.currentFilters = {
    make: '',
    model: '',
    variant: '',
   
};
let makeAnyOption = document.querySelector('#makeDropdown + .dropdown-menu a');
if (makeAnyOption) {
    makeAnyOption.click(); 
}
updateAllDropdowns();
updateSearchCount();
}


function updateDropdownText(selectedValue, dropdownId, inputId, displayValue = null) {
const dropdownButton = document.getElementById(dropdownId);
const inputField = document.getElementById(inputId);
const selectedFilters = document.getElementById('selectedFilters');
const filterName = dropdownId.replace('Dropdown', '').toLowerCase();
const buttonId = filterName + 'FilterButton';
if (selectedValue === 'Any') {
    dropdownButton.textContent = dropdownId.replace('Dropdown', ''); 
    inputField.value = '';
    removeFilter(buttonId, inputId);
} else {
    dropdownButton.textContent = displayValue || selectedValue;
    inputField.value = selectedValue;

    // Check if a button for this filter already exists
    if (document.getElementById(buttonId)) {
        // Update existing button
        const button = document.getElementById(buttonId);
        button.firstChild.textContent = displayValue || selectedValue; // Update the text content
    } else {
        // Create a new filter button
        const button = document.createElement('button');
        button.className = 'btn btn-outline-secondary btn-sm d-inline-flex align-items-center w-auto px-2';
        button.id = buttonId;
        button.innerHTML = `
           ${displayValue || selectedValue}
           <span class="ms-1" onclick="removeFilter('${buttonId}', '${inputId}')" style="cursor: pointer;">&times;</span>
       `;
        selectedFilters.prepend(button); // Add to the beginning
    }
}
}
function removefiltersdata() {
modelInput.value = '';
variantInput.value = '';

}


function updateSortFilter(filterValue) {
document.getElementById('sortInput').value = filterValue;
document.getElementById('sortButtonText').textContent = displayText;


}

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

// Custom searchModal handling
const searchModal = document.getElementById("searchModal");
if (searchModal) {
    const btn = document.querySelector(".form-search-button button");
    const span = document.querySelector(".close");

    btn.addEventListener("click", function () {
        searchModal.style.display = "flex";
        searchModal.style.justifyContent = "center";
        searchModal.style.alignItems = "center";
        handleModalOpen("searchModal"); // Track open
    });

    span.addEventListener("click", function () {
        searchModal.style.display = "none";
        handleModalClose("searchModal"); // Track close
    });

    window.addEventListener("click", function (event) {
        if (event.target === searchModal) {
            searchModal.style.display = "none";
            handleModalClose("searchModal"); // Track close
        }
    });
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
        if (lastModalId === "filterModal") {
          const bsModal = bootstrap.Modal.getInstance(modalElement);
          if (bsModal) {
              bsModal.hide();
          }
        } else if (modalElement.classList.contains('modal')) {
            const bsModal = bootstrap.Modal.getInstance(modalElement);
            if (bsModal) {
                bsModal.hide();
            }
        } else {
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