<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CuentaAprobada extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;

    public function __construct($nombre)
    {
        $this->nombre = $nombre;
    }

    public function build()
    {
        return $this->subject('¡Tu cuenta ha sido aprobada!')
                    ->view('emails.cuenta_aprobada');
    }
}
