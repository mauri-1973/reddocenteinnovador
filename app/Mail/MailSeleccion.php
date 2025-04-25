<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailSeleccion extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $name;
     public $status;
     public $id;
     public $title;
 
     public function __construct($name, $status, $id, $title)
     {
         $this->name = $name;
         $this->status = $status;
         $this->id = $id;
         $this->title = $title;
     }
 
     /**
      * Build the message.
      *
      * @return $this
      */
     public function build()
     {
        $mensaje = "";
        $obs = storage_path('app/public/pdftemp/') . $this->id .'_Formulario.pdf';
        $obs1 = storage_path('app/public/pdftemp/') . $this->id .'_Observaciones.pdf';
        switch (true) 
        {
            case ($this->status == "conobservaciones" || $this->status == "enrevision" || $this->status == "rechazado" ):
                $mensaje = "Estimado Docente, Le informamos que el proceso se selección de proyectos correspondientes a ". $this->title . " ha fimalizado. Tu postulación al proyecto no fue aceptada, te invitamos a revisar los comentarios asociados a la propuesta, para que puedas revisarlos, no te desanimes te invitamos a poder postular nuevamente en una próxima oportunidad.";
            break;
            case ($this->status == "seleccionado" ):
                $mensaje = "Estimado Docente, Le informamos que el proceso se selección de proyectos correspondientes a ". $this->title . " ha finalizado. Tu postulación al proyecto fue aceptada y adjudicada, te invitamos a revisar los comentarios asociados a la propuesta, para que puedas revisarlos e incorporar las mejoras respectivas.";
            break;
        }
         $user['name'] = $this->name;
         $user['mensaje'] = $mensaje;

         return $this->from("cco92479@reddocenteinnovador.congresocied.cl", "Red Docente Innovador")
         ->view('emails.seleccion')
         ->subject($this->title)
         ->attach($obs) 
         ->attach($obs1) 
         ->with('user', $user);
     }
}
