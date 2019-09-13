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
	
	/* Listar todos os Vendedores */
	Route::get( '/', 'VendedoresController@get' );
	
	/* Criar Vendedor */
	Route::post( '/cadastrar', 'VendedoresController@cadastrar' ); 
	
	/* Exclui um vendedor */
	Route::post( '/remover', 'VendedoresController@remover' ); 	
	
	
} );

# Rota de vendas
Route::group( [ 'prefix' => 'vendas' ], function () {
	
	# Listar todas as vendas de um vendedor
	Route::get( '/', 'VendasController@getAll' );
	
	# Listar todas as vendas de um vendedor
	Route::get( '/{vendedor_id}', 'VendasController@vendasPorVendedor' ); 
	
	# Lançar nova Venda
	Route::post( '/remover', 'VendasController@remover' );
	
	# Lançar nova Venda
	Route::post( '/lancar', 'VendasController@lancar' ); 	
	
	
} );

# Caso seja informado uma rota que não exista
Route::fallback(function(){
    return response()->json([
        'message' => 'Recurso não encontrado ou indisponível. Se o erro persistir, entre em contato com o suporte.'], 404);
});
