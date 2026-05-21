<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Suscripcion extends Model
{
    use HasFactory;

    protected $fillable = [
        'solicitante_id',
        'prestador_id',
    ];

    public function solicitante(): BelongsTo
    {
        return $this->belongsTo(User::class, 'solicitante_id');
    }

    public function prestador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prestador_id');
    }
}