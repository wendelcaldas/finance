<?php

namespace App\Http\Controllers;

use App\Models\Movimentacao;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MovimentacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a new movimentacao.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Validação dos dados recebidos
        $validator = Validator::make($request->all(), [
            'categoria' => 'required|string|max:255',
            'descricao' => 'required|string|max:255',
            'data' => 'required|date',
            'tipo' => 'required|in:entrada,saida',
            'natureza' => 'required|in:produto,servico',
            'conta_id' => 'nullable|exists:contas,id',
            'cartao_id' => 'nullable|exists:cartoes,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erro na validação dos dados.',
                'errors' => $validator->errors()
            ], 400);
        }

        // Montar os dados dinamicamente
        $data = [
            'categoria' => $request->categoria,
            'descricao' => $request->descricao,
            'data' => $request->data,
            'tipo' => $request->tipo,
            'natureza' => $request->natureza,
            'conta_id' => $request->conta_id,
            'cartao_id' => $request->cartao_id,
        ];
        // var_dump('machump');exit;
        // Criar a movimentação
        $movimentacao = Movimentacao::create($data);
        var_dump($movimentacao);exit;
        return response()->json([
            'success' => true,
            'message' => 'Movimentação cadastrada com sucesso.',
            'content' => $movimentacao
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movimentacao $movimentacao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movimentacao $movimentacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movimentacao $movimentacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movimentacao $movimentacao)
    {
        //
    }
}
