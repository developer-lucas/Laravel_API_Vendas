<?php
namespace App\ Http\ Controllers;

use App\ Http\ Controllers\ Controller;
use Illuminate\ Http\ JsonResponse;
use Illuminate\ Http\ Request;
use Illuminate\ Routing\ Controller as BaseController;
use Validator;
use App\ Models\ Vendas;

class VendasController extends Controller {

	# Lançar nova Venda
	public function lancar( Request $request ) {	
		
		# Regras a serem validadas
		$rules = array(
			'vendedor_id' => 'required|numeric',
			'valor'       => 'required'
		);

		# Mensagens de erro a serem enviadas
		$messages = array(
			'vendedor_id.required' => 'É necessário informar o ID do vendedor cadastrado.',
			'valor.required'       => 'É necessário informar o valor da venda (apenas números, com 2 casas decimais).',
		);

		# Valida os dados recebidos
		$validator = Validator::make( $request->toArray(), $rules, $messages );

		if ( $validator->fails() ) {
			return response()->json( [
				'object'    => 'erro',
				'http_code' => '401',
				'message'   => $validator->errors()
			], 403 );
		}
		
		# Cadastra uma nova venda
		$data = Vendas::lancar($request);

		# Retorna a resposta
		return $data;

	}
	
	# Remove uma venda lançada anteriormente
	public function remover(Request $request){
		
		# Regras a serem validadas
		$rules = array(
			'id' => 'required|numeric',
		);

		# Mensagens de erro a serem enviadas
		$messages = array(
			'id.required' => 'É necessário informar o ID da venda.'
		);
		
		# Valida os dados recebidos
		$validator = Validator::make( $request->toArray(), $rules, $messages );

		if ( $validator->fails() ) {
			return response()->json( [
				'object'    => 'erro',
				'http_code' => '401',
				'message'   => $validator->errors()
			], 403 );
		}
		
		# Remove uma venda lançada anteriormente
		$data = Vendas::remover($request);

		# Retorna a resposta
		return $data;
		
	}
	
	# Recupera todas as vendas cadastradas
	public function getAll(){
		
		# Recupera as vendas de um vendedor
		$data = Vendas::getAll();
		
		# Retorna a resposta
		return $data;
		
	}
	
	# Listar todas as vendas de um vendedor
	public function vendasPorVendedor($vendedor_id) {

		# Recupera as vendas de um vendedor
		$data = Vendas::vendasPorVendedor($vendedor_id);
		
		# Retorna a resposta
		return $data;

	}
	

}

?>