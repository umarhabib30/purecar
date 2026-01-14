<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BusinessType;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BusinessTypesImport; 

class BusinessTypeController extends Controller
{
    public function index()
    {
        $businessTypes = BusinessType::all();
        return view('business.backend.business-types.index', compact('businessTypes'));
    }

    public function create()
    {
        return view('business.backend.business-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:business_types',
        ]);

        BusinessType::create($validated);

        return redirect()->route('list-business-types.index')->with('success', 'Business type created successfully!');
    }

    public function edit(BusinessType $business_type)
    {
        return view('business.backend.business-types.edit', compact('business_type'));
    }

    public function update(Request $request, $id)
    {
        $businessType = BusinessType::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:business_types,name,' . $businessType->id,
        ]);

        $businessType->update($validated);

        return redirect()->route('list-business-types.index')->with('success', 'Business type updated successfully!');
    }

    public function delete(BusinessType $business_type)
    {
        $business_type->delete();
        return redirect()->route('list-business-types.index')->with('success', 'Business type deleted successfully!');
    }
    public function bulkUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls|max:5048', 
        ]);

        try {
            Excel::import(new BusinessTypesImport, $request->file('file'));
            return redirect()->route('list-business-types.index')->with('success', 'Business types imported successfully!');
        } catch (\Exception $e) {
            return redirect()->route('list-business-types.index')->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }
}