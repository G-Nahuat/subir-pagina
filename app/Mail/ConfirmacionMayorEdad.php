<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmacionMayorEdad extends Mailable
{
    use Queueable, SerializesModels;
        public $curso, $nombre;

        public function __construct($curso, $nombre)
        {
            $this->curso = $curso;
            $this->nombre = $nombre;
        }

        public function build()
        {
            return $this->subject('Inscripción confirmada')
                ->view('emails.confirmacion_mayor');
        }

}
