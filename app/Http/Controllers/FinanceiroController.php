<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinanceiroController extends Controller
{
    //
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
