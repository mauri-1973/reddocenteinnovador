<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class EmailNotifications extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $nameus;
     public $asunto;
     public $mensaje;
     public $nameaudit;
     public $emailadit;
     public $telaudit;
     public $fechaini;
     public $fechafin;
 
     public function __construct($nameus, $asunto, $mensaje, $nameaudit, $emailadit, $telaudit, $fechaini, $fechafin)
     {
         $this->nameus = $nameus;
         $this->asunto = $asunto;
         $this->mensaje = $mensaje;
         $this->nameaudit = $nameaudit;
         $this->emailadit = $emailadit;
         $this->telaudit = $telaudit;
         $this->fechaini = $fechaini;
         $this->fechafin = $fechafin;
     }
 
     /**
      * Build the message.
      *
      * @return $this
      */
     public function build()
     {
         $user['name'] = $this->nameus;
         $user['mensaje'] = $this->mensaje;
         $user['academico'] = $this->nameaudit;
         $user['emailacad'] = $this->emailadit;
         $user['telacad'] = $this->telaudit;
         $user['fechaini'] = $this->fechaini;
         $user['fechafin'] = $this->fechafin;
 
         return $this->from("cco92479@reddocenteinnovador.congresocied.cl", "Red Docente Innovador")
         ->subject($this->asunto)
         ->view('emails.newnotificationsauditor', ['user' => $user]);
     }
}
