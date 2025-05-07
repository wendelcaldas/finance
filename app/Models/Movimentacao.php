<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movimentacao extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria', 
        'descricao', 
        'data', 
        'tipo', 
        'natureza', 
        'conta_id', 
        'cartao_id'
    ];

    /**
     * Relacionamento com Conta
     * Uma movimentação pode estar vinculada a uma conta.
     */
    public function conta(): BelongsTo
    {
        return $this->belongsTo(Conta::class);
    }

    /**
     * Relacionamento com Cartao
     * Uma movimentação pode estar vinculada a um cartão.
     */
    public function cartao(): BelongsTo
    {
        return $this->belongsTo(Cartao::class);
    }
}
