<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecuperarSenha extends Mailable
{
    use Queueable, SerializesModels;

    public $url_recuperar_senha;

    public $url_cancelar_recuperacao;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url_recuperar, $url_cancelar)
    {
        $this->url_recuperar_senha = $url_recuperar;
        $this->url_cancelar_recuperacao = $url_cancelar;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('luccalafonte97@gmail.com')
                    ->markdown('emails.recuperar_senha');
    }
}
