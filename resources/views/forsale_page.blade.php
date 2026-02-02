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
            @media(max-width:1440px) {
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
            padding: 10px 16px;
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
            /*#filterModal .dropdown-item::before,
                    #filterModal .dropdown-item::after,
                    .dropdown-item::before,
                    .dropdown-item::after {
                        display: none !important;
                        content: none !important;
                        }*/

            /* Specifically hide circles in dropdown menu items */
            /*#filterModal .dropdown-menu li::before,
                    #filterModal .dropdown-menu li::after,
                    .dropdown-menu li::before,
                    .dropdown-menu li::after {
                        display: none !important;
                        content: none !important;
                        }*/

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

            /* Container scroll rahega, but native scrollbar hide ho jayegi */
            .desktop-hero-section-text {
                overflow-y: auto;
                overflow-x: hidden;
                position: relative;
                padding-right: 18px;
                /* indicator space */
                scrollbar-gutter: stable;
            }

            /* ✅ Hide native scrollbar - Chrome/Edge/Safari */
            .desktop-hero-section-text::-webkit-scrollbar {
                width: 0 !important;
                height: 0 !important;
            }

            /* ✅ Hide native scrollbar - Firefox */
            .desktop-hero-section-text {
                scrollbar-width: none;
                /* hides scrollbar */
            }

            /* ✅ Hide native scrollbar - old Edge/IE */
            .desktop-hero-section-text {
                -ms-overflow-style: none;
            }

            /* ✅ Permanent custom indicator */
            .desktop-hero-section-text .scroll-indicator {
                position: absolute;
                top: 8px;
                right: 6px;
                width: 6px;
                height: calc(100% - 16px);
                background: rgba(0, 0, 0, .12);
                border-radius: 999px;
                pointer-events: none;
                z-index: 10;
            }

            .desktop-hero-section-text .scroll-indicator .thumb {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 40px;
                /* JS update karega */
                background: rgba(0, 0, 0, .45);
                border-radius: 999px;
                transform: translateY(0);
            }

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
            /*#filterModal .dropdown-item::before,
                    #filterModal .dropdown-item::after,
                    .dropdown-item::before,
                    .dropdown-item::after {
                        display: none !important;
                        content: none !important;
                        }*/

            /* Specifically hide circles in dropdown menu items */
            /*#filterModal .dropdown-menu li::before,
                    #filterModal .dropdown-menu li::after,
                    .dropdown-menu li::before,
                    .dropdown-menu li::after {
                        display: none !important;
                        content: none !important;
                        }*/

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
                overflow: scroll !important;
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

            /* For-sale page only: show the "Close" button inside the search form (mobile only) */
            #mobileSearchForm .pc-mobile-search-close {
                display: inline-flex !important;
                justify-content: center !important;
                align-items: center !important;
                text-align: center !important;
            }
        }

        #sortList .dropdown-item {
            padding: 10px 34px !important;
            font-size: 16px !important;
        }

        .dropdowns.custom-dropdown .dropdown-menu .dropdown-item::before {
            background-color: red !important;
        }

        /*dropdown css*/
        #sortList .dropdown-item {
            position: relative !important;
            padding-left: 44px !important;
        }

        /* Outer ring (unselected) */
        #sortList .dropdown-item::before {
            content: "" !important;
            position: absolute !important;
            left: 18px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            width: 18px !important;
            height: 18px !important;
            border-radius: 50% !important;
            border: 2px solid #cbd5e1 !important;
            background: #fff !important;
            /* ring ke andar white */
        }

        /* Inner dot (hidden by default) */
        #sortList .dropdown-item::after {
            content: "" !important;
            position: absolute !important;
            left: 23px !important;
            /* (14 + 18/2) - (8/2) = 23 */
            top: 50% !important;
            transform: translateY(-50%) !important;
            width: 8px !important;
            height: 8px !important;
            border-radius: 50% !important;
            background: #0d6efd !important;
            opacity: 0 !important;
            /* default hide */
        }

        /* Selected: ring blue + show inner dot */
        #sortList .dropdown-item.sort-selected::before {
            border-color: #0d6efd !important;
        }

        #sortList .dropdown-item.sort-selected::after {
            opacity: 1 !important;
        }

        /* Safety: Bootstrap active background off */
        #sortList .dropdown-item.active,
        #sortList .dropdown-item:active {
            background: transparent !important;
            color: inherit !important;
        }

        .dropdown-item.active,
        .dropdown-item:active {
            background-color: transparent;
        }
    </style>

    <div class="hero-section-desktop">
        <div class="desktop-hero-section display-mobile-none">
            <img style="width:100%; height:100%; object-fit:cover; z-index:1; cursor: pointer;"
                src="https://purecar.co.uk/images/page_sections/1763807298_BMW-M5-CS-rear-view-1600x1200-cropped.jpg"
                alt="">
        </div>
        <div class="desktop-hero-section-text" id="mobileSearchForm">
            <div class="desktop-hero-section-innerbox">
                @include('partials.car_search_form', [
                    'formId' => 'heroSearchForm',
                    'showCloseButton' => true,
                ])
            </div>

            <div class="scroll-indicator" aria-hidden="true">
                <div class="thumb"></div>
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
                <p class="mb-0 result-title" id="forsaleTotalCount">{{ $totalCount }} used cars found</p>
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
            <div class="grid-for-car-cards" id="mobilelayout" data-next-page-url="{{ $cars->nextPageUrl() }}"
                data-prev-page-url="{{ $cars->previousPageUrl() }}"
                data-current-page="{{ $cars->currentPage() }}"
                data-last-page="{{ $cars->lastPage() }}"
                data-filter-query="{{ http_build_query(request()->except(['page', '_token'])) }}">
                @include('partials.car_list', ['cars' => $cars])
                <div id="lazy-load-marker" style="height: 1px;"></div>
            </div>

            <div id="loading" style="display: none; text-align: center; margin-top: 20px;">
                <p>Loading more cars...</p>
            </div>

            {{-- Load More Button --}}
            <div id="load-more-container" class="text-center mt-4 mb-4" style="display: none;">
                <button id="load-more-btn" class="btn btn-dark">
                    Load More Cars
                </button>
            </div>

            {{-- End of Results Message --}}
            <div id="end-of-results" class="text-center mt-4 mb-4" style="display: none;">
                <p class="text-muted"></p>
            </div>
        
        </div>
        <!-- Mobile Filter -->
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
                        <a class="dropdown-item" onclick="setSortOption('newest', this)" href="javascript:void(0)">Most
                            Recent</a>
                    </li>
                    <li>
                        <a class="dropdown-item" onclick="setSortOption('low-high', this)"
                            href="javascript:void(0)">Price (low
                            to high)</a>
                    </li>
                    <li>
                        <a class="dropdown-item" onclick="setSortOption('high-low', this)"
                            href="javascript:void(0)">Price
                            (high to low)</a>
                    </li>
                    <li>
                        <a class="dropdown-item" onclick="setSortOption('mileage', this)"
                            href="javascript:void(0)">Mileage
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



    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true"
        style="z-index: 10000;">
        <div class="modal-dialog modal-dialog-scrollable" style="max-width: 650px; width: 90%;  border-radius:10px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter and sort</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('forsale_filter') }}">
                        @csrf
                        <!-- Sort -->
                        <div style="display: flex; align-items: center; gap: 10px;" class="paddingmobile">
                            <i class="fas fa-filter"></i>
                            <select class="form-select bg-white w-100" name="sort" id="sort"
                                style="height: 40px;">
                                <option value="">Sort</option>
                                <option value="most-recent">Most Recent</option>
                                <option value="low-high">Price (low to high)</option>
                                <option value="high-low">Price (high to low)</option>
                                <option value="mileage">Mileage (low to high)</option>
                                <option value="mileage-low">Mileage (high to low)</option>
                                <option value="newest">Age (newest)</option>
                                <option value="oldest">Age (oldest)</option>
                            </select>
                        </div>
                        <!-- Make Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 10px;"
                            class="paddingmobile">
                            <i class="fas fa-car"></i>
                            <select class="form-select search_color w-100" name="make" id="make">
                                <option value="">Clear filter</option>
                                @foreach ($search_field['make'] as $make)
                                    <option value="{{ $make->make }}"
                                        {{ !empty($makeselected) && $make->make === $makeselected ? 'selected' : '' }}>
                                        {{ $make->make }} ({{ $make->count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Model Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 10px;"
                            class="paddingmobile">
                            <i class="fas fa-car"></i>
                            <select class="form-select search_color w-100" name="model" id="model">
                                <option value="">Any</option>
                                @foreach ($search_field['model'] as $model)
                                    <option value="{{ $model->model }}"
                                        {{ !empty($modelselected) && $model->model === $modelselected ? 'selected' : '' }}>
                                        {{ $model->model }} ({{ $model->count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Variant Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 10px;"
                            class="paddingmobile">
                            <i class="fas fa-car"></i>
                            <select class="form-select search_color w-100" name="variant" id="variant">
                                <option value="">Any</option>
                                @foreach ($search_field['variant'] as $variant)
                                    <option value="{{ $variant->variant }}"
                                        {{ !empty($variantselected) && $variant->variant === $variantselected ? 'selected' : '' }}>
                                        {{ $variant->variant }} ({{ $variant->count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Year From Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px;" class="paddingmobile">
                            <i class="fas fa-calendar"></i>
                            <select class="form-select search_color w-100" name="year_from" id="year_from">
                                <option value="">Any</option>
                                @foreach (array_reverse($year_ranges) as $year)
                                    <option value="{{ $year }}"
                                        {{ !empty($yearfromselected) && (string) $year === (string) $yearfromselected ? 'selected' : '' }}>
                                        Up to {{ $year }} ({{ $year_counts_from[$year] ?? ($year_counts[$year] ?? 0) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Year To Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px;" class="paddingmobile">
                            <i class="fas fa-calendar"></i>
                            <select class="form-select search_color w-100" name="year_to" id="year_to">
                                <option value="">Any</option>
                                @foreach (array_reverse($year_ranges) as $year)
                                    <option value="{{ $year }}"
                                        {{ !empty($yeartoselected) && (string) $year === (string) $yeartoselected ? 'selected' : '' }}>
                                        Up to {{ $year }} ({{ $year_counts_to[$year] ?? ($year_counts[$year] ?? 0) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price From Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px;" class="paddingmobile">
                            <i class="fas fa-tag"></i>
                            <select class="form-select search_color w-100" name="price_from" id="price_from">
                                <option value="">Any</option>
                                @foreach ($price_counts as $price_range)
                                    <option value="{{ $price_range['min'] }}"
                                        {{ !empty($pricefromselected) && (string) $price_range['min'] === (string) $pricefromselected ? 'selected' : '' }}>
                                        From £{{ number_format($price_range['min']) }} ({{ $price_range['count_from'] ?? $price_range['count'] }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price To Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px;" class="paddingmobile">
                            <i class="fas fa-tag"></i>
                            <select class="form-select search_color w-100" name="price_to" id="price_to">
                                <option value="">Any</option>
                                @foreach ($price_counts as $price_range)
                                    <option value="{{ $price_range['max'] }}"
                                        {{ !empty($pricetoselected) && (string) $price_range['max'] === (string) $pricetoselected ? 'selected' : '' }}>
                                        Up to £{{ number_format($price_range['max']) }} ({{ $price_range['count_to'] ?? $price_range['count'] }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Fuel Type Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px;" class="paddingmobile">
                            <i class="fas fa-gas-pump"></i>
                            <select class="form-select search_color w-100" name="fuel_type" id="fuel_type">
                                <option value="">Any</option>
                                @foreach ($search_field['fuel_type'] as $fuel_type)
                                    <option value="{{ $fuel_type->fuel_type }}"
                                        {{ !empty($fuel_typeselected) && $fuel_type->fuel_type === $fuel_typeselected ? 'selected' : '' }}>
                                        {{ $fuel_type->fuel_type }} ({{ $fuel_type->count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Max Miles Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px;" class="paddingmobile">
                            <i class="fas fa-gauge"></i>
                            <select class="form-select search_color w-100" name="miles" id="miles">
                                <option value="">Any</option>
                                @foreach ([10000, 20000, 30000, 40000, 50000, 60000, 70000, 80000, 90000, 100000] as $mile)
                                    <option value="{{ $mile }}"
                                        {{ !empty($milesselected) && (string) $mile === (string) $milesselected ? 'selected' : '' }}>
                                        Up to {{ number_format($mile) }} miles
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Gearbox Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px;" class="paddingmobile">
                            <i class="fas fa-gear"></i>
                            <select class="form-select search_color w-100" name="gear_box" id="gear_box">
                                <option value="">Any</option>
                                @foreach ($search_field['gear_box'] as $gear_box)
                                    <option value="{{ $gear_box->gear_box }}"
                                        {{ !empty($gear_boxselected) && $gear_box->gear_box === $gear_boxselected ? 'selected' : '' }}>
                                        {{ $gear_box->gear_box }} ({{ $gear_box->count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Seller Type Dropdown -->
                        <div style="display: flex; align-items: center; gap: 10px;" class="paddingmobile">
                            <i class="fas fa-user"></i>
                            <select class="form-select search_color w-100" name="seller_type" id="seller_type">
                                <option value="">Any</option>
                                @foreach ($search_field['seller_type'] as $seller)
                                    <option value="{{ $seller->seller_type }}"
                                        {{ !empty($seller_typeselected) && $seller->seller_type === $seller_typeselected ? 'selected' : '' }}>
                                        {{ $seller->seller_type }} ({{ $seller->count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Body Style Dropdown -->
                        <div style="display: flex; align-items: center; gap: 5px;" class="paddingmobile">
                            <i class="fas fa-car-side"></i>
                            <select class="form-select search_color w-100" name="body_type" id="body_type">
                                <option value="">Any</option>
                                @foreach ($search_field['body_type'] as $body_type)
                                    @if ($body_type->body_type !== 'N/A' && $body_type->body_type !== 'UNLISTED')
                                        <option value="{{ $body_type->body_type }}"
                                            {{ !empty($body_typeselected) && $body_type->body_type === $body_typeselected ? 'selected' : '' }}>
                                            {{ $body_type->body_type }} ({{ $body_type->count }})
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- Doors Dropdown -->
                        <div style="display: flex; align-items: center; gap: 5px;" class="paddingmobile">
                            <i class="fas fa-door-open"></i>
                            <select class="form-select search_color w-100" name="doors" id="doors">
                                <option value="">Any</option>
                                @foreach ($search_field['doors'] as $doors)
                                    @if ($doors->doors !== 0)
                                        <option value="{{ $doors->doors }}"
                                            {{ !empty($doorsselected) && (string) $doors->doors === (string) $doorsselected ? 'selected' : '' }}>
                                            {{ $doors->doors }} ({{ $doors->count }})
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- Engine Size Dropdown -->
                        <div style="display: flex; align-items: center; gap: 12px;" class="paddingmobile">
                            <i class="fas fa-plug"></i>
                            <select class="form-select search_color w-100" name="engine_size" id="engine_size">
                                <option value="">Any</option>
                                @foreach ($search_field['engine_size'] as $engine_size)
                                    @if ($engine_size->engine_size !== 'N/AL' && $engine_size->engine_size !== '0.0L')
                                        <option value="{{ $engine_size->engine_size }}"
                                            {{ !empty($engine_sizeselected) && $engine_size->engine_size === $engine_sizeselected ? 'selected' : '' }}>
                                            {{ $engine_size->engine_size }} ({{ $engine_size->count }})
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- Colors Dropdown -->
                        <div style="display: flex; align-items: center; gap: 12px;" class="paddingmobile">
                            <i class="fas fa-brush"></i>
                            <select class="form-select search_color w-100" name="colors" id="colors">
                                <option value="">Any</option>
                                @foreach ($search_field['colors'] as $colors)
                                    @if ($colors->colors !== 'N/A')
                                        <option value="{{ $colors->colors }}"
                                            {{ !empty($colorsselected) && $colors->colors === $colorsselected ? 'selected' : '' }}>
                                            {{ $colors->colors }} ({{ $colors->count }})
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer desktopfooter"
                    style="position: sticky; bottom: -20px; background-color: white; z-index: 1000; display:flex; justify-content:space-between; align-items:center;">
                    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: nowrap;">
                        <button type="button" class="btn bottonbuttons"
                            style="text-decoration: underline; white-space: nowrap;"
                            data-bs-dismiss="modal">Close</button>
                        <button type="reset" class="btn bottonbuttons"
                            style="text-decoration: underline; white-space: nowrap;">Clear All</button>
                    </div>
                    <button style="background-color: black; color: white; white-space: nowrap;" type="submit"
                        class="btn bottonbuttons">Apply
                        Filters</button>
                </div>

                </form>

            </div>
        </div>
    </div>


    <script>
        function parseNumberFromText(txt) {
            if (!txt) return NaN;
            return Number(String(txt).replace(/[^0-9.]/g, ''));
        }

        function getMilesFromCard(card) {
            const mileEl = card.querySelector('.car_detail .car_detail-item');
            return parseNumberFromText(mileEl?.textContent);
        }

        function getPriceFromCard(card) {
            const priceEl = card.querySelector('.car_price');
            const text = (priceEl?.textContent || '').trim();
            if (!text || text.toUpperCase() === 'POA') return Infinity;
            return parseNumberFromText(text);
        }

        function cacheOriginalOrder() {
            const container = document.getElementById('mobilelayout');
            if (!container) return;
            const wrappers = Array.from(container.querySelectorAll(':scope > div.my-3'));
            wrappers.forEach((w, i) => (w.dataset.originalIndex = String(i)));
        }

        // ✅ single select (remove sort-selected + active from siblings)
        function setSelectedSortUI(option, clickedEl) {
            // same dropdown menu ke andar operate karega
            const menu = clickedEl?.closest('ul.dropdown-menu') ||
                document.getElementById('sortList') ||
                document;

            const links = menu.querySelectorAll('.dropdown-item');
            links.forEach(a => {
                a.classList.remove('sort-selected');
                a.classList.remove('active'); // ✅ Bootstrap active bhi remove
                a.setAttribute('aria-current', 'false');
            });

            // target element find (fallback)
            const target = clickedEl || menu.querySelector(`.dropdown-item[data-sort="${option}"]`);
            if (target) {
                target.classList.add('sort-selected');
                target.classList.add('active'); // optional (Bootstrap)
                target.setAttribute('aria-current', 'true');
            }
        }

        window.setSortOption = function(option, el) {
            // 1) UI selection (only one)
            setSelectedSortUI(option, el);

            // 2) Sorting
            const container = document.getElementById('mobilelayout');
            if (!container) {
                console.warn('#mobilelayout not found');
                return;
            }

            const items = Array.from(container.querySelectorAll(':scope > div.my-3'));
            if (!items.length) return;

            if (!items[0].dataset.originalIndex) cacheOriginalOrder();

            const sorted = items.slice().sort((a, b) => {
                if (option === 'low-high') return getPriceFromCard(a) - getPriceFromCard(b);
                if (option === 'high-low') return getPriceFromCard(b) - getPriceFromCard(a);
                if (option === 'mileage') return getMilesFromCard(a) - getMilesFromCard(b);
                if (option === 'newest') return Number(a.dataset.originalIndex) - Number(b.dataset
                    .originalIndex);
                return 0;
            });

            const frag = document.createDocumentFragment();
            sorted.forEach(node => frag.appendChild(node));
            container.appendChild(frag);
        };

        document.addEventListener('DOMContentLoaded', function() {
            cacheOriginalOrder();

            // default select newest
            const first = document.querySelector('#sortList .dropdown-item[data-sort="newest"]');
            if (first) setSelectedSortUI('newest', first);
        });
    </script>



    <script>
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openBtn = document.getElementById('mobile-search-button');
            const panel = document.getElementById('mobileSearchForm');
            const closeBtn = document.querySelector('#mobileSearchForm .pc-mobile-search-close');

            function isMobile() {
                return window.matchMedia && window.matchMedia('(max-width: 768px)').matches;
            }

            function openPanel() {
                if (!panel) return;
                window.scrollTo({ top: 0, behavior: 'smooth' });
                panel.classList.add('show');
                document.body.style.overflow = 'scroll';
            }

            function closePanel() {
                if (!panel) return;
                panel.classList.remove('show');
                document.body.style.overflow = 'scroll';
            }

            if (openBtn) {
                openBtn.addEventListener('click', function(e) {
                    if (!isMobile()) return;
                    e.preventDefault();
                    openPanel();
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    closePanel();
                });
            }

            document.addEventListener('keydown', function(e) {
                if (!isMobile()) return;
                if (e.key === 'Escape') closePanel();
            });
        });
    </script>

    <script>
        (function() {
            function initScrollIndicator() {
                const box = document.getElementById('mobileSearchForm'); // same id as you have
                if (!box) return;

                const indicator = box.querySelector('.scroll-indicator');
                const thumb = indicator && indicator.querySelector('.thumb');
                if (!indicator || !thumb) return;

                function update() {
                    const scrollTop = box.scrollTop;
                    const scrollMax = box.scrollHeight - box.clientHeight;

                    // agar content fit hai, indicator hide (optional)
                    if (scrollMax <= 0) {
                        indicator.style.display = 'none';
                        return;
                    }
                    indicator.style.display = '';

                    const trackH = indicator.clientHeight;
                    const minThumb = 40;

                    const thumbH = Math.max(minThumb, Math.round(trackH * (box.clientHeight / box.scrollHeight)));
                    const maxY = trackH - thumbH;

                    const ratio = scrollMax > 0 ? (scrollTop / scrollMax) : 0;
                    const y = Math.round(maxY * ratio);

                    thumb.style.height = thumbH + 'px';
                    thumb.style.transform = 'translateY(' + y + 'px)';
                }

                box.addEventListener('scroll', update, {
                    passive: true
                });
                window.addEventListener('resize', update);

                // content changes par bhi update
                if (window.ResizeObserver) {
                    new ResizeObserver(update).observe(box);
                }

                update();
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initScrollIndicator);
            } else {
                initScrollIndicator();
            }
        })();
    </script>

    <script>
        (function() {
            const grid = document.getElementById('mobilelayout');
            if (!grid) return;

            let currentPage = parseInt(grid.dataset.currentPage || '1', 10);
            let lastPage = parseInt(grid.dataset.lastPage || '1', 10);
            let isLoading = false;
            let userHasScrolled = false;
            let observer = null;

            const loadingEl = document.getElementById('loading');
            const loadMoreContainer = document.getElementById('load-more-container');
            const loadMoreBtn = document.getElementById('load-more-btn');
            const endOfResults = document.getElementById('end-of-results');
            let marker = document.getElementById('lazy-load-marker');

            function hasNextPage() {
                return currentPage < lastPage;
            }

            function updateLoadMoreUI() {
                if (!loadMoreContainer) return;
                const isMobile = window.innerWidth <= 768;
                loadMoreContainer.style.display = hasNextPage() && !isMobile ? 'block' : 'none';
                if (!hasNextPage() && endOfResults) {
                    endOfResults.style.display = 'block';
                }
            }

            function isMobileView() {
                return window.innerWidth <= 768;
            }

            function buildNextUrl(nextPage) {
                const base = `${window.location.origin}${window.location.pathname}`;
                const filterQuery = grid.dataset.filterQuery || '';
                const params = new URLSearchParams(filterQuery);
                params.set('page', String(nextPage));
                const query = params.toString();
                return query ? `${base}?${query}` : `${base}?page=${nextPage}`;
            }

            function extractHtmlFromResponse(data) {
                if (data && typeof data === 'object') {
                    return data.html || data.cars_html || '';
                }
                return '';
            }

            function appendCars(html) {
                const temp = document.createElement('div');
                temp.innerHTML = html;
                const pagination = temp.querySelector('.pinmx-pagination-wrap');
                if (pagination) pagination.remove();

                // Ensure marker exists and is inside the grid
                let safeMarker = marker;
                if (!safeMarker || safeMarker.parentNode !== grid) {
                    safeMarker = document.createElement('div');
                    safeMarker.id = 'lazy-load-marker';
                    safeMarker.style.height = '1px';
                    grid.appendChild(safeMarker);
                }

                while (temp.firstChild) {
                    grid.insertBefore(temp.firstChild, safeMarker);
                }
            }

            function loadMoreCars() {
                if (isLoading || !hasNextPage()) return;
                isLoading = true;

                if (loadingEl) loadingEl.style.display = 'block';
                if (loadMoreBtn) {
                    loadMoreBtn.disabled = true;
                    loadMoreBtn.textContent = 'Loading...';
                }

                if (observer && marker) {
                    observer.unobserve(marker);
                }

                const nextPage = currentPage + 1;
                const url = buildNextUrl(nextPage);

                fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then((response) => response.json())
                    .then((data) => {
                        const html = extractHtmlFromResponse(data);
                        if (!html) return;

                        appendCars(html);
                        if (marker) {
                            grid.appendChild(marker);
                        }

                        currentPage = data.current_page ? parseInt(data.current_page, 10) : nextPage;
                        if (data.last_page) {
                            lastPage = parseInt(data.last_page, 10);
                        }

                        updateLoadMoreUI();
                    })
                    .catch((error) => {
                        console.error('Lazy loading failed:', error);
                    })
                    .finally(() => {
                        isLoading = false;
                        if (loadingEl) loadingEl.style.display = 'none';
                        if (loadMoreBtn) {
                            loadMoreBtn.disabled = false;
                            loadMoreBtn.textContent = 'Load More Cars';
                        }
                        if (observer && marker && hasNextPage()) {
                            observer.observe(marker);
                        }
                    });
            }

            function initObserver() {
                if (!marker || !('IntersectionObserver' in window)) return;

                observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (!userHasScrolled && !isMobileView()) return;
                        if (entry.isIntersecting) {
                            loadMoreCars();
                        }
                    });
                }, {
                    rootMargin: '200px 0px',
                    threshold: 0.01
                });

                observer.observe(marker);
            }

            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', loadMoreCars);
            }

            function onFirstScroll() {
                if (window.scrollY > 150) {
                    userHasScrolled = true;
                    window.removeEventListener('scroll', onFirstScroll);
                }
            }

            window.addEventListener('scroll', onFirstScroll, { passive: true });
            window.addEventListener('touchmove', onFirstScroll, { passive: true });

            updateLoadMoreUI();
            initObserver();

            window.addEventListener('resize', updateLoadMoreUI);

            window.addEventListener('pc:forsale-results-updated', function() {
                currentPage = parseInt(grid.dataset.currentPage || '1', 10);
                lastPage = parseInt(grid.dataset.lastPage || '1', 10);
                userHasScrolled = false;

                marker = document.getElementById('lazy-load-marker');
                if (observer) {
                    observer.disconnect();
                }
                updateLoadMoreUI();
                initObserver();
            });
        })();
    </script>

@endsection
