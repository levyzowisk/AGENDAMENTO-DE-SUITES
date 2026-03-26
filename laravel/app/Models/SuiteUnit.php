<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuiteUnit extends Model
{
    use HasFactory;

    protected $fillable = ['suite_id', 'room_number', 'status'];

    public function suite()
    {
        return $this->belongsTo(Suite::class);
    }
}
