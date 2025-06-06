<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ComunicaTotvsService
{
    protected $baseUrl; // url api totvs
    protected $username; // usuario liberado pra consulta
    protected $pass; // senha protegida

    public function __construct()
    {
        $this->baseUrl = env('TOTVS_API_URL');
        $this->username = env('TOTVS_USERNAME');
        $this->pass = env('TOTVS_PASSWORD');
    }

    /**
     * Faz uma requisição GET para a API TOTVS
     */
    public function buscarDados($dataIni, $dataFin)
    {
        try {
            $url = "{$this->baseUrl}/DEV.001/0/f";
            $params = [
                'parameters' => "DATAINI={$dataIni}T00:00:00;DATAFIN={$dataFin}T23:59:59"
            ];
    
            $response = Http::withBasicAuth($this->username, $this->pass)
                ->get($url, $params);
    
            if ($response->successful()) {
                return $response->json();
            }
    
            return [
                'erro' => 'Erro ao buscar dados da TOTVS',
                'status' => $response->status(),
                'detalhes' => $response->body()
            ];
        } catch (\Exception $e) {
            return [
                'erro' => 'Falha na requisição',
                'mensagem' => $e->getMessage(),
                'linha' => $e->getLine(),
                'arquivo' => $e->getFile()
            ];
        }
    }

    /**
     * Base para requisição POST para enviar dados à API TOTVS
     */
    public function enviarDados(array $dados)
    {
        $response = Http::withBasicAuth($this->username, $this->password)
            ->post("{$this->baseUrl}/endpoint_envio", $dados);

        if ($response->successful()) {
            return [
                'sucesso' => true,
                'content' => $response->json()
            ];
        }

        return [
            'sucesso' => false,
            'mensagem' => 'Erro ao enviar dados para TOTVS',
            'status' => $response->status(),
            'detalhes' => $response->body()
        ];
    }
}
