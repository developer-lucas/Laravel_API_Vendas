<?php

namespace App\ Console\ Commands;

use Illuminate\ Console\ Command;
use Carbon\ Carbon;
use Mail;

use App\ Mail\ RelatorioDiario as Relatorio;
use App\ Models\ Vendedores;

class RelatorioDiario extends Command {

	protected $signature   = 'relatorioDiario:cron';
	protected $description = 'Relatório diário';

	public function __construct() {
		parent::__construct();
	}

	public function handle() {
		
		try {
			
			  # Seleciona os vendedores
			  $vendedores = Vendedores::with('vendas')
				  ->get();
			
			  # Verifica se existe vendedores cadastrados
			  if (!$vendedores){
				  return;
			  }
			
			  # Envia o relatório diário para cada vendedor
			  foreach ($vendedores as $vendedor){
				  
				 Mail::to($vendedor->email)->send(new Relatorio($vendedor));
				  
			  }			  
		      
		
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
             return response()->json($e);
        }
	
	}
}