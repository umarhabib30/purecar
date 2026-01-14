<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarOptimizationController extends Controller
{
    public function optimizeCarsTable()
    {
        try {
            DB::beginTransaction();
            DB::table('cars')
                ->where('make', 'like', '%MERCEDES-BENZ%')
                ->update(['make' => 'MERCEDES']);

            DB::table('cars')->get()->each(function ($car) {
                $firstWord = explode(' ', trim($car->fuel_type))[0];
                DB::table('cars')
                    ->where('car_id', $car->car_id)
                    ->update(['fuel_type' => strtoupper($firstWord)]);
            });
            DB::table('cars')->get()->each(function ($car) {
                $gearbox = trim($car->gear_box);
                if (strtoupper($gearbox) === 'N/A') {
                    return; 
                }
                $autoValues = ['SEMI AUTO', 'TRIPTRONIC', 'CVT', 'SEMI AUTOMATIC', 'Tiptronic Automatic', 'Automatic', 'Semi auto', 'Semi Automatic', 'Auto','AUTO', 'AUTO 5 GEARS','SEMI AUTO'];
                $newGearbox = in_array($gearbox, $autoValues, true) ? 'AUTO' : 'MANUAL';
                DB::table('cars')
                    ->where('car_id', $car->car_id)
                    ->update(['gear_box' => strtoupper($newGearbox)]);
            });
           DB::table('cars')->get()->each(function ($car) {
                $colorParts = explode(' ', trim($car->colors));
                $newColor = isset($colorParts[1]) ? $colorParts[1] : $colorParts[0];
                DB::table('cars')
                    ->where('car_id', $car->car_id)
                    ->update(['colors' => strtoupper($newColor)]);
            });
            DB::table('cars')->get()->each(function ($car) {
                            if (preg_match('/^(\d+)L$/i', trim($car->engine_size), $matches)) {
                                $normalized = $matches[1] . '.0L';
                                DB::table('cars')
                                    ->where('car_id', $car->car_id)
                                    ->update(['engine_size' => $normalized]);
                            }
                        });

            DB::table('cars')->get()->each(function ($car) {
                $type = strtoupper(trim($car->body_type));

                $suv = ['SUV', 'SUV COUPE', 'SUV ESTATE','SPORTS UTILITY VEHICLE'];
                $van = ['CAR DERIVED VAN', 'COMMERCIAL', 'PANEL VAN', 'VAN DERIVED CAR', 'WINDOW VAN'];
                $pickup = ['PICK UP', 'PICKUP'];
                $convertible = ['CONVERTIBLE', 'SUV CONVERTIBLE'];
                $chassisCab = ['CHASSIS CAB', 'VEHICLE TRANSPORTER'];
                $sportsutality = [];

                if (in_array($type, $suv)) {
                    $normalizedType = 'SUV';
                } elseif (in_array($type, $van)) {
                    $normalizedType = 'VAN';
                } elseif (in_array($type, $pickup)) {
                    $normalizedType = 'PICKUP';
                } elseif (in_array($type, $convertible)) {
                    $normalizedType = 'CONVERTIBLE';
                } elseif (in_array($type, $chassisCab)) {
                    $normalizedType = 'CHASSIS CAB';
                } else {
                    $normalizedType = $car->body_type; 
                }

                DB::table('cars')
                    ->where('car_id', $car->car_id)
                    ->update(['body_type' => strtoupper($normalizedType)]);
            });

            DB::statement("
                DELETE FROM adverts
                WHERE advert_id NOT IN (
                    SELECT DISTINCT advert_id 
                    FROM cars 
                    WHERE advert_id IS NOT NULL
                )
            ");
            DB::commit();
           
        } catch (\Exception $e) {
            DB::rollBack();
           
            throw $e;
        }
    }
}