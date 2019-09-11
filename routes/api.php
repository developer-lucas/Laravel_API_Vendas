<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

# Rota de vendedores
Route::group( [ 'prefix' => 'vendedores' ], function () {
	
	/* Criar Vendedor */
	Route::post( '/cadastrar', 'VendedoresController@cadastrar' ); /* Entrada: [nome, email] | Saida:   [id, nome, email] */
	
	/* Listar todos os Vendedores */
	Route::get( '/', 'VendedoresController@get' ); /* Saida: [id, nome, email] */
	
} );

# Rota de vendas
Route::group( [ 'prefix' => 'vendas' ], function () {
	
	# Listar todas as vendas de um vendedor
	Route::get( '/', 'VendasController@getAll' );
	
	# Lançar nova Venda
	Route::post( '/lancar', 'VendasController@lancar' ); /* Entrada: [id_vendedor, valor] | Saida:   [id, nome, email, comissao, valor, data] */
	
	# Listar todas as vendas de um vendedor
	Route::get( '/{vendedor_id}', 'VendasController@vendasPorVendedor' ); /* Entrada: [id_vendedor] | Saida:   [id, nome, email, comissao, valor, data] */
	
} );

# Caso seja informado uma rota que não exista
Route::fallback(function(){
    return response()->json([
        'message' => 'Recurso não encontrado ou indisponível. Se o erro persistir, entre em contato com o suporte.'], 404);
});
