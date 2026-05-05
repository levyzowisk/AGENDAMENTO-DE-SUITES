<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /** @use HasFactory<\Database\Factories\ScheduleFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'suite_id',
        'suite_unit_id',
        'check_in',
        'check_out',
        'status',
        'total_price',
        'notes',
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'status' => \App\Enums\ScheduleStatusEnum::class,
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function suite()
    {
        return $this->belongsTo(Suite::class);
    }

    public function suiteUnit()
    {
        return $this->belongsTo(SuiteUnit::class);
    }
}
