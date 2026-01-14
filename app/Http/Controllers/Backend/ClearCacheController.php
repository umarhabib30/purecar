<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;

class ClearCacheController extends Controller
{
    public function clear()
    {
 
        Artisan::call('cache:clear');
        
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('clear-compiled');

          return redirect()->back()->with('success', 'Cache cleared');
    }
}