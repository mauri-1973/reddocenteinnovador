<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Mail\EmailNotifications;

use App\Mail\EmailNotAsesor;

use App\Mail\EmailNotAsesorDoc;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use App\Answers;

use Illuminate\Support\Facades\Log;

class NotifAdminActas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificaradmin:actas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando que permite notificar la creación de actas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Log::info('Esta tarea programada se inicio correctamente.');

        $this->info('iniciando');

        $emailspen = DB::table('emailjobs')->where('status', 0)->get();
            
        foreach($emailspen as $row)
        {
            $arrayData = json_decode($row->contenido, true);
            $tipo = $row->template;
            
            switch (true) 
            {
                case ($tipo == 'newnotificationsauditor'):
                    switch (true) 
                    {
                        case ($arrayData['tipo'] == "asesor"):
                            
                            $users = DB::table('users')->where('id', $arrayData['id_us'])->first();
                            $actas = DB::table('actas')->where('id', $arrayData['id_act'])->first();
                            $fechaini = trans('multi-new.0109');
                            $fechafin = trans('multi-new.0109');
                            if($actas->fecha_ini != "" || $actas->fecha_ini != null)
                            {
                                $fechaini = Carbon::parse($actas->fecha_ini)->format('d-m-Y');
                            }
                            if($actas->fecha_ter != "" || $actas->fecha_ter != null)
                            {
                                $fechafin = Carbon::parse($actas->fecha_ter)->format('d-m-Y');
                            }
                            if(isset($arrayData['nombreauditor']))
                            {
                                $nombre = $arrayData['nombreauditor'];
                            }
                            else
                            {
                                $nombre = $arrayData['nombredocente'];
                            }
                            

                            Mail::to('mauri-1973@outlook.cl')->send(new EmailNotifications($users->name.' '.$users->surname, $arrayData['asunto'], $arrayData['mensaje'], $nombre, $arrayData['emailaudit'], $arrayData['telaudit'], $fechaini,  $fechafin ) );
                            if(Mail::failures() != 0) 
                            {
                                DB::table('emailjobs')->where('id', $row->id)->update(['status' => 1]);
                                
                            } 
                            
                        break;
                        case ($arrayData['tipo'] == "docente"):
                            # code...
                        break;
                        
                    }
                    
                    
                break;
                case ($tipo == 'newnotificationdocact'):

                    $actas = DB::table('actas')->where('id', $arrayData['id_act'])->count();
                    $emailspenus = DB::table('users')->where('id', $arrayData['id_us'])->count(); 
                    
                    switch (true) 
                    {
                        case ($actas > 0 && $emailspenus > 0):

                            $actas = DB::table('actas')->where('id', $arrayData['id_act'])->first();
                            $emailspenus = DB::table('users')->where('id', $arrayData['id_us'])->first(); 
                            Mail::to('mauri-1973@outlook.cl')->send(new EmailNotAsesor($emailspenus->name.' '.$emailspenus->surname, $arrayData['asunto'], $arrayData['mensaje'], $arrayData['nombredocente'], $arrayData['emaildocente'], $arrayData['telaudit'] ) );
                            if(Mail::failures() != 0) 
                            {
                                DB::table('emailjobs')->where('id', $row->id)->update(['status' => 1]);
                                DB::table('notifications')->insert([
                                    'id_us' => $arrayData['tipo'], 'id_answ' => $arrayData['id_act'], 'asunto' => $arrayData['asunto'], 'mensaje' => $arrayData['mensaje'], 'tipo' => 'asesor',
                                    'fechanot' => date('Y-m-d H:i:s'), 'fechares' => date('Y-m-d H:i:s')
                                ]);
                                
                            }
                            
                        break;
                    }
                break;
                case ($tipo == 'newnotificationdocactcreada'):

                    $actas = DB::table('actas')->where('id', $arrayData['id_act'])->count();
                    $emailspenus = DB::table('users')->where('id', $arrayData['id_us'])->count(); 
                    
                    switch (true) 
                    {
                        case ($actas > 0 && $emailspenus > 0):

                            $actas = DB::table('actas')->where('id', $arrayData['id_act'])->first();
                            $emailspenus = DB::table('users')->where('id', $arrayData['id_us'])->first(); 
                            Mail::to('mauri-1973@outlook.cl')->send(new EmailNotAsesor($emailspenus->name.' '.$emailspenus->surname, $arrayData['asunto'], $arrayData['mensaje'], $arrayData['nombredocente'], $arrayData['emaildocente'], $arrayData['telaudit'] ) );
                            if(Mail::failures() != 0) 
                            {
                                DB::table('emailjobs')->where('id', $row->id)->update(['status' => 1]);
                                DB::table('notifications')->insert([
                                    'id_us' => $arrayData['tipo'], 'id_answ' => $arrayData['id_act'], 'asunto' => $arrayData['asunto'], 'mensaje' => $arrayData['mensaje'], 'tipo' => 'asesor',
                                    'fechanot' => date('Y-m-d H:i:s'), 'fechares' => date('Y-m-d H:i:s')
                                ]);
                                
                            }
                            
                        break;
                    }
                break;
                
                case ($tipo == 'newnotificationasesor'):

                    $emailspenus = DB::table('users')->where('cargo_us', 'Administrador')->get();

                    $answers = DB::table('answers')->where('idansw', $arrayData['id_act'])->first();

                    if($arrayData['mensaje'] == 'solicitar')
                    {
                        $mensaje = 'Se ha solicitado la asignación de asesor(es), al proyecto : '.$answers->preg1et1.', presentado por el(la) docente: '.$arrayData['nombredocente'].'. Ingrese a su panel de administración de la plataforma, para realizar esta solicitud';
                    }
                    else
                    {
                        $mensaje = 'Se ha solicitado la asignación de asesor(es), al proyecto : '.$answers->preg1et1.', presentado por el(la) docente: '.$arrayData['nombredocente'].'. Ingrese a su panel de administración de la plataforma, para realizar esta solicitud. Pues este proyecto no tiene asesores activos, que realicen esta tarea.';
                    }                    

                    foreach($emailspenus as $rows)
                    {
                        
                        Mail::to('mauri-1973@outlook.cl')->send(new EmailNotAsesor($rows->name.' '.$rows->surname, $arrayData['asunto'], $mensaje, $arrayData['nombredocente'], $arrayData['emaildocente'], $arrayData['telaudit'] ) );
                        if(Mail::failures() != 0) 
                        {
                            DB::table('emailjobs')->where('id', $row->id)->update(['status' => 1]);
                            DB::table('notifications')->insert([
                                'id_us' => $arrayData['id_us'], 'id_answ' => $arrayData['id_act'], 'asunto' => $arrayData['asunto'], 'mensaje' => 'Se ha solicitado la asignación de asesor(es), al proyecto : '.$answers->preg1et1.', presentado por la docente: '.$arrayData['nombredocente'], 'tipo' => 'solicitudasesores',
                                'fechanot' => date('Y-m-d H:i:s'), 'fechares' => date('Y-m-d H:i:s')
                            ]);
                            
                        }
                    }
                break;
                
                case ($tipo == 'newnotificationasesoracta'):

                    $emailspenus = DB::table('users')->where('id', $arrayData['mensaje'])->count();

                    $actas = DB::table('actas')->where('id', $arrayData['id_act'])->count();

                    switch (true) 
                    {
                        case ($emailspenus == 1 && $actas == 1):

                            $actas = DB::table('actas')->where('id', $arrayData['id_act'])->first();

                            $answ = DB::table('answers')->where('idansw', $actas->id_proy)->count();

                            switch (true) 
                            {
                                case ($answ == 1):

                                    $answ = DB::table('answers')->where('idansw', $actas->id_proy)->first();

                                    $emailspenus = DB::table('users')->where('id', $arrayData['mensaje'])->first();

                                    Mail::to('mauri-1973@outlook.cl')->send(new EmailNotAsesor($emailspenus->name.' '.$emailspenus->surname, $arrayData['asunto'], 'Se ha creado un acta al proyecto : '.$answ->preg1et1.' con fecha de revisión para el: '.$arrayData['fecharev'].' , presentado por el Docente '. $arrayData['nombredocente'], $arrayData['nombredocente'] , $arrayData['emaildocente'], $arrayData['telaudit'] ) );

                                    if(Mail::failures() != 0) 
                                    {
                                        DB::table('emailjobs')->where('id', $row->id)->update(['status' => 1]);
                                        DB::table('notifications')->insert([
                                            'id_us' => $arrayData['id_us'], 'id_answ' => $arrayData['id_act'], 'asunto' => $arrayData['asunto'], 'mensaje' => 'Se ha notificado al asesor '.$emailspenus->name.' '.$emailspenus->surname.' sobre la fecha de revisión del proyecto, para el '.$arrayData['fecharev'], 'tipo' => 'solicitudasesores',
                                            'fechanot' => date('Y-m-d H:i:s'), 'fechares' => date('Y-m-d H:i:s')
                                        ]);
                                        
                                    }

                                break;
                            }

                        break;
                    }

                break;
                case ($tipo == 'newnotificationdocenteacta'):

                    $emailspenus = DB::table('users')->where('id', $arrayData['id_us'])->count();

                    $actas = DB::table('actas')->where('id', $arrayData['id_act'])->count();

                    switch (true) 
                    {
                        case ($emailspenus == 1 && $actas == 1):

                            $actas = DB::table('actas')->where('id', $arrayData['id_act'])->first();

                            $answ = DB::table('answers')->where('idansw', $actas->id_proy)->count();

                            switch (true) 
                            {
                                case ($answ == 1):

                                    $answ = DB::table('answers')->where('idansw', $actas->id_proy)->first();

                                    $emailspenus = DB::table('users')->where('id', $arrayData['id_us'])->first();

                                    Mail::to('mauri-1973@outlook.cl')->send(new EmailNotAsesor($emailspenus->name.' '.$emailspenus->surname, $arrayData['asunto'], 'Se ha creado un acta al proyecto : '.$answ->preg1et1.' con fecha de revisión para el: '.$arrayData['fecharev'].' , presentado por el Docente'. $arrayData['nombredocente'].'. Los asesores también han sido notificados.', $arrayData['nombredocente'] , $arrayData['emaildocente'], $arrayData['telaudit'] ) );

                                    if(Mail::failures() != 0) 
                                    {
                                        DB::table('emailjobs')->where('id', $row->id)->update(['status' => 1]);
                                        
                                    }

                                break;
                            }

                        break;
                    }


                break;
                case ($tipo == 'newnotificationteacherpresupuesto'):

                    $id_act = $arrayData['id_act'];

                    $emailsaudit = DB::table('users')->where(['cargo_us' => 'Administrador'])->count();

                    $actas = DB::table('answers')->where('idansw', $id_act)->count();

                    if($emailsaudit > 0 && $actas > 0)
                    {
                        $emailsaudit = DB::table('users')->where(['cargo_us' => 'Administrador'])->get();

                        $actas = DB::table('answers')->where('idansw', $id_act)->first();

                        $answ = DB::table('answers')->where('idansw', $id_act)->count();

                        switch (true) 
                        {
                            case ($answ == 1):

                                $answ = DB::table('answers')->where('idansw', $id_act)->first();

                                foreach($emailsaudit as $ema)
                                {

                                    Mail::to('mauri-1973@outlook.cl')->send(new EmailNotAsesor($ema->name.' '.$ema->surname, $arrayData['asunto'], 'Se ha creado una notificación al proyecto : '.$answ->preg1et1.' con fecha : '.date('d-m-Y H:i:s').'. Mensaje: '.$arrayData['mensaje'], $arrayData['nombredocente'] , $arrayData['emaildocente'], $arrayData['telaudit'] ) );

                                }

                                if(Mail::failures() != 0) 
                                {
                                    DB::table('emailjobs')->where('id', $row->id)->update(['status' => 1]);
                                    DB::table('notifications')->insert(['id_us' => $arrayData['id_us'], 'id_answ' => $id_act, 'asunto' => $arrayData['asunto'], 'mensaje' => $arrayData['mensaje'], 'tipo' => 'docentepresupuesto', 'fechanot' => date('Y-m-d H:i:s'), 'fechares' => date('Y-m-d H:i:s')]);
                                }

                            break;
                        }
                    }

                break;
                case ($tipo == 'newnotificationadminpresupuesto'):

                    $id_act = $arrayData['id_act'];

                    

                    $answ = Answers::select('*')->join('postulations as pos', 'answers.id_post', '=', 'pos.idpost')->join('users as u', 'u.id', '=', 'pos.idus')->where('answers.id_post', $id_act)->orderBy('answers.idansw', 'asc')->count();

                    if($answ > 0)
                    {
                        

                        $answ = Answers::select('*')->join('postulations as pos', 'answers.id_post', '=', 'pos.idpost')->join('users as u', 'u.id', '=', 'pos.idus')->where('answers.id_post', $id_act)->orderBy('answers.idansw', 'asc')->first();

                        Mail::to('mauri-1973@outlook.cl')->send(new EmailNotAsesor($answ->name.' '.$answ->surname, $arrayData['asunto'], 'Se ha creado una notificación al proyecto : '.$answ->preg1et1.' con fecha : '.date('d-m-Y H:i:s').'. Mensaje: '.$arrayData['mensaje'], $arrayData['nombredocente'] , $arrayData['emaildocente'], $arrayData['telaudit'] ) );

                        if(Mail::failures() != 0) 
                        {
                            DB::table('emailjobs')->where('id', $row->id)->update(['status' => 1]);
                            DB::table('notifications')->insert(['id_us' => $arrayData['id_us'], 'id_answ' => $id_act, 'asunto' => $arrayData['asunto'], 'mensaje' => $arrayData['mensaje'], 'tipo' => 'adminpresupuesto', 'fechanot' => date('Y-m-d H:i:s'), 'fechares' => date('Y-m-d H:i:s')]);
                        }
                    }

                break;
                case ($tipo == 'newnotificationteacher'):

                    $id_act = $arrayData['id_act'];

                    $emailsaudit = DB::table('actasadit as aca')->join('users as u', 'aca.idaudit','=', 'u.id')->where(['aca.idacta'=> $id_act, 'aca.status' => 'si', 'u.cargo_us' => 'Auditor'])->count();

                    $actas = DB::table('actas')->where('id', $id_act)->count();

                    if($emailsaudit > 0 && $actas > 0)
                    {
                        $emailsaudit = DB::table('actasadit as aca')->select('u.*')->join('users as u', 'aca.idaudit','=', 'u.id')->where(['aca.idacta'=> $id_act, 'aca.status' => 'si', 'u.cargo_us' => 'Auditor'])->get();

                        $actas = DB::table('actas')->where('id', $id_act)->first();

                        $answ = DB::table('answers')->where('idansw', $actas->id_proy)->count();

                        switch (true) 
                        {
                            case ($answ == 1):

                                $answ = DB::table('answers')->where('idansw', $actas->id_proy)->first();

                                foreach($emailsaudit as $ema)
                                {

                                    Mail::to('mauri-1973@outlook.cl')->send(new EmailNotAsesor($ema->name.' '.$ema->surname, $arrayData['asunto'], 'Se ha creado una notificación al proyecto : '.$answ->preg1et1.' con fecha : '.date('d-m-Y H:i:s').'. Mensaje: '.$arrayData['mensaje'], $arrayData['nombredocente'] , $arrayData['emaildocente'], $arrayData['telaudit'] ) );

                                }

                                if(Mail::failures() != 0) 
                                {
                                    DB::table('emailjobs')->where('id', $row->id)->update(['status' => 1]);
                                    DB::table('notifications')->insert(['id_us' => $arrayData['id_us'], 'id_act' => $id_act, 'asunto' => $arrayData['asunto'], 'mensaje' => $arrayData['mensaje'], 'tipo' => 'docente', 'fechanot' => date('Y-m-d H:i:s'), 'fechares' => date('Y-m-d H:i:s')]);
                                }

                            break;
                        }
                    }

                break;
                case ($tipo == 'newnotificationteacheradmin'):

                    $id_act = $arrayData['id_act'];

                    $emailsaudit = DB::table('actasadit as aca')->join('users as u', 'aca.idaudit','=', 'u.id')->where(['aca.idacta'=> $id_act, 'aca.status' => 'si', 'u.cargo_us' => 'Auditor'])->count();

                     

                    $actas = DB::table('actas')->where('id', $id_act)->count();

                    if($emailsaudit > 0 && $actas > 0)
                    {
                        $emailsaudit = DB::table('actasadit as aca')->select('u.*')->join('users as u', 'aca.idaudit','=', 'u.id')->where(['aca.idacta'=> $id_act, 'aca.status' => 'si', 'u.cargo_us' => 'Auditor'])->get();

                        $actas = DB::table('actas')->where('id', $id_act)->first();

                        $answ = DB::table('answers')->where('idansw', $actas->id_proy)->count();

                        $postulations = DB::table('postulations as post')->join('users as u', 'post.idus','=', 'u.id')->where(['post.idpost'=> $actas->id_proy, 'u.status_us' => 1, 'u.cargo_us' => 'Docente'])->count();

                        switch (true) 
                        {
                            case ($answ == 1):

                                $answ = DB::table('answers')->where('idansw', $actas->id_proy)->first();

                                if($postulations == 1)
                                {
                                    $postulations = DB::table('postulations as post')->join('users as u', 'post.idus','=', 'u.id')->where(['post.idpost'=> $actas->id_proy, 'u.status_us' => 1, 'u.cargo_us' => 'Docente'])->first();

                                    Mail::to('mauri-1973@outlook.cl')->send(new EmailNotAsesorDoc($postulations->name.' '.$postulations->surname, $arrayData['asunto'], 'Se ha creado una notificación al proyecto : '.$answ->preg1et1.' con fecha : '.date('d-m-Y H:i:s').'. Mensaje: '.$arrayData['mensaje'], $arrayData['nombredocente'] , $arrayData['emaildocente'], $arrayData['telaudit'] ) ); 
                                }

                                foreach($emailsaudit as $ema)
                                {

                                    Mail::to('mauri-1973@outlook.cl')->send(new EmailNotAsesorDoc($ema->name.' '.$ema->surname, $arrayData['asunto'], 'Se ha creado una notificación al proyecto : '.$answ->preg1et1.' con fecha : '.date('d-m-Y H:i:s').'. Mensaje: '.$arrayData['mensaje'], $arrayData['nombredocente'] , $arrayData['emaildocente'], $arrayData['telaudit'] ) );

                                }

                                if(Mail::failures() != 0) 
                                {
                                    DB::table('emailjobs')->where('id', $row->id)->update(['status' => 1]);
                                    DB::table('notifications')->insert(['id_us' => $arrayData['id_us'], 'id_act' => $id_act, 'asunto' => $arrayData['asunto'], 'mensaje' => $arrayData['mensaje'], 'tipo' => 'docente', 'fechanot' => date('Y-m-d H:i:s'), 'fechares' => date('Y-m-d H:i:s')]);
                                }

                            break;
                        }
                    }

                break;
                case ($tipo == 'newdatenotificationasesoracta'):

                    $emailspenus = DB::table('users')->where('id', $arrayData['mensaje'])->count();

                    $actas = DB::table('actas')->where('id', $arrayData['id_act'])->count();

                    switch (true) 
                    {
                        case ($emailspenus == 1 && $actas == 1):

                            $actas = DB::table('actas')->where('id', $arrayData['id_act'])->first();

                            $answ = DB::table('answers')->where('idansw', $actas->id_proy)->count();

                            switch (true) 
                            {
                                case ($answ == 1):

                                    $answ = DB::table('answers')->where('idansw', $actas->id_proy)->first();

                                    $audit = DB::table('actasadit')->where(['idacta' => $arrayData['id_act'], 'status' => 'si'])->get();

                                    foreach($audit as $a)
                                    {
                                        $emailspenus = DB::table('users')->where('id', $a->idaudit )->first();
                                        Mail::to('mauri-1973@outlook.cl')->send(new EmailNotAsesor($emailspenus->name.' '.$emailspenus->surname, $arrayData['asunto'], 'Se ha creado una nueva fecha de revisión al acta del proyecto : '.$answ->preg1et1.' para el día: '.$arrayData['fecharev'].' , solicitud creada por el Docente '. $arrayData['nombredocente'], $arrayData['nombredocente'] , $arrayData['emaildocente'], $arrayData['telaudit'] ) );
                                    }
                                    

                                    

                                    if(Mail::failures() != 0) 
                                    {
                                        $actas = DB::table('actas')->where('id', $arrayData['id_act'])->update(["fecha_reu" => date('Y-m-d H:i:s', strtotime($arrayData['fecharev'])) ]);
                                        DB::table('emailjobs')->where('id', $row->id)->update(['status' => 1]);
                                        DB::table('notifications')->insert([
                                            'id_us' => $arrayData['id_us'], 'id_act' => $arrayData['id_act'], 'asunto' => $arrayData['asunto'], 'mensaje' => 'Se ha notificado a los asesores sobre la nueva fecha de revisión del proyecto, para el día '.$arrayData['fecharev'], 'tipo' => 'solicitudasesores',
                                            'fechanot' => date('Y-m-d H:i:s'), 'fechares' => date('Y-m-d H:i:s')
                                        ]);
                                        
                                    }

                                break;
                            }

                        break;
                    }

                break;
                
            }
        }
        //Log::info('Esta tarea programada se finalizó correctamente.');
        $this->info('OK');
    }
}
