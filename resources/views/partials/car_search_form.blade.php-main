
<style>
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

.custom-select-content {
       .custom-select-content {
        background: #ffffff;
        width: 100%;
        max-width: 400px;
        max-height: 80vh;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        animation: fade-in 0.3s 
ease-out;
        overflow: hidden;
        position: relative;
        display: flex;
        flex-direction: column;
    }
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
}


@media (min-width: 768px) {
    .display-desktop-none {
        display: none !important;
    }
}

@media (max-width: 768px) {
    .show.display-mobile-none li .dropdown-item,
    .display-mobile-none {
    display: none !important;
  }

  .custom-select-list .dropdown-item{
    padding-left:35px !important;
    position: relative;
    font-weight:normal !important;
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


}
 
</style>
<form class="filter-box" method="GET" action="{{route('search_car')}}" id="{{ $formId ?? 'desktopform' }}">
    @csrf
    <div class="filter-inner">
        <!-- Row 1: Make, Model, Variant, Body Type, Fuel Type -->
        <div class="filter-item flex-column gap-1">
            <label class="field-label text-start" for="make">Make</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                        type="button" id="makeDropdown" data-bs-toggle="dropdown" data-dropdown="make">
                    <span class="dropdown-text">Select Make</span>
                </button>
                <ul class="dropdown-menu overflow-auto display-mobile-none">
                    @foreach($search_field['make'] as $make)
                        <li class="">
                            <a class="dropdown-item" href="javascript:void(0)"
                            onclick="updateDropdownText('{{ $make->make }}', 'makeDropdown', 'makeInput')">
                                {{ $make->make }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $make->count }})
                            </a>
                        </li>
                    @endforeach
                </ul>


   <!-- Make Modal -->
        <div class="custom-select-modal display-desktop-none" data-modal="make">
            <div class="custom-select-content">
                <ul class="custom-select-list">
                    @foreach($search_field['make'] as $make)
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)"
                               onclick="updateDropdownText('{{ $make->make }}', 'makeDropdown', 'makeInput')">
                                {{ $make->make }} ({{ $make->count }})
                            </a>
                        </li>
                    @endforeach
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
                        type="button" id="modelDropdown" data-bs-toggle="dropdown" disabled data-dropdown="model">
                    <span class="dropdown-text">Select Model</span>
                </button>
                <ul class="dropdown-menu ove display-mobile-none" id="modelList">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0)"
                        onclick="updateDropdownText('Any', 'modelDropdown', 'modelInput')">
                            
                        </a>
                    </li>
                </ul>
            </div>







       <div class="custom-select-modal display-desktop-none" data-modal="model">
            <div class="custom-select-content">
                <ul class="custom-select-list" id="modelListMobile">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0)"
                           onclick="updateDropdownText('Any', 'modelDropdown', 'modelInput')">
                            Any
                        </a>
                    </li>
                </ul>
            </div>
        </div>



            <input type="hidden" name="model" id="modelInput" value="">
        </div>

        <div class="filter-item flex-column gap-1">
            <label class="field-label text-start" for="variant">Variant</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                        type="button" id="variantDropdown" data-bs-toggle="dropdown" disabled data-dropdown="varient">
                    <span class="dropdown-text">Select Variant</span>
                </button>
                <ul class="dropdown-menu overflow-auto display-mobile-none" id="variantList">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0)"
                        onclick="updateDropdownText('Any', 'variantDropdown', 'variantInput')">
                        
                        </a>
                    </li>
                </ul>
            </div>





 <div class="custom-select-modal display-desktop-none" data-modal="varient">
            <div class="custom-select-content">
                <ul class="custom-select-list" id="variantListMobile">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0)"
                        onclick="updateDropdownText('Any', 'variantDropdown', 'variantInput')">
                        
                        </a>
                    </li>
                </ul>
            </div>
        </div>



            <input type="hidden" name="variant" id="variantInput" value="">
        </div>

        <div class="filter-item flex-column gap-1">
            <label class="field-label text-start" for="bodytype">Body Type</label>
            <div class="dropdown custom-dropdown" >
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                        type="button" id="bodytypeDropdown" data-bs-toggle="dropdown" data-model="false">
                    <span class="dropdown-text">Select Body Type</span>
                </button>
                <ul class="dropdown-menu overflow-auto display-mobile-none" id="bodytypeList">
                    @if(isset($search_field['body_type']))
                        @foreach($search_field['body_type'] as $body_type)
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)"
                                onclick="updateDropdownText('{{ $body_type->body_type }}', 'bodytypeDropdown', 'bodytypeInput')">
                                    {{ $body_type->body_type }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $body_type->count }})
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <input type="hidden" name="body_type" id="bodytypeInput" value="">
        </div>
        <!-- Fuel Type to Max Miles -->

        <!-- Row 3: Max Miles, Engine Size, Doors, Colors, Seller Type (Hidden by default) -->
        <div class="filter-item flex-column gap-1">
            <label class="field-label text-start" for="maxmiles">Max Miles</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                        type="button" id="maxmilesDropdown" data-bs-toggle="dropdown" data-model="false">
                    <span class="dropdown-text">Select Max Miles</span>
                </button>
                <ul class="dropdown-menu overflow-auto" style="max-height:20rem;" id="maxmilesList">
                    @php
                        $mileRanges = [
                            ['label' => 'Up to 10,000', 'value' => 10000],
                            ['label' => 'Up to 20,000', 'value' => 20000],
                            ['label' => 'Up to 30,000', 'value' => 30000],
                            ['label' => 'Up to 40,000', 'value' => 40000],
                            ['label' => 'Up to 50,000', 'value' => 50000],
                            ['label' => 'Up to 60,000', 'value' => 60000],
                            ['label' => 'Up to 70,000', 'value' => 70000],
                            ['label' => 'Up to 80,000', 'value' => 80000],
                            ['label' => 'Up to 90,000', 'value' => 90000],
                            ['label' => 'Up to 100,000', 'value' => 100000],
                        ];
                    @endphp
                    @foreach($mileRanges as $range)
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)"
                            onclick="updateDropdownText('{{ $range['value'] }}', 'maxmilesDropdown', 'maxmilesInput', '{{ $range['label'] }}')">
                                {{ $range['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <input type="hidden" name="miles" id="maxmilesInput" value="">
        </div>
        

        <!-- Row 2: Price From, Price To, Year From, Year To, Gearbox -->
        <div class="filter-item flex-column gap-1">
            <label class="field-label text-start" for="pricefrom">Price From</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                        type="button" id="pricefromDropdown" data-bs-toggle="dropdown" data-dropdown="price-from">
                        <span class="dropdown-text">Select Price From</span>
                </button>
                <ul class="dropdown-menu overflow-auto display-mobile-none" id="pricefromDropdownList">
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







 <div class="custom-select-modal display-desktop-none" data-modal="price-from">
            <div class="custom-select-content">
                <ul class="custom-select-list">
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
        </div>



            <input type="hidden" name="price_from" id="pricefromInput" value="">
        </div>

        <div class="filter-item flex-column gap-1">
            <label class="field-label text-start" for="priceto">Price To</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center" type="button" id="pricetoDropdown" data-dropdown="price-to" data-bs-toggle="dropdown">
                    <span class="dropdown-text">Select Price To</span>
                </button>
                <ul class="dropdown-menu overflow-auto display-mobile-none" id="priceDropdownList">
                    @foreach($price_counts as $price_range)
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)"
                            onclick="updateDropdownText('{{ $price_range['max'] }}', 'pricetoDropdown', 'pricetoInput', '£{{ number_format($price_range['max']) }}')">
                            £{{ number_format($price_range['max']) }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $price_range['count'] }})
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>






    <div class="custom-select-modal display-desktop-none" data-modal="price-to">
            <div class="custom-select-content">
                <ul class="custom-select-list">
                       @foreach($price_counts as $price_range)
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)"
                            onclick="updateDropdownText('{{ $price_range['max'] }}', 'pricetoDropdown', 'pricetoInput', '£{{ number_format($price_range['max']) }}')">
                            £{{ number_format($price_range['max']) }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $price_range['count'] }})
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>



            <input type="hidden" name="price_to" id="pricetoInput" value="">
        </div>

        <div class="filter-item flex-column gap-1">
            <label class="field-label text-start" for="yearfrom">Year From</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center" data-dropdown="year-from"
                        type="button" id="yearfromDropdown" data-bs-toggle="dropdown">
                        <span class="dropdown-text">Select Year From</span>
                </button>
                <ul class="dropdown-menu overflow-auto display-mobile-none" id="yearfromDropdownList">
                    @if(isset($year_ranges))
                        @foreach($year_ranges as $year)
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)"
                                onclick="updateDropdownText('{{ $year }}', 'yearfromDropdown', 'yearfromInput', '{{ $year }}')">
                                {{ $year }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $year_counts[$year] ?? 0 }})
                                </a>
                            </li>
                        @endforeach
                    @else
                        @foreach($year_counts as $year_range)
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)"
                                onclick="updateDropdownText('{{ $year_range['year'] }}', 'yearfromDropdown', 'yearfromInput', '{{ $year_range['year'] }}')">
                                {{ $year_range['year'] }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $year_range['count'] }})
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>







 <div class="custom-select-modal display-desktop-none" data-modal="year-from">
            <div class="custom-select-content">
                <ul class="custom-select-list">
                        @if(isset($year_ranges))
                        @foreach($year_ranges as $year)
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)"
                                onclick="updateDropdownText('{{ $year }}', 'yearfromDropdown', 'yearfromInput', '{{ $year }}')">
                                {{ $year }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $year_counts[$year] ?? 0 }})
                                </a>
                            </li>
                        @endforeach
                    @else
                        @foreach($year_counts as $year_range)
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)"
                                onclick="updateDropdownText('{{ $year_range['year'] }}', 'yearfromDropdown', 'yearfromInput', '{{ $year_range['year'] }}')">
                                {{ $year_range['year'] }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $year_range['count'] }})
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>








            <input type="hidden" name="year_from" id="yearfromInput" value="">
        </div>
        
        <div class="filter-item flex-column gap-1">
            <label class="field-label text-start" for="yearto">Year To</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center" data-dropdown="year-to" type="button" id="yeartoDropdown" data-bs-toggle="dropdown">
                    <span class="dropdown-text">Select Year To</span>
                </button>
                <ul class="dropdown-menu overflow-auto display-mobile-none" id="yeartoDropdownList">
                    @if(isset($year_ranges))
                        @foreach($year_ranges as $year)
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)"
                                onclick="updateDropdownText('{{ $year }}', 'yeartoDropdown', 'yeartoInput', '{{ $year }}')">
                                {{ $year }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $year_counts[$year] ?? 0 }})
                                </a>
                            </li>
                        @endforeach
                    @else
                        @foreach($year_counts as $year_range)
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)"
                                onclick="updateDropdownText('{{ $year_range['year'] }}', 'yeartoDropdown', 'yeartoInput', '{{ $year_range['year'] }}')">
                                {{ $year_range['year'] }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $year_range['count'] }})
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>









 <div class="custom-select-modal display-desktop-none" data-modal="year-to">
            <div class="custom-select-content">
                <ul class="custom-select-list">
                          @if(isset($year_ranges))
                        @foreach($year_ranges as $year)
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)"
                                onclick="updateDropdownText('{{ $year }}', 'yeartoDropdown', 'yeartoInput', '{{ $year }}')">
                                {{ $year }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $year_counts[$year] ?? 0 }})
                                </a>
                            </li>
                        @endforeach
                    @else
                        @foreach($year_counts as $year_range)
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)"
                                onclick="updateDropdownText('{{ $year_range['year'] }}', 'yeartoDropdown', 'yeartoInput', '{{ $year_range['year'] }}')">
                                {{ $year_range['year'] }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $year_range['count'] }})
                                </a>
                            </li>
                        @endforeach
                    @endif
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
                        type="button" id="enginesizeDropdown" data-bs-toggle="dropdown" data-model="false">
                    <span class="dropdown-text">Select Engine Size</span>
                </button>
                <ul class="dropdown-menu overflow-auto" id="enginesizeList">
                    @if(isset($search_field['engine_size']))
                        @foreach($search_field['engine_size'] as $engine_size)
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)"
                                onclick="updateDropdownText('{{ $engine_size->engine_size }}', 'enginesizeDropdown', 'enginesizeInput')">
                                    {{ $engine_size->engine_size }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $engine_size->count }})
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <input type="hidden" name="engine_size" id="enginesizeInput" value="">
        </div>

        <!-- Max Miles to Fuel Type -->
        
        <div class="filter-item flex-column gap-1 advanced-filter-row" style="display: none;">
            <label class="field-label text-start" for="fueltype">Fuel Type</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                        type="button" id="fueltypeDropdown-" data-bs-toggle="dropdown" data-model="false">
                    <span class="dropdown-text">Select Fuel Type</span>
                </button>
                <ul class="dropdown-menu overflow-auto" id="fueltypeList">
                    @if(isset($search_field['fuel_type']))
                        @foreach($search_field['fuel_type'] as $fuel_type)
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)"
                                onclick="updateDropdownText('{{ $fuel_type->fuel_type }}', 'fueltypeDropdown', 'fueltypeInput')">
                                    {{ $fuel_type->fuel_type }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $fuel_type->count }})
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <input type="hidden" name="fuel_type" id="fueltypeInput" value="">
        </div>

        <!-- Engine Size to Gearbox -->
         <div class="filter-item flex-column gap-1 advanced-filter-row" style="display: none;">
            <label class="field-label text-start" for="gearbox">Gearbox</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                        type="button" id="gearboxDropdown" data-bs-toggle="dropdown" data-model="false">
                    <span class="dropdown-text">Select Gearbox</span>
                </button>
                <ul class="dropdown-menu overflow-auto" id="gearboxList">
                    @if(isset($search_field['gear_box']))
                        @foreach($search_field['gear_box'] as $gear_box)
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)"
                                onclick="updateDropdownText('{{ $gear_box->gear_box }}', 'gearboxDropdown', 'gearboxInput')">
                                    {{ $gear_box->gear_box }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $gear_box->count }})
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <input type="hidden" name="transmission_type" id="gearboxInput" value="">
        </div>
        

        <div class="filter-item flex-column gap-1 advanced-filter-row" style="display: none;">
            <label class="field-label text-start" for="doors">Doors</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                        type="button" id="doorsDropdown" data-bs-toggle="dropdown" data-model="false">
                    <span class="dropdown-text">Select Doors</span>
                </button>
                <ul class="dropdown-menu overflow-auto" style="max-height:20rem;" id="doorsList">
                    @if(isset($search_field['doors']))
                        @foreach($search_field['doors'] as $door)
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)"
                                onclick="updateDropdownText('{{ $door->doors }}', 'doorsDropdown', 'doorsInput')">
                                    {{ $door->doors }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $door->count }})
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <input type="hidden" name="doors" id="doorsInput" value="">
        </div>

        <div class="filter-item flex-column gap-1 advanced-filter-row" style="display: none;">
            <label class="field-label text-start" for="colors">Colors</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                        type="button" id="colorsDropdown" data-bs-toggle="dropdown" data-model="false">
                    <span class="dropdown-text">Select Colors</span>
                </button>
                <ul class="dropdown-menu overflow-auto" id="colorsList">
                    @if(isset($search_field['colors']))
                        @foreach($search_field['colors'] as $color)
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)"
                                onclick="updateDropdownText('{{ $color->colors }}', 'colorsDropdown', 'colorsInput')">
                                    {{ $color->colors }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $color->count }})
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <input type="hidden" name="colors" id="colorsInput" value="">
        </div>

        <div class="filter-item flex-column gap-1 advanced-filter-row" style="display: none;">
            <label class="field-label text-start" for="sellertype">Seller Type</label>
            <div class="dropdown custom-dropdown">
                <button class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                        type="button" id="sellertypeDropdown" data-bs-toggle="dropdown" data-model="false">
                    <span class="dropdown-text">Select Seller Type</span>
                </button>
                <ul class="dropdown-menu overflow-auto" id="sellertypeList">
                    @if(isset($search_field['seller_type']))
                        @foreach($search_field['seller_type'] as $seller)
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)"
                                onclick="updateDropdownText('{{ $seller->original_seller_type }}', 'sellertypeDropdown', 'sellertypeInput', '{{ $seller->seller_type }}')">
                                    {{ $seller->seller_type }}&nbsp;&nbsp;&nbsp;&nbsp;({{ $seller->count }})
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <input type="hidden" name="seller_type" id="sellertypeInput" value="">
        </div>
    </div>
    <div class="filter-actions d-flex align-items-center justify-content-between flex-wrap gap-2 mt-4">
        <button type="button" id="moreFiltersBtn" class="btn btn-outline-secondary more-filters-btn" onclick="showMoreFilters()">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7 21V18" stroke="#525866" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M17 21V15" stroke="#525866" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M17 6V3" stroke="#525866" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M7 9V3" stroke="#525866" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M7 18C6.06812 18 5.60218 18 5.23463 17.8478C4.74458 17.6448 4.35523 17.2554 4.15224 16.7654C4 16.3978 4 15.9319 4 15C4 14.0681 4 13.6022 4.15224 13.2346C4.35523 12.7446 4.74458 12.3552 5.23463 12.1522C5.60218 12 6.06812 12 7 12C7.93188 12 8.39782 12 8.76537 12.1522C9.25542 12.3552 9.64477 12.7446 9.84776 13.2346C10 13.6022 10 14.0681 10 15C10 15.9319 10 16.3978 9.84776 16.7654C9.64477 17.2554 9.25542 17.6448 8.76537 17.8478C8.39782 18 7.93188 18 7 18Z" stroke="#525866" stroke-width="1.5"/>
                <path d="M17 12C16.0681 12 15.6022 12 15.2346 11.8478C14.7446 11.6448 14.3552 11.2554 14.1522 10.7654C14 10.3978 14 9.93188 14 9C14 8.06812 14 7.60218 14.1522 7.23463C14.3552 6.74458 14.7446 6.35523 15.2346 6.15224C15.6022 6 16.0681 6 17 6C17.9319 6 18.3978 6 18.7654 6.15224C19.2554 6.35523 19.6448 6.74458 19.8478 7.23463C20 7.60218 20 8.06812 20 9C20 9.93188 20 10.3978 19.8478 10.7654C19.6448 11.2554 19.2554 11.6448 18.7654 11.8478C18.3978 12 17.9319 12 17 12Z" stroke="#525866" stroke-width="1.5"/>
            </svg>
            More Filters
        </button>
        <button type="button" id="lessFiltersBtn" class="btn btn-outline-secondary less-filters-btn " style="display: none;" onclick="showLessFilters()">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7 21V18" stroke="#525866" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M17 21V15" stroke="#525866" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M17 6V3" stroke="#525866" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M7 9V3" stroke="#525866" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M7 18C6.06812 18 5.60218 18 5.23463 17.8478C4.74458 17.6448 4.35523 17.2554 4.15224 16.7654C4 16.3978 4 15.9319 4 15C4 14.0681 4 13.6022 4.15224 13.2346C4.35523 12.7446 4.74458 12.3552 5.23463 12.1522C5.60218 12 6.06812 12 7 12C7.93188 12 8.39782 12 8.76537 12.1522C9.25542 12.3552 9.64477 12.7446 9.84776 13.2346C10 13.6022 10 14.0681 10 15C10 15.9319 10 16.3978 9.84776 16.7654C9.64477 17.2554 9.25542 17.6448 8.76537 17.8478C8.39782 18 7.93188 18 7 18Z" stroke="#525866" stroke-width="1.5"/>
            <path d="M17 12C16.0681 12 15.6022 12 15.2346 11.8478C14.7446 11.6448 14.3552 11.2554 14.1522 10.7654C14 10.3978 14 9.93188 14 9C14 8.06812 14 7.60218 14.1522 7.23463C14.3552 6.74458 14.7446 6.35523 15.2346 6.15224C15.6022 6 16.0681 6 17 6C17.9319 6 18.3978 6 18.7654 6.15224C19.2554 6.35523 19.6448 6.74458 19.8478 7.23463C20 7.60218 20 8.06812 20 9C20 9.93188 20 10.3978 19.8478 10.7654C19.6448 11.2554 19.2554 11.6448 18.7654 11.8478C18.3978 12 17.9319 12 17 12Z" stroke="#525866" stroke-width="1.5"/>
        </svg>
            Less Filters
        </button>
        <div class="d-flex align-items-center gap-2 search-btn-container">
            <a onclick="clearFilters()" class="clear-all-link">Clear all</a>
            <button type="submit" id="searchButton" class="btn btn-dark search-btn">Search</button>
        </div>
    </div> 
</form>

<script>
(function() {

    document.addEventListener('click', function (e) {
        const item = e.target.closest('.dropdown-item');
        if (!item) return;
        const parentDropdown = item.closest('.dropdown-menu') || item.closest('.custom-select-list');
        parentDropdown
            .querySelectorAll('.dropdown-item')
            .forEach(i => i.classList.remove('selected-option'));
            item.classList.add('selected-option');
    });


    const advancedFilterRows = document.querySelectorAll('.advanced-filter-row');
    const moreFiltersBtn = document.getElementById('moreFiltersBtn');
    const lessFiltersBtn = document.getElementById('lessFiltersBtn');
    
    function toggleAdvancedFilters(show) {
        const displayValue = show ? 'flex' : 'none';
        
        advancedFilterRows.forEach(function(filter) {
            filter.style.display = displayValue;
        });
        
        if (moreFiltersBtn) {
            moreFiltersBtn.style.display = show ? 'none' : 'inline-flex';
        }
        
        if (lessFiltersBtn) {
            lessFiltersBtn.style.display = show ? 'inline-flex' : 'none';
        }
    }
    
    window.showMoreFilters = function() {
        toggleAdvancedFilters(true);
        return false;
    };
    
    window.showLessFilters = function() {
        toggleAdvancedFilters(false);
        return false;
    };
})();

// Add "open" class to dropdown when dropdown-menu has "show" class
(function() {
    const dropdownMenus = document.querySelectorAll('.dropdown-menu');
    
    dropdownMenus.forEach(function(menu) {
        const dropdown = menu.closest('.dropdown');
        if (!dropdown) return;
        
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
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


document.addEventListener('DOMContentLoaded', function() {
  
    const dropdownButtons = document.querySelectorAll('.dropdown-toggle');
    const modals = document.querySelectorAll('.custom-select-modal');

    dropdownButtons.forEach(button => {
        if(button.dataset.model == "false") return;
        button.addEventListener('click', function(e) {
            const filterName = button.dataset.dropdown;

            modals.forEach(modal => {
                if (modal.dataset.modal === filterName) {
                    // Toggle the corresponding modal
                    modal.style.display = modal.style.display === 'flex' ? 'none' : 'flex';
                } else {
                    modal.style.display = 'none'; // hide others
                }
            });
        });
    });

    // Close modal on clicking outside
    modals.forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
 
});

</script>
