<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BusinessLocation;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BusinessLocationsImport; 

class BusinessLocationController extends Controller
{
    public function index()
    {
        $businessLocations = BusinessLocation::all();
        return view('business.backend.business-locations.index', compact('businessLocations'));
    }

    public function create()
    {
        return view('business.backend.business-locations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:business_locations',
        ]);

        BusinessLocation::create($validated);

        return redirect()->route('list-business-locations.index')->with('success', 'Business location created successfully!');
    }

    public function edit(BusinessLocation $business_location)
    {
        return view('business.backend.business-locations.edit', compact('business_location'));
    }

    public function update(Request $request, $id)
    {
        $businessLocation = BusinessLocation::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:business_locations,name,' . $businessLocation->id,
        ]);

        $businessLocation->update($validated);

        return redirect()->route('list-business-locations.index')->with('success', 'Business location updated successfully!');
    }

    public function delete(BusinessLocation $business_location)
    {
        $business_location->delete();
        return redirect()->route('list-business-locations.index')->with('success', 'Business location deleted successfully!');
    }

    public function bulkUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls|max:5048', 
        ]);

        try {
            Excel::import(new BusinessLocationsImport, $request->file('file'));
            return redirect()->route('list-business-locations.index')->with('success', 'Business locations imported successfully!');
        } catch (\Exception $e) {
            return redirect()->route('list-business-locations.index')->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }
}