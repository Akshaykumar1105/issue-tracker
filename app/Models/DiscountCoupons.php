<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiscountCoupons extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'discount',
        'discount_type',
        'is_active',
        'active_at',
        'expire_at'
    ];
}
