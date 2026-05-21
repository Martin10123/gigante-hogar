<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'prestador_id',
        'descripcion',
        'fecha',
        'cupos_totales',
        'cupos_disponibles',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'cupos_totales' => 'integer',
            'cupos_disponibles' => 'integer',
        ];
    }

    public function prestador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prestador_id');
    }

    public function cupos(): HasMany
    {
        return $this->hasMany(Cupo::class);
    }
}