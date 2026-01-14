<?php

namespace App\Imports;

use App\Models\BusinessLocation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithValidation;

class BusinessLocationsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new BusinessLocation([
            'name' => $row['name'],
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('business_locations', 'name')],
        ];
    }
}