<?php
namespace App\Http\Controllers;

use App\Services\FacebookCatalogService;
use App\Models\Car;
use Illuminate\Http\Request;

class FacebookCatalogController extends Controller
{
    protected $facebookService;
    
    public function __construct(FacebookCatalogService $facebookService)
    {
        $this->facebookService = $facebookService;
    }
    
    
    public function syncSingleCar($carId)
    {
        $car = Car::findOrFail($carId);
        $result = $this->facebookService->syncCar($car);
        
        if ($result) {
            return response()->json([
                'success' => true,
                'message' => "Car {$carId} synced successfully"
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Failed to sync car {$carId}"
            ], 500);
        }
    }
    
    
    public function syncAllCars(Request $request)
    {
        $limit = $request->input('limit', null);
        $results = $this->facebookService->syncAllCars($limit);
        
        return response()->json([
            'success' => true,
            'results' => $results,
            'message' => "Synced {$results['success']} cars successfully, {$results['failed']} failed"
        ]);
    }
    
    
    // public function testSync()
    // {
    //     $car = Car::with(['advert', 'advert.user'])
    //         ->whereHas('advert')
    //         ->first();
        
    //     if (!$car) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'No cars found to test'
    //         ], 404);
    //     }
        
    //     $result = $this->facebookService->syncCar($car);
        
    //     return response()->json([
    //         'success' => $result,
    //         'car_id' => $car->car_id,
    //         'message' => $result ? 'Test sync successful' : 'Test sync failed'
    //     ]);
    // }
    
    
    // public function deleteCar($carId)
    // {
    //     $car = Car::findOrFail($carId);
    //     $result = $this->facebookService->deleteCar($car);
        
    //     return response()->json([
    //         'success' => $result,
    //         'message' => $result ? 'Car deleted from catalog' : 'Failed to delete car'
    //     ]);
    // }
}