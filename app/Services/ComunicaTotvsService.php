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
    public function buscarDados()
    {
        var_dump("{$this->baseUrl}/DEV.001/0/f");

        $response = Http::withBasicAuth($this->username, $this->password)
            ->get("{$this->baseUrl}/DEV.001/0/f"); // encapsular a logica do endpoint - TO DO
        var_dump($response);exit; // dbg
        if ($response->successful()) {
            return $response->json();
        }

        return [
            'erro' => 'Erro ao buscar dados da TOTVS',
            'status' => $response->status(),
            'detalhes' => $response->body()
        ];
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
