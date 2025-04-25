<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Answers;

use App\AnswersDirector;

use App\AnswersFiles;

use App\Corrections;

use App\DetailsResources;

use App\Competitions;

use App\FilesCompetitions;

use App\CompetitionsTags;

use App\Postulations;

use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Mail\MailSeleccion;

use Illuminate\Support\Facades\Mail;

class SeleccionadosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seleccionados:enviar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Esta funcionalidad permite notificar a los postulates a los concursos si fueron o no seleccionados a continuar a la siguiete etapa';

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
        $Competitions = Competitions::where(['statuspos' => 'seleccionados', 'sendmail' => 0])->count();
        switch (true) 
        {
            case ($Competitions == 0):
                $this->info('No hay concursos finalizados.');
            break;

            case ($Competitions > 0):
                $tempuno = 0;
                $tempdos = 0;
                $Competitions = Competitions::select('idcomp', 'title')->where(['statuspos' => 'seleccionados', 'sendmail' => 0])->get();
                foreach($Competitions as $row)
                {
                    $idcomp = $row->idcomp;

                    $titlecomp = $row->title;

                    $postulacion = Postulations::where('idconc', $idcomp)->count();

                    switch (true) 
                    {
                        case ($postulacion > 0):
                            $postulacion = Postulations::select('idpost', 'status')->where('idconc', $idcomp)->orderBy('idpost', 'desc')->get();
                            foreach($postulacion as $postuno)
                            {
                                
                                $sumper = 0; $sumcom = 0; $sumfun = 0; $sumotr = 0;

                                $answ = DB::table('answers')->select('idansw')->where('id_post', $postuno->idpost)->orderBy('idansw', 'asc')->first();

                                $id = (int)$answ ->idansw;

                                $answ = Answers::select('*')->where('idansw', $id)->orderBy('idansw', 'asc')->get();

                                $dir = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'dir'])->first();

                                $subdir = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'sub'])->first();

                                $est = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'est'])->get();

                                $acad = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'acad'])->get();

                                $files = AnswersFiles::where(['id_answ' => $id, 'tipofile' => 'Normal'])->orderBy('idanswfile', 'asc')->get();

                                $tablaper = DetailsResources::select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_answ' =>  $id, 'type' => 1])->orderBy('iddetres', 'asc')->get();

                                foreach($tablaper as $tabla)
                                {
                                    $sumper = ($tabla->valor1 * $tabla->valor2) + $sumper;
                                }

                                $tablacom = DetailsResources::select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_answ' =>  $id, 'type' => 2])->orderBy('iddetres', 'asc')->get();
                                
                                foreach($tablacom as $tabla)
                                {
                                    $sumcom = ($tabla->valor1 * $tabla->valor2) + $sumcom;
                                }

                                $tablafun = DetailsResources::select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_answ' =>  $id, 'type' => 3])->orderBy('iddetres', 'asc')->get();
                                
                                foreach($tablafun as $tabla)
                                {
                                    $sumfun = ($tabla->valor1 * $tabla->valor2) + $sumfun;
                                }

                                $tablaotr = DetailsResources::select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_answ' =>  $id, 'type' => 4])->orderBy('iddetres', 'asc')->get();
                                
                                foreach($tablaotr as $tabla)
                                {
                                    $sumotr = ($tabla->valor1 * $tabla->valor2) + $sumotr;
                                }

                                $countfilesDA = AnswersFiles::where(['id_answ' => $id, 'tipofile' => 'Director (a) Académico'])->count();

                                $countfilesDN = AnswersFiles::where(['id_answ' => $id, 'tipofile' => 'Director(a) Nacional'])->count();

                                //$sumper = DetailsResources::where(['id_answ' =>  $id, 'type' => 1])->selectRaw('(SUM(valor1) * SUM(valor2)) as sumaTotal')->get();

                                $filesa = AnswersFiles::where(['id_answ' => $id])->where('tipofile', '!=', 'Normal')->orderBy('idanswfile', 'asc')->get();

                                
                                $data = PDF::loadView('emails/prueba', ["answ" => $answ, 'dir' => $dir, 'subdir' => $subdir, 'est' => $est, 'acad' => $acad, 'files' => $files, "sumper" => (int)$sumper, "sumcom" => (int)$sumcom, "sumfun" => (int)$sumfun, "sumotr" => (int)$sumotr, 'tablaper' => $tablaper, 'tablacom' => $tablacom, 'tablafun' => $tablafun , 'tablaotr' => $tablaotr,  'filesa' => $filesa,  'contda' => $countfilesDA,  'contdn' => $countfilesDN])->save(storage_path('app/public/pdftemp/') . $id .'_Formulario.pdf');

                                $filename = storage_path('app/public/pdftemp/') . $id .'_Formulario.pdf';

                                if (file_exists($filename)) 
                                {
                                    $tempuno++;
                                }
                                
                                $sumper = 0; $sumcom = 0; $sumfun = 0; $sumotr = 0; 

                                $correc = Corrections::where('id_answ', $id)->first();

                                $answ = Answers::select('id_post')->where('idansw', $id)->orderBy('idansw', 'asc')->first();

                                $idconc = Postulations::select('idpost')->where(['idpost' =>  $answ->id_post])->first();

                                $post = Postulations::join('competitions as con', 'postulations.idconc', '=', 'con.idcomp')

                                ->join('users as u', 'u.id', '=', 'postulations.idus')

                                ->where('postulations.idpost', $idconc->idpost )

                                ->first(['postulations.created_at', 'con.title', 'u.name', 'u.surname', 'u.email']);
                                
                                $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");

                                $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

                                $pdf = \PDF::loadView('emails/observaciones', ["correc" => $correc, 'conc' => $post->title, 'nombre' => $post->name.' '.$post->surname, 'fecha' => $dias[date("w", strtotime($post->created_at))]." ".date("d", strtotime($post->created_at))." de ".$meses[date("n", strtotime($post->created_at))-1]. " del ".date("Y", strtotime($post->created_at))])->save(storage_path('app/public/pdftemp/') . $id .'_Observaciones.pdf');

                                $filename1 = storage_path('app/public/pdftemp/') . $id .'_Observaciones.pdf';

                                if (file_exists($filename1)) 
                                {
                                    $tempdos++;
                                }
                                if($postuno->status == "seleccionado")
                                {
                                    Mail::to($post->email)->cc("mauri-1973@outlook.cl")->send(new MailSeleccion($post->name.' '.$post->surname, $postuno->status, $id, $titlecomp));
                                }
                                else
                                {
                                    Mail::to($post->email)->send(new MailSeleccion($post->name.' '.$post->surname, $postuno->status, $id, $titlecomp));
                                }
                                
                                
                                unlink($filename);

                                unlink($filename1);
                                }
                        break;
                    }
                    $Compupdate = Competitions::where(['idcomp' => $idcomp])->update(['sendmail' => 1]);
                }
            break;
        }
        $this->info('OK');
    }
}
