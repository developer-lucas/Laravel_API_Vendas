<?php
namespace App\ Http\ Controllers;

use App\ Http\ Controllers\ Controller;
use Illuminate\ Http\ JsonResponse;
use Illuminate\ Http\ Request;
use Illuminate\ Routing\ Controller as BaseController;
use Validator;
use App\ Models\ Vendedores;

class VendedoresController extends Controller {

	# Lista todos os vendedores cadastrados
	public function get() {	
		
		# Retorna todos os vendedores
		$data = Vendedores::get();

		# Retorna a resposta
		return $data;

	}
	
	# Cadastra um novo vendedor
	public function cadastrar( Request $request ) {
		
		# Regras a serem validadas
		$rules = array(
			'nome'  => 'required',
			'email' => 'required'
		);

		# Mensagens de erro a serem enviadas
		$messages = array(
			'nome.required'  => 'É necessário informar o nome do vendedor.',
			'email.required' => 'É necessário informar o email do vendedor.',
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

		# Recupera as vendas de um vendedor
		$data = Vendedores::cadastrar($request);
		
		# Retorna a resposta
		return $data;

	}
	
	# Excluí um vendedor cadastrado
	public function remover(Request $request){
		
		# Regras a serem validadas
		$rules = array(
			'id'  => 'required'
		);

		# Mensagens de erro a serem enviadas
		$messages = array(
			'id.required'  => 'É necessário informar o ID do vendedor.'
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

		# Recupera as vendas de um vendedor
		$data = Vendedores::remover($request);
		
		# Retorna a resposta
		return $data;
		
	}
	

}

?>