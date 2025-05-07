<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conta extends Model
{
    use HasFactory;

    protected $fillable = ['banco_id', 'tipo', 'pessoa', 'saldo'];

    /**
     * Relacionamento com Banco
     * Uma conta pertence a um banco.
     */
    public function banco(): BelongsTo
    {
        return $this->belongsTo(Banco::class);
    }

    /**
     * Relacionamento com Movimentacao
     * Uma conta pode ter várias movimentações.
     */
    public function movimentacoes(): HasMany
    {
        return $this->hasMany(Movimentacao::class);
    }
}
