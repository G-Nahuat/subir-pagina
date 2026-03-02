<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductoAceptadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $producto;
    public $nombre_completo;

    public function __construct($producto, $nombre_completo)
    {
        $this->producto = $producto;
        $this->nombre_completo = $nombre_completo;
    }

    public function build()
    {
        return $this->from('emprender.semujeres@qroo.gob.mx', 'Mujer Es Emprender')
            ->subject('✅ Tu producto ha sido aceptado')
            ->view('emails.producto_aceptado')
            ->with([
                'producto' => $this->producto,
                'nombre_completo' => $this->nombre_completo
            ]);
    }
}
