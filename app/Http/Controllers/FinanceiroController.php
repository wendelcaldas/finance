<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinanceiroController extends Controller
{
    //
    public function movimentacaoPorUsuario($userId)
    {
        $user = User::findOrFail($userId);
    
        $movimentacoes = \App\Models\Movimentacao::whereHas('conta', function ($query) use ($user) {
            $query->whereIn('id', $user->contas->pluck('id'));
        })->get();
    
        return response()->json($movimentacoes);
    }

    public function index()
    {
        return 'testado';
    }

    public function fluxoDeCaixa(){
        return 'teste';
    }

    public function testeRole(Request $request){

        // para validar acesso podemos utilizar o user()->role
        var_dump($request->user()->role);exit;

        return 'tela protegida';
    }
}
