<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount',
        'type',
        'usage_limit',
        'used_count',
        'expiry_date',
    ];

    public function isValid()
    {
        return (!$this->isExpired() && !$this->isUsedUp());
    }

    public function isExpired()
    {
        return $this->expiry_date && now()->greaterThan($this->expiry_date);
    }

    public function isUsedUp()
    {
        return $this->usage_limit && $this->used_count >= $this->usage_limit;
    }

    public function apply()
    {
        if ($this->isValid()) {
            $this->increment('used_count');
            return true;
        }
        return false;
    }
}
