<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ComunicaTotvsService;
use App\Services\TotvsService;
use App\Http\Resources\ResponseApi;
use Carbon\Carbon;

class TotvsController extends Controller
{
    protected $totvsService;

    public function __construct(ComunicaTotvsService $totvsService)
    {
        $this->totvsService = $totvsService;
    }

    public function buscarDados(Request $request)
    {
        // Pegando os parâmetros da requisição - Caso não receba parametros usará o primeiro e ultimo dia do mês corrente
        $dataIni = $request->query('data_inicio', Carbon::now()->startOfMonth()->toDateString());
        $dataFin = $request->query('data_fim', Carbon::now()->endOfMonth()->toDateString());

        // Chama o service que comunica com a totvs
        $dados = $this->totvsService->buscarDados($dataIni, $dataFin); // chamada do service passando os param de data

        // Trata os dados para formato esperado no frontend
        $formatado = [
            "entradas" => [],
            "saidas" => []
        ];

        foreach ($dados as $item) {
            $dataFormatada = Carbon::parse($item["DATA"])->toDateString(); // Converte a data para 'YYYY-MM-DD'

            $formatado["entradas"][$dataFormatada] = $item["TOTAL_RECEBIDO"];
            $formatado["saidas"][$dataFormatada] = $item["TOTAL_PAGO"];
        }

        return response()->json($formatado);
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
