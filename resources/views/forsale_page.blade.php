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

        .custom-select-list .dropdown-item {
            @media(max-width:1440px){
                padding-top: 18px !important;
                padding-bottom: 18px !important;
            }
        }


        .dropdown.custom-dropdown .dropdown-toggle {
            @media (max-width: 1440px) {
                font-size: 15px !important;
                height: 46px !important;
                color: rgb(33, 37, 41) !important;
                font-weight: 300 !important;
            }
        }


        .dropdown.custom-dropdown .dropdown-menu .dropdown-item {
            font-size: 13px;
            padding: 18px 16px;
            color: #0E121B;
            white-space: normal;
            position: relative;
            padding-left: 40px;
        }

        .scrollable-dropdown {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 0;
            margin: 0;
        }

        .selected-option {
            background-color: #e3f2fd !important;
            font-weight: bold;
        }

        .dropdown-menu {

            width: 100%;
            max-height: 400px;
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

        .search_color {
            background-color: rgb(255, 255, 255) !important;
        }


        @media (min-width: 999px) {
            #topbarpadding {
                position: sticky;
                top: 0;
                z-index: 1000;
                /* Ensures it stays on top */
                background: white;
                /* Add a background to avoid transparency issues */
                border: none;
                box-shadow: none;
                /* Removes any shadow */
                height: 70px !important;
            }

            .desktopfooter {
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

            .filter-item:has(#bodytypeList),
            .filter-item:has(#fueltypeList),
            .filter-item:has(#gearboxList),
            .filter-item:has(#maxmilesList),
            .filter-item:has(#enginesizeList),
            .filter-item:has(#doorsList),
            .filter-item:has(#colorsList),
            .filter-item:has(#sellertypeList) {
                display: inline !important;
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
                padding-top: 0 !important;

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

            .bottonbuttons {
                margin-bottom: 20px !important;
            }

            #filterModal .modal-footer {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                gap: 10px !important;
                flex-wrap: nowrap !important;
            }

            #filterModal .modal-footer>div {
                display: flex !important;
                gap: 10px !important;
                flex-wrap: nowrap !important;
                align-items: center !important;
                flex-shrink: 0 !important;
            }

            #filterModal .modal-footer .bottonbuttons {
                white-space: nowrap !important;
                flex-shrink: 0 !important;
                margin-bottom: 0 !important;
                padding: 8px 16px !important;
                min-width: auto !important;
            }



        }

        .paddingmobile {
            margin-bottom: 5px !important;

        }

        .paddingmobile {
            position: relative;
            padding-bottom: 10px;
            /* Space before the line */
        }

        .paddingmobile::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 5%;
            width: 90% !important;
            height: 1px;
            background-color: #ccc;
            /* Light grey separator */
        }

        @media screen and (max-width: 990px) {

            /* Hide radio buttons in filter selects on mobile */
            #filterModal input[type="radio"],
            #filterModal .dropdown-menu input[type="radio"],
            .dropdown-menu input[type="radio"],
            #filterModal .dropdown-item input[type="radio"],
            .dropdown-item input[type="radio"],
            #filterModal li input[type="radio"],
            #filterModal .dropdown-menu li input[type="radio"],
            .dropdown-menu li input[type="radio"],
            #filterModal .form-check-input[type="radio"],
            #filterModal .form-check,
            #filterModal .form-check-label::before,
            #filterModal .form-check-label::after {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
                width: 0 !important;
                height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* Hide any circular indicators that might look like radio buttons */
            #filterModal .dropdown-item::before,
            #filterModal .dropdown-item::after,
            .dropdown-item::before,
            .dropdown-item::after {
                display: none !important;
                content: none !important;
            }

            /* Specifically hide circles in dropdown menu items */
            #filterModal .dropdown-menu li::before,
            #filterModal .dropdown-menu li::after,
            .dropdown-menu li::before,
            .dropdown-menu li::after {
                display: none !important;
                content: none !important;
            }

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
                width: 12px;
                /* Adjust size of the circle */
                height: 12px;
                border: 2px solid black;
                /* Black border for unfilled effect */
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
                background-color: #fefefe;
                border: 1px solid #888;
                border-radius: 10px 10px 0 0;
                margin: auto auto 0 auto;
                max-width: 100%;
                position: absolute;
                left: 0;
                right: 0;
                bottom: 0;
                width: 480px;
                max-height: calc(100% - 60px);
                overflow-y: auto;
            }

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

        .search-filter-bar .header {
            padding: 10px 12px;
            border-bottom: 1px solid #f1efef;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .search-filter-bar .header .header-title {
            font-size: 18px;
            color: #000;
        }

        .search-filter-bar .header .header-times {
            color: #000;
            font-size: 27px;
            height: 2rem;
            width: 1rem;
            margin-top: -10px;
        }

        @media (min-width: 768px) {
            .display-desktop-none {
                display: none !important;
            }
        }

        @media (max-width: 768px) {

            /* Hide radio buttons in filter selects on mobile */
            #filterModal input[type="radio"],
            #filterModal .dropdown-menu input[type="radio"],
            .dropdown-menu input[type="radio"],
            #filterModal .dropdown-item input[type="radio"],
            .dropdown-item input[type="radio"],
            #filterModal li input[type="radio"],
            #filterModal .dropdown-menu li input[type="radio"],
            .dropdown-menu li input[type="radio"],
            #filterModal .form-check-input[type="radio"],
            #filterModal .form-check,
            #filterModal .form-check-label::before,
            #filterModal .form-check-label::after {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
                width: 0 !important;
                height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* Hide any circular indicators that might look like radio buttons */
            #filterModal .dropdown-item::before,
            #filterModal .dropdown-item::after,
            .dropdown-item::before,
            .dropdown-item::after {
                display: none !important;
                content: none !important;
            }

            /* Specifically hide circles in dropdown menu items */
            #filterModal .dropdown-menu li::before,
            #filterModal .dropdown-menu li::after,
            .dropdown-menu li::before,
            .dropdown-menu li::after {
                display: none !important;
                content: none !important;
            }

            .navbar.navbar-expand-lg {
                z-index: 80 !important;
            }

            .show.display-mobile-none li .dropdown-item,
            .display-mobile-none {
                display: none !important;
            }

            .desktop-hero-section-text {
                padding: 0px !important;
                position: absolute;
                top: -100vh;
                left: 0;
                right: 0;
                width: 100%;
                z-index: 75 !important;
                background: #ffffff;
                overflow: hidden;
                height: 90vh !important;
                overflow: auto !important;
            }


            .desktop-hero-section-text.show {
                padding: 16px !important;
                animation: slideDown 0.6s ease forwards;
            }

            @keyframes slideDown {
                from {
                    top: -100vh;
                }

                to {
                    top: 70px;
                }
            }

            .search-filter-bar {
                z-index: 10 !important;
            }
        }

        #sortList .dropdown-item {
            padding: 10px 34px !important;
            font-size: 16px !important;
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

    <div class="hero-section-desktop">
        <div class="desktop-hero-section display-mobile-none">
            <img style="width:100%; height:100%; object-fit:cover; z-index:1; cursor: pointer;"
                src="https://purecar.co.uk/images/page_sections/1763807298_BMW-M5-CS-rear-view-1600x1200-cropped.jpg"
                alt="">
        </div>
        <div class="desktop-hero-section-text" id="mobileSearchForm">
            <div class="desktop-hero-section-innerbox">
                @include('partials.car_search_form', ['formId' => 'heroSearchForm'])
            </div>
        </div>
    </div>
    </div>

    <section class="text-center pt-4 pt-lg-5">
        <div class="card-list-container">
            <div class="d-flex justify-content-between align-items-center" id="topbarpadding"
                style="display:none !important;">
                <div class="filteritems d-flex flex-wrap gap-2" id="selectedFilters">
                    <?php if (!empty($makeselected)) : ?>
                    <button style="background-color: #D6DDF5"
                        class="btn btn-sm d-inline-flex align-items-center w-auto px-2" id="makeFilterButton"
                        data-bs-toggle="modal" data-bs-target="#filterModal" data-filter-name="make">
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
                        class="btn btn-sm d-inline-flex align-items-center w-auto px-2" id="modelFilterButton"
                        data-bs-toggle="modal" data-bs-target="#filterModal" data-filter-name="model">
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
                        class="btn btn-sm d-inline-flex align-items-center w-auto px-2" id="variantFilterButton"
                        data-bs-toggle="modal" data-bs-target="#filterModal" data-filter-name="variant">
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
                        class="btn btn-sm d-inline-flex align-items-center w-auto px-2" id="priceFromFilterButton"
                        data-bs-toggle="modal" data-bs-target="#filterModal" data-filter-name="pricefrom">
                        <?= htmlspecialchars($displayText) ?>
                        <span class="ms-1" onclick="removeFilter('priceFromFilterButton', 'pricefromInput')"
                            style="cursor: pointer;">&times;</span>
                    </button>
                    <?php } else { ?>
                    <button style="background-color: white; color:black; border:2px solid black; border-radius:10px;"
                        class="btn btn-sm d-inline-flex align-items-center w-auto px-2" data-bs-toggle="modal"
                        data-bs-target="#filterModal" data-filter-name="pricefrom">
                        + Price From
                    </button>
                    <?php }

if (!empty($pricetoselected)) {
    $displayText = formatPrice($pricetoselected);
    ?>
                    <button style="background-color: #D6DDF5"
                        class="btn btn-sm d-inline-flex align-items-center w-auto px-2" id="priceToFilterButton"
                        data-bs-toggle="modal" data-bs-target="#filterModal" data-filter-name="priceto">
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

                <button style="background-color: white; color:black; border:2px solid black; border-radius:10px;"
                    type="button" class="btn btn-sm d-none d-md-block" data-bs-toggle="modal"
                    data-bs-target="#filterModal">
                    Filter & Sort <i class="fas fa-filter"></i>
                </button>

                <div class="filter-scroll-container d-md-none">
                    <button class="filter-scroll-button" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <strong>Sort</strong>
                    </button>
                    <button class="filter-scroll-button" onclick="scrollToTop()">
                        <i class="fas fa-arrow-up"></i>
                    </button>
                </div>





            </div>
            <div>

            </div>
            <div class="d-none d-md-flex justify-content-between align-items-end">
                <p class="mb-0 result-title">{{ $totalCount }} used cars found</p>
                <div class="dropdown custom-dropdown sort-dropdown">
                    <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center gap-2"
                        type="button" id="sortDropdown" data-bs-toggle="dropdown">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.8335 17.5V15" stroke="#FFFCFC" stroke-width="1.25" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M14.1665 17.5V12.5" stroke="#FFFCFC" stroke-width="1.25" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M14.1665 5V2.5" stroke="#FFFCFC" stroke-width="1.25" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M5.8335 7.5V2.5" stroke="#FFFCFC" stroke-width="1.25" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M5.8335 15C5.05693 15 4.66865 15 4.36235 14.8732C3.95398 14.704 3.62952 14.3795 3.46036 13.9712C3.3335 13.6648 3.3335 13.2766 3.3335 12.5C3.3335 11.7234 3.3335 11.3352 3.46036 11.0288C3.62952 10.6205 3.95398 10.296 4.36235 10.1268C4.66865 10 5.05693 10 5.8335 10C6.61006 10 6.99835 10 7.30464 10.1268C7.71301 10.296 8.03747 10.6205 8.20663 11.0288C8.3335 11.3352 8.3335 11.7234 8.3335 12.5C8.3335 13.2766 8.3335 13.6648 8.20663 13.9712C8.03747 14.3795 7.71301 14.704 7.30464 14.8732C6.99835 15 6.61006 15 5.8335 15Z"
                                stroke="#FFFCFC" stroke-width="1.25" />
                            <path
                                d="M14.1665 10C13.3899 10 13.0017 10 12.6953 9.87317C12.287 9.704 11.9625 9.3795 11.7933 8.97117C11.6665 8.66483 11.6665 8.27657 11.6665 7.5C11.6665 6.72343 11.6665 6.33515 11.7933 6.02886C11.9625 5.62048 12.287 5.29602 12.6953 5.12687C13.0017 5 13.3899 5 14.1665 5C14.9431 5 15.3313 5 15.6377 5.12687C16.046 5.29602 16.3705 5.62048 16.5397 6.02886C16.6665 6.33515 16.6665 6.72343 16.6665 7.5C16.6665 8.27657 16.6665 8.66483 16.5397 8.97117C16.3705 9.3795 16.046 9.704 15.6377 9.87317C15.3313 10 14.9431 10 14.1665 10Z"
                                stroke="#FFFCFC" stroke-width="1.25" />
                        </svg>
                        <span class="dropdown-text">Filter & Sort</span>
                    </button>
                    <ul class="dropdown-menu overflow-auto" id="sortList">
                        <li>
                            <a class="dropdown-item" onclick="setSortOption('newest')" href="javascript:void(0)">Most
                                Recent</a>
                        </li>
                        <li>
                            <a class="dropdown-item" onclick="setSortOption('low-high')" href="javascript:void(0)">Price
                                (low to high)</a>
                        </li>
                        <li>
                            <a class="dropdown-item" onclick="setSortOption('high-low')" href="javascript:void(0)">Price
                                (high to low)</a>
                        </li>
                        <li>
                            <a class="dropdown-item" onclick="setSortOption('mileage')" href="javascript:void(0)">Mileage
                                (low to high)</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="grid-for-car-cards" id="mobilelayout" data-next-page-url="{{ $cars->nextPageUrl() }}">
                @include('partials.car_list', ['cars' => $cars])
            </div>

            <div id="loading" style="display: none; text-align: center; margin-top: 20px;">
                <p>Loading more cars...</p>
            </div>
        </div>
        <div class="search-filter-bar">
            <button id="mobile-search-button" class="bar-section">Search</button>
            <div class="dropdown custom-dropdown">
                <button class="bar-section" type="button" id="sortDropdown" data-bs-toggle="dropdown">
                    Filter
                </button>
                <ul class="dropdown-menu overflow-auto" id="sortList">
                    <li class="header">
                        <span class="header-title" href="javascript:void(0)">Filter</span>
                        <span class="header-times" data-bs-toggle="dropdown">&times;</span>
                    </li>
                    <li>
                        <a class="dropdown-item" onclick="setSortOption('newest')" href="javascript:void(0)">Most
                            Recent</a>
                    </li>
                    <li>
                        <a class="dropdown-item" onclick="setSortOption('low-high')" href="javascript:void(0)">Price (low
                            to high)</a>
                    </li>
                    <li>
                        <a class="dropdown-item" onclick="setSortOption('high-low')" href="javascript:void(0)">Price
                            (high to low)</a>
                    </li>
                    <li>
                        <a class="dropdown-item" onclick="setSortOption('mileage')" href="javascript:void(0)">Mileage
                            (low to high)</a>
                    </li>
                </ul>
            </div>
            <button class="bar-section arrow-section" onclick="scrollToTop()">
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.5 0.5V14.5M7.5 0.5L0.5 7.5M7.5 0.5L14.5 7.5" stroke="white" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
        </div>
    </section>
    <script>
        let isLoading = false;
        let nextPageUrl = document.getElementById('mobilelayout').dataset.nextPageUrl;

        let sortOption = null;

        // Progressive loading function
        function applyProgressiveLoading(container) {
            if (!container) return;

            const carCards = container.querySelectorAll(
                '.main_car_card, .my-3, [class*="car-card"], [class*="card"][class*="car"]');

            if (carCards.length > 7) {
                // Hide all cards beyond the first 7
                carCards.forEach((card, index) => {
                    if (index >= 7) {
                        card.style.display = 'none';
                        card.classList.add('progressive-load-hidden');
                    }
                });

                // After delay, show all cards with fade-in effect
                setTimeout(() => {
                    carCards.forEach((card, index) => {
                        if (index >= 7) {
                            card.style.display = '';
                            card.style.opacity = '0';
                            card.style.transition = 'opacity 0.3s ease-in';
                            setTimeout(() => {
                                card.style.opacity = '1';
                                card.classList.remove('progressive-load-hidden');
                            }, 10);
                        }
                    });
                }, 500); // 500ms delay
            }
        }

        // Apply progressive loading on initial page load
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('mobilelayout');
            if (container) {
                applyProgressiveLoading(container);
            }
        });

        // Helper function to extract total count from API response
        function getTotalCount(data, containerElement = null) {
            let totalCount = 0;
            let htmlCount = 0;

            // First, count actual items from HTML if container is available (for validation)
            if (containerElement) {
                // Use a more specific selector to avoid double counting
                // Try to find the actual car card containers - use main_car_card first as it's more specific
                const carItemsByMain = containerElement.querySelectorAll('.main_car_card').length;
                const carItemsByMy3 = containerElement.querySelectorAll('.my-3').length;
                // Use the larger count (in case one selector is more accurate)
                htmlCount = Math.max(carItemsByMain, carItemsByMy3);

                // If both are 0, try alternative selector
                if (htmlCount === 0) {
                    const altCount = containerElement.querySelectorAll('[class*="car"][class*="card"]').length;
                    htmlCount = altCount > 0 ? altCount : 0;
                }
            }

            // Try data.total from API
            let apiTotal = 0;
            if (data.total !== undefined && data.total !== null && data.total !== '' && !isNaN(data.total)) {
                apiTotal = parseInt(data.total, 10);
            }
            // Try alternative property names
            else if (data.total_count !== undefined && data.total_count !== null && data.total_count !== '' && !isNaN(data
                    .total_count)) {
                apiTotal = parseInt(data.total_count, 10);
            }
            // Try Laravel pagination structure
            else if (data.last_page && data.per_page && !isNaN(data.last_page) && !isNaN(data.per_page)) {
                apiTotal = parseInt(data.last_page, 10) * parseInt(data.per_page, 10);
            }

            // If we have both HTML count and API total, check if API total is exactly double
            // This handles the case where the API is returning doubled counts
            if (htmlCount > 0 && apiTotal > 0 && apiTotal === htmlCount * 2) {
                // API total is doubled, divide by 2 to get correct total
                totalCount = Math.floor(apiTotal / 2);
            } else if (apiTotal > 0) {
                // Use API total (it's the authoritative source for total across all pages)
                totalCount = apiTotal;
            } else if (htmlCount > 0) {
                // Only HTML count available (for current page only)
                totalCount = htmlCount;
            }

            return totalCount;
        }

        function setSortOption(option) {
            sortOption = option;
            nextPageUrl = '/searchcar?page=1';
            if (isLoading || !nextPageUrl) return;
            fetchHtmlCarItem();
        }


        window.addEventListener('scroll', function() {
            if (isLoading || !nextPageUrl) return;

            const scrollPosition = window.scrollY + window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight;

            if (scrollPosition > documentHeight - 1200) { // Trigger 200px before bottom
                fetchHtmlCarItem();
            }
        });


        function fetchHtmlCarItem() {

            isLoading = true;
            document.getElementById('loading').style.display = 'block';

            if (sortOption) nextPageUrl = `${nextPageUrl}&sort=${sortOption}`;

            fetch(nextPageUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => response.json())
                .then(data => {

                    const query = new URLSearchParams(nextPageUrl.split('?')[1]);

                    const container = document.getElementById('mobilelayout');
                    if (query.get('page') == '1' && sortOption) {
                        container.innerHTML = data.html;
                        // Apply progressive loading for new page
                        applyProgressiveLoading(container);
                    } else {
                        container.insertAdjacentHTML('beforeend', data.html);
                    }

                    nextPageUrl = data.next_page_url;
                    container.dataset.nextPageUrl = nextPageUrl;
                    isLoading = false;
                    document.getElementById('loading').style.display = 'none';
                })
                .catch(error => {
                    console.error('Error loading more cars:', error);
                    isLoading = false;
                    document.getElementById('loading').style.display = 'none';
                });
        }




        // Update dropdown button text when an item is selected
        document.querySelectorAll('#sortList .dropdown-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const selectedText = this.textContent.trim();
                const dropdownText = document.querySelector('#sortDropdown .dropdown-text');
                if (dropdownText) {
                    dropdownText.textContent = selectedText;
                }
            });
        });

        // Update filter form submission to use AJAX
        document.querySelector('#filterModal form').addEventListener('submit', function(e) {
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
                    const container = document.getElementById('mobilelayout');
                    container.innerHTML = data.html;

                    // Apply progressive loading
                    applyProgressiveLoading(container);

                    const resultTitles = document.querySelectorAll('.result-title');
                    if (resultTitles.length > 0) {
                        const totalCount = getTotalCount(data, container);
                        resultTitles.forEach(resultTitle => {
                            resultTitle.textContent = `${totalCount} used cars found`;
                        });
                    }
                    nextPageUrl = data.next_page_url;
                    container.dataset.nextPageUrl = nextPageUrl;
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
                    const container = document.getElementById('mobilelayout');
                    container.innerHTML = data.html;

                    // Apply progressive loading
                    applyProgressiveLoading(container);

                    const resultTitles = document.querySelectorAll('.result-title');
                    if (resultTitles.length > 0) {
                        const totalCount = getTotalCount(data, container);
                        resultTitles.forEach(resultTitle => {
                            resultTitle.textContent = `${totalCount} used cars found`;
                        });
                    }
                    nextPageUrl = data.next_page_url;
                    container.dataset.nextPageUrl = nextPageUrl;

                    // Update filter buttons and listings using the new functions
                    if (typeof updateFilterButtons === 'function') {
                        updateFilterButtons();
                    } else {
                        // Fallback: Reset filter buttons manually
                        document.querySelectorAll('.filteritems button').forEach(btn => {
                            if (btn.textContent.includes('×')) {
                                btn.remove();
                            }
                        });
                    }
                })
                .catch(error => console.error('Error clearing filters:', error));
        }

        // Update removeFilter function to use AJAX
        function removeFilter(buttonId, inputId) {
            document.getElementById(inputId).value = '';

            // Update currentFilters
            const filterName = inputId.replace('Input', '').toLowerCase();
            if (window.currentFilters && window.currentFilters[filterName]) {
                window.currentFilters[filterName] = '';
            }

            // Update dropdown text
            const dropdownId = filterName.charAt(0).toUpperCase() + filterName.slice(1) + 'Dropdown';
            const dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                const fieldLabels = {
                    make: "Make",
                    model: "Model",
                    variant: "Variant",
                    pricefrom: "Price From",
                    priceto: "Price To",
                    yearfrom: "Year From",
                    yearto: "Year To",
                    fueltype: "Fuel Type",
                    bodytype: "Body Type",
                    enginesize: "Engine Size",
                    doors: "Doors",
                    colors: "Colors",
                    sellertype: "Seller Type",
                    gearbox: "Gearbox",
                    maxmiles: "Max Miles"
                };
                dropdown.textContent = fieldLabels[filterName] || filterName;
            }

            // Update listings, filter buttons, and dropdowns
            if (typeof updateCarListings === 'function') {
                updateCarListings();
            }
            if (typeof updateFilterButtons === 'function') {
                updateFilterButtons();
            }
            if (typeof updateAllDropdowns === 'function') {
                updateAllDropdowns();
            }
        }

        (function() {
            const dropdownMenus = document.querySelectorAll('.dropdown-menu');

            dropdownMenus.forEach(function(menu) {
                const dropdown = menu.closest('.dropdown');
                if (!dropdown) return;

                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'attributes' && mutation.attributeName ===
                            'class') {
                            if (menu.classList.contains('show')) {
                                dropdown.classList.add('open');
                            } else {
                                dropdown.classList.remove('open');
                            }
                        }
                    });
                });

                observer.observe(menu, {
                    attributes: true,
                    attributeFilter: ['class']
                });

                // Check initial state
                if (menu.classList.contains('show')) {
                    dropdown.classList.add('open');
                }
            });
        })();
    </script>



    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true"
        style="z-index: 10000;">
        <div class="modal-dialog modal-dialog-scrollable" style="max-width: 650px; width: 90%;  border-radius:10px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter and sort</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- the recent button -->
                    <div style="display: flex; align-items: center; gap: 10px;" class="paddingmobile">
                        <i class="fas fa-filter"></i>
                        <div class="dropdown w-100">
                            <button
                                class="bg-white btn dropdown-toggle d-flex justify-content-between align-items-center w-100"
                                style="height: 40px;" type="button" id="dropdownMenuButtonside"
                                data-bs-toggle="dropdown">
                                <span id="sortButtonText">Sort</span>
                                <i class="fas fa-chevron-down ml-2"></i> <!-- Custom arrow -->
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonside"
                                style="color: #A4A7AD; width: 100%;">
                                <li><a class="dropdown-item" href="javascript:void(0)" data-filter="most-recent"
                                        onclick="updateSortFilter('most-recent')">Most Recent</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" data-filter="low-high"
                                        onclick="updateSortFilter('low-high')">Price (low to high)</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" data-filter="high-low"
                                        onclick="updateSortFilter('high-low')">Price (high to low)</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" data-filter="mileage"
                                        onclick="updateSortFilter('mileage')">Mileage (low to high)</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" data-filter="mileage"
                                        onclick="updateSortFilter('mileage-low')">Mileage (high to low)</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" data-filter="newest"
                                        onclick="updateSortFilter('newest')">Age (newest)</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" data-filter="oldest"
                                        onclick="updateSortFilter('oldest')">Age (oldest)</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- The Filter Form -->
                    <form method="GET" action="{{ route('search_car') }}">
                        @csrf
                        <!-- Make Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 10px;"
                            class="paddingmobile">
                            <i class="fas fa-car"></i>
                            <div class="dropdown w-100">
                                <button
                                    class="btn search_color dropdown-toggle d-flex justify-content-between align-items-center w-100"
                                    type="button" data-bs-toggle="dropdown" id="makeDropdown">
                                    <span>{{ $makeselected ?? 'Make' }}</span>
                                    <i class="fas fa-chevron-down ml-2"></i> <!-- Custom arrow -->
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            onclick="updateDropdownText('Any', 'makeDropdown', 'makeInput');">
                                            Clear filter
                                        </a>
                                    </li>
                                    @foreach ($search_field['make'] as $make)
                                        <li>
                                            <a class="dropdown-item {{ !empty($makeselected) && $make->make === $makeselected ? 'selected-option' : '' }}"
                                                href="javascript:void(0)"
                                                onclick="updateDropdownText('{{ $make->make }}', 'makeDropdown', 'makeInput'); fetchModels('{{ $make->make }}')">
                                                {{ $make->make }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $make->count }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <input type="hidden" name="make" id="makeInput" value="{{ $makeselected ?? '' }}">
                            </div>
                        </div>

                        <!-- Model Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 10px;"
                            class="paddingmobile">
                            <i class="fas fa-car"></i>
                            <div class="dropdown w-100">
                                <button
                                    class="btn search_color dropdown-toggle d-flex justify-content-between align-items-center w-100"
                                    id="modelDropdown" type="button" data-bs-toggle="dropdown" disabled>
                                    <span>{{ $modelselected ?? 'Model' }}</span>

                                </button>
                                <ul class="dropdown-menu" id="modelList">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            onclick="updateDropdownText('Any', 'modelDropdown', 'modelInput');">
                                            Any
                                        </a>
                                    </li>
                                </ul>
                                <input type="hidden" name="model" id="modelInput"
                                    value="{{ $modelselected ?? '' }}">
                            </div>
                        </div>

                        <!-- Variant Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 10px;"
                            class="paddingmobile">
                            <i class="fas fa-car"></i>
                            <div class="dropdown w-100">
                                <button
                                    class="btn search_color dropdown-toggle d-flex justify-content-between align-items-center w-100"
                                    id="variantDropdown" type="button" data-bs-toggle="dropdown" disabled>
                                    <span>{{ $variantselected ?? 'Variant' }}</span>

                                </button>
                                <ul class="dropdown-menu" id="variantList">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            onclick="updateDropdownText('Any', 'variantDropdown', 'variantInput');">
                                            Any
                                        </a>
                                    </li>
                                </ul>
                                <input type="hidden" name="variant" id="variantInput"
                                    value="{{ $variantselected ?? '' }}">
                            </div>
                        </div>





                        <!-- Year From Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px;" class="paddingmobile">
                            <i class="fas fa-calendar"></i>
                            <div class="dropdown w-100">
                                <button
                                    class="btn dropdown-toggle search_color w-100 d-flex justify-content-between align-items-center"
                                    type="button" id="yearFromDropdown" data-bs-toggle="dropdown">
                                    <span>{{ $yearfromselected ?? 'Year From' }}</span>
                                    <i class="fas fa-chevron-down ml-2"></i> <!-- Custom arrow -->
                                </button>
                                <ul class="dropdown-menu scrollable-dropdown">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            onclick="updateDropdownText('Any', 'yearFromDropdown', 'yearFromInput')">
                                            Any
                                        </a>
                                    </li>
                                    @foreach (array_reverse($year_ranges) as $year)
                                        <li>
                                            <a class="dropdown-item {{ !empty($yearfromselected) && $year == $yearfromselected ? 'selected-option' : '' }}"
                                                href="javascript:void(0)"
                                                onclick="updateDropdownText('{{ $year }}', 'yearFromDropdown', 'yearFromInput')">
                                                {{ $year }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $year_counts[$year] ?? 0 }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <input type="hidden" name="year_from" id="yearFromInput"
                                    value="{{ $yearfromselected ?? '' }}">
                            </div>
                        </div>

                        <!-- Year To Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px;" class="paddingmobile">
                            <i class="fas fa-calendar"></i>
                            <div class="dropdown w-100">
                                <button
                                    class="btn dropdown-toggle search_color w-100 d-flex justify-content-between align-items-center"
                                    type="button" id="yearToDropdown" data-bs-toggle="dropdown">
                                    <span>{{ $yeartoselected ?? 'Year To' }}</span>
                                    <i class="fas fa-chevron-down ml-2"></i> <!-- Custom arrow -->
                                </button>
                                <ul class="dropdown-menu scrollable-dropdown">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            onclick="updateDropdownText('Any', 'yearToDropdown', 'yearToInput')">
                                            Any
                                        </a>
                                    </li>
                                    @foreach (array_reverse($year_ranges) as $year)
                                        <li>
                                            <a class="dropdown-item {{ !empty($yeartoselected) && $year == $yeartoselected ? 'selected-option' : '' }}"
                                                href="javascript:void(0)"
                                                onclick="updateDropdownText('{{ $year }}', 'yearToDropdown', 'yearToInput')">
                                                {{ $year }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $year_counts[$year] ?? 0 }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <input type="hidden" name="year_to" id="yearToInput"
                                    value="{{ $yeartoselected ?? '' }}">
                            </div>
                        </div>

                        <!-- Price From Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px;" class="paddingmobile">
                            <i class="fas fa-tag"></i>
                            <div class="dropdown w-100">
                                <button
                                    class="btn dropdown-toggle search_color w-100 d-flex justify-content-between align-items-center"
                                    type="button" id="pricefromDropdown" data-bs-toggle="dropdown">
                                    <span>{{ $pricefromselected ?? 'Price From' }}</span>
                                    <i class="fas fa-chevron-down ml-2"></i> <!-- Custom arrow -->
                                </button>
                                <ul class="overflow-auto dropdown-menu" style="max-height: 300px;"
                                    id="pricefromDropdownList">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            onclick="updateDropdownText('Any', 'pricefromDropdown', 'pricefromInput')">
                                            Any
                                        </a>
                                    </li>
                                    @foreach ($price_counts as $price_range)
                                        <li>
                                            <a class="dropdown-item {{ !empty($pricefromselected) && $price_range['min'] == $pricefromselected ? 'selected-option' : '' }}"
                                                href="javascript:void(0)"
                                                onclick="updateDropdownText('{{ $price_range['min'] }}', 'pricefromDropdown', 'pricefromInput')">
                                                £{{ number_format($price_range['min']) }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $price_range['count'] }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <input type="hidden" name="price_from" id="pricefromInput"
                                    value="{{ $pricefromselected ?? '' }}">
                            </div>
                        </div>

                        <!-- Price To Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px;" class="paddingmobile">
                            <i class="fas fa-tag"></i>
                            <div class="dropdown w-100">
                                <button
                                    class="btn dropdown-toggle search_color w-100 d-flex justify-content-between align-items-center"
                                    type="button" id="pricetoDropdown" data-bs-toggle="dropdown">
                                    <span>{{ $pricetoselected ?? 'Price To' }}</span>
                                    <i class="fas fa-chevron-down ml-2"></i> <!-- Custom arrow -->
                                </button>
                                <ul class="overflow-auto dropdown-menu" style="max-height: 300px;"
                                    id="priceDropdownList">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            onclick="updateDropdownText('Any', 'pricetoDropdown', 'pricetoInput')">
                                            Any
                                        </a>
                                    </li>
                                    @foreach ($price_counts as $price_range)
                                        <li>
                                            <a class="dropdown-item {{ !empty($pricetoselected) && $price_range['max'] == $pricetoselected ? 'selected-option' : '' }}"
                                                href="javascript:void(0)"
                                                onclick="updateDropdownText('{{ $price_range['max'] }}', 'pricetoDropdown', 'pricetoInput')">
                                                £{{ number_format($price_range['max']) }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $price_range['count'] }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <input type="hidden" name="price_to" id="pricetoInput"
                                    value="{{ $pricetoselected ?? '' }}">
                            </div>
                        </div>

                        <!-- Fuel Type Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px;" class="paddingmobile">
                            <i class="fas fa-gas-pump"></i>
                            <div class="dropdown w-100">
                                <button
                                    class="btn dropdown-toggle search_color w-100 d-flex justify-content-between align-items-center"
                                    type="button" id="fuel_typeDropdown" data-bs-toggle="dropdown">
                                    <span>{{ $fuel_typeselected ?? 'Fuel Type' }}</span>
                                    <i class="fas fa-chevron-down ml-2"></i> <!-- Custom arrow -->
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            onclick="updateDropdownText('Any', 'fuel_typeDropdown', 'fuel_typeInput')">
                                            Any
                                        </a>
                                    </li>
                                    @foreach ($search_field['fuel_type'] as $fuel_type)
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)"
                                                onclick="updateDropdownText('{{ $fuel_type->fuel_type }}', 'fuel_typeDropdown', 'fuel_typeInput')">
                                                {{ $fuel_type->fuel_type }} ({{ $fuel_type->count }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <input type="hidden" name="fuel_type" id="fuel_typeInput"
                                    value="{{ $fuel_typeselected ?? '' }}">
                            </div>
                        </div>

                        <!-- Max Miles Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px;" class="paddingmobile">
                            <i class="fas fa-gauge"></i>
                            <div class="dropdown w-100">
                                <button
                                    class="btn search_color dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                    type="button" id="milesDropdown" data-bs-toggle="dropdown">
                                    <span>{{ $milesselected ?? 'Max miles' }}</span>
                                    <i class="fas fa-chevron-down ml-2"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            onclick="updateDropdownText('Any', 'milesDropdown', 'milesInput')">
                                            Any
                                        </a>
                                    </li>
                                    @foreach ([10000, 20000, 30000, 40000, 50000, 60000, 70000, 80000, 90000, 100000] as $mile)
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)"
                                                onclick="updateDropdownText('{{ $mile }}', 'milesDropdown', 'milesInput', 'Up to {{ number_format($mile) }} miles')">
                                                Up to {{ number_format($mile) }} miles
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <input type="hidden" name="miles" id="milesInput"
                                    value="{{ $milesselected ?? '' }}">
                            </div>
                        </div>

                        <!-- Gearbox Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px;" class="paddingmobile">
                            <i class="fas fa-gear"></i>
                            <div class="dropdown w-100">
                                <button
                                    class="btn search_color dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                    type="button" id="gear_boxDropdown" data-bs-toggle="dropdown">
                                    <span>{{ $gear_boxselected ?? 'Gearbox' }}</span>
                                    <i class="fas fa-chevron-down ml-2"></i> <!-- Custom arrow -->
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            onclick="updateDropdownText('Any', 'gear_boxDropdown', 'gear_boxInput')">
                                            Any
                                        </a>
                                    </li>
                                    @foreach ($search_field['gear_box'] as $gear_box)
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)"
                                                onclick="updateDropdownText('{{ $gear_box->gear_box }}', 'gear_boxDropdown', 'gear_boxInput')">
                                                {{ $gear_box->gear_box }} ({{ $gear_box->count }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <input type="hidden" name="gear_box" id="gear_boxInput"
                                    value="{{ $gear_boxselected ?? '' }}">
                            </div>
                        </div>

                        <!-- Seller Type Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px;" class="paddingmobile">
                            <i class="fas fa-user"></i>
                            <div class="dropdown w-100">
                                <button
                                    class="btn search_color dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                    type="button" id="seller_typeDropdown" data-bs-toggle="dropdown">
                                    <span>{{ $seller_typeselected ?? 'Seller type' }}</span>
                                    <i class="fas fa-chevron-down ml-2"></i> <!-- Custom arrow -->
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            onclick="updateDropdownText('Any', 'seller_typeDropdown', 'seller_typeInput')">
                                            Any
                                        </a>
                                    </li>
                                    @foreach ($search_field['seller_type'] as $seller)
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)"
                                                onclick="updateDropdownText('{{ $seller->seller_type }}', 'seller_typeDropdown', 'seller_typeInput')">
                                                {{ $seller->seller_type }} ({{ $seller->count }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <input type="hidden" name="seller_type" id="seller_typeInput"
                                    value="{{ $seller_typeselected ?? '' }}">
                            </div>
                        </div>

                        <!-- Body Style Dropdown -->
                        <div style="display: flex; align-items: center; gap: 5px;" class="paddingmobile">
                            <i class="fas fa-car-side"></i>
                            <div class="dropdown w-100">
                                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                    type="button" id="body_typeDropdown" data-bs-toggle="dropdown">
                                    <span>{{ $body_typeselected ?? 'Body style' }}</span>
                                    <i class="fas fa-chevron-down ml-2"></i> <!-- Custom arrow -->
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            onclick="updateDropdownText('Any', 'body_typeDropdown', 'body_typeInput')">
                                            Any
                                        </a>
                                    </li>
                                    @foreach ($search_field['body_type'] as $body_type)
                                        @if ($body_type->body_type !== 'N/A' && $body_type->body_type !== 'UNLISTED')
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                    onclick="updateDropdownText('{{ $body_type->body_type }}', 'body_typeDropdown', 'body_typeInput')">
                                                    {{ $body_type->body_type }} ({{ $body_type->count }})
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach

                                </ul>
                                <input type="hidden" name="body_type" id="body_typeInput"
                                    value="{{ $body_typeselected ?? '' }}">
                            </div>
                        </div>

                        <!-- Doors Dropdown -->
                        <div style="display: flex; align-items: center; gap: 5px;" class="paddingmobile">
                            <i class="fas fa-door-open"></i>
                            <div class="dropdown w-100">
                                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                    type="button" id="doorsDropdown" data-bs-toggle="dropdown">
                                    <span>{{ $doorsselected ?? 'Doors' }}</span>
                                    <i class="fas fa-chevron-down ml-2"></i> <!-- Custom arrow -->
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            onclick="updateDropdownText('Any', 'doorsDropdown', 'doorsInput')">
                                            Any
                                        </a>
                                    </li>
                                    @foreach ($search_field['doors'] as $doors)
                                        @if ($doors->doors !== 0)
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                    onclick="updateDropdownText('{{ $doors->doors }}', 'doorsDropdown', 'doorsInput')">
                                                    {{ $doors->doors }} ({{ $doors->count }})
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                                <input type="hidden" name="doors" id="doorsInput"
                                    value="{{ $doorsselected ?? '' }}">
                            </div>
                        </div>

                        <!-- Engine Size Dropdown -->
                        <div style="display: flex; align-items: center; gap: 12px;" class="paddingmobile">
                            <i class="fas fa-plug"></i>
                            <div class="dropdown w-100">
                                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                    type="button" id="engine_sizeDropdown" data-bs-toggle="dropdown">
                                    <span>{{ $engine_sizeselected ?? 'Engine size' }}</span>
                                    <i class="fas fa-chevron-down ml-2"></i> <!-- Custom arrow -->
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            onclick="updateDropdownText('Any', 'engineSizeDropdown', 'engine_sizeInput')">
                                            Any
                                        </a>
                                    </li>
                                    @foreach ($search_field['engine_size'] as $engine_size)
                                        @if ($engine_size->engine_size !== 'N/AL' && $engine_size->engine_size !== '0.0L')
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                    onclick="updateDropdownText('{{ $engine_size->engine_size }}', 'engine_sizeDropdown', 'engine_sizeInput')">
                                                    {{ $engine_size->engine_size }} ({{ $engine_size->count }})
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                                <input type="hidden" name="engine_size" id="engine_sizeInput"
                                    value="{{ $engine_sizeselected ?? '' }}">
                            </div>
                        </div>

                        <!-- Colors Dropdown -->
                        <div style="display: flex; align-items: center; gap: 12px;" class="paddingmobile">
                            <i class="fas fa-brush"></i>
                            <div class="dropdown w-100">
                                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                    type="button" id="colorsDropdown" data-bs-toggle="dropdown">
                                    <span>{{ $colorsselected ?? 'Colors' }}</span>
                                    <i class="fas fa-chevron-down ml-2"></i> <!-- Custom arrow -->
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            onclick="updateDropdownText('Any', 'colorsDropdown', 'colorsInput')">
                                            Any
                                        </a>
                                    </li>
                                    @foreach ($search_field['colors'] as $colors)
                                        @if ($colors->colors !== 'N/A')
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                    onclick="updateDropdownText('{{ $colors->colors }}', 'colorsDropdown', 'colorsInput')">
                                                    {{ $colors->colors }} ({{ $colors->count }})
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                                <input type="hidden" name="colors" id="colorsInput"
                                    value="{{ $colorsselected ?? '' }}">
                            </div>
                        </div>
                        <input type="hidden" name="sort" id="sortInput" value="">
                </div>
                <div class="modal-footer desktopfooter"
                    style="position: sticky; bottom: -20px; background-color: white; z-index: 1000; display:flex; justify-content:space-between; align-items:center;">
                    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: nowrap;">
                        <button type="button" class="btn bottonbuttons"
                            style="text-decoration: underline; white-space: nowrap;"
                            data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn bottonbuttons"
                            style="text-decoration: underline; white-space: nowrap;" onclick="clearFiltersModel()">Clear
                            All</button>
                    </div>
                    <button style="background-color: black; color: white; white-space: nowrap;" type="submit"
                        class="btn bottonbuttons">Apply
                        Filters</button>
                </div>

                </form>

            </div>
        </div>
    </div>
    </div>
    <!-- <div class="d-block d-lg-none">
                 <div id="externalDropdown" class="search-form-modal" style="z-index: 10000;">
                     <div class="modal-contentmobile">
                        <div style="display: flex; justify-content: flex-end;" >
                            <span onclick="closeExternalDropdown()" style="padding-top: 20px; padding-right: 20px; padding-bottom: 0 !important;"> <strong>Back</strong></span>
                        </div>
                         <ul id="externalDropdownList" style="list-style: none; padding-top: 0 !important; margin-top: 0 !important;"></ul>
                     </div>
                 </div>
             </div> -->

    </div>
    </div>

    <script>
        // const params = new URLSearchParams(window.location.search);
        // updateSearchCount(params.toString());

        function updateSearchCount(url) {
            const formData = new FormData();

            const params = new URLSearchParams(`?${url}`);
            params.forEach((value, key) => {
                formData.append(key, value);
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

        (function() {





            var mobileSearchButton = document.getElementById('mobile-search-button');
            var mobileSearchForm = document.getElementById('mobileSearchForm');

            mobileSearchButton.addEventListener('click', function() {
                mobileSearchForm.classList.toggle('show');
                document.body.classList.toggle('no-scroll');
                setTimeout(() => {
                    mobileSearchForm.style.setProperty('z-index', '100', 'important');
                }, 1000);
            });


            const dropdownMenus = document.querySelectorAll('.dropdown-menu');

            dropdownMenus.forEach(function(menu) {
                const dropdown = menu.closest('.dropdown');
                if (!dropdown) return;

                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'attributes' && mutation.attributeName ===
                            'class') {
                            if (menu.classList.contains('show')) {
                                dropdown.classList.add('open');
                            } else {
                                dropdown.classList.remove('open');
                            }
                        }
                    });
                });

                observer.observe(menu, {
                    attributes: true,
                    attributeFilter: ['class']
                });

                // Check initial state
                if (menu.classList.contains('show')) {
                    dropdown.classList.add('open');
                }
            });
        })();

        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
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
                    'yearToInput': 'year' // Note the change here to 'year'
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
                    'yearto': ['year']
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

                const currentFilterValue = window.currentFilters ? window.currentFilters[fieldName.toLowerCase()] : '';
                options.forEach(option => {
                    const isSelected = String(option.value) === String(currentFilterValue);
                    const escapedValue = String(option.value).replace(/'/g, "\\'");
                    const escapedLabel = String(option.label).replace(/'/g, "\\'");
                    html += `
               <li>
                   <a class="dropdown-item ${isSelected ? 'selected-option' : ''}" href="javascript:void(0)"
                      data-value="${escapedValue}"
                      onclick="updateDropdownText('${escapedValue}', '${fieldName}Dropdown', '${fieldName}Input', '${escapedLabel}')">
                       ${escapedLabel}&nbsp;&nbsp;&nbsp;&nbsp;(${option.count})
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




                // Initialize currentFilters from URL parameters
                const urlParams = new URLSearchParams(window.location.search);
                for (const [key, value] of urlParams.entries()) {
                    if (value.trim() !== '' && value.trim() !== " ") {
                        if (key === 'year_from') window.currentFilters.yearFrom = value;
                        else if (key === 'year_to') window.currentFilters.yearTo = value;
                        else if (key === 'price_from') window.currentFilters.pricefrom = value;
                        else if (key === 'price_to') window.currentFilters.priceto = value;
                        else window.currentFilters[key] = value;
                    }
                }

                if (makeselected) {
                    window.currentFilters.make = makeselected;
                    if (document.getElementById('makeDropdown')) {
                        if (document.getElementById('makeDropdown').textContent.trim() !== makeselected
                            .trim()) {
                            updateDropdownText(makeselected, 'makeDropdown', 'makeInput');
                            // Fetch models for the selected make
                            fetchModels(makeselected);
                        }
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
                if (milesselected) {

                    if (document.getElementById('milesDropdown').textContent !== milesselected) {

                        updateDropdownText(milesselected, 'milesDropdown', 'milesInput',
                            'Up to {{ number_format($milesselected) }} miles');

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


            window.updateDropdownText = function(value, dropdownId, inputId, displayLabel = null) {
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
                    // Handle dropdowns with span inside (like Make dropdown)
                    const span = dropdown.querySelector('span');
                    if (span) {
                        span.textContent = displayText;
                    } else {
                        dropdown.textContent = displayText;
                    }
                    input.value = value === "Any" ? "" : value;

                    const filterName = inputId.replace("Input", "").toLowerCase();
                    window.currentFilters[filterName] = input.value;
                    enableNextDropdown(dropdownId);
                    updateAllDropdowns();

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
                        const span = dropdown.querySelector('span');
                        if (span) {
                            span.textContent = displayValue;
                        } else {
                            dropdown.textContent = displayValue;
                        }
                        input.value = value === "Any" ? "" : value.toString().replace(/[,£]/g, "");
                        // Refresh models if a make is selected
                        if (window.currentFilters.make) {
                            fetchModels(window.currentFilters.make);
                        }
                    }

                    updateAllDropdowns();
                    updateCarListings();
                    updateFilterButtons();
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
                // updateAllDropdowns();
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
                if (!price) return {
                    value: 0,
                    displayValue: "£0"
                };

                const parsedPrice = parseInt(price);

                // Define price buckets
                const ranges = [{
                        max: 5000,
                        increment: 500
                    },
                    {
                        max: 10000,
                        increment: 1000
                    },
                    {
                        max: 50000,
                        increment: 5000
                    },
                    {
                        max: 100000,
                        increment: 10000
                    }
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

            function formatOptionData(key, options = []) {

                let consolidatedOptions = {};

                options.forEach(option => {
                    let value = option[key] || option;

                    if (!consolidatedOptions[value]) {
                        consolidatedOptions[value] = {
                            value: value,
                            count: 0
                        };
                    }
                    consolidatedOptions[value].count += (option.count || 0);

                });

                return consolidatedOptions;
            }


            function updateDropdownOptions(fieldName, options, key = '') {
                const fieldLabels = {
                    make: "Make",
                    fueltype: "Fuel Type",
                    bodytype: "Body Type",
                    enginesize: "Engine Size",
                    doors: "Doors",
                    colors: "Colors",
                    sellertype: "Seller Type",
                    gearbox: "Gearbox",
                    yearfrom: "Year From",
                    yearto: "Year To",
                    pricefrom: "Price From",
                    priceto: "Price To",
                    maxmiles: "Max Miles",
                };

                const sellerTypeLabels = {
                    car_dealer: "Dealer",
                    private_seller: "Private"
                };

                const dropdown = document.getElementById(`${fieldName}Dropdown`);
                if (!dropdown) {
                    console.error(`Dropdown elements not found for ${fieldName}`);
                    return;
                }
                const dropdownParent = dropdown.closest('.dropdown');

                const dropdownMenu = dropdownParent.querySelector('.dropdown-menu');
                const customSelectList = dropdownParent.querySelector('.custom-select-list');


                // Consolidate options
                let consolidatedOptions = {};

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
                    consolidatedOptions = formatOptionData(key, options);
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
                        // For year fields, sort in descending order (newest to oldest)
                        if ((fieldName === 'yearfrom' || fieldName === 'yearto') && !isNaN(numA) && !isNaN(
                            numB)) {
                            return numB - numA;
                        }
                        return !isNaN(numA) && !isNaN(numB) ?
                            numA - numB :
                            a.displayValue.localeCompare(b.displayValue);
                    });
                // Add sorted options to dropdown
                const currentFilterValue = window.currentFilters ? window.currentFilters[fieldName.toLowerCase()] :
                    '';

                sortedOptions.forEach(option => {
                    const isSelected = String(option.value) === String(currentFilterValue);
                    const escapedValue = String(option.value).replace(/'/g, "\\'");
                    const escapedDisplay = String(option.displayValue).replace(/'/g, "\\'");

                    html += `
            <li>
                <a class="dropdown-item ${isSelected ? 'selected-option' : ''}" href="javascript:void(0)"
                   onclick="updateDropdownText('${escapedValue}', '${fieldName}Dropdown', '${fieldName}Input', '${escapedDisplay}')">
                    ${escapedDisplay}&nbsp;&nbsp;&nbsp;&nbsp;(${option.count})
                </a>
            </li>
        `;
                });

                dropdownMenu.innerHTML = html;

                if (customSelectList) {
                    customSelectList.innerHTML = html;
                }

                // Don't update dropdown button text here - let updateDropdownText handle it
                // This function only updates the dropdown menu items
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

            var isMount = false;
            updateAllDropdowns();

            function updateAllDropdowns() {
                // updateSearchCount();
                // const queryParams = new URLSearchParams();
                // for (const [key, value] of Object.entries(window.currentFilters)) {
                //     if (value) {
                //         queryParams.append(key, value);
                //     }
                // }

                // Create query string from current filters
                var queryParams = new URLSearchParams('');
                var queryParamsCount = new URLSearchParams('');

                // Parameter name mapping for the endpoint (currentFilters keys -> API endpoint params)
                const paramMapping = {
                    'year_from': 'yearfrom',
                    'year_to': 'yearto',
                    'price_from': 'pricefrom',
                    'price_to': 'priceto',
                    'yearFrom': 'yearfrom',
                    'yearTo': 'yearto',
                    'pricefrom': 'pricefrom',
                    'priceto': 'priceto',
                    'fuel_type': 'fuel_type',
                    'body_type': 'body_type',
                    'engine_size': 'engine_size',
                    'seller_type': 'seller_type',
                    'gear_box': 'gear_box',
                    'miles': 'miles'
                };

                if (isMount) {
                    // Build queryParamsCount with all filters for search count
                    for (const [key, value] of Object.entries(window.currentFilters)) {
                        if (value && value.toString().trim() !== '' && value !== 'Any') {
                            queryParamsCount.append(key, value);
                        }
                    }

                    // Build queryParams for dropdown filtering - include ALL active filters
                    // This ensures counts reflect all selected filters (including make, model, variant)
                    for (const [key, value] of Object.entries(window.currentFilters)) {
                        if (value && value.toString().trim() !== '' && value !== 'Any') {
                            // Map the key to API parameter name
                            const mappedKey = paramMapping[key] || key;
                            queryParams.append(mappedKey, value);
                        }
                    }
                } else {
                    isMount = true;
                    const urlParams = new URLSearchParams(window.location.search);
                    queryParams = new URLSearchParams();
                    queryParamsCount = new URLSearchParams();

                    // Initialize currentFilters from URL and build queryParams with proper mapping
                    for (const [key, value] of urlParams.entries()) {
                        if (value.trim() == '' || value.trim() == " " || value.trim() === null) {
                            continue;
                        }

                        // Map URL parameter names to endpoint parameter names
                        const mappedKey = paramMapping[key] || key;
                        queryParams.append(mappedKey, value);
                        queryParamsCount.append(key, value);

                        // Store in currentFilters with proper key mapping
                        if (key === 'year_from') window.currentFilters.yearFrom = value;
                        else if (key === 'year_to') window.currentFilters.yearTo = value;
                        else if (key === 'price_from') window.currentFilters.pricefrom = value;
                        else if (key === 'price_to') window.currentFilters.priceto = value;
                        else window.currentFilters[key] = value;
                    }
                }
                updateSearchCount(queryParamsCount.toString());

                // Log the query params for debugging
                console.log('Fetching dropdown data with params:', queryParams.toString());

                fetch(`/get-filtered-fieldssale?${queryParams.toString()}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Dropdown data received:', data);

                        // Update all dropdowns with proper null checks
                        if (data.fuel_type && Array.isArray(data.fuel_type)) {
                            updateDropdownOptions('fueltype', data.fuel_type, 'fuel_type');
                        }
                        if (data.body_type && Array.isArray(data.body_type)) {
                            updateDropdownOptions('bodytype', data.body_type, 'body_type');
                        }
                        if (data.engine_size && Array.isArray(data.engine_size)) {
                            updateDropdownOptions('enginesize', data.engine_size, 'engine_size');
                        }
                        if (data.doors && Array.isArray(data.doors)) {
                            updateDropdownOptions('doors', data.doors, 'doors');
                        }
                        if (data.colors && Array.isArray(data.colors)) {
                            updateDropdownOptions('colors', data.colors, 'colors');
                        }
                        if (data.seller_type && Array.isArray(data.seller_type)) {
                            updateDropdownOptions('sellertype', data.seller_type, 'seller_type');
                        }
                        if (data.gear_box && Array.isArray(data.gear_box)) {
                            updateDropdownOptions('gearbox', data.gear_box, 'gear_box');
                        }

                        if (data.miles && Array.isArray(data.miles)) {
                            const mileRanges = processeMileRanges(data.miles);
                            updateDropdownOptions('maxmiles', mileRanges, 'label');
                        }

                        if (data.year && Array.isArray(data.year)) {
                            updateDropdownOptions('yearfrom', data.year, 'yearfrom');
                            updateDropdownOptions('yearto', data.year, 'yearto');
                        }
                        if (data.price && Array.isArray(data.price)) {
                            updateDropdownOptions('pricefrom', data.price, 'pricefrom');
                            updateDropdownOptions('priceto', data.price, 'priceto');
                        }

                        // Update Make dropdown
                        if (data.make && Array.isArray(data.make)) {
                            updateDropdownOptions('make', data.make, 'make');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching dropdown data:', error);
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

            function fetchModels(make) {
                const modelDropdown = document.getElementById('modelList');
                const modelListMobile = document.getElementById('modelListMobile');
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
                        modelListMobile.innerHTML = '';

                        // Add "Any" option
                        const anyOption = document.createElement('li');
                        anyOption.innerHTML = `
                <a class="dropdown-item" href="javascript:void(0)"
                   onclick="updateDropdownText('Any', 'modelDropdown', 'modelInput')">
                    Clear filter
                </a>`;
                        modelDropdown.appendChild(anyOption);
                        modelListMobile.appendChild(anyOption.cloneNode(true));

                        // Add model options
                        const currentModel = window.currentFilters ? window.currentFilters.model : '';
                        data.models.forEach(model => {
                            const isSelected = String(model.model) === String(currentModel);
                            const escapedModel = String(model.model).replace(/'/g, "\\'");
                            const listItem = document.createElement('li');
                            listItem.innerHTML = `
                    <a class="dropdown-item ${isSelected ? 'selected-option' : ''}" href="javascript:void(0)"
                       onclick="updateDropdownText('${escapedModel}', 'modelDropdown', 'modelInput');">
                        ${escapedModel}&nbsp;&nbsp;&nbsp;&nbsp;(${model.count})
                    </a>`;
                            modelDropdown.appendChild(listItem.cloneNode(true));
                            modelListMobile.appendChild(listItem.cloneNode(true));
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

                        const currentVariant = window.currentFilters ? window.currentFilters.variant : '';
                        data.variants.forEach(variant => {
                            const isSelected = String(variant.variant) === String(currentVariant);
                            const escapedVariant = String(variant.variant).replace(/'/g, "\\'");
                            const listItem = document.createElement('li');
                            listItem.innerHTML = `
                    <a class="dropdown-item ${isSelected ? 'selected-option' : ''}" href="javascript:void(0)"
                       onclick="updateDropdownText('${escapedVariant}', 'variantDropdown', 'variantInput')">
                        ${escapedVariant}&nbsp;&nbsp;&nbsp;&nbsp;(${variant.count})
                    </a>`;
                            variantDropdown.appendChild(listItem);
                        });

                        document.getElementById('variantDropdown').disabled = false;
                    })
                    .catch(error => console.error('Error fetching variants:', error));
            }

        });


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
            document.getElementById('pricefromInput').value = '';
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
        }


        // function updateDropdownText(selectedValue, dropdownId, inputId, displayValue = null) {

        //     if(inputId == 'modelInput'){
        //         fetchVariants(selectedValue);
        //     }


        // const dropdownButton = document.getElementById(dropdownId);
        // const inputField = document.getElementById(inputId);
        // const selectedFilters = document.getElementById('selectedFilters');
        // const filterName = dropdownId.replace('Dropdown', '').toLowerCase();
        // console.log(inputField);
        // const buttonId = filterName + 'FilterButton';
        // if (selectedValue === 'Any') {
        //     dropdownButton.textContent = dropdownId.replace('Dropdown', ''); 
        //     inputField.value = '';
        //     removeFilter(buttonId, inputId);
        // } else {
        //     dropdownButton.textContent = displayValue || selectedValue;
        //     inputField.value = selectedValue;

        //     // Check if a button for this filter already exists
        //     if (document.getElementById(buttonId)) {
        //         // Update existing button
        //         const button = document.getElementById(buttonId);
        //         button.firstChild.textContent = displayValue || selectedValue; // Update the text content
        //     } else {
        //         // Create a new filter button
        //         const button = document.createElement('button');
        //         button.className = 'btn btn-outline-secondary btn-sm d-inline-flex align-items-center w-auto px-2';
        //         button.id = buttonId;
        //         button.innerHTML = `
    //           ${displayValue || selectedValue}
    //           <span class="ms-1" onclick="removeFilter('${buttonId}', '${inputId}')" style="cursor: pointer;">&times;</span>
    //       `;
        //         selectedFilters.prepend(button); // Add to the beginning
        //     }
        // }
        // }
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
                openExternalDropdown = function(...args) {
                    originalOpen(...args);
                    handleModalOpen('externalDropdown');
                };

                const originalClose = closeExternalDropdown;
                closeExternalDropdown = function() {
                    originalClose();
                    handleModalClose('externalDropdown');
                };
            }

            // Custom searchModal handling
            const searchModal = document.getElementById("searchModal");
            if (searchModal) {
                const btn = document.querySelector(".form-search-button button");
                const span = document.querySelector(".close");

                btn.addEventListener("click", function() {
                    searchModal.style.display = "flex";
                    searchModal.style.justifyContent = "center";
                    searchModal.style.alignItems = "center";
                    handleModalOpen("searchModal"); // Track open
                });

                span.addEventListener("click", function() {
                    searchModal.style.display = "none";
                    handleModalClose("searchModal"); // Track close
                });

                window.addEventListener("click", function(event) {
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

        history.pushState(null, null, location.href);

        window.addEventListener('popstate', e => {

            history.pushState(null, null, location.href);

            const dropdown = document.querySelector(".dropdown.custom-dropdown.open");

            if (dropdown) {
                dropdown.classList.remove('open');
                dropdown.querySelector(".dropdown-menu.show")?.classList.remove('show');
            }

            const modals = document.querySelectorAll(".custom-select-modal");

            if (modals.length) {
                modals.forEach((modal) => {
                    console.log(model.style.display);
                    if (modal.style.display == 'flex') {
                        modal.style.display = 'none';
                    }
                });
            }

            // const searchForm = document.querySelector(".desktop-hero-section-text.show");
            // if(searchForm){
            //     searchForm.classList.remove('show');
            // }



            // if (modalStack.length > 0) {
            //     const lastModalId = modalStack.pop();
            //     sessionStorage.setItem('modalStack', JSON.stringify(modalStack));

            //     const modalElement = document.getElementById(lastModalId);
            //     if (modalElement) {
            //         if (lastModalId === "filterModal") {
            //           const bsModal = bootstrap.Modal.getInstance(modalElement);
            //           if (bsModal) {
            //               bsModal.hide();
            //           }
            //         } else if (modalElement.classList.contains('modal')) {
            //             const bsModal = bootstrap.Modal.getInstance(modalElement);
            //             if (bsModal) {
            //                 bsModal.hide();
            //             }
            //         } else {
            //             modalElement.style.display = "none";
            //         }
            //     }

            //     if (modalStack.length > 0) {
            //         history.pushState({ action: 'modal-open' }, '');
            //     }
            // }
        });

        // Function to update car listings via AJAX
        function updateCarListings() {
            const carListingContainer = document.getElementById('mobilelayout');
            if (!carListingContainer) return;

            const loadingDiv = document.getElementById('loading');
            if (loadingDiv) {
                loadingDiv.style.display = 'block';
            }

            // Build query parameters from current filters
            const queryParams = new URLSearchParams();

            const paramMapping = {
                'yearfrom': 'year_from',
                'yearto': 'year_to',
                'pricefrom': 'price_from',
                'priceto': 'price_to',
                'fueltype': 'fuel_type',
                'bodytype': 'body_type',
                'enginesize': 'engine_size',
                'sellertype': 'seller_type',
                'gearbox': 'gear_box',
                'maxmiles': 'miles',
                'yearFrom': 'year_from',
                'yearTo': 'year_to'
            };

            // Get all filter inputs
            const inputMapping = {
                'makeInput': 'make',
                'modelInput': 'model',
                'variantInput': 'variant',
                'pricefromInput': 'price_from',
                'pricetoInput': 'price_to',
                'yearfromInput': 'year_from',
                'yeartoInput': 'year_to',
                'fueltypeInput': 'fuel_type',
                'bodytypeInput': 'body_type',
                'enginesizeInput': 'engine_size',
                'doorsInput': 'doors',
                'colorsInput': 'colors',
                'sellertypeInput': 'seller_type',
                'gearboxInput': 'gear_box',
                'maxmilesInput': 'miles'
            };

            // Add filters from inputs
            for (const [inputId, paramName] of Object.entries(inputMapping)) {
                const input = document.getElementById(inputId);
                if (input && input.value && input.value.trim() !== '' && input.value !== 'Any') {
                    queryParams.set(paramName, input.value);
                }
            }

            // Also add from currentFilters
            for (const [key, value] of Object.entries(window.currentFilters)) {
                if (value && value.toString().trim() !== '' && value !== 'Any') {
                    const mappedKey = paramMapping[key] || key;
                    queryParams.set(mappedKey, value);
                }
            }

            const url = `{{ route('search_car') }}?${queryParams.toString()}`;

            fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.html) {
                        carListingContainer.innerHTML = data.html;

                        // Apply progressive loading
                        applyProgressiveLoading(carListingContainer);

                        if (data.next_page_url) {
                            carListingContainer.setAttribute('data-next-page-url', data.next_page_url);
                            nextPageUrl = data.next_page_url;
                        }
                    }

                    // Update result count
                    const resultTitles = document.querySelectorAll('.result-title');
                    if (resultTitles.length > 0) {
                        const totalCount = getTotalCount(data, carListingContainer);
                        resultTitles.forEach(resultTitle => {
                            resultTitle.textContent = `${totalCount} used cars found`;
                        });
                    }

                    if (loadingDiv) {
                        loadingDiv.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error updating car listings:', error);
                    if (loadingDiv) {
                        loadingDiv.style.display = 'none';
                    }
                });
        }

        // Function to update filter buttons dynamically
        function updateFilterButtons() {
            const selectedFilters = document.getElementById('selectedFilters');
            if (!selectedFilters) return;

            const filterButtons = {
                make: {
                    id: 'makeFilterButton',
                    inputId: 'makeInput',
                    label: 'Make'
                },
                model: {
                    id: 'modelFilterButton',
                    inputId: 'modelInput',
                    label: 'Model'
                },
                variant: {
                    id: 'variantFilterButton',
                    inputId: 'variantInput',
                    label: 'Variant'
                },
                pricefrom: {
                    id: 'priceFromFilterButton',
                    inputId: 'pricefromInput',
                    label: 'Price From'
                },
                priceto: {
                    id: 'priceToFilterButton',
                    inputId: 'pricetoInput',
                    label: 'Price To'
                },
                yearfrom: {
                    id: 'yearFromFilterButton',
                    inputId: 'yearfromInput',
                    label: 'Year From'
                },
                yearto: {
                    id: 'yearToFilterButton',
                    inputId: 'yeartoInput',
                    label: 'Year To'
                },
                fuel_type: {
                    id: 'fuelTypeFilterButton',
                    inputId: 'fueltypeInput',
                    label: 'Fuel Type'
                },
                miles: {
                    id: 'milesFilterButton',
                    inputId: 'maxmilesInput',
                    label: 'Miles'
                },
                colors: {
                    id: 'colorsFilterButton',
                    inputId: 'colorsInput',
                    label: 'Color'
                },
                bodytype: {
                    id: 'bodyTypeFilterButton',
                    inputId: 'bodytypeInput',
                    label: 'Body Type'
                },
                enginesize: {
                    id: 'engineSizeFilterButton',
                    inputId: 'enginesizeInput',
                    label: 'Engine Size'
                },
                doors: {
                    id: 'doorsFilterButton',
                    inputId: 'doorsInput',
                    label: 'Doors'
                },
                sellertype: {
                    id: 'sellerTypeFilterButton',
                    inputId: 'sellertypeInput',
                    label: 'Seller Type'
                },
                gearbox: {
                    id: 'gearboxFilterButton',
                    inputId: 'gearboxInput',
                    label: 'Gearbox'
                }
            };

            // Helper function to format price
            function formatPriceDisplay(price) {
                if (!price) return '';
                const numPrice = parseFloat(price.toString().replace(/[,£]/g, ''));
                if (isNaN(numPrice)) return '';
                return '£' + numPrice.toLocaleString('en-GB');
            }

            // Remove all existing filter buttons (but keep the structure for + buttons)
            const existingButtons = selectedFilters.querySelectorAll('button[style*="background-color: #D6DDF5"]');
            existingButtons.forEach(btn => {
                // Only remove buttons with × symbol (active filters)
                if (btn.innerHTML.includes('&times;') || btn.innerHTML.includes('×')) {
                    btn.remove();
                }
            });

            // Add filter buttons for active filters
            for (const [key, config] of Object.entries(filterButtons)) {
                const input = document.getElementById(config.inputId);
                if (!input) continue;

                const value = input.value || window.currentFilters[key] || window.currentFilters[key.toLowerCase()];
                if (!value || value.toString().trim() === '' || value === 'Any') continue;

                let displayText = value.toString();

                // Format price displays
                if (key === 'pricefrom' || key === 'priceto') {
                    displayText = formatPriceDisplay(value);
                }

                // Check if button already exists (from PHP rendered state)
                let button = document.getElementById(config.id);

                if (!button) {
                    // Create new button
                    button = document.createElement('button');
                    button.id = config.id;
                    button.className = 'btn btn-sm d-inline-flex align-items-center w-auto px-2';
                    button.style.cssText = 'background-color: #D6DDF5';
                    button.setAttribute('data-bs-toggle', 'modal');
                    button.setAttribute('data-bs-target', '#filterModal');
                    button.setAttribute('data-filter-name', key);
                }

                button.innerHTML = `
            ${displayText}
            <span class="ms-1" onclick="removeFilter('${config.id}', '${config.inputId}'); event.stopPropagation();" style="cursor: pointer;">&times;</span>
        `;

                // Insert before the first "+" button or at the end
                const firstAddButton = selectedFilters.querySelector('button[style*="background-color: white"]');
                if (firstAddButton) {
                    selectedFilters.insertBefore(button, firstAddButton);
                } else {
                    selectedFilters.appendChild(button);
                }
            }
        }
    </script>
@endsection
