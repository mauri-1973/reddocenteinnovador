<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailNewActas extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $name;
     public $title;
 
     public function __construct($name, $title)
     {
         $this->name = $name;
         $this->title = $title;
     }
 
     /**
      * Build the message.
      *
      * @return $this
      */
     public function build()
     {
         $user['name'] = $this->name;
         $user['title'] = $this->title;
 
         return $this->from("cco92479@reddocenteinnovador.congresocied.cl", "Red Docente Innovador")
         ->subject('Inicializando Actas')
         ->view('emails.newactas', ['user' => $user]);
     }
}
