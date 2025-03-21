<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ComunicaTotvsService;
use App\Http\Resources\ResponseApi;

class TotvsController extends Controller
{
    protected $totvsService;

    public function __construct(ComunicaTotvsService $totvsService)
    {
        $this->totvsService = $totvsService;
    }

    public function buscarDados(Request $request)
    {
        // var_dump('bateu na rota');exit;
        $dados = $this->totvsService->buscarDados();
        return ResponseApi::success('Dados obtidos com sucesso', $dados);
    }

    public function enviarDados(Request $request)
    {
        $dados = $request->all();
        $resultado = $this->totvsService->enviarDados($dados);

        if ($resultado['sucesso']) {
            return ResponseApi::success('Dados enviados com sucesso', $resultado['content']);
        } else {
            return ResponseApi::error($resultado['mensagem']);
        }
    }
}
