<style>
    .dropdown.custom-dropdown .dropdown-menu .dropdown-item {
        font-size: 13px !important;
    }

    .custom-select-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: 100000;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    /* Force modal fully hidden when closed - overrides any other display/visibility so it never "half shows" */
    .custom-select-modal.custom-select-modal--closed {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        height: 0 !important;
        max-height: 0 !important;
        overflow: hidden !important;
        pointer-events: none !important;
        position: fixed !important;
        left: -9999px !important;
        top: 0 !important;
        z-index: -1 !important;
    }
    .custom-select-modal.custom-select-modal--closed .custom-select-content {
        display: none !important;
        visibility: hidden !important;
    }

    .custom-select-content {
        background: #ffffff;
        width: 100%;
        max-width: 400px;
        max-height: 80vh;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        animation: fade-in 0.3s ease-out;
        overflow: hidden;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .custom-select-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 16px;
        border-bottom: 1px solid #f1efef;
        background: #fff;
    }

    .custom-select-title {
        font-size: 18px;
        font-weight: 600;
        color: #0E121B;
    }

    .custom-select-close {
        border: 0;
        background: transparent;
        font-size: 28px;
        line-height: 1;
        color: #0E121B;
        padding: 0;
        cursor: pointer;
    }

    .custom-select-list {
        list-style: none;
        padding: 0;
        margin: 0;
        flex-grow: 1;
        overflow-y: auto;
        background: #ffffff;
        border-bottom-left-radius: 16px;
        border-bottom-right-radius: 16px;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
        position: relative;
        scrollbar-gutter: stable;
    }


    @media (min-width: 768px) {
        .display-desktop-none {
            display: none !important;
        }

        .dropdown-item {
            padding: 18px 16px;
            color: #0E121B !important;
            white-space: normal !important;
            position: relative !important;
            padding-left: 40px !important;
            border-bottom: unset !important;
        }

        /* Show the same "selected circle" on desktop dropdown menus */
        .filter-box .dropdown-menu .dropdown-item::before {
            border: 3px solid #fff;
            border-radius: 16px;
            content: '';
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 14px;
            height: 14px;
            outline: 1px solid #BFBFBF;
            background: #fff;
        }

        .filter-box .dropdown-menu .dropdown-item.selected-option::before {
            outline: 1px solid #388BF7;
            background-color: #388BF7 !important;
        }
    }
    .dropdown.custom-dropdown .dropdown-toggle {

}
    @media (max-width: 768px) {

        .custom-select-header {
            height: 78px;
        }

        .desktop-hero-section-text {
            overflow-y: scroll !important;
        }

        /* Full-screen selector modal on mobile */
        .custom-select-modal {
            background: #fff !important;
            align-items: stretch !important;
            justify-content: stretch !important;
        }

        .custom-select-content {
            max-width: 100% !important;
            width: 100% !important;
            height: 100vh !important;
            max-height: 100vh !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            animation: none !important;
        }

        .custom-select-list {
            border-radius: 0 !important;
        }

        .dropdown-menu.mobile-menu .dropdown-item,
        .custom-select-list .dropdown-item {
            padding-left: 35px !important;
            position: relative;
            font-weight: normal !important;
            border-bottom: 1px solid #dddddd;
            font-size: 15px !important;
        }

        .custom-select-list .dropdown-item.selected-option::before {
            outline: 1px solid #388BF7;
            background-color: #388BF7 !important;
        }

        .custom-select-list .dropdown-item::before {
            border: 3px solid #fff;
            border-radius: 16px;
            content: '';
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 14px;
            height: 14px;
            outline: 1px solid #BFBFBF;
            background: #fff;
        }


        .custom-select-list .dropdown-item.selected-option::before {
            outline: 1px solid #388BF7;
            background-color: #388BF7;
        }

        /* We don't use Bootstrap dropdown menus on mobile (we use full-screen custom modals). */
        .dropdown-menu.mobile-menu {
            display: none !important;
        }

        .custom-select-modal .custom-select-list {
            max-height: 100% !important;
            height: 100% !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            -webkit-overflow-scrolling: touch !important;
            scrollbar-width: thin !important;
            scrollbar-color: #888 #f1f1f1 !important;
        }

        /* Force scrollbar to always be visible on mobile - Webkit browsers */
        .custom-select-modal .custom-select-list::-webkit-scrollbar {
            width: 8px !important;
            -webkit-appearance: none !important;
            display: block !important;
            background: transparent !important;
        }

        .custom-select-modal .custom-select-list::-webkit-scrollbar-track {
            background: #f1f1f1 !important;
            border-radius: 10px !important;
            -webkit-box-shadow: inset 0 0 2px rgba(0, 0, 0, 0.1) !important;
        }

        .custom-select-modal .custom-select-list::-webkit-scrollbar-thumb {
            background: #888 !important;
            border-radius: 10px !important;
            -webkit-box-shadow: inset 0 0 2px rgba(0, 0, 0, 0.2) !important;
            min-height: 30px !important;
        }

        .custom-select-modal .custom-select-list::-webkit-scrollbar-thumb:hover {
            background: #555 !important;
        }

        /* Force scrollbar visibility on iOS by adding a wrapper trick */
        .custom-select-modal .custom-select-list {
            scrollbar-gutter: stable !important;
        }

        .filter-item:has(#variantInput) {
            grid-column: 1 / -1;
        }

        /* Show Close button on mobile and make both buttons 50% width */
        .display-mobile-only {
            display: block !important;
        }

        .mobile-buttons-container {
            width: 100% !important;
        }

        .mobile-buttons-container .clear-all-link,
        .mobile-buttons-container .clear-all-link {
            width: 50% !important;
            text-align: center !important;
            padding: 8px 0 !important;
        }

    }

    /* Base styles for all dropdown items - 15px font size */
    .dropdown-menu .dropdown-item,
    .custom-select-list .dropdown-item {
        font-size: 15px !important;
    }

    /* Base styles for clear-all-link */
    .clear-all-link {
        text-decoration: underline !important;
        cursor: pointer !important;
        padding: 10px 20px !important;
    }

    /* Hide Close button on desktop */
    @media (min-width: 769px) {
        .display-mobile-only {
            display: none !important;
        }

        .search-btn-container>div {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            flex-wrap: nowrap !important;
        }

        .clear-all-link {
            white-space: nowrap !important;
        }
    }

    #variantDropdown {}

    #sortList .dropdown-item{
  position: relative;
  padding-left: 44px;
}

/* Outer ring (unselected) */
#sortList .dropdown-item::before{
  content:"";
  position:absolute;
  left:14px;
  top:50%;
  transform: translateY(-50%);
  width:18px;
  height:18px;
  border-radius:50%;
  border:2px solid #cbd5e1;
  background:transparent !important;           /* ring ke andar white */
}

/* Inner dot (hidden by default) */
#sortList .dropdown-item::after{
  content:"";
  position:absolute;
  left:23px;                 /* (14 + 18/2) - (8/2) = 23 */
  top:50%;
  transform: translateY(-50%);
  width:8px;
  height:8px;
  border-radius:50%;
  background:#0d6efd !important;
  opacity:0;                 /* default hide */
}

/* Selected: ring blue + show inner dot */
#sortList .dropdown-item.sort-selected::before{
  border-color:#0d6efd;
}

#sortList .dropdown-item.sort-selected::after{
  opacity:1;
}

/* Safety: Bootstrap active background off */
#sortList .dropdown-item.active,
#sortList .dropdown-item:active{
  background: transparent !important;
  color: inherit !important;
}


    /* Hide the "Close" button everywhere by default (we enable it only on for-sale page mobile). */
    .pc-mobile-search-close {
        display: none !important;
    }
</style>
<form class="filter-box" method="POST" action="{{ route('filter') }}" data-search-url="{{ route('search_car') }}"
    data-initial-facets='@json($initialFacets ?? null)' id="{{ $formId ?? 'desktopform' }}">
    @csrf
    <input type="hidden" name="page" id="pageInput" value="">
    <div class="filter-inner">
        <div class="filter-item flex-column gap-1">
            <label class="field-label text-start" for="make">Make</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                    type="button" id="makeDropdown" data-bs-toggle="dropdown" data-dropdown="make">
                    <span class="dropdown-text">Make</span>
                </button>
                <ul class="dropdown-menu overflow-auto display-mobile-none">
                    <li><span class="dropdown-item text-muted">Loading...</span></li>
                </ul>
                <div class="custom-select-modal display-desktop-none" data-modal="make">
                    <div class="custom-select-content">
                        <div class="custom-select-header">
                            <span class="custom-select-title">Make</span>
                            <button type="button" class="custom-select-close" aria-label="Close">&times;</button>
                        </div>
                        <ul class="custom-select-list">
                            <li><span class="dropdown-item text-muted">Loading...</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <input type="hidden" name="make" id="makeInput" value="">
        </div>

        <div class="filter-item flex-column gap-1">
            <label class="field-label text-start" for="model">Model</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                    type="button" id="modelDropdown" data-bs-toggle="dropdown" data-dropdown="model" disabled>
                    <span class="dropdown-text">Model</span>
                </button>
                <ul class="dropdown-menu ove display-mobile-none" id="modelList">
                    <li><span class="dropdown-item text-muted">Loading...</span></li>
                </ul>
            </div>
            <div class="custom-select-modal display-desktop-none" data-modal="model">
                <div class="custom-select-content">
                    <div class="custom-select-header">
                        <span class="custom-select-title">Model</span>
                        <button type="button" class="custom-select-close" aria-label="Close">&times;</button>
                    </div>
                    <ul class="custom-select-list" id="modelListMobile">
                        <li><span class="dropdown-item text-muted">Loading...</span></li>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="model" id="modelInput" value="">
        </div>

        <div class="filter-item flex-column gap-1">
            <label class="field-label text-start" for="variant">Variant</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                    type="button" id="variantDropdown" data-bs-toggle="dropdown" data-dropdown="variant" disabled>
                    <span class="dropdown-text">Variant</span>
                </button>
                <ul class="dropdown-menu overflow-auto display-mobile-none" id="variantList">
                    <li><span class="dropdown-item text-muted">Loading...</span></li>
                </ul>
            </div>
            <div class="custom-select-modal display-desktop-none" data-modal="variant">
                <div class="custom-select-content">
                    <div class="custom-select-header">
                        <span class="custom-select-title">Variant</span>
                        <button type="button" class="custom-select-close" aria-label="Close">&times;</button>
                    </div>
                    <ul class="custom-select-list">
                        <li><span class="dropdown-item text-muted">Loading...</span></li>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="variant" id="variantInput" value="">
        </div>

        <div class="filter-item flex-column gap-1">
            <label class="field-label text-start" for="bodytype">Body Type</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                    type="button" id="bodytypeDropdown" data-bs-toggle="dropdown" data-dropdown="bodytype"
                    data-model="false">
                    <span class="dropdown-text">Body Type</span>
                </button>
                <ul class="dropdown-menu overflow-auto display-mobile-none" id="bodytypeList">
                    <li><span class="dropdown-item text-muted">Loading...</span></li>
                </ul>
            </div>

            <div class="custom-select-modal display-desktop-none" data-modal="bodytype">
                <div class="custom-select-content">
                    <div class="custom-select-header">
                        <span class="custom-select-title">Body Type</span>
                        <button type="button" class="custom-select-close" aria-label="Close">&times;</button>
                    </div>
                    <ul class="custom-select-list">
                        <li><span class="dropdown-item text-muted">Loading...</span></li>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="body_type" id="bodytypeInput" value="">
        </div>
        <!-- Fuel Type to Max Miles -->

        <!-- Row 3: Max Miles, Engine Size, Doors, Colors, Seller Type (Hidden by default) -->
        <div class="filter-item flex-column gap-1">
            <label class="field-label text-start" for="maxmiles">Max Miles</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                    type="button" id="maxmilesDropdown" data-bs-toggle="dropdown" data-dropdown="maxmiles"
                    data-model="false">
                    <span class="dropdown-text">Max Miles</span>
                </button>
                <ul class="dropdown-menu overflow-auto display-mobile-none" id="maxmilesList">
                    <li><span class="dropdown-item text-muted">Loading...</span></li>
                </ul>
            </div>

            <div class="custom-select-modal display-desktop-none" data-modal="maxmiles">
                <div class="custom-select-content">
                    <div class="custom-select-header">
                        <span class="custom-select-title">Max Miles</span>
                        <button type="button" class="custom-select-close" aria-label="Close">&times;</button>
                    </div>
                    <ul class="custom-select-list">
                        <li><span class="dropdown-item text-muted">Loading...</span></li>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="miles" id="maxmilesInput" value="">
        </div>


        <!-- Row 2: Price From, Price To, Year From, Year To, Gearbox -->
        <div class="filter-item flex-column gap-1">
            <label class="field-label text-start" for="pricefrom">Price From</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                    type="button" id="pricefromDropdown" data-bs-toggle="dropdown" data-dropdown="price-from">
                    <span class="dropdown-text">Price From</span>
                </button>
                <ul class="dropdown-menu overflow-auto display-mobile-none" id="pricefromDropdownList">
                    <li><span class="dropdown-item text-muted">Loading...</span></li>
                </ul>
            </div>







            <div class="custom-select-modal display-desktop-none" data-modal="price-from">
                <div class="custom-select-content">
                    <div class="custom-select-header">
                        <span class="custom-select-title">Price From</span>
                        <button type="button" class="custom-select-close" aria-label="Close">&times;</button>
                    </div>
                    <ul class="custom-select-list">
                        <li><span class="dropdown-item text-muted">Loading...</span></li>
                    </ul>
                </div>
            </div>



            <input type="hidden" name="price_from" id="pricefromInput" value="">
        </div>

        <div class="filter-item flex-column gap-1">
            <label class="field-label text-start" for="priceto">Price To</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                    type="button" id="pricetoDropdown" data-dropdown="price-to" data-bs-toggle="dropdown">
                    <span class="dropdown-text">Price To</span>
                </button>
                <ul class="dropdown-menu overflow-auto display-mobile-none" id="priceDropdownList">
                    <li><span class="dropdown-item text-muted">Loading...</span></li>
                </ul>
            </div>






            <div class="custom-select-modal display-desktop-none" data-modal="price-to">
                <div class="custom-select-content">
                    <div class="custom-select-header">
                        <span class="custom-select-title">Price To</span>
                        <button type="button" class="custom-select-close" aria-label="Close">&times;</button>
                    </div>
                    <ul class="custom-select-list">
                        <li><span class="dropdown-item text-muted">Loading...</span></li>
                    </ul>
                </div>
            </div>



            <input type="hidden" name="price_to" id="pricetoInput" value="">
        </div>

        <div class="filter-item flex-column gap-1">
            <label class="field-label text-start" for="yearfrom">Year From</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                    data-dropdown="year-from" type="button" id="yearfromDropdown" data-bs-toggle="dropdown">
                    <span class="dropdown-text">Year From</span>
                </button>
                <ul class="dropdown-menu overflow-auto display-mobile-none" id="yearfromDropdown">
                    <li><span class="dropdown-item text-muted">Loading...</span></li>
                </ul>
            </div>







            <div class="custom-select-modal display-desktop-none" data-modal="year-from">
                <div class="custom-select-content">
                    <div class="custom-select-header">
                        <span class="custom-select-title">Year From</span>
                        <button type="button" class="custom-select-close" aria-label="Close">&times;</button>
                    </div>
                    <ul class="custom-select-list">
                        <li><span class="dropdown-item text-muted">Loading...</span></li>
                    </ul>
                </div>
            </div>








            <input type="hidden" name="year_from" id="yearfromInput" value="">
        </div>

        <div class="filter-item flex-column gap-1">
            <label class="field-label text-start" for="yearto">Year To</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                    data-dropdown="year-to" type="button" id="yeartoDropdown" data-bs-toggle="dropdown">
                    <span class="dropdown-text">Year To</span>
                </button>
                <ul class="dropdown-menu overflow-auto display-mobile-none" id="yearToDropdownList">
                    <li><span class="dropdown-item text-muted">Loading...</span></li>
                </ul>
            </div>









            <div class="custom-select-modal display-desktop-none" data-modal="year-to">
                <div class="custom-select-content">
                    <div class="custom-select-header">
                        <span class="custom-select-title">Year To</span>
                        <button type="button" class="custom-select-close" aria-label="Close">&times;</button>
                    </div>
                    <ul class="custom-select-list">
                        <li><span class="dropdown-item text-muted">Loading...</span></li>
                    </ul>
                </div>
            </div>




            <input type="hidden" name="year_to" id="yeartoInput" value="">
        </div>

        <!-- Gearbox to Engine Size -->

        <div class="filter-item flex-column gap-1">
            <label class="field-label text-start" for="enginesize">Engine Size</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                    type="button" id="enginesizeDropdown" data-bs-toggle="dropdown" data-dropdown="enginesize"
                    data-model="false">
                    <span class="dropdown-text">Engine Size</span>
                </button>
                <ul class="dropdown-menu overflow-auto display-mobile-none" id="enginesizeList">
                    <li><span class="dropdown-item text-muted">Loading...</span></li>
                </ul>
            </div>

            <div class="custom-select-modal display-desktop-none" data-modal="enginesize">
                <div class="custom-select-content">
                    <div class="custom-select-header">
                        <span class="custom-select-title">Engine Size</span>
                        <button type="button" class="custom-select-close" aria-label="Close">&times;</button>
                    </div>
                    <ul class="custom-select-list">
                        <li><span class="dropdown-item text-muted">Loading...</span></li>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="engine_size" id="enginesizeInput" value="">
        </div>

        <!-- Max Miles to Fuel Type -->

        <div class="filter-item flex-column gap-1 advanced-filter-row" style="display: none;">
            <label class="field-label text-start" for="fueltype">Fuel Type</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                    type="button" id="fueltypeDropdown" data-bs-toggle="dropdown" data-dropdown="fueltype"
                    data-model="false">
                    <span class="dropdown-text">Fuel Type</span>
                </button>
                <ul class="dropdown-menu overflow-auto display-mobile-none" id="fueltypeList">
                    <li><span class="dropdown-item text-muted">Loading...</span></li>
                </ul>
            </div>

            <div class="custom-select-modal display-desktop-none" data-modal="fueltype">
                <div class="custom-select-content">
                    <div class="custom-select-header">
                        <span class="custom-select-title">Fuel Type</span>
                        <button type="button" class="custom-select-close" aria-label="Close">&times;</button>
                    </div>
                    <ul class="custom-select-list">
                        <li><span class="dropdown-item text-muted">Loading...</span></li>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="fuel_type" id="fueltypeInput" value="">
        </div>

        <!-- Engine Size to Gearbox -->
        <div class="filter-item flex-column gap-1 advanced-filter-row" style="display: none;">
            <label class="field-label text-start" for="gearbox">Gearbox</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                    type="button" id="gearboxDropdown" data-bs-toggle="dropdown" data-dropdown="gearbox"
                    data-model="false">
                    <span class="dropdown-text">Gearbox</span>
                </button>
                <ul class="dropdown-menu overflow-auto display-mobile-none" id="gearboxList">
                    <li><span class="dropdown-item text-muted">Loading...</span></li>
                </ul>
            </div>

            <div class="custom-select-modal display-desktop-none" data-modal="gearbox">
                <div class="custom-select-content">
                    <div class="custom-select-header">
                        <span class="custom-select-title">Gearbox</span>
                        <button type="button" class="custom-select-close" aria-label="Close">&times;</button>
                    </div>
                    <ul class="custom-select-list">
                        <li><span class="dropdown-item text-muted">Loading...</span></li>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="gear_box" id="gearboxInput" value="">
        </div>


        <div class="filter-item flex-column gap-1 advanced-filter-row" style="display: none;">
            <label class="field-label text-start" for="doors">Doors</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                    type="button" id="doorsDropdown" data-bs-toggle="dropdown" data-dropdown="doors"
                    data-model="false">
                    <span class="dropdown-text">Doors</span>
                </button>
                <ul class="dropdown-menu overflow-auto display-mobile-none" id="doorsList">
                    <li><span class="dropdown-item text-muted">Loading...</span></li>
                </ul>
            </div>

            <div class="custom-select-modal display-desktop-none" data-modal="doors">
                <div class="custom-select-content">
                    <div class="custom-select-header">
                        <span class="custom-select-title">Doors</span>
                        <button type="button" class="custom-select-close" aria-label="Close">&times;</button>
                    </div>
                    <ul class="custom-select-list">
                        <li><span class="dropdown-item text-muted">Loading...</span></li>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="doors" id="doorsInput" value="">
        </div>

        <div class="filter-item flex-column gap-1 advanced-filter-row" style="display: none;">
            <label class="field-label text-start" for="colors">Colors</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                    type="button" id="colorsDropdown" data-bs-toggle="dropdown" data-dropdown="colors"
                    data-model="false">
                    <span class="dropdown-text">Colors</span>
                </button>
                <ul class="dropdown-menu overflow-auto display-mobile-none" id="colorsList">
                    <li><span class="dropdown-item text-muted">Loading...</span></li>
                </ul>
            </div>

            <div class="custom-select-modal display-desktop-none" data-modal="colors">
                <div class="custom-select-content">
                    <div class="custom-select-header">
                        <span class="custom-select-title">Colors</span>
                        <button type="button" class="custom-select-close" aria-label="Close">&times;</button>
                    </div>
                    <ul class="custom-select-list">
                        <li><span class="dropdown-item text-muted">Loading...</span></li>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="colors" id="colorsInput" value="">
        </div>

        <div class="filter-item flex-column gap-1 advanced-filter-row" style="display: none;">
            <label class="field-label text-start" for="sellertype">Seller Type</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                    type="button" id="sellertypeDropdown" data-bs-toggle="dropdown" data-dropdown="sellertype"
                    data-model="false">
                    <span class="dropdown-text">Seller Type</span>
                </button>
                <ul class="dropdown-menu overflow-auto display-mobile-none" id="sellertypeList">
                    <li><span class="dropdown-item text-muted">Loading...</span></li>
                </ul>
            </div>

            <div class="custom-select-modal display-desktop-none" data-modal="sellertype">
                <div class="custom-select-content">
                    <div class="custom-select-header">
                        <span class="custom-select-title">Seller Type</span>
                        <button type="button" class="custom-select-close" aria-label="Close">&times;</button>
                    </div>
                    <ul class="custom-select-list">
                        <li><span class="dropdown-item text-muted">Loading...</span></li>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="seller_type" id="sellertypeInput" value="">
            <input type="hidden" name="advanced" id="advancedInput" value="">
            <input type="hidden" name="sort" id="sortInput" value="">
        </div>
    </div>
    <div class="filter-actions d-flex align-items-center justify-content-between flex-wrap gap-2 mt-4">
        <button type="button" id="moreFiltersBtn" class="btn btn-outline-secondary more-filters-btn">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M7 21V18" stroke="#525866" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M17 21V15" stroke="#525866" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M17 6V3" stroke="#525866" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M7 9V3" stroke="#525866" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path
                    d="M7 18C6.06812 18 5.60218 18 5.23463 17.8478C4.74458 17.6448 4.35523 17.2554 4.15224 16.7654C4 16.3978 4 15.9319 4 15C4 14.0681 4 13.6022 4.15224 13.2346C4.35523 12.7446 4.74458 12.3552 5.23463 12.1522C5.60218 12 6.06812 12 7 12C7.93188 12 8.39782 12 8.76537 12.1522C9.25542 12.3552 9.64477 12.7446 9.84776 13.2346C10 13.6022 10 14.0681 10 15C10 15.9319 10 16.3978 9.84776 16.7654C9.64477 17.2554 9.25542 17.6448 8.76537 17.8478C8.39782 18 7.93188 18 7 18Z"
                    stroke="#525866" stroke-width="1.5" />
                <path
                    d="M17 12C16.0681 12 15.6022 12 15.2346 11.8478C14.7446 11.6448 14.3552 11.2554 14.1522 10.7654C14 10.3978 14 9.93188 14 9C14 8.06812 14 7.60218 14.1522 7.23463C14.3552 6.74458 14.7446 6.35523 15.2346 6.15224C15.6022 6 16.0681 6 17 6C17.9319 6 18.3978 6 18.7654 6.15224C19.2554 6.35523 19.6448 6.74458 19.8478 7.23463C20 7.60218 20 8.06812 20 9C20 9.93188 20 10.3978 19.8478 10.7654C19.6448 11.2554 19.2554 11.6448 18.7654 11.8478C18.3978 12 17.9319 12 17 12Z"
                    stroke="#525866" stroke-width="1.5" />
            </svg>
            More Filters
        </button>
        <button type="button" id="lessFiltersBtn" class="btn btn-outline-secondary less-filters-btn "
            style="display: none;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M7 21V18" stroke="#525866" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M17 21V15" stroke="#525866" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M17 6V3" stroke="#525866" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M7 9V3" stroke="#525866" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path
                    d="M7 18C6.06812 18 5.60218 18 5.23463 17.8478C4.74458 17.6448 4.35523 17.2554 4.15224 16.7654C4 16.3978 4 15.9319 4 15C4 14.0681 4 13.6022 4.15224 13.2346C4.35523 12.7446 4.74458 12.3552 5.23463 12.1522C5.60218 12 6.06812 12 7 12C7.93188 12 8.39782 12 8.76537 12.1522C9.25542 12.3552 9.64477 12.7446 9.84776 13.2346C10 13.6022 10 14.0681 10 15C10 15.9319 10 16.3978 9.84776 16.7654C9.64477 17.2554 9.25542 17.6448 8.76537 17.8478C8.39782 18 7.93188 18 7 18Z"
                    stroke="#525866" stroke-width="1.5" />
                <path
                    d="M17 12C16.0681 12 15.6022 12 15.2346 11.8478C14.7446 11.6448 14.3552 11.2554 14.1522 10.7654C14 10.3978 14 9.93188 14 9C14 8.06812 14 7.60218 14.1522 7.23463C14.3552 6.74458 14.7446 6.35523 15.2346 6.15224C15.6022 6 16.0681 6 17 6C17.9319 6 18.3978 6 18.7654 6.15224C19.2554 6.35523 19.6448 6.74458 19.8478 7.23463C20 7.60218 20 8.06812 20 9C20 9.93188 20 10.3978 19.8478 10.7654C19.6448 11.2554 19.2554 11.6448 18.7654 11.8478C18.3978 12 17.9319 12 17 12Z"
                    stroke="#525866" stroke-width="1.5" />
            </svg>
            Less Filters
        </button>
        <div class="d-flex align-items-center gap-2 search-btn-container">
            <div class="d-flex align-items-center gap-2 mobile-buttons-container">
                <button type="reset" class="btn btn-link clear-all-link p-0"
                    style="text-decoration: none !important;">Clear all</button>
                @if (!empty($showCloseButton))
                    <button type="button" class="btn btn-link clear-all-link p-0 pc-mobile-search-close"
                        style="text-decoration: none !important;">Close</button>
                @endif
                <!-- <button type="button" id="mobileSearchClose" style="border: 0; background: transparent; font-size: 32px; line-height: 1; padding: 0;">&times;</button> -->
            </div>
            <button type="submit" id="searchButton" class="btn btn-dark search-btn">Search ({{ $totalCount ?? $totalResults ?? 0 }}
                )</button>
        </div>
    </div>
</form>

<script>
    // Minimal JS kept for:
    // - Custom dropdown UI (hidden inputs)
    // - More/Less filters toggle
    // - AJAX: after any filter selection, POST to /filter and rebuild ALL dropdown option lists with counts
    document.addEventListener('DOMContentLoaded', function() {
        // This partial is included multiple times on some pages (e.g. landing has desktop + mobile forms).
        // Prevent double-binding global event listeners / duplicate AJAX calls.
        if (window.__pcCarSearchFormBootstrapped) return;
        window.__pcCarSearchFormBootstrapped = true;

        // Landing page mobile fix:
        // If the search form is inside a clipped/overflow container, the "fixed" modal can appear constrained.
        // For landing page only, we temporarily move the active modal to <body> so it can truly be full-screen.
        const landingModalPositions = new WeakMap();

        function isMobile() {
            return window.matchMedia && window.matchMedia('(max-width: 768px)').matches;
        }

        function isLandingScope(form) {
            // Landing page uses this id for the mobile hero form include.
            // We scope the "move modal to body" behavior to this form only so other pages remain unchanged.
            return !!(form && String(form.id || '') === 'mobileHeroSearchForm');
        }

        function moveModalToBody(modal, ownerFormId) {
            if (!modal || !isMobile()) return;
            if (modal.dataset && modal.dataset.movedToBody === '1') return;
            const parent = modal.parentNode;
            if (!parent) return;
            landingModalPositions.set(modal, {
                parent: parent,
                nextSibling: modal.nextSibling
            });
            if (modal.dataset) {
                modal.dataset.movedToBody = '1';
                if (ownerFormId) modal.dataset.ownerFormId = ownerFormId;
            }
            document.body.appendChild(modal);
        }

        function restoreModalFromBody(modal) {
            if (!modal || !(modal.dataset && modal.dataset.movedToBody === '1')) return;
            const pos = landingModalPositions.get(modal);
            if (pos && pos.parent) {
                if (pos.nextSibling && pos.nextSibling.parentNode === pos.parent) {
                    pos.parent.insertBefore(modal, pos.nextSibling);
                } else {
                    pos.parent.appendChild(modal);
                }
            }
            landingModalPositions.delete(modal);
            if (modal.dataset) {
                delete modal.dataset.movedToBody;
                delete modal.dataset.ownerFormId;
            }
        }

        function resolveFormForElement(el) {
            if (!el) return null;
            const direct = el.closest && el.closest('form.filter-box');
            if (direct) return direct;
            const modal = el.closest && el.closest('.custom-select-modal');
            const ownerId = modal && modal.dataset ? String(modal.dataset.ownerFormId || '') : '';
            if (ownerId) return document.getElementById(ownerId);
            return null;
        }

        function initDefaultDropdownText(form) {
            form.querySelectorAll('.dropdown-toggle .dropdown-text').forEach(function(span) {
                if (!span.dataset.defaultText) {
                    span.dataset.defaultText = span.textContent || '';
                }
            });
        }

        function hydrateFormFromUrl(form) {
            const qs = window.location && window.location.search ? window.location.search : '';
            const params = new URLSearchParams(qs);
            if (!params || Array.from(params.keys()).length === 0) return false;

            const mappings = [{
                    param: 'make',
                    inputId: 'makeInput',
                    buttonId: 'makeDropdown'
                },
                {
                    param: 'model',
                    inputId: 'modelInput',
                    buttonId: 'modelDropdown'
                },
                {
                    param: 'variant',
                    inputId: 'variantInput',
                    buttonId: 'variantDropdown'
                },
                {
                    param: 'body_type',
                    inputId: 'bodytypeInput',
                    buttonId: 'bodytypeDropdown'
                },
                {
                    param: 'engine_size',
                    inputId: 'enginesizeInput',
                    buttonId: 'enginesizeDropdown'
                },
                {
                    param: 'fuel_type',
                    inputId: 'fueltypeInput',
                    buttonId: 'fueltypeDropdown'
                },
                {
                    param: 'gear_box',
                    inputId: 'gearboxInput',
                    buttonId: 'gearboxDropdown'
                },
                {
                    param: 'doors',
                    inputId: 'doorsInput',
                    buttonId: 'doorsDropdown'
                },
                {
                    param: 'colors',
                    inputId: 'colorsInput',
                    buttonId: 'colorsDropdown'
                },
                {
                    param: 'seller_type',
                    inputId: 'sellertypeInput',
                    buttonId: 'sellertypeDropdown'
                },
                {
                    param: 'price_from',
                    inputId: 'pricefromInput',
                    buttonId: 'pricefromDropdown',
                    format: formatPriceFrom
                },
                {
                    param: 'price_to',
                    inputId: 'pricetoInput',
                    buttonId: 'pricetoDropdown',
                    format: formatPriceTo
                },
                {
                    param: 'year_from',
                    inputId: 'yearfromInput',
                    buttonId: 'yearfromDropdown'
                },
                {
                    param: 'year_to',
                    inputId: 'yeartoInput',
                    buttonId: 'yeartoDropdown'
                },
                {
                    param: 'miles',
                    inputId: 'maxmilesInput',
                    buttonId: 'maxmilesDropdown',
                    format: function(v) {
                        const num = Number(v);
                        return Number.isFinite(num) ? ('Up to ' + num.toLocaleString('en-GB')) : String(
                            v);
                    }
                },
                {
                    param: 'sort',
                    inputId: 'sortInput',
                    buttonId: 'sortInput'
                },
            ];

            let hydrated = false;

            // Preserve pagination page if present in URL
            if (params.has('page')) {
                const pageVal = params.get('page');
                if (pageVal !== null && pageVal !== '') {
                    const pageInput = form.querySelector('#pageInput');
                    if (pageInput) pageInput.value = String(pageVal);
                    hydrated = true;
                }
            }

            mappings.forEach(function(m) {
                if (!params.has(m.param)) return;
                const v = params.get(m.param);
                if (v === null || v === '') return;

                const input = form.querySelector('#' + m.inputId);
                if (input) input.value = String(v);

                // Try to select the existing option in the list (keeps labels consistent)
                let match = null;
                form.querySelectorAll('.dropdown-item[data-dd-input="' + m.inputId + '"]').forEach(
                    function(item) {
                        if (String(item.getAttribute('data-dd-value') || '') === String(v)) match =
                            item;
                    });

                if (match) {
                    applyDropdownItemSelection(match);
                } else {
                    // Fallback: set button label if option isn't present yet
                    const btn = form.querySelector('#' + m.buttonId);
                    const span = btn ? (btn.querySelector('.dropdown-text') || btn.querySelector(
                        'span')) : null;
                    if (span) {
                        if (!span.dataset.defaultText) span.dataset.defaultText = span.textContent ||
                        '';
                        span.textContent = m.format ? m.format(v) : String(v);
                    }
                }

                hydrated = true;
            });

            return hydrated;
        }

        function resetPageToFirst(form) {
            if (!form) return;
            const pageInput = form.querySelector('#pageInput');
            if (pageInput) pageInput.value = '1';
        }

        function getCsrfToken(form) {
            return (
                form.querySelector('input[name="_token"]')?.value ||
                document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                ''
            );
        }

        function formatGBP(n) {
            const num = Number(n);
            if (!Number.isFinite(num)) return String(n);
            return '£' + Math.round(num).toLocaleString('en-GB');
        }

        function formatPriceFrom(n) {
            return 'From ' + formatGBP(n);
        }

        function formatPriceTo(n) {
            return 'Up to ' + formatGBP(n);
        }

        function normalizeFacetMap(facet) {
            if (!facet || typeof facet !== 'object') return [];
            if (Array.isArray(facet)) return facet;

            // { value: count } -> [{ value, count }]
            return Object.keys(facet).map(function(k) {
                return {
                    value: String(k),
                    count: Number(facet[k] || 0)
                };
            });
        }

        function toSortableString(v) {
            return String(v ?? '').trim();
        }

        function toSortableNumber(v) {
            const s = toSortableString(v)
                .replace(/,/g, '') // "10,000" -> "10000"
                .replace(/[^\d.\-]/g, ''); // "2.0L" -> "2.0"
            const n = Number(s);
            return Number.isFinite(n) ? n : NaN;
        }

        function normalizeFacetItems(items) {
            return (items || [])
                .filter(function(i) {
                    const v = (i && (i.value ?? i.k)) ?? '';
                    if (v === '' || v === null || v === undefined) return false;
                    const s = String(v).trim();
                    if (!s) return false;
                    // Hide invalid placeholder values like "N/A", "N/A L", etc.
                    if (/^n\/a\b/i.test(s)) return false;
                    if (/^na\b/i.test(s)) return false;
                    return true;
                })
                .map(function(i) {
                    if (i && typeof i === 'object' && 'value' in i) return i;
                    return {
                        value: String(i),
                        count: 0
                    };
                });
        }

        // Sorting rules requested:
        // - Text facets: A → Z (ignore counts)
        // - Numeric facets: smallest → largest (ignore counts)
        function sortFacetItems(items, mode) {
            const normalized = normalizeFacetItems(items);

            if (mode === 'numeric') {
                return normalized.sort(function(a, b) {
                    const an = toSortableNumber(a.value);
                    const bn = toSortableNumber(b.value);

                    const aOk = Number.isFinite(an);
                    const bOk = Number.isFinite(bn);

                    if (aOk && bOk && an !== bn) return an - bn;
                    if (aOk && !bOk) return -1;
                    if (!aOk && bOk) return 1;
                    return toSortableString(a.value).localeCompare(toSortableString(b.value),
                    undefined, {
                        sensitivity: 'base'
                    });
                });
            }

            // default: text
            return normalized.sort(function(a, b) {
                return toSortableString(a.value).localeCompare(toSortableString(b.value), undefined, {
                    sensitivity: 'base'
                });
            });
        }

        function applyDropdownItemSelection(item, forceForm) {
            const targetId = item.getAttribute('data-dd-target');
            const inputId = item.getAttribute('data-dd-input');
            if (!targetId || !inputId) return;

            const rawValue = item.getAttribute('data-dd-value');
            const value = rawValue === null ? '' : String(rawValue);
            const text = String(item.getAttribute('data-dd-text') || value);
            const shouldClear = item.hasAttribute('data-dd-clear') || value === '' || value === 'Any';

            const form = forceForm || resolveFormForElement(item);
            if (!form) return; // avoid updating the wrong form (duplicate IDs across forms)

            const btn = form.querySelector('#' + targetId);
            const span = btn ? (btn.querySelector('.dropdown-text') || btn.querySelector('span')) : null;
            const input = form.querySelector('#' + inputId);

            const prevValue = input ? String(input.value || '') : '';

            if (span && !span.dataset.defaultText) {
                span.dataset.defaultText = span.textContent || '';
            }

            if (input) input.value = shouldClear ? '' : value;
            if (span) span.textContent = shouldClear ? (span.dataset.defaultText || '') : text;
            if (form && prevValue !== (shouldClear ? '' : value)) {
                resetPageToFirst(form);
            }

            function clearSelectionForInput(localForm, depInputId) {
                const depInput = localForm.querySelector('#' + depInputId);
                if (depInput) depInput.value = '';

                // remove selected-option styling for that input (form + owner modals when moved to body)
                const inForm = localForm.querySelectorAll('.dropdown-item.selected-option[data-dd-input="' + depInputId + '"]');
                const inOwnerModals = localForm.id
                    ? document.querySelectorAll('.custom-select-modal[data-owner-form-id="' + localForm.id + '"] .dropdown-item.selected-option[data-dd-input="' + depInputId + '"]')
                    : [];
                Array.from(inForm).concat(Array.from(inOwnerModals)).forEach(function(el) {
                    el.classList.remove('selected-option');
                });
            }

            function resetButtonLabel(localForm, buttonId) {
                const b = localForm.querySelector('#' + buttonId);
                const s = b ? (b.querySelector('.dropdown-text') || b.querySelector('span')) : null;
                if (!s) return;
                s.textContent = s.dataset.defaultText || '';
            }

            function setBtnDisabled(localForm, buttonId, disabled) {
                const b = localForm.querySelector('#' + buttonId);
                if (b) b.disabled = !!disabled;
            }

            // Cascade behavior:
            // - Make change clears model + variant, disables model/variant until facets re-apply
            // - Model change clears variant, keeps variant disabled until model selected
            if (form && inputId === 'makeInput') {
                const nextMake = shouldClear ? '' : value;
                if (prevValue !== nextMake) {
                    clearSelectionForInput(form, 'modelInput');
                    clearSelectionForInput(form, 'variantInput');
                    resetButtonLabel(form, 'modelDropdown');
                    resetButtonLabel(form, 'variantDropdown');
                    setBtnDisabled(form, 'modelDropdown', true);
                    setBtnDisabled(form, 'variantDropdown', true);
                }
            }

            if (form && inputId === 'modelInput') {
                const nextModel = shouldClear ? '' : value;
                if (prevValue !== nextModel) {
                    clearSelectionForInput(form, 'variantInput');
                    resetButtonLabel(form, 'variantDropdown');
                    setBtnDisabled(form, 'variantDropdown', true);
                }
            }


            // visual selection state (keep in sync across desktop + mobile lists)
            if (form) {
                // Items to update: inside form + inside modals that belong to this form (e.g. moved to body on landing mobile)
                function itemsForInput(formEl, id) {
                    const inForm = formEl.querySelectorAll('.dropdown-item[data-dd-input="' + id + '"]');
                    const inOwnerModals = formEl.id
                        ? document.querySelectorAll('.custom-select-modal[data-owner-form-id="' + formEl.id + '"] .dropdown-item[data-dd-input="' + id + '"]')
                        : [];
                    return Array.from(inForm).concat(Array.from(inOwnerModals));
                }
                // clear selection for this specific input
                itemsForInput(form, inputId).forEach(function(el) {
                    el.classList.remove('selected-option');
                });
                // apply selection to all matching options
                if (!shouldClear) {
                    itemsForInput(form, inputId).forEach(function(el) {
                        const v = String(el.getAttribute('data-dd-value') ?? '');
                        if (v === value) el.classList.add('selected-option');
                    });
                }
            } else {
                // fallback: just mark the clicked item
                item.classList.add('selected-option');
            }

            // close modal if clicked inside a custom modal list
            const modal = item.closest('.custom-select-modal');
            if (modal) {
                modal.classList.add(CLOSED_CLASS);
                modal.style.setProperty('display', 'none', 'important');
                setBodyScrollLocked(false);
            }
        }



        function buildDropdownItem(cfg, value, text, count, isClear, isSelected) {
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.className = 'dropdown-item' + (isSelected ? ' selected-option' : '');
            a.href = 'javascript:void(0)';
            a.setAttribute('data-dd-target', cfg.buttonId);
            a.setAttribute('data-dd-input', cfg.inputId);
            a.setAttribute('data-dd-value', value);
            a.setAttribute('data-dd-text', text);
            if (isClear) a.setAttribute('data-dd-clear', '1');
            a.textContent = count === null ? text : (text + ' (' + Number(count || 0) + ')');
            li.appendChild(a);
            return li;
        }

        function rebuildLists(form, cfg, items, labelFn) {
            const input = form.querySelector('#' + cfg.inputId);
            let selectedValue = input ? String(input.value || '') : '';

            const btn = form.querySelector('#' + cfg.buttonId);
            const btnSpan = btn ? (btn.querySelector('.dropdown-text') || btn.querySelector('span')) : null;
            const dropdownRoot = btn ? btn.closest('.dropdown') : null;
            const desktopList = dropdownRoot ? dropdownRoot.querySelector('.dropdown-menu') : null;
            let mobileList = cfg.modalKey
                ? form.querySelector('.custom-select-modal[data-modal="' + cfg.modalKey +
                    '"] .custom-select-list')
                : null;
            // When modal was moved to body (landing mobile), find it by owner form id
            if (!mobileList && cfg.modalKey && form.id) {
                const movedModal = document.querySelector('.custom-select-modal[data-modal="' +
                    cfg.modalKey + '"][data-owner-form-id="' + form.id + '"]');
                mobileList = movedModal ? movedModal.querySelector('.custom-select-list') : null;
            }

            // Enable/disable if configured
            // if (btn && cfg.disableWhenEmpty) {
            //     btn.disabled = items.length === 0;
            // }

            // Rebuild list function
            function rebuild(listEl) {
                if (!listEl) return;
                listEl.innerHTML = '';

                if (cfg.clearText) {
                    // We do not mark "Any" as selected; only real selections get the circle.
                    listEl.appendChild(buildDropdownItem(cfg, '', cfg.clearText, null, true, false));
                }

                const seen = new Set();
                // Cascade fields (make/model/variant): only clear when user explicitly changes make/model,
                // not when facet list changes due to year/price/etc. Otherwise model/variant get disabled incorrectly.
                const isCascadeField = cfg.inputId === 'makeInput' || cfg.inputId === 'modelInput' || cfg.inputId === 'variantInput';
                if (selectedValue) {
                    const hasSelected = items.some(function(i) {
                        return String(i.value) === selectedValue;
                    });
                    if (!hasSelected && !isCascadeField) {
                        // Selection is no longer valid under current filters → clear it.
                        if (input) input.value = '';
                        selectedValue = '';

                        if (btnSpan) {
                            if (!btnSpan.dataset.defaultText) btnSpan.dataset.defaultText = btnSpan
                                .textContent || '';
                            btnSpan.textContent = btnSpan.dataset.defaultText || '';
                        }
                    }
                }

                items.forEach(function(i) {
                    const v = String(i.value);
                    if (!v) return;
                    if (/^n\/a\b/i.test(v)) return;
                    if (/^na\b/i.test(v)) return;
                    if (seen.has(v)) return;
                    const isSelected = !!selectedValue && v === selectedValue;
                    listEl.appendChild(buildDropdownItem(cfg, v, labelFn(v), i.count, false,
                        isSelected));
                    seen.add(v);
                });
            }

            rebuild(desktopList);
            rebuild(mobileList);
        }

        function applyFacetsToForm(form, facets) {
            if (!facets || typeof facets !== 'object') return;

            const configs = {
                make: {
                    facetKey: 'make',
                    buttonId: 'makeDropdown',
                    inputId: 'makeInput',
                    modalKey: 'make',
                    clearText: 'Any'
                },
                model: {
                    facetKey: 'model',
                    buttonId: 'modelDropdown',
                    inputId: 'modelInput',
                    modalKey: 'model',
                    clearText: 'Any',
                    disableWhenEmpty: true
                },
                variant: {
                    facetKey: 'variant',
                    buttonId: 'variantDropdown',
                    inputId: 'variantInput',
                    modalKey: 'variant',
                    clearText: 'Any',
                    disableWhenEmpty: true
                },
                body_type: {
                    facetKey: 'body_type',
                    buttonId: 'bodytypeDropdown',
                    inputId: 'bodytypeInput',
                    modalKey: 'bodytype',
                    clearText: 'Any'
                },
                engine_size: {
                    facetKey: 'engine_size',
                    buttonId: 'enginesizeDropdown',
                    inputId: 'enginesizeInput',
                    modalKey: 'enginesize',
                    clearText: 'Any',
                    sortMode: 'numeric'
                },
                fuel_type: {
                    facetKey: 'fuel_type',
                    buttonId: 'fueltypeDropdown',
                    inputId: 'fueltypeInput',
                    modalKey: 'fueltype',
                    clearText: 'Any'
                },
                gear_box: {
                    facetKey: 'gear_box',
                    buttonId: 'gearboxDropdown',
                    inputId: 'gearboxInput',
                    modalKey: 'gearbox',
                    clearText: 'Any'
                },
                doors: {
                    facetKey: 'doors',
                    buttonId: 'doorsDropdown',
                    inputId: 'doorsInput',
                    modalKey: 'doors',
                    clearText: 'Any',
                    sortMode: 'numeric'
                },
                colors: {
                    facetKey: 'colors',
                    buttonId: 'colorsDropdown',
                    inputId: 'colorsInput',
                    modalKey: 'colors',
                    clearText: 'Any'
                },
                seller_type: {
                    facetKey: 'seller_type',
                    buttonId: 'sellertypeDropdown',
                    inputId: 'sellertypeInput',
                    modalKey: 'sellertype',
                    clearText: 'Any'
                },
            };

            Object.keys(configs).forEach(function(k) {
                const cfg = configs[k];
                const mode = cfg.sortMode || 'text';
                const items = sortFacetItems(normalizeFacetMap(facets[cfg.facetKey]), mode);
                rebuildLists(form, cfg, items, function(value) {
                    if (cfg.facetKey === 'seller_type') {
                        if (value === 'private_seller') return 'PRIVATE';
                        if (value === 'car_dealer') return 'DEALER';
                    }
                    return String(value);
                });
            });

            // Year (used by year-from + year-to)
            const yearFromFacet = facets.year_from || facets.year || {};
            const yearToFacet = facets.year_to || facets.year || {};

            if (yearFromFacet && typeof yearFromFacet === 'object') {
                const yearItems = Object.keys(yearFromFacet)
                    .map(function(y) {
                        return {
                            value: String(y),
                            count: Number(yearFromFacet[y] || 0)
                        };
                    })
                    .filter(function(i) {
                        return (i.count || 0) >= 1;
                    })
                    .sort(function(a, b) {
                        return Number(b.value) - Number(a.value);
                    });

                rebuildLists(form, {
                    facetKey: 'year',
                    buttonId: 'yearfromDropdown',
                    inputId: 'yearfromInput',
                    modalKey: 'year-from',
                    clearText: 'Any'
                }, yearItems, function(v) {
                    return 'Up to ' + String(v);
                });
            }
            if (yearToFacet && typeof yearToFacet === 'object') {
                const yearToItems = Object.keys(yearToFacet)
                    .map(function(y) {
                        return {
                            value: String(y),
                            count: Number(yearToFacet[y] || 0)
                        };
                    })
                    .filter(function(i) {
                        return (i.count || 0) >= 1;
                    })
                    .sort(function(a, b) {
                        return Number(b.value) - Number(a.value);
                    });
                rebuildLists(form, {
                    facetKey: 'year',
                    buttonId: 'yeartoDropdown',
                    inputId: 'yeartoInput',
                    modalKey: 'year-to',
                    clearText: 'Any'
                }, yearToItems, function(v) {
                    return 'Up to ' + String(v);
                });
            }

            // Price (used by price-from + price-to)
            if (Array.isArray(facets.price)) {
                const fromItems = facets.price
                    .map(function(r) {
                        return {
                            value: String(r.min),
                            count: Number(r.count_from || r.count || 0)
                        };
                    })
                    .filter(function(i) {
                        return (i.count || 0) >= 1;
                    })
                    .sort(function(a, b) {
                        return toSortableNumber(a.value) - toSortableNumber(b.value);
                    });
                const toItems = facets.price
                    .map(function(r) {
                        return {
                            value: String(r.max),
                            count: Number(r.count_to || r.count || 0)
                        };
                    })
                    .filter(function(i) {
                        return (i.count || 0) >= 1;
                    })
                    .sort(function(a, b) {
                        return toSortableNumber(a.value) - toSortableNumber(b.value);
                    });

                rebuildLists(form, {
                    facetKey: 'price',
                    buttonId: 'pricefromDropdown',
                    inputId: 'pricefromInput',
                    modalKey: 'price-from',
                    clearText: 'Any'
                }, fromItems, function(v) {
                    return formatPriceFrom(v);
                });
                rebuildLists(form, {
                    facetKey: 'price',
                    buttonId: 'pricetoDropdown',
                    inputId: 'pricetoInput',
                    modalKey: 'price-to',
                    clearText: 'Any'
                }, toItems, function(v) {
                    return formatPriceTo(v);
                });
            }

            // Miles
            if (Array.isArray(facets.miles)) {
                const milesItems = facets.miles
                    .map(function(r) {
                        return {
                            value: String(r.max),
                            count: Number(r.count || 0)
                        };
                    })
                    .filter(function(i) {
                        return (i.count || 0) >= 1;
                    })
                    .sort(function(a, b) {
                        return toSortableNumber(a.value) - toSortableNumber(b.value);
                    });
                rebuildLists(form, {
                    facetKey: 'miles',
                    buttonId: 'maxmilesDropdown',
                    inputId: 'maxmilesInput',
                    modalKey: 'maxmiles',
                    clearText: 'Any'
                }, milesItems, function(v) {
                    const num = Number(v);
                    return Number.isFinite(num) ? ('Up to ' + num.toLocaleString('en-GB')) : String(v);
                });
            }
        }

        function enforceMakeModelVariantCascade(form) {
            if (!form) return;
            const makeVal = String(form.querySelector('#makeInput')?.value || '').trim();
            const modelVal = String(form.querySelector('#modelInput')?.value || '').trim();

            const modelBtn = form.querySelector('#modelDropdown');
            const variantBtn = form.querySelector('#variantDropdown');

            // Model enabled only after make is selected
            if (modelBtn) modelBtn.disabled = !makeVal;

            // Variant enabled only after model is selected (even if facets.variant has values)
            if (variantBtn) variantBtn.disabled = !modelVal;
        }

        function setSearchButtonLoading(form, isLoading) {
            const btn = form.querySelector('#searchButton');
            if (!btn) return;

            if (isLoading) {
                if (!btn.dataset.baseHtml) btn.dataset.baseHtml = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = 'Loading...';
            } else {
                if (btn.dataset.baseHtml) btn.innerHTML = btn.dataset.baseHtml;
                btn.disabled = false;
            }
        }

        function setSearchButtonTotal(form, total) {
            const btn = form.querySelector('#searchButton');
            if (!btn) return;
            const n = Number(total);
            if (!Number.isFinite(n)) return;
            const next = 'Search (' + n + ')';
            btn.dataset.baseHtml = next;
            if (!btn.disabled) btn.innerHTML = next;
        }

        function buildFilterQueryFromForm(form) {
            if (!form) return '';
            const qs = new URLSearchParams();
            form.querySelectorAll('input[type="hidden"][name]').forEach(function(inp) {
                if (!inp || inp.name === '_token' || inp.name === 'page') return;
                const v = String(inp.value || '').trim();
                if (!v) return;
                if (inp.name === 'advanced' && v !== '1') return;
                qs.append(inp.name, v);
            });
            return qs.toString();
        }

        function updateForsaleResults(payload, form) {
            const grid = document.getElementById('mobilelayout');
            if (!grid) return; // only on for-sale page
            if (!payload || typeof payload !== 'object') return;

            if (typeof payload.cars_html === 'string') {
                grid.innerHTML = payload.cars_html;
            }

            // already present:
            if ('next_page_url' in payload) {
                grid.dataset.nextPageUrl = payload.next_page_url || '';
            }

            // ADD THESE if your backend returns them (recommended):
            if ('prev_page_url' in payload) {
                grid.dataset.prevPageUrl = payload.prev_page_url || '';
            }
            if ('current_page' in payload) {
                grid.dataset.currentPage = String(payload.current_page || 1);
            }
            if ('last_page' in payload) {
                grid.dataset.lastPage = String(payload.last_page || 1);
            }

            const filterQuery = buildFilterQueryFromForm(form);
            grid.dataset.filterQuery = filterQuery;

            if (!grid.querySelector('#lazy-load-marker')) {
                const marker = document.createElement('div');
                marker.id = 'lazy-load-marker';
                marker.style.height = '1px';
                grid.appendChild(marker);
            }

            const totalEl = document.getElementById('forsaleTotalCount') || document.querySelector(
                '.result-title');
            if (totalEl && typeof payload.total !== 'undefined') {
                totalEl.textContent = String(payload.total) + ' used cars found';
            }

            // NEW: refresh button states / label
            if (typeof updateForsalePaginationFromGrid === 'function') {
                updateForsalePaginationFromGrid();
            }

            window.dispatchEvent(new CustomEvent('pc:forsale-results-updated'));
        }


        var FILTER_DEBOUNCE_MS = 320;

        function doPostFilterForm(form) {
            if (!form || !form.action) return;
            if (form._filterXhr) {
                form._filterXhr.abort();
                form._filterXhr = null;
            }
            const nextSeq = (Number(form.dataset.reqSeq || '0') || 0) + 1;
            form.dataset.reqSeq = String(nextSeq);
            const requestSeq = nextSeq;
            const token = getCsrfToken(form);
            const params = new URLSearchParams(new FormData(form)).toString();
            setSearchButtonLoading(form, true);
            const xhr = new XMLHttpRequest();
            form._filterXhr = xhr;
            xhr.open((form.method || 'POST').toUpperCase(), form.action, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            if (token) xhr.setRequestHeader('X-CSRF-TOKEN', token);
            xhr.onreadystatechange = function() {
                if (xhr.readyState !== 4) return;
                if (form._filterXhr === xhr) form._filterXhr = null;
                if (String(form.dataset.reqSeq || '') !== String(requestSeq)) return;
                var payload = null;
                try {
                    var contentType = xhr.getResponseHeader('content-type') || '';
                    payload = contentType.indexOf('application/json') !== -1 ?
                        JSON.parse(xhr.responseText || '{}') : null;
                } catch (e) {}
                var fForm = form;
                var fPayload = payload;
                requestAnimationFrame(function() {
                    try {
                        if (fPayload && fPayload.facets) applyFacetsToForm(fForm, fPayload.facets);
                        enforceMakeModelVariantCascade(fForm);
                        if (fPayload) {
                            updateForsaleResults(fPayload, fForm);
                            if (typeof fPayload.total !== 'undefined') setSearchButtonTotal(fForm, fPayload.total);
                        }
                    } finally {
                        setSearchButtonLoading(fForm, false);
                    }
                });
            };
            xhr.onerror = function() {
                if (form._filterXhr === xhr) form._filterXhr = null;
                if (String(form.dataset.reqSeq || '') !== String(requestSeq)) return;
                setSearchButtonLoading(form, false);
            };
            xhr.onabort = function() {
                if (form._filterXhr === xhr) form._filterXhr = null;
                setSearchButtonLoading(form, false);
            };
            xhr.send(params);
        }

        function postFilterForm(form) {
            if (!form || !form.action) return;
            if (form._filterDebounceTimer) {
                clearTimeout(form._filterDebounceTimer);
                form._filterDebounceTimer = null;
            }
            form._filterDebounceTimer = setTimeout(function() {
                form._filterDebounceTimer = null;
                doPostFilterForm(form);
            }, FILTER_DEBOUNCE_MS);
        }

        function clearAllForm(form) {
            if (!form) return;

            // Clear hidden inputs (the actual filter values)
            form.querySelectorAll('input[type="hidden"][name]').forEach(function(inp) {
                // keep CSRF token
                if (inp.name === '_token') return;
                if (inp.name === 'page') {
                    inp.value = '1';
                } else {
                    inp.value = '';
                }
            });

            // Reset dropdown button labels
            form.querySelectorAll('.dropdown-toggle .dropdown-text').forEach(function(span) {
                span.textContent = span.dataset.defaultText || '';
            });

            // Clear selected-option styling
            form.querySelectorAll('.dropdown-item.selected-option').forEach(function(el) {
                el.classList.remove('selected-option');
            });

            // Re-run filter with empty values
            postFilterForm(form);
        }

        // Delegated click handler: selecting any dropdown item updates hidden input + triggers facet refresh
        document.addEventListener('click', function(e) {
            const item = e.target.closest('.dropdown-item');
            if (!item) return;
            if (!item.hasAttribute('data-dd-target')) return;

            const form = resolveFormForElement(item);
            applyDropdownItemSelection(item, form);
            if (form) postFilterForm(form);
        });

        function setBodyScrollLocked(lock) {
            if (!isMobile()) return;
            if (lock) {
                if (!document.body.dataset.prevOverflow) {
                    document.body.dataset.prevOverflow = document.body.style.overflow || '';
                }
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = document.body.dataset.prevOverflow || '';
                delete document.body.dataset.prevOverflow;
            }
        }

        var CLOSED_CLASS = 'custom-select-modal--closed';

        function closeAllCustomSelectModals() {
            document.querySelectorAll('.custom-select-modal').forEach(function(m) {
                m.classList.add(CLOSED_CLASS);
                m.style.setProperty('display', 'none', 'important');
            });
            setBodyScrollLocked(false);
        }
        window.__closeAllCustomSelectModals = closeAllCustomSelectModals;

        // Mobile: open custom modal when clicking dropdown toggles that have data-dropdown
        document.querySelectorAll('form.filter-box .dropdown-toggle[data-dropdown]').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                if (!isMobile()) return;
                const key = btn.getAttribute('data-dropdown');
                const form = btn.closest('form.filter-box');
                let modal = form ? form.querySelector('.custom-select-modal[data-modal="' +
                    key + '"]') : null;
                // If landing-scope moved it to body previously, re-find it by form id.
                if (!modal && form && form.id) {
                    modal = document.querySelector('.custom-select-modal[data-modal="' + key +
                        '"][data-owner-form-id="' + form.id + '"]');
                }
                if (!modal) return;

                e.preventDefault();
                e.stopPropagation();
                closeAllCustomSelectModals();

                const label = btn.closest('.filter-item')?.querySelector('label')?.textContent
                    ?.trim();
                const title = modal.querySelector('.custom-select-title');
                if (title && label) title.textContent = label;

                if (form && isLandingScope(form)) {
                    moveModalToBody(modal, form.id || '');
                }
                modal.classList.remove(CLOSED_CLASS);
                modal.style.removeProperty('display');
                modal.style.display = 'flex';
                setBodyScrollLocked(true);
                history.pushState({ customSelectOpen: true }, '', location.href);
                if (typeof bootstrap !== 'undefined' && bootstrap.Dropdown) {
                    var openMenus = document.querySelectorAll('.dropdown-menu.show');
                    openMenus.forEach(function(menu) {
                        var dropdown = menu.closest('.dropdown');
                        if (dropdown) {
                            var t = dropdown.querySelector('[data-bs-toggle="dropdown"]');
                            if (t && t.getAttribute('data-dropdown')) {
                                var inst = bootstrap.Dropdown.getInstance(t);
                                if (inst) inst.hide();
                            }
                        }
                    });
                }
            });
        });

        // Close modal by clicking backdrop (rare on full-screen, but keep it)
        document.querySelectorAll('form.filter-box .custom-select-modal').forEach(function(modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add(CLOSED_CLASS);
                    modal.style.setProperty('display', 'none', 'important');
                    setBodyScrollLocked(false);
                }
            });
        });

        // Close modal by clicking X
        document.querySelectorAll('form.filter-box .custom-select-modal .custom-select-close').forEach(function(
            btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const modal = btn.closest('.custom-select-modal');
                if (modal) {
                    modal.classList.add(CLOSED_CLASS);
                    modal.style.setProperty('display', 'none', 'important');
                }
                setBodyScrollLocked(false);
            });
        });

        // Close any open selector on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeAllCustomSelectModals();
        });

        // More/Less filters toggle (per form)
        document.querySelectorAll('form.filter-box').forEach(function(form) {
            initDefaultDropdownText(form);
            const didHydrate = hydrateFormFromUrl(form);

            const advancedFilterRows = form.querySelectorAll('.advanced-filter-row');
            const moreFiltersBtn = form.querySelector('#moreFiltersBtn');
            const lessFiltersBtn = form.querySelector('#lessFiltersBtn');

            function toggleAdvancedFilters(show) {
                const displayValue = show ? 'flex' : 'none';
                advancedFilterRows.forEach(function(row) {
                    row.style.display = displayValue;
                });
                if (moreFiltersBtn) moreFiltersBtn.style.display = show ? 'none' : 'inline-flex';
                if (lessFiltersBtn) lessFiltersBtn.style.display = show ? 'inline-flex' : 'none';

                // Persist state in a hidden field so landing -> /searchcar keeps expanded state
                const adv = form.querySelector('input[name="advanced"]');
                if (adv) adv.value = show ? '1' : '';
            }

            if (moreFiltersBtn) moreFiltersBtn.addEventListener('click', function() {
                toggleAdvancedFilters(true);
            });
            if (lessFiltersBtn) lessFiltersBtn.addEventListener('click', function() {
                toggleAdvancedFilters(false);
            });

            // Initial: expand if URL indicates advanced=1 (used by landing redirect)
            (function() {
                const qs = window.location && window.location.search ? window.location.search : '';
                const params = new URLSearchParams(qs);
                const adv = (params.get('advanced') || '').toLowerCase();
                if (adv === '1' || adv === 'true' || adv === 'yes') {
                    toggleAdvancedFilters(true);
                }
            })();

            // Apply cascade rules on init (URL hydrate may have make/model/variant)
            enforceMakeModelVariantCascade(form);

            // Submit behavior:
            // - On for-sale page (has #mobilelayout): prevent reload and use AJAX
            // - On landing/other pages: redirect to /searchcar with selected filters as query params
            form.addEventListener('submit', function(e) {
                const hasForsaleGrid = !!document.getElementById('mobilelayout');
                if (hasForsaleGrid) {
                    e.preventDefault();
                    postFilterForm(form);
                    // On the for-sale mobile overlay, close the panel so scroll/header are restored
                    if (isMobile && isMobile()) {
                        var container = form.closest('#mobileSearchForm');
                        if (container && container.classList.contains('show') && typeof window.__forsaleCloseSearchPanel === 'function') {
                            window.__forsaleCloseSearchPanel();
                        }
                    }
                    return;
                }

                // Redirect to the results page
                e.preventDefault();
                const base = form.getAttribute('data-search-url') || '/searchcar';
                const qs = new URLSearchParams();

                form.querySelectorAll('input[type="hidden"][name]').forEach(function(inp) {
                    if (!inp || inp.name === '_token') return;
                    const v = String(inp.value || '').trim();
                    if (!v) return;
                    if (inp.name === 'advanced' && v !== '1') return;
                    qs.append(inp.name, v);
                });

                const nextUrl = base + (qs.toString() ? ('?' + qs.toString()) : '');
                window.location.href = nextUrl;
            });

            // AJAX Clear All (button/link)
            form.querySelectorAll('button[type="reset"], .clear-all-link').forEach(function(btn) {
                if (btn.classList && btn.classList.contains('pc-mobile-search-close')) return;
                btn.addEventListener('click', function(e) {
                    // Prevent native reset so we can also reset labels + refresh via AJAX
                    e.preventDefault();
                    clearAllForm(form);
                });
            });

            // Initial load:
            // - If server provided initial facets, render dropdowns immediately (no initial /filter call).
            // - If URL has filters, or no initial facets were provided, fetch facets/options from /filter.
            let hasInitialFacets = false;
            try {
                const raw = form.getAttribute('data-initial-facets');
                if (raw) {
                    const initial = JSON.parse(raw);
                    if (initial && typeof initial === 'object') {
                        applyFacetsToForm(form, initial);
                        hasInitialFacets = true;
                    }
                }
            } catch (e) {
                // ignore JSON parse errors
            }

            // After applying facets, re-apply URL params so the form shows the filter values from the
            // previous page (e.g. landing -> forsale with make/model in URL). applyFacetsToForm
            // rebuilds lists but can reset labels; re-hydrating restores selected values and button text.
            if (didHydrate) {
                hydrateFormFromUrl(form);
                enforceMakeModelVariantCascade(form);
            }

            // Do not run initial AJAX when we landed on forsale page with filter params in URL:
            // the server already rendered the filtered results (e.g. from landing Search -> /searchcar?make=...).
            // Running postFilterForm here would replace server-rendered HTML and cause a flash / extra request.
            const hasForsaleGrid = !!document.getElementById('mobilelayout');
            const skipInitialFilter = hasForsaleGrid && didHydrate;
            if (!skipInitialFilter && (didHydrate || !hasInitialFacets)) {
                postFilterForm(form);
            }
            // Expose so forsale page sort dropdown can trigger server-side sort (no client-side reorder).
            form._doFilter = function() { postFilterForm(form); };
        });
    });
</script>

<script>
    (function() {
        function syncMakeModelVariantState() {
            var makeInput = document.getElementById('makeInput');
            var modelInput = document.getElementById('modelInput');

            var modelBtn = document.getElementById('modelDropdown');
            var variantBtn = document.getElementById('variantDropdown');

            if (!makeInput || !modelInput || !modelBtn || !variantBtn) return;

            // Default: page load
            modelBtn.disabled = true;
            variantBtn.disabled = true;
            // If make selected
            if (makeInput.value !== '') {
                modelBtn.disabled = false;
                variantBtn.disabled = true;
            }

            // If model selected
            if (modelInput.value !== '') {
                modelBtn.disabled = false;
                variantBtn.disabled = false;
            }
        }

        // Run after DOM + Bootstrap + facets
        window.addEventListener('load', function() {
            // run twice to beat async facet rendering
            syncMakeModelVariantState();

        });

        document.getElementById('variantDropdown').setAttribute('disabled', true);
    })();
</script>
