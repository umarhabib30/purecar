<?php

namespace App\Http\Controllers;
use App\Models\MotHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\MotData;
use App\Models\VehicleKeeperData;
use App\Models\VehicleData;
use Session;
class APIController extends Controller
{
    
    public function fetchVehicleData(Request $request)
    {
        return $this->getVehicleData($request);
    }

 
    public function getVehicleData(Request $request)
    {

        $isFromAdvert = $request->has('license_plate') && $request->has('miles');
        
        if ($isFromAdvert) {
            $request->validate([
                'license_plate' => 'required|string|unique:adverts,license_plate',
                'miles' => 'required'
            ]);
            $vrm = str_replace(' ', '', $request->input('license_plate'));
            $miles = $request->input('miles');
        } else {
            $vrm = str_replace(' ', '', $request->input('vrm'));
            if (!$vrm) {
                return response()->json(['error' => 'VRM is required.'], 400);
            }
        }

   
        $endpoint = "https://uk1.ukvehicledata.co.uk/api/datapackage/VehicleData";
        $response = Http::get($endpoint, [
            'v' => 2,
            'api_nullitems' => 1,
            'auth_apikey' => env('UK_VEHICLE_DATA_API_KEY'),
            'key_VRM' => $vrm
        ]);
       
        if ($response->successful()) {
            $data = $response->json();
            VehicleKeeperData::updateOrCreate(
                ['license_plate' => $vrm],
                ['vehicle_data' => $data]
            );
        
     
            if ($isFromAdvert) {
                if (!empty($data['Response']['DataItems'])) {
                    $vehicleInfo = [
                        'make' => $data['Response']['DataItems']['ClassificationDetails']['Dvla']['Make'] ?? 'N/A',
                        'model' => $data['Response']['DataItems']['ClassificationDetails']['Smmt']['Range'] ?? 'N/A',
                        'variant' => $data['Response']['DataItems']['ClassificationDetails']['Dvla']['Model'] ?? 'N/A',
                        'YearOfManufacture' => $data['Response']['DataItems']['VehicleRegistration']['YearOfManufacture'] ?? 'N/A',
                        'EngineCapacity' => $data['Response']['DataItems']['SmmtDetails']['NominalEngineCapacity'] ?? 'N/A',
                        'MakeModel' => $data['Response']['DataItems']['VehicleRegistration']['MakeModel'] ?? 'N/A',
                        'NumberOfDoors' => $data['Response']['DataItems']['TechnicalDetails']['Dimensions']['NumberOfDoors'] ?? 0,
                        'FuelType' => $data['Response']['DataItems']['VehicleRegistration']['FuelType'] ?? 'N/A',
                        'Transmission' => $data['Response']['DataItems']['SmmtDetails']['Transmission'] ?? 'N/A',
                        'BodyStyle' => $data['Response']['DataItems']['SmmtDetails']['BodyStyle'] ?? 'N/A',
                        'NumberOfSeats' => $data['Response']['DataItems']['TechnicalDetails']['Dimensions']['NumberOfSeats'] ?? 0,
                        'NumberOfPreviousKeepers' => $data['Response']['DataItems']['VehicleHistory']['NumberOfPreviousKeepers'] ?? 0,
                        'Color' => $data['Response']['DataItems']['VehicleRegistration']['Colour'] ?? 'N/A',
                        'Rpm' => $data['Response']['DataItems']['TechnicalDetails']['Performance']['Power']['Rpm'] ?? 'N/A',
                        'RigidArtic' => $data['Response']['DataItems']['TechnicalDetails']['Dimensions']['RigidArtic'] ?? 'N/A',
                        'BodyShape' => $data['Response']['DataItems']['TechnicalDetails']['Dimensions']['BodyShape'] ?? 'N/A',
                        'NumberOfAxles' => $data['Response']['DataItems']['TechnicalDetails']['Dimensions']['NumberOfAxles'] ?? 0,
                        'FuelTankCapacity' => $data['Response']['DataItems']['TechnicalDetails']['Dimensions']['FuelTankCapacity'] ?? 0,
                        'GrossVehicleWeight' => $data['Response']['DataItems']['TechnicalDetails']['Dimensions']['GrossVehicleWeight'] ?? 0,
                        'FuelCatalyst' => $data['Response']['DataItems']['TechnicalDetails']['General']['Engine']['FuelCatalyst'] ?? 'N/A',
                        'Aspiration' => $data['Response']['DataItems']['TechnicalDetails']['General']['Engine']['Aspiration'] ?? 'N/A',
                        'FuelSystem' => $data['Response']['DataItems']['TechnicalDetails']['General']['Engine']['FuelSystem'] ?? 'N/A',
                        'FuelDelivery' => $data['Response']['DataItems']['TechnicalDetails']['General']['Engine']['FuelDelivery'] ?? 'N/A',
                        'Bhp' => $data['Response']['DataItems']['TechnicalDetails']['Performance']['Power']['Bhp'] ?? 'N/A',
                        'Kph' => $data['Response']['DataItems']['TechnicalDetails']['Performance']['MaxSpeed']['Mph'] ?? 'N/A',
                        'NominalEngineCapacity' => $data['Response']['DataItems']['SmmtDetails']['NominalEngineCapacity'] ?? 'N/A',
                        'NumberOfCylinders' => $data['Response']['DataItems']['TechnicalDetails']['General']['Engine']['NumberOfCylinders'] ?? 0,
                        'gear_box' => $data['Response']['DataItems']['SmmtDetails']['Transmission'] ?? 'N/A',
                        'DriveType' => $data['Response']['DataItems']['SmmtDetails']['DriveType'] ?? 'N/A',
                        'Trim' => $data['Response']['DataItems']['ClassificationDetails']['Smmt']['Trim'] ?? 'N/A',
                        'Range' => $data['Response']['DataItems']['ClassificationDetails']['Smmt']['Range'] ?? 'N/A',
                        'Scrapped' => (bool)($data['Response']['DataItems']['VehicleRegistration']['Scrapped'] ?? false),
                        'Imported' => (bool)($data['Response']['DataItems']['VehicleRegistration']['Imported'] ?? false),
                       'ExtraUrban' => is_numeric($data['Response']['DataItems']['TechnicalDetails']['Consumption']['ExtraUrban']['Mpg'] ?? null) 
                            ? $data['Response']['DataItems']['TechnicalDetails']['Consumption']['ExtraUrban']['Mpg'] 
                            : 0,

                        'UrbanCold' => is_numeric($data['Response']['DataItems']['TechnicalDetails']['Consumption']['UrbanCold']['Mpg'] ?? null) 
                            ? $data['Response']['DataItems']['TechnicalDetails']['Consumption']['UrbanCold']['Mpg'] 
                            : 0,

                        'Combined' => is_numeric($data['Response']['DataItems']['TechnicalDetails']['Consumption']['Combined']['Mpg'] ?? null) 
                            ? $data['Response']['DataItems']['TechnicalDetails']['Consumption']['Combined']['Mpg'] 
                            : 0,

                    ];

                    $licensedata = [
                        'license_plate' => $vrm,
                        'miles' => $miles
                    ];

                    session([
                        'vehicleInfo' => $vehicleInfo,
                        'licensedata' => $licensedata
                    ]);

                    return view('SubmitAdvertPage2', compact('vehicleInfo'));
                } else {
                    return back()->withErrors('No data found - Please try again.');
                }
            } else {
               
                return response()->json($data);
            }
        } else {
        
            if ($isFromAdvert) {
                return back()->withErrors('Failed to connect to the API. Please try again later.');
            } else {
                return response()->json(['error' => 'Failed to fetch data from API.'], 500);
            }
        }
    }
    public function getVehiclefeaturesData(Request $request)
    {
        $vrm = str_replace(' ', '', $request->input('vrm'));

        if (!$vrm) {
            return response()->json(['error' => 'VRM is required.'], 400);
        }

        $response = Http::get("https://uk1.ukvehicledata.co.uk/api/datapackage/SpecAndOptionsData", [
            'v' => 2,
            'api_nullitems' => 1,
            'auth_apikey' => env('UK_VEHICLE_DATA_API_KEY'),
            'key_VRM' => $vrm
        ]);

        if ($response->successful()) {
            $responseData = $response->json();

            $existingRecord = VehicleData::where('license_plate', $vrm)->first();

            if ($existingRecord) {
                if ($existingRecord->data !== $responseData) {
                    $existingRecord->update(['data' => $responseData]);
                }
            } else {
                VehicleData::create([
                    'license_plate' => $vrm,
                    'data' => $responseData
                ]);
            }

            return response()->json($responseData);
        } else {
            return response()->json(['error' => 'Failed to fetch data from API.'], 500);
        }
    }
    
    

    public function getMotHistory(Request $request)
    {
        $vrm = str_replace(' ', '', $request->input('vrm'));

        if (!$vrm) {
            return response()->json(['error' => 'VRM is required.'], 400);
        }

        $response = Http::get("https://uk1.ukvehicledata.co.uk/api/datapackage/MotHistoryData", [
            'v' => 2,
            'api_nullitems' => 1,
            'auth_apikey' => env('UK_VEHICLE_DATA_API_KEY'),
            'key_VRM' => $vrm
        ]);

        if ($response->successful()) {
            $responseData = $response->json();

            MotData::updateOrCreate(
                ['license_plate' => $vrm],
                ['mot_history' => $responseData]
            );

            return response()->json($responseData);
        } else {
            return response()->json(['error' => 'Failed to fetch data from API.'], 500);
        }
    }

    public function getVehicleDetailsFromDb(Request $request)
    {
        $vrm = str_replace(' ', '', $request->input('vrm'));
        if (!$vrm) {    
            return response()->json(['error' => 'VRM is required.'], 400);
        }
        
        $vehicleData = VehicleKeeperData::where('license_plate', $vrm)->first();

        if (!$vehicleData) {
            return response()->json(['error' => 'No data found for this VRM.'], 404);
        }

        $vehicleDataArray = is_array($vehicleData->vehicle_data) ? $vehicleData->vehicle_data : json_decode($vehicleData->vehicle_data, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid JSON data.'], 500);
        }

        $dateFirstRegistered = $vehicleDataArray['Response']['DataItems']['VehicleRegistration']['DateFirstRegistered'] ?? null;
        $vehicleHistory = $vehicleDataArray['Response']['DataItems']['VehicleHistory'] ?? [];
        $numberOfPreviousKeepers = $vehicleHistory['NumberOfPreviousKeepers'] ?? null;
        $keeperChangesList = [];
        
        if (!empty($vehicleHistory['KeeperChangesList'])) {
            foreach ($vehicleHistory['KeeperChangesList'] as $index => $keeperChange) {
                $keeperChangesList[] = [
                    'SerialNo' => $index + 1,
                    'NumberOfPreviousKeepers' => $keeperChange['NumberOfPreviousKeepers'],
                    'DateOfLastKeeperChange' => $keeperChange['DateOfLastKeeperChange']
                ];
            }
        }
        $responseData = [
            'DateFirstRegistered' => $dateFirstRegistered,
            'NumberOfPreviousKeepers' => $numberOfPreviousKeepers,
            'KeeperChangesList' => $keeperChangesList,
        ];

        return response()->json($responseData);
    }
    public function getVehicleFeaturesFromDb(Request $request)
{
    $vrm = str_replace(' ', '', $request->input('vrm'));

    if (!$vrm) {
        return response()->json(['error' => 'VRM is required.'], 400);
    }

    try {
        $vehicleData = VehicleData::where('license_plate', $vrm)->first();

        if (!$vehicleData) {
            return response()->json(['error' => 'No data found for this VRM.'], 404);
        }

       
        $dataArray = $vehicleData->data;
        
      
        if (is_string($dataArray)) {
            $dataArray = json_decode($dataArray, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json(['error' => 'Invalid JSON data: ' . json_last_error_msg()], 500);
            }
        } 
     
        else if (!is_array($dataArray)) {
            return response()->json(['error' => 'Data is neither a JSON string nor an array.'], 500);
        }

        
        $vehicleDetails = $dataArray['Response']['DataItems']['VehicleDetails'] ?? [];
        $factoryEquipmentList = $dataArray['Response']['DataItems']['FactoryEquipmentList'] ?? [];

      
        if (!is_array($factoryEquipmentList)) {
            $factoryEquipmentList = [];
        }

        $response = [
            'VehicleDetails' => [
                'VRM' => $vrm,
                'Make' => $vehicleDetails['Make'] ?? null,
                'Model' => $vehicleDetails['Model'] ?? null,
                'Colour' => $vehicleDetails['Colour'] ?? null,
                'FuelType' => $vehicleDetails['FuelType'] ?? null,
                'DateFirstRegistered' => $vehicleDetails['DateFirstRegistered'] ?? null
            ],
            'FactoryEquipmentList' => $factoryEquipmentList
        ];
        
        return response()->json($response);
    } catch (\Exception $e) {
        
     
        
        return response()->json([
            'error' => 'Server error occurred. Please check the logs for details.',
            'message' => $e->getMessage()
        ], 500);
    }
}

    public function getMotDataFromDb(Request $request)
    {
        $vrm = str_replace(' ', '', $request->input('vrm'));
        if (!$vrm) {    
            return response()->json(['error' => 'VRM is required.'], 400);
        }

        $motData = MotData::where('license_plate', $vrm)->first();

        if (!$motData) {
            return response()->json(['error' => 'No MOT data found for this VRM.'], 404);
        }

        $motDataArray = is_array($motData->mot_history) ? $motData->mot_history : json_decode($motData->mot_history, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid JSON data: ' . json_last_error_msg()], 500);
        }


        $vehicleDetails = $motDataArray['Response']['DataItems']['VehicleDetails'] ?? [];
        $vehicleStatus = $motDataArray['Response']['DataItems']['VehicleStatus'] ?? [];
        
        $response = [
            'VehicleDetails' => [
                'VRM' => $vrm,
                'Make' => $vehicleDetails['Make'] ?? null,
                'Model' => $vehicleDetails['Model'] ?? null,
                'Colour' => $vehicleDetails['Colour'] ?? null,
                'FuelType' => $vehicleDetails['FuelType'] ?? null,
                'DateFirstRegistered' => $vehicleDetails['DateFirstRegistered'] ?? null
            ],
            'VehicleStatus' => [
                'HasCurrentMot' => $vehicleStatus['VehicleHasCurrentMot'] ?? null,
                'IsMotExempt' => $vehicleStatus['VehicleIsMotExempt'] ?? null,
                'DaysUntilNextMotIsDue' => $vehicleStatus['DaysUntilNextMotIsDue'] ?? null,
                'MotExemptReason' => $vehicleStatus['VehicleMotExemptReason'] ?? null,
                'NextMotDueDate' => $vehicleStatus['NextMotDueDate'] ?? null
            ],
            'TestDetails' => []
        ];

        $motHistory = $motDataArray['Response']['DataItems']['MotHistory'] ?? [];

        if (!empty($motHistory['RecordList'])) {
            foreach ($motHistory['RecordList'] as $record) {
                if (isset($record['TestNumber'])) {
                    $response['TestDetails'][] = [
                      
                        'TestNumber' => $record['TestNumber'],
                        'TestDate' => $record['TestDate'],
                        'TestResult' => $record['TestResult'],
                        'ExpiryDate' => $record['ExpiryDate'] ?? null,
                        'IsRetest' => $record['IsRetest'] ?? false,
                        
                      
                        'OdometerReading' => $record['OdometerReading'],
                        'OdometerUnit' => $record['OdometerUnit'],
                        'OdometerInKilometers' => $record['OdometerInKilometers'],
                        'OdometerInMiles' => $record['OdometerInMiles'],
                        
                   
                        'MileageSinceLastPass' => $record['MileageSinceLastPass'],
                        'MileageAnomalyDetected' => $record['MileageAnomalyDetected'],
                        'DaysSinceLastPass' => $record['DaysSinceLastPass'],
                        'DaysSinceLastTest' => $record['DaysSinceLastTest'],
                        'DaysOutOfMot' => $record['DaysOutOfMot'] ?? null,
                        
              
                        'AdvisoryNoticeCount' => $record['AdvisoryNoticeCount'] ?? 0,
                        'DangerousFailureCount' => $record['DangerousFailureCount'] ?? 0,
                        'MajorFailureCount' => $record['MajorFailureCount'] ?? 0,
                        
                  
                        'HasExtensionPeriod' => $record['HasExtensionPeriod'] ?? false,
                        'ExtensionPeriodReason' => $record['ExtensionPeriodReason'] ?? null,
                        'ExtensionPeriodAdditionalDays' => $record['ExtensionPeriodAdditionalDays'] ?? null,
                        'ExtensionPeriodOriginalDueDate' => $record['ExtensionPeriodOriginalDueDate'] ?? null,
                        
                   
                        'AdvisoryNoticeList' => $record['AdvisoryNoticeList'] ?? [],
                        'FailureReasonList' => $record['FailureReasonList'] ?? [],
                        'AnnotationDetailsList' => array_map(function($annotation) {
                            return [
                                'Type' => $annotation['Type'] ?? '',
                                'Text' => $annotation['Text'] ?? '',
                                'Dangerous' => $annotation['Dangerous'] ?? false
                            ];
                        }, $record['AnnotationDetailsList'] ?? [])
                    ];
                }
            }
        }

        return response()->json($response);
    }
    
}