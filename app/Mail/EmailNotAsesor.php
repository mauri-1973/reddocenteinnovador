<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailNotAsesor extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $nameadm;
     public $subject;
     public $message;
     public $namedoc;
     public $emaildoc;
     public $teldoc;
 
     public function __construct($nameadm, $subject, $message, $namedoc, $emaildoc, $teldoc )
     {
         $this->nameadm = $nameadm;
         $this->subject = $subject;
         $this->message = $message;
         $this->namedoc = $namedoc;
         $this->emaildoc = $emaildoc;
         $this->teldoc = $teldoc;
     }
 
     /**
      * Build the message.
      *
      * @return $this
      */
     public function build()
     {
         $user['nameadm'] = $this->nameadm;
         $user['message'] = $this->message;
         $user['namedoc'] = $this->namedoc;
         $user['emaildoc'] = $this->emaildoc;
         $user['teldoc'] = $this->teldoc;
 
         return $this->from("cco92479@reddocenteinnovador.congresocied.cl", "Red Docente Innovador")
         ->subject($this->subject)
         ->view('emails.newasesoradm', ['user' => $user]);
     }
}
