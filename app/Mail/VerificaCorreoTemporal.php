<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class VerificaCorreoTemporal extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $url;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $url)
    {
        $this->user = $user;
        $this->url = $url;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Verifica tu correo electrónico')
                    ->view('emails.verificacion-temporal')
                    ->with([
                        'url' => $this->url,
                        'user' => $this->user
                    ]);
    }
}
