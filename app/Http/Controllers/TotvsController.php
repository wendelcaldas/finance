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

        $dados = $this->totvsService->buscarDados();
        // var_dump($dados);exit;
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
        // return $dados;
        // return ResponseApi::success('Dados obtidos com sucesso', $dados);

        // $sandboxData = '[{"IDLAN":236666,"DATAVENCIMENTO":"2029-11-05T00:00:00-03:00","NUMERODOCUMENTO":"9801","NOMEFANTASIA":"PARCELAMENTO RECEITA FEDERAL","HISTORICO":"PARCELAMENTO IMPOSTOS REF. 02110001201353884312473 - PARC. 1/60","VALOR":-129066.82,"PAGREC":2},{"IDLAN":236665,"DATAVENCIMENTO":"2029-10-06T00:00:00-03:00","NUMERODOCUMENTO":"9800","NOMEFANTASIA":"PARCELAMENTO RECEITA FEDERAL","HISTORICO":"PARCELAMENTO IMPOSTOS REF. 02110001201353884312473 - PARC. 1/60","VALOR":-129066.82,"PAGREC":2},{"IDLAN":226084,"DATAVENCIMENTO":"2029-10-02T00:00:00-03:00","NUMERODOCUMENTO":"9563","NOMEFANTASIA":"PARCELAMENTO RECEITA FEDERAL","HISTORICO":"PARCELAMENTO IMPOSTOS REF. 02110001200864546602401 -  PARCELA 01 / 60","VALOR":-25846.51,"PAGREC":2},{"IDLAN":236664,"DATAVENCIMENTO":"2029-09-06T00:00:00-03:00","NUMERODOCUMENTO":"9799","NOMEFANTASIA":"PARCELAMENTO RECEITA FEDERAL","HISTORICO":"PARCELAMENTO IMPOSTOS REF. 02110001201353884312473 - PARC. 1/60","VALOR":-129066.82,"PAGREC":2},{"IDLAN":226083,"DATAVENCIMENTO":"2029-08-31T00:00:00-03:00","NUMERODOCUMENTO":"9562","NOMEFANTASIA":"PARCELAMENTO RECEITA FEDERAL","HISTORICO":"PARCELAMENTO IMPOSTOS REF. 02110001200864546602401 -  PARCELA 01 / 60","VALOR":-25846.51,"PAGREC":2},{"IDLAN":236663,"DATAVENCIMENTO":"2029-08-07T00:00:00-03:00","NUMERODOCUMENTO":"9798","NOMEFANTASIA":"PARCELAMENTO RECEITA FEDERAL","HISTORICO":"PARCELAMENTO IMPOSTOS REF. 02110001201353884312473 - PARC. 1/60","VALOR":-129066.82,"PAGREC":2},{"IDLAN":226082,"DATAVENCIMENTO":"2029-07-30T00:00:00-03:00","NUMERODOCUMENTO":"9561","NOMEFANTASIA":"PARCELAMENTO RECEITA FEDERAL","HISTORICO":"PARCELAMENTO IMPOSTOS REF. 02110001200864546602401 -  PARCELA 01 / 60","VALOR":-25846.51,"PAGREC":2},{"IDLAN":236662,"DATAVENCIMENTO":"2029-07-08T00:00:00-03:00","NUMERODOCUMENTO":"9797","NOMEFANTASIA":"PARCELAMENTO RECEITA FEDERAL","HISTORICO":"PARCELAMENTO IMPOSTOS REF. 02110001201353884312473 - PARC. 1/60","VALOR":-129066.82,"PAGREC":2},{"IDLAN":226081,"DATAVENCIMENTO":"2029-06-28T00:00:00-03:00","NUMERODOCUMENTO":"9560","NOMEFANTASIA":"PARCELAMENTO RECEITA FEDERAL","HISTORICO":"PARCELAMENTO IMPOSTOS REF. 02110001200864546602401 -  PARCELA 01 / 60","VALOR":-25846.51,"PAGREC":2},{"IDLAN":188908,"DATAVENCIMENTO":"2029-06-10T00:00:00-03:00","NUMERODOCUMENTO":"3973","NOMEFANTASIA":"BANCO BRADESCO S.A.","HISTORICO":"ACORDO REFERENTE AO PROCESSO 8086206-91.2022.8.05.0001 - PARCELA 73/73","VALOR":-2957.18,"PAGREC":1},{"IDLAN":236661,"DATAVENCIMENTO":"2029-06-08T00:00:00-03:00","NUMERODOCUMENTO":"9796","NOMEFANTASIA":"PARCELAMENTO RECEITA FEDERAL","HISTORICO":"PARCELAMENTO IMPOSTOS REF. 02110001201353884312473 - PARC. 1/60","VALOR":-129066.82,"PAGREC":1},{"IDLAN":226080,"DATAVENCIMENTO":"2029-05-27T00:00:00-03:00","NUMERODOCUMENTO":"9559","NOMEFANTASIA":"PARCELAMENTO RECEITA FEDERAL","HISTORICO":"PARCELAMENTO IMPOSTOS REF. 02110001200864546602401 -  PARCELA 01 / 60","VALOR":-25846.51,"PAGREC":1},{"IDLAN":188907,"DATAVENCIMENTO":"2029-05-10T00:00:00-03:00","NUMERODOCUMENTO":"3972","NOMEFANTASIA":"BANCO BRADESCO S.A.","HISTORICO":"ACORDO REFERENTE AO PROCESSO 8086206-91.2022.8.05.0001 - PARCELA 72/73","VALOR":-2956.84,"PAGREC":1}]';

        // $dados = json_decode($sandboxData, true);

        // $entradas = array_filter($dados, fn($mov) => $mov['PAGREC'] == 1);
        // $saidas = array_filter($dados, fn($mov) => $mov['PAGREC'] == 2);
    
        // return response()->json([
        //     'entradas' => array_values($entradas),
        //     'saidas' => array_values($saidas)
        // ]);

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
