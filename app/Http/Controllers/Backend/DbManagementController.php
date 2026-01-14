<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;

class DbManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::with('advert');

        if ($request->filled('make')) {
            $query->where('make', 'LIKE', '%' . $request->make . '%');
        }

        if ($request->filled('model')) {
            $query->where('model', 'LIKE', '%' . $request->model . '%');
        }

        if ($request->filled('variant')) {
            $query->where('variant', 'LIKE', '%' . $request->variant . '%');
        }

        $cars = $query->get();

        return view('DbManagement.index', compact('cars'));
    }

    public function edit($id)
    {
        $car = Car::with('advert')->findOrFail($id);
        return view('DbManagement.edit', compact('car'));
    }

    public function update(Request $request, $id)
{
    $car = Car::findOrFail($id);

    $request->validate([
        'make' => 'required|string|max:255',
        'model' => 'required|string|max:255',
        'variant' => 'nullable|string|max:255',
        'fuel_type' => 'nullable|string|max:100',
        'transmission_type' => 'nullable|string|max:100',
        'body_type' => 'nullable|string|max:100',
        'engine_size' => 'nullable|string|max:50',
        'doors' => 'nullable|numeric',
        'seats' => 'nullable|numeric',
        'colors' => 'nullable|string|max:100',
        'gear_box' => 'nullable|string|max:100',
        'Rpm' => 'nullable|string|max:100',
        'RigidArtic' => 'nullable|string|max:100',
        'NumberOfAxles' => 'nullable|string|max:100',
        'FuelTankCapacity' => 'nullable|string|max:100',
        'GrossVehicleWeight' => 'nullable|string|max:100',
        'Bhp' => 'nullable|string|max:100',
        'Kph' => 'nullable|string|max:100',
        'Transmission' => 'nullable|string|max:100',
        'EngineCapacity' => 'nullable|string|max:100',
        'NumberOfCylinders' => 'nullable|string|max:100',
        'DriveType' => 'nullable|string|max:100',
        'Trim' => 'nullable|string|max:100',
        'Range' => 'nullable|string|max:100',
        'ExtraUrban' => 'nullable|string|max:100',
        'UrbanCold' => 'nullable|string|max:100',
        'Combined' => 'nullable|string|max:100',
    ]);

    $car->update($request->only([
        'make', 'model', 'variant', 'fuel_type', 'transmission_type', 'body_type',
        'engine_size', 'doors', 'seats', 'colors', 'gear_box', 
        'Rpm', 'RigidArtic',  'NumberOfAxles', 'FuelTankCapacity',
        'GrossVehicleWeight',  'Bhp', 'Kph', 'Transmission', 'EngineCapacity',
        'NumberOfCylinders', 'DriveType', 'Trim', 'Range',
        'ExtraUrban', 'UrbanCold', 'Combined'
    ]));

    return redirect()->route('admin.car.index')->with('success', 'Car advert updated successfully!');
}

}
