<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::orderBy('created_at', 'desc')->get();
        return view('packages.index', compact('packages'));
    }

    public function create()
    {
        return view('packages.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
            'is_featured' => 'required|boolean',
            'features' => 'required|array|min:1',
            'features.*' => 'required|string|max:255',
            'recovery_payment' => 'required|string|max:255',
        ]);

        $validatedData['features'] = json_encode($request->features);

        try {
            Package::create($validatedData);
            return redirect()->route('packages.index')->with('success', 'Package added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating package: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $package = Package::findOrFail($id);
        $package->features = json_decode($package->features, true);
        return view('packages.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
            'is_featured' => 'required|boolean',
            'features' => 'required|array|min:1',
            'features.*' => 'required|string|max:255',
            'recovery_payment' => 'required|string|max:255',

        ]);

        try {
            $validatedData['features'] = json_encode($request->features);
            
            $package->update($validatedData);
            return redirect()->route('packages.index')->with('success', 'Package updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating package: ' . $e->getMessage())->withInput();
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $package = Package::findOrFail($id);
            $validated = $request->validate([
                'is_active' => 'required|boolean'
            ]);

            $package->is_active = $validated['is_active'];
            $package->save();
        
            return response()->json([
                'status' => 'success',
                'message' => 'Package status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating package status: ' . $e->getMessage()
            ], 500);
        }
    }
    public function featureupdateStatus(Request $request, $id)
    {
        try {
            $package = Package::findOrFail($id);
            $validated = $request->validate([
                'is_featured' => 'required|boolean'
            ]);

            $package->is_featured = $validated['is_featured'];
            $package->save();
        
            return response()->json([
                'status' => 'success',
                'message' => 'Package status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating package status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $package = Package::findOrFail($id);
            $package->delete();

            return redirect()->route('packages.index')->with('success', 'Package deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('packages.index')->with('error', 'Error deleting package: ' . $e->getMessage());
        }
    }
}