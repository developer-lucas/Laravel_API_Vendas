<?php

namespace App\ Models;
use Eloquent;
use Illuminate\ Database\ Eloquent\ Model;
use DateTime;
use Carbon\ Carbon;
use Carbon\ CarbonPeriod;
use Illuminate\ Support\ Facades\ Auth;
use Response;

use App\ Models\ Vendedores;

class Vendas extends Eloquent {
	
	protected $hidden = ['vendedor_id'];
	
	# Formata o retorno da comissão em 2 casas decimais
	public function getComissaoAttribute($comissao){
        return number_format($comissao / 100, 2, '.', '');
    }
	
	# Formata o retorno do valor da venda em 2 casas decimais
	public function getValorAttribute($valor){
        return number_format($valor / 100, 2, '.', '');
    }
		
	# Recupera as vendas de um determinado vendedor
	public static function vendasPorVendedor($request){
		
		try {
			
			# Busca os dados do vendedor e as respectivas vendas
			$vendedor = Vendedores::where('id', '=', $request->vendedor_id)
				->with('Vendas')
				->first();
			
			if (!$vendedor){
				return response()->json( [
				    'objeto'   => 'erro',
				    'mensagem' => 'Não encontramos nenhum vendedor com o ID informado.'
			    ], 404 );
			}
			
			# Cria o objeto a ser retornado
			$object           = new \stdClass();
            $object->object   = 'vendas';
			$object->id       = $vendedor->id;
			$object->nome     = $vendedor->nome;
			$object->email    = $vendedor->email;
			$object->vendas   = $vendedor->Vendas;
			
			# Retorna a requisição para a API
			return response()->json($object, 200 );
			
			
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json($e);
        }
		
	}

	# Cadastra uma nova venda
	public static function lancar( $request ) {

		try {
			
			# Verifica se existe o vendedor com o ID informado
			$vendedor = Vendedores::find($request->vendedor_id);
			if (!$vendedor){
				return response()->json( [
				    'objeto'   => 'erro',
				    'mensagem' => 'Não encontramos nenhum vendedor com o ID informado.'
			    ], 404 );
			}

			# Inicializa o objeto a ser retornado
			$object         = new\ stdClass();
			$object->object = 'venda';

			# Cadastra uma nova venda no banco de dados
			$venda              = new Vendas();
			$venda->vendedor_id = $request->vendedor_id;
			$venda->valor       = ($request->valor);
			$venda->comissao    = $venda->valor * $vendedor->comissao;
			$venda->save();


			if ( $venda ) {

				return response()->json( [
					'id'       => $venda->id,
					'nome'     => $vendedor->nome,
					'email'    => $vendedor->email,
					'comissao' => $venda->comissao,
					'valor'    => $venda->valor,
					'data'     => $venda->created_at->format('Y-m-d H:i:s')
				], 200 );
			}

		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json($e);
        }

	}

}