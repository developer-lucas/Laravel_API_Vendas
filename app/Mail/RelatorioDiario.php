<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use Carbon\Carbon;

class RelatorioDiario extends Mailable
{
    use Queueable, SerializesModels;
	
	private $vendedor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($vendedor)
    {
        $this->vendedor = $vendedor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->vendedor->email)
                ->view('emails.relatorioDiario')
			    ->with('vendedor', $this->vendedor)
			    ->with('referencia', Carbon::now()->format('d/m/y'));
    }
}
