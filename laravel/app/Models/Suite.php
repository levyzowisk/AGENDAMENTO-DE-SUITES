<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suite extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_suite',
        'amount_per_hour',
        'available_count',
    ];

    protected $casts = [
        'amount_per_hour' => 'decimal:2',
        'available_count' => 'integer',
    ];
}
