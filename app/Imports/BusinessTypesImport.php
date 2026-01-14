<?php

namespace App\Imports;

use App\Models\BusinessType;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithValidation;

class BusinessTypesImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new BusinessType([
            'name' => $row['name'],
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('business_types', 'name')],
        ];
    }
}