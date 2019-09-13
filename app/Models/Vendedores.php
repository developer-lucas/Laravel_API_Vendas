<?php

namespace App\ Models;
use Eloquent;
use Illuminate\ Database\ Eloquent\ Model;
use DateTime;
use Carbon\ Carbon;
use Carbon\ CarbonPeriod;
use Illuminate\ Support\ Facades\ Auth;
use Response;

use App\ Models\ Vendas;

class Vendedores extends Eloquent {

	# Relacionamento com a tabela vendas
	public function vendas() {
		return $this->hasMany( Vendas::class, 'vendedor_id' );
	}

	# Lista todos os vendedores cadastrados
	public static function get() {

		try {	
			
			# Cria o objeto a ser retornado
			$object         = new \stdClass();
            $object->object = 'vendedores';
			
			# Recupera os vendedores cadastrados
			$vendedores = Vendedores::orderBy('id', 'DESC')->get();
			
			# Adiciona os vendedores no objeto a ser retornado
			$object->items = $vendedores;
			
			# Retorna a requisição para a API
			return response()->json($object, 200 );
			

		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json($e);
        }
		
	}


	# Cadastra um novo vendedor
	public static function cadastrar( $request ) {

		try {	
			
			# Verifica se já existe um vendedor com o mesmo endereço de e-mail
			$busca = Vendedores::where('email', '=', $request->email)->count();
			if ($busca > 0){
				return response()->json( [
				   'objeto'   => 'erro',
				   'mensagem' => 'Já existe um vendedor com o mesmo endereço de e-mail.'
			    ], 401 );
			}
			
			# Cadastra o vendedor no banco de dados
			$vendedor           = new Vendedores();
			$vendedor->nome     = $request->nome;
			$vendedor->email    = $request->email;
			$vendedor->comissao = isset($request->comissao) ? $request->comissao : 8.5;
			$vendedor->save();
			
			# Retorna a requisição para a API
			return response()->json( [
				'id'       => $vendedor->id,
				'nome'     => $vendedor->nome,
				'email'    => $vendedor->email,
				'comissao' => $vendedor->comissao
			], 200 );
			

		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json($e);
        }

	}
	
	# Remove um vendedor cadastrado anteriormente
	public static function remover($request){
		
		$vendedor = Vendedores::find($request->id);
		if (!$vendedor){
			return response()->json( [
				'objeto'   => 'erro',
				'mensagem' => 'Não encontramos nenhum vendedor com o ID informado.'
			], 401 );
		}
		
		# Remove o vendedor
		$vendedor->delete();
		
		# Retorna a requisição para a API
		return response()->json( [
			'id'       => $request->id,
			'mensagem' => 'Vendedor excluído com sucesso. Todas as vendas foram excluídas.'
		], 200 );
	}

}