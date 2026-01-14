<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Counter;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'advert_id' => 'required|integer',
            'counter_type' => 'required|in:call,text,email',
        ]);

        Counter::create([
            'advert_id' => $request->advert_id,
            'counter_type' => $request->counter_type,
        ]);

        return response()->json(['message' => 'Counter recorded successfully.']);
    }

}
