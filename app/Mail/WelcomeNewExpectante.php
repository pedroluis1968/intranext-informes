<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeNewExpectante extends Mailable
{
    use Queueable, SerializesModels;

    public $nombreCompleto;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombreCompleto)
    {
        $this->nombreCompleto = $nombreCompleto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('¡Bienvenido a Axis Gestora!')
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('emails.welcome-expectante');
    }
}
