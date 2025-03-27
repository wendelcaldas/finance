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

        $entrada = ["futebol"=>500, "alimentacao"=>100, "base"=>1000, "compras"=>1400];
        $saida = ["futebol"=>100, "alimentacao"=>500, "base"=>300];
        $natureza = ["entradas"=>$entrada, "saidas"=>$saida];
        $re = ["natureza"=>$natureza, "fluxo"=>$formatado];

        return response()->json($re);
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
