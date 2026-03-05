<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\SuiteStatusEnum;
class Suite extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_suite',
        'amount_per_hour',
    ];

    protected $casts = [
        'amount_per_hour' => 'decimal:2',
    ];

    // Adiciona a contagem de disponíveis virtualmente quando listar as suítes
    protected $appends = ['available_count'];

    public function units()
    {
        return $this->hasMany(SuiteUnit::class);
    }

    public function getAvailableCountAttribute(): int
    {
        // Ao invés de um número fixo enganoso, ele faz a contagem em tempo real 
        // dos quartos físicos vinculados a esta categoria que estão LIVRES.
        return $this->units()->where('status', SuiteStatusEnum::FREE->value)->count();
    }
}
