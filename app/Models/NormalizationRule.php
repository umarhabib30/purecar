<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NormalizationRule extends Model {
    use HasFactory;

    protected $fillable = ['category', 'raw_value', 'normalized_value'];

    // Helper to get mapping for a category
    public static function getMappings(string $category): array {
        return self::where('category', $category)
            ->pluck('normalized_value', 'raw_value')
            ->toArray();
    }
}