<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Banco extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];

    /**
     * Relacionamento com Conta
     * Um banco pode ter várias contas.
     */
    public function contas(): HasMany
    {
        return $this->hasMany(Conta::class);
    }

    /**
     * Relacionamento com Cartao
     * Um banco pode ter vários cartões.
     */
    public function cartoes(): HasMany
    {
        return $this->hasMany(Cartao::class);
    }
}
