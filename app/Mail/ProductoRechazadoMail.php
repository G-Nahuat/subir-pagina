<?php

namespace App\Mail;

use App\Models\TempProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductoRechazadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $producto;
    public $nombre;
    public $razon;

    public function __construct(TempProduct $producto, $nombre, $razon)
    {
        $this->producto = $producto;
        $this->nombre = $nombre;
        $this->razon = $razon;
    }

    public function build()
    {
        return $this->subject('Tu producto fue rechazado')
                    ->view('emails.producto_rechazado');
    }
}
