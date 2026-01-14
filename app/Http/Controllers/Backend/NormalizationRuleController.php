<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\NormalizationRule;
use App\Models\NormalizationHistory;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class NormalizationRuleController extends Controller
{
    public function index()
    {
        $categories = [
            'colors' => 'Color',
            'make' => 'Make',
            'model' => 'Model',
            'variant' => 'Variant',
            'fuel_type' => 'Fuel Type',
            'transmission_type' => 'Transmission',
            'body_type' => 'Body Type',
            'gear_box' => 'Gear Box',
            'seats' => 'Seats',
            'doors' => 'Doors',
            'engine_size' => 'Engine Size'
        ];
        return view('admin.normalization_rules.index', compact('categories'));
    }
    public function getValues(Request $request)
    {
        try {
            $category = $request->input('category');
            $page = $request->input('page', 1);
            $perPage = $request->input('per_page', 50);
            $search = $request->input('search', '');
            $showEmpty = $request->input('show_empty', false);
            
            $columnMap = $this->getColumnMap();
            if (!isset($columnMap[$category])) {
                return response()->json(['error' => 'Invalid category'], 400);
            }
            $column = $columnMap[$category];
            $originalColumn = 'original_'.$column;
            // echo $category;
            // echo '<br>';
            // echo $originalColumn;
            // echo '<br>';
            // echo $column;die();
            if($category == 'colors')
            {
               $column = 'advert_colour';
            }
            $query = Car::select([
                DB::raw("COALESCE({$originalColumn}, {$column}) as raw_value"),
                DB::raw('COUNT(*) as count'),
                DB::raw("MAX({$column}) as current_value")
            ]);
            if ($category === 'model') {
                $query->addSelect(DB::raw('GROUP_CONCAT(DISTINCT make ORDER BY make SEPARATOR ", ") as makes'));
            } elseif ($category === 'variant') {
                $query->addSelect([
                    DB::raw('GROUP_CONCAT(DISTINCT make ORDER BY make SEPARATOR ", ") as makes'),
                    DB::raw('GROUP_CONCAT(DISTINCT model ORDER BY model SEPARATOR ", ") as models')
                ]);
            }
            if($showEmpty) 
            {
                $query->where(function($q) use ($column, $originalColumn) {
                    $q->where(function($sq) use ($column) {
                        $sq->whereNull($column)
                          ->orWhere($column, '')
                          ->orWhere($column, 'NULL')
                          ->orWhere($column, 'null');
                    })->orWhere(function($sq) use ($originalColumn) {
                        $sq->whereNull($originalColumn)
                          ->orWhere($originalColumn, '')
                          ->orWhere($originalColumn, 'NULL')
                          ->orWhere($originalColumn, 'null');
                    });
                });
            }
            $query->groupBy(DB::raw("COALESCE({$originalColumn}, {$column})"));
            $carsValues = $query->get()->map(function($item) use ($category) {
                $rawValue = $item->raw_value ?? '';
                
                $result = [
                    'raw_value' => $rawValue === '' ? '[EMPTY]' : $rawValue,
                    'current_value' => $item->current_value,
                    'count' => $item->count,
                    'is_empty' => $rawValue === '' || $rawValue === 'null' || $rawValue === 'NULL'
                ];
                if ($category === 'model' && isset($item->makes)) {
                    $result['makes'] = $item->makes;
                } elseif ($category === 'variant') {
                    $result['makes'] = $item->makes ?? '';
                    $result['models'] = $item->models ?? '';
                }
                return $result;
            });
            $rules = NormalizationRule::where('category', $category)->get();
            
            $allRawValues = $carsValues->pluck('raw_value')->merge(
                $rules->pluck('raw_value')->map(function($value) {
                    return $value === '' || $value === null ? '[EMPTY]' : $value;
                })
            )->unique();
            $allValues = $allRawValues->map(function($rawValue) use ($rules, $carsValues, $category) {
                $displayRawValue = $rawValue === '[EMPTY]' ? '' : $rawValue;
                
                $rule = $rules->first(function($r) use ($displayRawValue) {
                    return ($r->raw_value ?? '') === $displayRawValue;
                });
                
                $carValue = $carsValues->firstWhere('raw_value', $rawValue);
                
                $normalizedValue = $rule ? $rule->normalized_value : ($carValue ? $carValue['current_value'] : $rawValue);
                
                $result = [
                    'raw_value' => $rawValue,
                    'normalized_value' => $normalizedValue,
                    'is_hidden' => $rule && $rule->normalized_value === null,
                    'rule_id' => $rule ? $rule->id : null,
                    'has_rule' => $rule !== null,
                    'count' => $carValue ? $carValue['count'] : 0,
                    'is_empty' => $rawValue === '[EMPTY]'
                ];
                if ($category === 'model' && $carValue) {
                    $result['makes'] = $carValue['makes'] ?? '';
                } elseif ($category === 'variant' && $carValue) {
                    $result['makes'] = $carValue['makes'] ?? '';
                    $result['models'] = $carValue['models'] ?? '';
                }
                return $result;
            })->sortBy('raw_value')->values();
            if ($search) {
                $allValues = $allValues->filter(function($value) use ($search) {
                    return stripos($value['raw_value'], $search) !== false ||
                           stripos($value['normalized_value'], $search) !== false;
                })->values();
            }
            $total = $allValues->count();
            $values = $allValues->slice(($page - 1) * $perPage, $perPage)->values();
            return response()->json([
                'data' => $values->all(),
                'pagination' => [
                    'current_page' => (int)$page,
                    'per_page' => (int)$perPage,
                    'total' => $total,
                    'last_page' => (int)ceil($total / $perPage)
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getValues: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function storeOrUpdate(Request $request)
    {
        try {
            $validated = $request->validate([
                'category' => 'required|string',
                'raw_value' => 'required|string',
                'normalized_value' => 'nullable|string',
            ]);
            $category = $validated['category'];
            $rawValue = $validated['raw_value'] === '[EMPTY]' ? '' : $validated['raw_value'];
            $rawValue = trim($rawValue);
            $normalizedValue = $validated['normalized_value'] ?? null;
            $normalizedValue = trim($normalizedValue);
            $existingRule = NormalizationRule::where('category', $category)->where('raw_value', $rawValue)->first();
            $oldNormalizedValue = $existingRule ? $existingRule->normalized_value : null;
            $rule = NormalizationRule::updateOrCreate(
                [
                    'category' => $category,
                    'raw_value' => $rawValue
                ],
                [
                    'normalized_value' => $normalizedValue
                ]
            );
            // echo $category;
            // echo '<br>';
            // echo $rawValue;
            // echo '<br>';
            // echo $normalizedValue;die();
            $affectedRows = $this->applyNormalization($category, $rawValue, $normalizedValue);
            NormalizationHistory::create([
                'category' => $category,
                'raw_value' => $rawValue,
                'old_normalized_value' => $oldNormalizedValue,
                'new_normalized_value' => $normalizedValue,
                'affected_records' => $affectedRows,
                'action' => 'normalize',
                'user_id' => Auth::id()
            ]);
            return response()->json([
                'success' => true,
                'message' => "Rule saved successfully. Updated {$affectedRows} existing records.",
                'rule' => $rule
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function bulkNormalize(Request $request)
    {
        try {
            $validated = $request->validate([
                'category' => 'required|string',
                'raw_values' => 'required|array',
                'raw_values.*' => 'required|string',
                'normalized_value' => 'required|string',
            ]);
            $category = $validated['category'];
            $rawValues = $validated['raw_values'];
            $normalizedValue = $validated['normalized_value'];
            $totalAffected = 0;
            $rulesCreated = 0;
            DB::beginTransaction();
            foreach ($rawValues as $rawValue) {
                $processedRawValue = $rawValue === '[EMPTY]' ? '' : $rawValue;
            
                $existingRule = NormalizationRule::where('category', $category)
                    ->where('raw_value', $processedRawValue)
                    ->first();
                
                $oldNormalizedValue = $existingRule ? $existingRule->normalized_value : null;
                $rule = NormalizationRule::updateOrCreate(
                    [
                        'category' => $category,
                        'raw_value' => $processedRawValue
                    ],
                    [
                        'normalized_value' => $normalizedValue
                    ]
                );
                $rulesCreated++;
                $affected = $this->applyNormalization($category, $processedRawValue, $normalizedValue);
                $totalAffected += $affected;
             
                NormalizationHistory::create([
                    'category' => $category,
                    'raw_value' => $processedRawValue,
                    'old_normalized_value' => $oldNormalizedValue,
                    'new_normalized_value' => $normalizedValue,
                    'affected_records' => $affected,
                    'action' => 'bulk_normalize',
                    'user_id' => Auth::id()
                ]);
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Bulk normalization complete! Created/updated {$rulesCreated} rules and normalized {$totalAffected} records."
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in bulkNormalize: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function bulkHide(Request $request)
    {
        try {
            $validated = $request->validate([
                'category' => 'required|string',
                'raw_values' => 'required|array',
                'raw_values.*' => 'required|string',
            ]);
            $category = $validated['category'];
            $rawValues = $validated['raw_values'];
            $totalAffected = 0;
            $rulesCreated = 0;
            DB::beginTransaction();
            foreach ($rawValues as $rawValue) {
                $processedRawValue = $rawValue === '[EMPTY]' ? '' : $rawValue;
                $existingRule = NormalizationRule::where('category', $category)
                    ->where('raw_value', $processedRawValue)
                    ->first();
                
                $oldNormalizedValue = $existingRule ? $existingRule->normalized_value : null;
                $rule = NormalizationRule::updateOrCreate(
                    [
                        'category' => $category,
                        'raw_value' => $processedRawValue
                    ],
                    [
                        'normalized_value' => null
                    ]
                );
                $rulesCreated++;
                $affected = $this->applyNormalization($category, $processedRawValue, null);
                $totalAffected += $affected;
                NormalizationHistory::create([
                    'category' => $category,
                    'raw_value' => $processedRawValue,
                    'old_normalized_value' => $oldNormalizedValue,
                    'new_normalized_value' => null,
                    'affected_records' => $affected,
                    'action' => 'bulk_hide',
                    'user_id' => Auth::id()
                ]);
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Bulk hide complete! Hidden {$rulesCreated} values affecting {$totalAffected} records."
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in bulkHide: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function hide(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'raw_value' => 'required|string',
        ]);
        $category = $request->input('category');
        $rawValue = $request->input('raw_value') === '[EMPTY]' ? '' : $request->input('raw_value');
        $existingRule = NormalizationRule::where('category', $category)
            ->where('raw_value', $rawValue)
            ->first();
        
        $oldNormalizedValue = $existingRule ? $existingRule->normalized_value : null;
        NormalizationRule::updateOrCreate(
            [
                'category' => $category,
                'raw_value' => $rawValue
            ],
            [
                'normalized_value' => null
            ]
        );
        $affected = $this->applyNormalization($category, $rawValue, null);
        NormalizationHistory::create([
            'category' => $category,
            'raw_value' => $rawValue,
            'old_normalized_value' => $oldNormalizedValue,
            'new_normalized_value' => null,
            'affected_records' => $affected,
            'action' => 'hide',
            'user_id' => Auth::id()
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Value hidden from filters.'
        ]);
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'raw_value' => 'required|string',
        ]);
        $category = $request->input('category');
        $rawValue = $request->input('raw_value') === '[EMPTY]' ? '' : $request->input('raw_value');
        $rule = NormalizationRule::where('category', $category)
            ->where('raw_value', $rawValue)
            ->first();
        if ($rule) {
            $rule->delete();
            $this->restoreOriginalValues($category, $rawValue);
        }
        return response()->json([
            'success' => true,
            'message' => 'Rule deleted and original values restored.'
        ]);
    }
    public function getHistory(Request $request)
    {
        $category = $request->input('category');
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 20);
        $query = NormalizationHistory::where('category', $category)
            ->orderBy('created_at', 'desc');
        $total = $query->count();
        $history = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();
        return response()->json([
            'data' => $history,
            'pagination' => [
                'current_page' => (int)$page,
                'per_page' => (int)$perPage,
                'total' => $total,
                'last_page' => (int)ceil($total / $perPage)
            ]
        ]);
    }
    public function revert(Request $request)
    {
        try {
            $historyId = $request->input('history_id');
            
            $history = NormalizationHistory::findOrFail($historyId);
            DB::beginTransaction();
            $rule = NormalizationRule::where('category', $history->category)
                ->where('raw_value', $history->raw_value)
                ->first();
            if ($rule) {
                if ($history->old_normalized_value === null && $history->action === 'normalize') {
                   
                    $rule->delete();
                    
                    $affectedRows = $this->restoreOriginalValues($history->category, $history->raw_value);
                } else {
                  
                    $rule->update(['normalized_value' => $history->old_normalized_value]);
                   
                    $affectedRows = $this->applyNormalization($history->category, $history->raw_value, $history->old_normalized_value);
                }
            } else {
               
                $affectedRows = $this->restoreOriginalValues($history->category, $history->raw_value);
            }
           
            NormalizationHistory::create([
                'category' => $history->category,
                'raw_value' => $history->raw_value,
                'old_normalized_value' => $history->new_normalized_value,
                'new_normalized_value' => $history->old_normalized_value,
                'affected_records' => $affectedRows,
                'action' => 'revert',
                'user_id' => Auth::id()
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Change reverted successfully. Restored original values.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in revert: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    private function applyNormalization($category, $rawValue, $normalizedValue)
    {
        $columnMap = $this->getColumnMap();
        if (!isset($columnMap[$category])) {
            return 0;
        }
        $column = $columnMap[$category];
        $originalColumn = 'original_'.$column;
        if ($rawValue === '') {
            Car::where(function($q) use ($originalColumn) {
                $q->whereNull($originalColumn)
                  ->orWhere($originalColumn, '')
                  ->orWhere($originalColumn, 'NULL')
                  ->orWhere($originalColumn, 'null');
            })
            ->where(function($q) use ($column) {
                $q->whereNull($column)
                  ->orWhere($column, '')
                  ->orWhere($column, 'NULL')
                  ->orWhere($column, 'null');
            })
            ->update([$originalColumn => DB::raw("COALESCE({$column}, '')")]);
            $affectedRows = Car::where(function($q) use ($originalColumn) {
                $q->whereNull($originalColumn)
                  ->orWhere($originalColumn, '')
                  ->orWhere($originalColumn, 'NULL')
                  ->orWhere($originalColumn, 'null');
            })->update([$column => $normalizedValue]);
        } else {
            Car::whereNull($originalColumn)
                ->where($column, $rawValue)
                ->update([$originalColumn => DB::raw($column)]);
            Car::where($originalColumn, $rawValue)
                ->update([$originalColumn => DB::raw("COALESCE({$originalColumn}, {$column})")]);
            if($column == 'colors')
            {
                Car::whereNull($originalColumn)->where($column, $rawValue)->update([$column => $normalizedValue,$originalColumn => $normalizedValue]);
                $affectedRows = Car::where('advert_colour', $rawValue)->update([$column => $normalizedValue,$originalColumn => $normalizedValue,'advert_colour'=>$normalizedValue]);
            }
            else
            {
                Car::whereNull($originalColumn)->where($column, $rawValue)->update([$column => $normalizedValue,$originalColumn => $normalizedValue]);
                $affectedRows = Car::where($originalColumn, $rawValue)->update([$column => $normalizedValue,$originalColumn => $normalizedValue]);
            }
        }
        return $affectedRows;
    }
    private function restoreOriginalValues($category, $rawValue)
    {
        $columnMap = $this->getColumnMap();
        if (!isset($columnMap[$category])) {
            return 0;
        }
        $column = $columnMap[$category];
        $originalColumn = 'original_' . $column;
        if ($rawValue === '') {
            $affectedRows = Car::where(function($q) use ($originalColumn) {
                $q->whereNull($originalColumn)
                  ->orWhere($originalColumn, '')
                  ->orWhere($originalColumn, 'NULL')
                  ->orWhere($originalColumn, 'null');
            })
            ->update([$column => DB::raw("COALESCE({$originalColumn}, '')")]);
        } else {
          
            $affectedRows = Car::where($originalColumn, $rawValue)
                ->update([$column => DB::raw($originalColumn)]);
        }
        return $affectedRows;
    }
    private function getColumnMap()
    {
        return [
            'colors' => 'colors',
            'make' => 'make',
            'model' => 'model',
            'variant' => 'variant',
            'fuel_type' => 'fuel_type',
            'transmission_type' => 'transmission_type',
            'body_type' => 'body_type',
            'gear_box' => 'gear_box',
            'seats' => 'seats',
            'doors' => 'doors',
            'engine_size' => 'engine_size'
        ];
    }
}