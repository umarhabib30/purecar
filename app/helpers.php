<?php

use App\Models\Companies;
use App\Models\Customers;
use App\Models\ReservationRoute;
use App\Models\Reservations;
use App\Models\RouteVehicle;
use App\Models\ReservationRequest;
use App\Models\Routes;
use App\Models\Setting;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Models\Vehicle;
use App\Models\Faq;
use App\Models\Highlight;
use App\Models\Blog;

if (!function_exists('getCompanyDetail')) {
function getCompanyDetail($data)
{
    $companyDetail = \App\Models\CompanyDetail::first();
    return $companyDetail ? $companyDetail->$data : null;
}
}
