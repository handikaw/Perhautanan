<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanFeature extends Model
{
    protected $fillable = [
        'feature_name',
        'value_type',
        'free_text',
        'premium_text',
        'free_bool',
        'premium_bool',
        'sort_order',
    ];

    protected $casts = [
        'free_bool' => 'boolean',
        'premium_bool' => 'boolean',
    ];
}
