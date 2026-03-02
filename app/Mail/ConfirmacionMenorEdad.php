<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmacionMenorEdad extends Mailable
{
    use Queueable, SerializesModels;

            public $curso, $nombreTutor, $nombreParticipante;

        public function __construct($curso, $nombreTutor, $nombreParticipante)
        {
            $this->curso = $curso;
            $this->nombreTutor = $nombreTutor;
            $this->nombreParticipante = $nombreParticipante;
        }

        public function build()
        {
            return $this->subject('Inscripción de su hij@ confirmada')
                ->view('emails.confirmacion_menor');
        }

}
