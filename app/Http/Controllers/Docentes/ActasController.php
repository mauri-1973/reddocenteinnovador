<?php



namespace App\Http\Controllers\Docentes;



use App\Http\Controllers\Controller;

use App\Http\Requests\StorePostRequest;

use App\Http\Requests\UpdatePostRequest;

use App\Categoryblog;

use App\Post;

use App\Tagblog;

use App\TagsComp;

use App\PostTag;

use App\Commentblog;

use App\CategoriesCompetitions;

use App\Competitions;

use App\FilesCompetitions;

use App\CompetitionsTags;

use App\Postulations;

use App\DetailsResources;

use App\Answers;

use App\AnswersDirector;

use App\AnswersFiles;

use App\AnswersStatus;

use App\Corrections;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Intervention\Image\Facades\Image as Image;

use Symfony\Component\HttpFoundation\Response;

use Illuminate\Http\JsonResponse;

use Barryvdh\DomPDF\Facade\Pdf;

use File;

use Crypt;

use Mail;

use Carbon\Carbon;



class ActasController extends Controller

{

    /**

    *

    * allow blog only

    *

    */

    public function __construct() {

        //$this->middleware(['role:admin|creator']);

        $this->middleware(['role:docente']);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    

    public function veractfordocconsel($id = null)
    {
        $idansw = Crypt::decrypt($id);
        
        $answ = Answers::select('idansw', 'id_post', 'preg1et1', 'preg2et1')->where('idansw', $idansw)->orderBy('idansw', 'asc')->count();

        $sumglobal = 0;

        $arreglo = array();

        $defansw = array();

        $actas = array();

        $auditores = array();

        $personal = array();

        $newhist = array();

        $fechaini = date('Y-m-d H:i:s');

        $fechater = date('Y-m-d H:i:s');

        $fechareu = date('Y-m-d H:i:s');

        $porcentaje = 0;

        $numaudit = 0;

        $evaluado = 0;

        $resumenactas = "";

        $resumenacuerdos = "";

        $resumencompromisos = "";

        $idantiguasactas = [];

        switch (true) 
        {
            case ($answ == 1):

                $answ = Answers::select('idansw', 'id_post', 'preg1et1', 'preg2et1')->where('idansw', $idansw)->orderBy('idansw', 'asc')->first();
                
                
                $post = Postulations::where(['idpost' =>  $answ->id_post])->count();

                switch (true) 
                {
                    case ($post == 1):

                        $act = "sininfo";

                        $post = Postulations::where(['idpost' =>  $answ->id_post])->first();

                        $actasini = DB::table('actas')->where(['id_proy' => $answ->id_post] )->count();
                        
                        //$actascreada = DB::table('actas')->where(['id_proy' => $answ->id_post, 'status' => 'creada'] )->count();

                        //$actasencurso = DB::table('actas')->where(['id_proy' => $answ->id_post, 'status' => 'encurso'] )->count();

                        //$actashistorico = DB::table('actas')->where(['id_proy' => $answ->id_post, 'status' => 'histrorico'] )->count();

                        //$actasfinalizada = DB::table('actas')->where(['id_proy' => $answ->id_post, 'status' => 'finalizada'] )->count();

                        switch (true) 
                        {
                            case ($actasini == 0):

                                
                                return view('docentes.postulaciones.veractas', ["id" => $id, "actas" => $actas, "act" => $act, "count" => count($arreglo), "arreglo" => $arreglo, 'value' => 0, 'idconc' => Crypt::encrypt($post->idconc), 'defansw' => $answ, 'statusacta' => 'solicitar', 'fechaini' => $fecha_ini, 'fechater' => $fechater, 'fechareu' => $fechareu, "auditores" => $auditores, "personal" => $personal, "porcentaje" => $porcentaje, "evaluado" => $evaluado, "resumenactas" => $resumenactas, "resumenacuerdos" => $resumenacuerdos, "resumencompromisos" => $resumencompromisos, "newhist" => $newhist, 'sumglobal' => (100 - $sumglobal), 'idantiguasactas' => $idantiguasactas ]);

                            break;

                            case ($actasini  == 1):

                                $actasini = DB::table('actas')->where(['id_proy' => $answ->id_post] )->first();

                                $arreglo = DB::table('actas')
                                ->join('actasadit', 'actas.id', '=', 'actasadit.idacta')
                                ->where(['actasadit.status' => 'si', 'actas.id' => $actasini->id])
                                ->count();
                                
                                switch (true) 
                                {
                                    case ($arreglo == 0):
                                        

                                        return view('docentes.postulaciones.veractas', ["id" => $id, "actas" => $actas, "act" => $act, "count" => count($arreglo), "arreglo" => $arreglo, 'value' => 0, 'idconc' => Crypt::encrypt($post->idconc), 'defansw' => $answ, 'statusacta' => 'sinasesores', 'fechaini' => $fecha_ini, 'fechater' => $fechater, 'fechareu' => $fechareu, "auditores" => $auditores, "personal" => $personal, "porcentaje" => $porcentaje, "evaluado" => $evaluado, "resumenactas" => $resumenactas, "resumenacuerdos" => $resumenacuerdos, "resumencompromisos" => $resumencompromisos, "newhist" => $newhist, 'sumglobal' => (100 - $sumglobal), 'idantiguasactas' => $idantiguasactas ]);

                                    break;

                                    case ($arreglo > 0):

                                        $arreglo = DB::table('actas')->where(['id' => $actasini->id])->orderBy('id', 'asc')->first();

                                        if($arreglo->fecha_ini != null || $arreglo->fecha_ini != '')
                                        {
                                            $fechaini = date('Y-m-d\TH:i:s', strtotime($arreglo->fecha_ini));
                                        }
                                        if($arreglo->fecha_ter != null || $arreglo->fecha_ter != '')
                                        {
                                            $fechater = date('Y-m-d\TH:i:s', strtotime($arreglo->fecha_ter));
                                        }
                                        if($arreglo->fecha_reu != null || $arreglo->fecha_reu != '')
                                        {
                                            $fechareu = date('Y-m-d\TH:i:s', strtotime($arreglo->fecha_reu));
                                        }

                                        $auditores = DB::table('actasadit as aa')->join('actashistorial as ah', 'aa.id', '=', 'ah.idaudit')->join('users as u', 'u.id', '=', 'ah.idusers')->where(['aa.idacta' => $actasini->id, 'aa.status' => 'si' ])->get();

                                        $newhist = DB::table('actashistorial as ah')->where(['idacta' => $actasini->id])->get();
                                               
                                        $personal = DB::table('actashistorial as ah')->where(['idacta' => $actasini->id, 'idusers' => Auth::user()->id ])->first();
                                        
                                        if($personal->temas != '' || $personal->temas != null)
                                        {
                                            $resumenactas .= $personal->temas;
                                        }
                                        if($personal->acuerdos != '' || $personal->acuerdos != null)
                                        {
                                            $resumenacuerdos .= '\n************************\n'.$personal->acuerdos.' ('.$personal->nombreaudit.' - '.$personal->fechaacuerdos.')\n************************\n';
                                        }
                                        if($personal->compromisos != '' || $personal->compromisos != null)
                                        {
                                            $resumencompromisos .= '\n************************\n'.$personal->compromisos.' ('.$personal->nombreaudit.' - '.$personal->fechacompromisos.')\n************************\n';
                                        }
                                        
                                        foreach($auditores as $aud)
                                        {
                                            if($aud->temas != '' || $aud->temas != null)
                                            {
                                                $resumenactas .= '<br>************************\n'.$aud->temas.' ('.$aud->nombreaudit.' - '.$aud->fechatemas.')\n************************\n';
                                            }
                                            if($aud->acuerdos != '' || $aud->acuerdos != null)
                                            {
                                                $resumenacuerdos .= '\n************************\n'.$aud->acuerdos.' ('.$aud->nombreaudit.' - '.$aud->fechaacuerdos.')\n************************\n';
                                            }
                                            if($aud->compromisos != '' || $aud->compromisos != null)
                                            {
                                                $resumencompromisos .= '\n************************\n'.$aud->compromisos.' ('.$aud->nombreaudit.' - '.$aud->fechacompromisos.')\n************************\n';
                                            }
                                            $porcentaje = $aud->porcentaje + $porcentaje;
                                            $numaudit++;
                                        }
                                        if($porcentaje > 0)
                                        {
                                            $evaluado = round($porcentaje/$numaudit, 0, PHP_ROUND_HALF_UP);
                                        }
                                        
                                        return view('docentes.postulaciones.veractas', ["id" => $id, "actas" => $actas, "act" => $act, "count" => 0, "arreglo" => $arreglo, 'value' => 0, 'idconc' => Crypt::encrypt($post->idconc), 'defansw' => $answ, 'statusacta' => $arreglo->status, 'fechaini' => $fechaini, 'fechater' => $fechater, 'fechareu' => $fechareu, "auditores" => $auditores, "personal" => $personal, "porcentaje" => $porcentaje, "evaluado" => $evaluado, "resumenactas" => $resumenactas, "resumenacuerdos" => $resumenacuerdos, "resumencompromisos" => $resumencompromisos, "newhist" => $newhist, 'sumglobal' => (100 - $sumglobal), 'idantiguasactas' => $idantiguasactas ]);

                                    break;

                                    
                                    
                                    default:
                                         abort(404);
                                    break;
                                }

                                

                            break;
                            case ($actasini  > 1):

                                

                                $actasini = DB::table('actas')->where(['id_proy' => $answ->id_post] )->orderBy('id', 'desc')->first();

                                $actasantiguas = DB::table('actas')->where('id_proy', $answ->id_post)->where('id', '!=', $actasini->id)->get();
                                foreach($actasantiguas as $cont)
                                {
                                    $sumglobal = $sumglobal + $cont->avance;
                                    $idantiguasactas[] = $cont->id;
                                    $idantiguasactas[] = date('d-m-Y H:i:s', strtotime($cont->fecha_ini));
                                    $idantiguasactas[] = date('d-m-Y H:i:s', strtotime($cont->fecha_ter));
                                }
                                
                                $arreglo = DB::table('actas')
                                ->join('actasadit', 'actas.id', '=', 'actasadit.idacta')
                                ->where(['actasadit.status' => 'si', 'actas.id' => $actasini->id])
                                ->count();
                                switch (true) 
                                {
                                    case ($arreglo == 0):
                                        

                                        return view('docentes.postulaciones.veractas', ["id" => $id, "actas" => $actas, "act" => $act, "count" => count($arreglo), "arreglo" => $arreglo, 'value' => 0, 'idconc' => Crypt::encrypt($post->idconc), 'defansw' => $answ, 'statusacta' => 'sinasesores', 'fechaini' => $fecha_ini, 'fechater' => $fechater, 'fechareu' => $fechareu, "auditores" => $auditores, "personal" => $personal, "porcentaje" => $porcentaje, "evaluado" => $evaluado, "resumenactas" => $resumenactas, "resumenacuerdos" => $resumenacuerdos, "resumencompromisos" => $resumencompromisos, "newhist" => $newhist, 'sumglobal' => (100 - $sumglobal), 'idantiguasactas' => $idantiguasactas ]);

                                    break;

                                    case ($arreglo > 1):

                                        $arreglo = DB::table('actas')->where(['id' => $actasini->id])->orderBy('id', 'desc')->first();

                                        if($arreglo->fecha_ini != null || $arreglo->fecha_ini != '')
                                        {
                                            $fechaini = date('Y-m-d\TH:i:s', strtotime($arreglo->fecha_ini));
                                        }
                                        if($arreglo->fecha_ter != null || $arreglo->fecha_ter != '')
                                        {
                                            $fechater = date('Y-m-d\TH:i:s', strtotime($arreglo->fecha_ter));
                                        }
                                        if($arreglo->fecha_reu != null || $arreglo->fecha_reu != '')
                                        {
                                            $fechareu = date('Y-m-d\TH:i:s', strtotime($arreglo->fecha_reu));
                                        }

                                        $auditores = DB::table('actasadit as aa')->join('actashistorial as ah', 'aa.id', '=', 'ah.idaudit')->join('users as u', 'u.id', '=', 'ah.idusers')->where(['aa.idacta' => $actasini->id, 'aa.status' => 'si' ])->get();

                                        $newhist = DB::table('actashistorial as ah')->where(['idacta' => $actasini->id])->get();
                                               
                                        $personal = DB::table('actashistorial as ah')->where(['idacta' => $actasini->id, 'idusers' => Auth::user()->id ])->first();
                                        
                                        if($personal->temas != '' || $personal->temas != null)
                                        {
                                            $resumenactas .= $personal->temas;
                                        }
                                        if($personal->acuerdos != '' || $personal->acuerdos != null)
                                        {
                                            $resumenacuerdos .= '\n************************\n'.$personal->acuerdos.' ('.$personal->nombreaudit.' - '.$personal->fechaacuerdos.')\n************************\n';
                                        }
                                        if($personal->compromisos != '' || $personal->compromisos != null)
                                        {
                                            $resumencompromisos .= '\n************************\n'.$personal->compromisos.' ('.$personal->nombreaudit.' - '.$personal->fechacompromisos.')\n************************\n';
                                        }
                                        
                                        foreach($auditores as $aud)
                                        {
                                            if($aud->temas != '' || $aud->temas != null)
                                            {
                                                $resumenactas .= '<br>************************\n'.$aud->temas.' ('.$aud->nombreaudit.' - '.$aud->fechatemas.')\n************************\n';
                                            }
                                            if($aud->acuerdos != '' || $aud->acuerdos != null)
                                            {
                                                $resumenacuerdos .= '\n************************\n'.$aud->acuerdos.' ('.$aud->nombreaudit.' - '.$aud->fechaacuerdos.')\n************************\n';
                                            }
                                            if($aud->compromisos != '' || $aud->compromisos != null)
                                            {
                                                $resumencompromisos .= '\n************************\n'.$aud->compromisos.' ('.$aud->nombreaudit.' - '.$aud->fechacompromisos.')\n************************\n';
                                            }
                                            $porcentaje = $aud->porcentaje + $porcentaje;
                                            $numaudit++;
                                        }
                                        if($porcentaje > 0)
                                        {
                                            $evaluado = round($porcentaje/$numaudit, 0, PHP_ROUND_HALF_UP);
                                        }
                                        
                                        return view('docentes.postulaciones.veractas', ["id" => $id, "actas" => $actas, "act" => $act, "count" => 0, "arreglo" => $arreglo, 'value' => 0, 'idconc' => Crypt::encrypt($post->idconc), 'defansw' => $answ, 'statusacta' => $arreglo->status, 'fechaini' => $fechaini, 'fechater' => $fechater, 'fechareu' => $fechareu, "auditores" => $auditores, "personal" => $personal, "porcentaje" => $porcentaje, "evaluado" => $evaluado, "resumenactas" => $resumenactas, "resumenacuerdos" => $resumenacuerdos, "resumencompromisos" => $resumencompromisos, "newhist" => $newhist, 'sumglobal' => (100 - $sumglobal), 'idantiguasactas' => $idantiguasactas ]);

                                    break;

                                    
                                    
                                    default:
                                         abort(404);
                                    break;
                                }
                            break;
                            default:

                                abort(404);
                                
                            break;
                        }
                    break;

                    default:

                        abort(404);

                    break;
                }

            break;

            default:

                abort(404);

            break;

        }
    }

    public function verfordocconfinact($id = null)
    {
        $idansw = Crypt::decrypt($id);
        
        $answ = Answers::select('idansw', 'id_post', 'preg1et1', 'preg2et1')->where('idansw', $idansw)->orderBy('idansw', 'asc')->count();

        $arreglo = array();

        switch (true) 
        {
            case ($answ == 1):

                $answ = Answers::select('idansw', 'id_post', 'preg1et1', 'preg2et1')->where('idansw', $idansw)->orderBy('idansw', 'asc')->first();

                $post = Postulations::where(['idpost' =>  $answ->id_post])->count();

                switch (true) 
                {
                    case ($post == 1):

                        $act = "sininfo";

                        $post = Postulations::where(['idpost' =>  $answ->id_post])->first();

                        $actas = DB::table('actas')->where('id_proy', $answ->id_post )->count();

                        switch (true) 
                        {
                            case ($actas >= 0):

                                $actas = DB::table('actas')->where('id_proy', $answ->id_post )->get();

                                foreach($actas as $row)
                                {
                                    $actasaudit = DB::table('actasadit as a')->select('u.name','u.surname')->join('users as u', 'u.id', '=', 'a.userid')->join('actas as ac', 'a.idacta', '=', 'ac.id')->join('actashistorial as ah', 'ac.id', 'ah.idacta')->where('a.idacta', $actas->id)->get();

                                    array_push($arreglo, array("nombre" => $actasaudit->name.''.$actasaudit->surname));
                                }

                                $act = "coninfo";
                                
                            break;
                            
                            default:
                                # code...
                            break;
                        }

                        $text = "Actas Relacionadas a su postulación adjudicada.";

                        return view('docentes.historial.veractas', ["id" => $id, "text" => $text, "actas" => $actas, "act" => $act, "count" => count($arreglo), "arreglo" => $arreglo]); 
                    
                    break;
                    default:

                        abort(404);

                    break;
                }

            break;

            default:

                abort(404);

            break;

        }
    }
    public function funajausudocact(Request $request)
    {
        switch (true) 
        {
            case ($request->tipo == 'solicitar' || $request->tipo == 'sinasesores'):
            
                $idansw = Crypt::decrypt($request->idansw);
                
                $datos = [
                    'id_us' => Auth::user()->id, 'id_act' => $idansw, 'asunto' => "Asignación de Asesores", 'mensaje' => $request->tipo, 'tipo' => 'solasesor',
                    'nombredocente' => Auth::user()->name.' '.Auth::user()->surname, 'emaildocente' => Auth::user()->email, 'telaudit' => Auth::user()->mobile
                ];
                
                $jsonData = json_encode($datos);

                $emailjob = DB::table('emailjobs')->insert([

                    'contenido' => $jsonData, 'template' => 'newnotificationasesor', 'status' => 0

                ]);

                return redirect()->route('ver-actas-formulario-docente-concurso-seleccionado', $request->idansw)->with('success', trans('multi-new.0140'));

            break;
            case ($request->tipo == 'emailteacher'):

                $idact = Crypt::decrypt($request->idact);
                
                $datos = [
                    'id_us' => Auth::user()->id, 'id_act' => $idact, 'asunto' => $request->asunto, 'mensaje' => $request->mensaje, 'tipo' => $request->tipo,
                    'nombredocente' => Auth::user()->name.' '.Auth::user()->surname, 'emaildocente' => Auth::user()->email, 'telaudit' => Auth::user()->mobile
                ];
                
                $jsonData = json_encode($datos);

                $emailjob = DB::table('emailjobs')->insert([

                    'contenido' => $jsonData, 'template' => 'newnotificationteacher', 'status' => 0

                ]);

                return response()->json(['status' => "ok", "idact" => $request->idact, "idus" => Auth::user()->id ], 200);

            break;
            case ($request->tipo == 'agendarreunion'):

                $idact = Crypt::decrypt($request->idact);
                $idus = Crypt::decrypt($request->idus);
                $actas = DB::table('actas')->where('id', $idact )->count();
                if($actas == 1)
                {
                    $datos = [
                        'id_us' => Auth::user()->id, 'id_act' => $idact, 'asunto' => "Nueva fecha de revisión acta", 'mensaje' => $idus, 'tipo' => 'newfechainicialactaaudit',
                        'nombredocente' => Auth::user()->name.' '.Auth::user()->surname, 'emaildocente' => Auth::user()->email, 'telaudit' => Auth::user()->mobile, "fecharev" => date('d-m-Y H:i:s', strtotime($request->datetimereu))
                    ];
                    
                    $jsonData = json_encode($datos);
    
                    $emailjob = DB::table('emailjobs')->insert([
    
                        'contenido' => $jsonData, 'template' => 'newdatenotificationasesoracta', 'status' => 0
    
                    ]);
                    return response()->json(['status' => "ok", "idact" => $idact, "idus" => Auth::user()->id, 'fecha' => date('d-m-Y H:i:s', strtotime($request->datetimereu)) ], 200);
                }
                else
                {
                    return response()->json(['status' => "error", "idact" => $idact, "idus" => Auth::user()->id, 'fecha' => date('d-m-Y H:i:s', strtotime($request->datetimereu)) ], 200);
                }

            break;
            
            case ($request->tipo == 'finalizaracta' ):
                $array = array();
                $idansw = Crypt::decrypt($request->idansw);
                $idacta = Crypt::decrypt($request->idacta);
                $porcen = DB::table('actasadit')->select('*')->where(['idacta' => $idacta, 'status' => 'si'])->count();
                if($porcen > 0)
                {
                    $tot = 0;
                    $num = 0;
                    $porcen = DB::table('actasadit')->select('*')->where(['idacta' => $idacta, 'status' => 'si'])->get();
                    foreach($porcen as $row)
                    {
                        
                        $sum = DB::table('actashistorial')->select('*')->where(['idacta' => $idacta, 'idaudit' => $row->id])->get();
                        foreach($sum as $s)
                        {
                            $tot = $tot + $s->porcentaje;
                            $num++;
                        }

                    } 
                    if($tot > 0)
                    {
                        $tot = round($tot/$num, 0, PHP_ROUND_HALF_UP);
                    }
                }
                switch (true) 
                {
                    case ($tot == 100):
                        $acta = DB::table('actas')->select('*')->where(['id' => $idacta])->count();
                        switch (true) 
                        {
                            case ($acta == 1):
                                $acta = DB::table('actas')->select('*')->where(['id' => $idacta])->first();
                                $audit = DB::table('actasadit')->select('*')->where(['idacta' => $idacta, 'status' => 'si'])->count();
                                switch (true) 
                                {
                                    case ($audit == 0):
                                        return redirect()->route('ver-actas-formulario-docente-concurso-seleccionado', $request->idansw)->with('danger', trans('multi-new.0202'));
                                    break;
                                    case ($audit > 0):

                                        $marcaTiempo = strtotime($acta->fecha_ter);

                                        $marcaTiempoMasUnDia = strtotime('+1 day', $marcaTiempo);

                                        $fechaResultante = date('Y-m-d H:i:s', $marcaTiempoMasUnDia);

                                        $actaup = DB::table('actas')->where(['id' => $idacta])->update(['status' => 'finalizada']);

                                        $actasin = DB::table('actas')->insertGetId([ 'id_proy' => $acta->id_proy, 'fecha_ini' => $fechaResultante, 'fecha_ter' => $fechaResultante, 'fecha_reu' => $fechaResultante, 'status' => 'creada' ]);

                                        $audit = DB::table('actasadit')->select('*')->where(['idacta' => $idacta, 'status' => 'si'])->get();

                                        foreach($audit as $au)
                                        {
                                            $hist = DB::table('actashistorial')->select('*')->where(['idaudit' => $au->id, 'idusers' => $au->idaudit ])->first();

                                            $auditnew = DB::table('actasadit')->insertGetId(['idacta' => $actasin, 'idaudit' => $au->idaudit, 'status' => 'si']);

                                            $audithist = DB::table('actashistorial')->insert(['idacta' => $actasin, 'idaudit' => $auditnew, 'idusers' => $hist->idusers, 'nombreaudit' => $hist->nombreaudit ]);

                                        }
                                        $audithist = DB::table('actashistorial')->insert(['idacta' => $actasin, 'idusers' => Auth::user()->id, 'nombreaudit' => Auth::user()->name.' '.Auth::user()->surname ]);

                                        return redirect()->route('ver-actas-formulario-docente-concurso-seleccionado', $request->idansw)->with('success', trans('multi-new.0203').'');
                                    break;
                                    
                                    default:
                                        return redirect()->route('ver-actas-formulario-docente-concurso-seleccionado', $request->idansw)->with('danger', trans('multi-new.0201'));
                                    break;
                                }
                                
                                
                            break;
                            
                            default:
                                return redirect()->route('ver-actas-formulario-docente-concurso-seleccionado', $request->idansw)->with('danger', trans('multi-new.0201'));
                            break;
                        }
                    break;
                    
                    default:
                        return redirect()->route('ver-actas-formulario-docente-concurso-seleccionado', $request->idansw)->with('danger', trans('multi-new.0200').$tot.'%');
                    break;
                }
                
                

            break;
            case ($request->tipo == 'notificaciones' ):
                $array = array();
                $idact = Crypt::decrypt($request->idact);
                $idus = Crypt::decrypt($request->idus);
                
                $actasaudit = DB::table('notifications as n')->select('u.name', 'u.surname', 'u.email', 'u.mobile','n.*')->join('users as u', 'u.id', '=', 'n.id_us')->where('n.id_act', $idact)->count();
                if($actasaudit > 0)
                {
                    $array = json_encode(DB::table('notifications as n')->select('u.name', 'u.surname', 'u.email', 'u.mobile','n.*')->join('users as u', 'u.id', '=', 'n.id_us')->where('n.id_act', $idact)->get());
                }
                return response()->json(['status' => "ok", "idact" => $idact, "idus" => $idus, "html" => $array ], 200);

            break;
            case ($request->tipo == 'temas' ):
                $array = array();
                $idact = Crypt::decrypt($request->idacta);
                $idus = Crypt::decrypt($request->idus);
                $idhis = $request->idhis;
                $html = "";
                $hist = DB::table('actashistorial')->select('*')->where('id', $idhis)->count();
                switch (true) 
                {
                    case ($hist == 1):
                        $hist = DB::table('actashistorial')->select('*')->where('id', $idhis)->first();
                        $temp = $hist->temas;
                        if($temp != null || $temp != '')
                        {
                            DB::table('actashistorial')->select('*')->where('id', $idhis)->update(['temas' => $temp.'<br>'.$request->tema.' ('.$hist->nombreaudit.'*****'.date('d-m-Y H:i:s').')', 'fechatemas' =>  date('Y-m-d H:i:s') ]);
                        }
                        else
                        {
                            DB::table('actashistorial')->select('*')->where('id', $idhis)->update(['temas' => $request->tema.' ('.$hist->nombreaudit.'*****'.date('d-m-Y H:i:s').')', 'fechatemas' =>  date('Y-m-d H:i:s') ]);
                        }
                        
                        $hist = DB::table('actashistorial')->select('*')->where('idacta', $idact)->get();
                        
                        
                        return response()->json(['status' => "ok", "idact" => $idact, "idus" => $idus, 'html' => json_encode($hist) ], 200);

                    break;
                    
                    default:
                        return response()->json(['status' => "error", "idact" => $idact, "idus" => $idus ], 200);
                    break;
                }
                
                

            break;
            case ($request->tipo == 'acuerdos' ):
                $array = array();
                $idact = Crypt::decrypt($request->idacta);
                $idus = Crypt::decrypt($request->idus);
                $idhis = $request->idhis;
                $html = "";
                $hist = DB::table('actashistorial')->select('*')->where('id', $idhis)->count();
                switch (true) 
                {
                    case ($hist == 1):
                        $hist = DB::table('actashistorial')->select('*')->where('id', $idhis)->first();
                        $temp = $hist->acuerdos;
                        if($temp != null || $temp != '')
                        {
                            DB::table('actashistorial')->select('*')->where('id', $idhis)->update(['acuerdos' => $temp.'<br>'.$request->tema.' ('.$hist->nombreaudit.'*****'.date('d-m-Y H:i:s').')', 'fechaacuerdos' =>  date('Y-m-d H:i:s') ]);
                        }
                        else
                        {
                            DB::table('actashistorial')->select('*')->where('id', $idhis)->update(['acuerdos' => $request->tema.' ('.$hist->nombreaudit.'*****'.date('d-m-Y H:i:s').')', 'fechaacuerdos' =>  date('Y-m-d H:i:s') ]);
                        }
                        
                        $hist = DB::table('actashistorial')->select('*')->where('idacta', $idact)->get();
                        
                        
                        return response()->json(['status' => "ok", "idact" => $idact, "idus" => $idus, 'html' => json_encode($hist) ], 200);

                    break;
                    
                    default:
                        return response()->json(['status' => "error", "idact" => $idact, "idus" => $idus ], 200);
                    break;
                }
                
                

            break;
            case ($request->tipo == 'compromisos' ):
                $array = array();
                $idact = Crypt::decrypt($request->idacta);
                $idus = Crypt::decrypt($request->idus);
                $idhis = $request->idhis;
                $html = "";
                $hist = DB::table('actashistorial')->select('*')->where('id', $idhis)->count();
                switch (true) 
                {
                    case ($hist == 1):
                        $hist = DB::table('actashistorial')->select('*')->where('id', $idhis)->first();
                        $temp = $hist->compromisos;
                        if($temp != null || $temp != '')
                        {
                            DB::table('actashistorial')->select('*')->where('id', $idhis)->update(['compromisos' => $temp.'<br>'.$request->tema.' ('.$hist->nombreaudit.'*****'.date('d-m-Y H:i:s').')', 'fechacompromisos' =>  date('Y-m-d H:i:s') ]);
                        }
                        else
                        {
                            DB::table('actashistorial')->select('*')->where('id', $idhis)->update(['compromisos' => $request->tema.' ('.$hist->nombreaudit.'*****'.date('d-m-Y H:i:s').')', 'fechacompromisos' =>  date('Y-m-d H:i:s') ]);
                        }
                        
                        $hist = DB::table('actashistorial')->select('*')->where('idacta', $idact)->get();
                        
                        
                        return response()->json(['status' => "ok", "idact" => $idact, "idus" => $idus, 'html' => json_encode($hist) ], 200);

                    break;
                    
                    default:
                        return response()->json(['status' => "error", "idact" => $idact, "idus" => $idus ], 200);
                    break;
                }
                
                

            break;
            case ($request->tipo == 'respuestaemail' ):
                $array = array();
                $idact = $request->idmens;
                $mensaje = $request->mensaje;

                $mens = DB::table('notifications as n')->select('n.*')->where('n.id', $idact)->count();

                if($mens > 0)
                {

                    $mens = DB::table('notifications as n')->select('n.*')->where('n.id', $idact)->first();

                    $text = $mens->respuesta.'*%%%%%%*'.$request->mensaje.'---*('.Auth::user()->name.' '.Auth::user()->surname.' '.date('d-m-Y H:i:s').')%%*********************************%%';

                    $mens = DB::table('notifications as n')->select('n.*')->where('n.id', $idact)->update(["n.respuesta" => $text]);

                    return response()->json(['status' => "ok", "idact" => $request->idmensresp ], 200);

                }
                return response()->json(['status' => "error", "idact" => $request->idmensresp ], 200);

            break;

            case ($request->tipo == 'imprimir'):

                $fechaini = date('d-m-Y H:i:s');

                $fechater = date('d-m-Y H:i:s');

                $fechareu = date('d-m-Y H:i:s');

                $porcentaje = 0;

                $numaudit = 0;

                $evaluado = 0;

            
                $idacta = Crypt::decrypt($request->idact);

                $actas = DB::table('actas')->where('id', $idacta )->first();

                if($actas->fecha_ini != null || $actas->fecha_ini != '')
                {
                    $fechaini = date('d-m-Y H:i:s', strtotime($actas->fecha_ini));
                }
                if($actas->fecha_ter != null || $actas->fecha_ter != '')
                {
                    $fechater = date('d-m-Y H:i:s', strtotime($actas->fecha_ter));
                }
                if($actas->fecha_reu != null || $actas->fecha_reu != '')
                {
                    $fechareu = date('d-m-Y H:i:s', strtotime($actas->fecha_reu));
                }

                $answers = DB::table('answers')->where('id_post', $actas->id_proy )->first();

                $auditores = DB::table('actasadit as aa')->join('actashistorial as ah', 'aa.id', '=', 'ah.idaudit')->join('users as u', 'u.id', '=', 'ah.idusers')->where(['aa.idacta' => $idacta, 'aa.status' => 'si' ])->get();
                
                $personal = DB::table('actashistorial as ah')->where(['idacta' => $idacta, 'idusers' => Auth::user()->id ])->first();

                foreach($auditores as $aud)
                {
                    $porcentaje = $aud->porcentaje + $porcentaje;
                    $numaudit++;
                }
                if($porcentaje > 0)
                {
                    $evaluado = round($porcentaje/$numaudit, 0, PHP_ROUND_HALF_UP);
                }

                
                //$pdf = PDF::loadView('pdfs/actas');
                
                //return response()->json(['status' => $pdf], 200);
                //return $pdf->download('Formulario.pdf');
            
                $pdf = \PDF::loadView('pdfs/actas', [ "fechaini" => $fechaini, "fechater" => $fechater, "fechareu" => $fechareu, "evaluado" => $evaluado, "actas" => $actas, "auditores" => $auditores, "personal" => $personal, "nombre" => Auth::user()->name.' '.Auth::user()->surname, "email" => Auth::user()->email, "mobile" => Auth::user()->mobile, "answers" => $answers ]);

                // Opciones adicionales (opcional)
                 $pdf->setPaper('A4', 'portrait');

                // Descargar el PDF
                //return $pdf->download('factura.pdf');
                //dd($pdf->download('factura.pdf'));
                // También puedes mostrarlo en el navegador:
                 //return $pdf->stream('factura.pdf');

                // O guardarlo en el servidor:
                $pdf->save(storage_path('app/public/pruebapdf.pdf'));

                $archivo = base64_encode($pdf->output());

                $var1 = "ok";

                return response()->json(['status' => "ok", "pdf" => $archivo, "mensaje" => $var1 ], 200);


            break;

            case ($request->tipo == 'configurar'):

                $idansw = Crypt::decrypt($request->idansw);

                $idacta = Crypt::decrypt($request->idacta);

                $fechaini = date('Y-m-d H:i:s', strtotime($request->fechainiconfig));

                $fechafin = date('Y-m-d H:i:s', strtotime($request->fechafinconfig));
                
                $fechareu = date('Y-m-d H:i:s', strtotime($request->fechareuconfig));
        
                $porcen = $request->porcentaje; 

                $actaud = DB::table('actasadit')->where(['idacta' =>  $idacta])->count();

                switch (true) {
                    case ($actaud == 0):

                        return redirect()->route('ver-actas-formulario-docente-concurso-seleccionado', $request->idansw)->with('danger', trans('multi-new.0153'));

                    break;
                    case ($actaud > 0):

                        $acta = DB::table('actas')->where('id', $idacta)->update([

                            'fecha_ini' => $fechaini, 'fecha_ter' => $fechafin, 'fecha_reu' => $fechareu, 'avance' => $porcen, 'status' => 'encurso'
        
                        ]);

                        $col = DB::table('actasadit')->where(['idacta' =>  $idacta, 'status' => 'si'])->distinct('idaudit')->get();

                        foreach($col as $c)
                        {
                            $auditor = DB::table('actashistorial')->where(['idacta' =>  $idacta, 'idusers' =>  $c->idaudit ])->count();

                            switch (true) 
                            {
                                case ($auditor == 0):

                                    $emailspenus = DB::table('users')->where('id', $c->idaudit)->first();

                                    $acta = DB::table('actashistorial')->insert([

                                        'idacta' => $idacta, 'idaudit' => $c->id, 'nombreaudit' => $emailspenus->name.' '.$emailspenus->surname, 'idusers' => $emailspenus->id
                    
                                    ]);
                                    $datos = [
                                        'id_us' => Auth::user()->id, 'id_act' => $idacta, 'asunto' => "Fecha de revisión acta", 'mensaje' => $c->idaudit, 'tipo' => 'fechainicialactaaudit',
                                        'nombredocente' => Auth::user()->name.' '.Auth::user()->surname, 'emaildocente' => Auth::user()->email, 'telaudit' => Auth::user()->mobile, "fecharev" => date('d-m-Y H:i:s', strtotime($request->fechareuconfig))
                                    ];
                                    
                                    $jsonData = json_encode($datos);
                    
                                    $emailjob = DB::table('emailjobs')->insert([
                    
                                        'contenido' => $jsonData, 'template' => 'newnotificationasesoracta', 'status' => 0
                    
                                    ]);
                                break;
                                
                            }

                            
                        }

                        $col = DB::table('actashistorial')->where(['idacta' =>  $idacta, 'idusers' => Auth::user()->id])->count();

                        if($col == 0)
                        {
                            $acta = DB::table('actashistorial')->insert([

                                'idacta' => $idacta, 'idusers' => Auth::user()->id, 'nombreaudit' => Auth::user()->name.' '.Auth::user()->surname
            
                            ]);
                        }

                        $datos = [
                            'id_us' => Auth::user()->id, 'id_act' => $idacta, 'asunto' => "Fecha de revisión acta", 'mensaje' => "", 'tipo' => 'fechainicialactaaudit',
                            'nombredocente' => Auth::user()->name.' '.Auth::user()->surname, 'emaildocente' => Auth::user()->email, 'telaudit' => Auth::user()->mobile, "fecharev" => date('d-m-Y H:i:s', strtotime($request->fechareuconfig))
                        ];
                        
                        $jsonData = json_encode($datos);
        
                        $emailjob = DB::table('emailjobs')->insert([
        
                            'contenido' => $jsonData, 'template' => 'newnotificationdocenteacta', 'status' => 0
        
                        ]);

                        return redirect()->route('ver-actas-formulario-docente-concurso-seleccionado', $request->idansw)->with('success', trans('multi-new.0153'));

                    break;
                    
                    default:
                        return redirect()->route('ver-actas-formulario-docente-concurso-seleccionado', $request->idansw)->with('danger', 'Se ha producido un error al procesar su solicitud');
                    break;
                }

               

            break;
            
            default:

                return response()->json(['status' => "error"], 500);

            break;
        }
        
        
    }

    public function veractdochis($id = null)
    {
        $idacta = Crypt::decrypt($id);

        $acta = DB::table('actas')->where(['id' =>  $idacta])->count();

        switch (true) 
        {
            case ($acta > 0):

                $acta = DB::table('actas')->where(['id' =>  $idacta])->first();
                $answ = Answers::select('idansw', 'id_post', 'preg1et1', 'preg2et1')->where('id_post', $acta->id_proy)->orderBy('idansw', 'asc')->count();
                switch (true) 
                {
                    case ($answ > 0):

                        $answ = Answers::select('idansw', 'id_post', 'preg1et1', 'preg2et1')->where('id_post', $acta->id_proy)->orderBy('idansw', 'asc')->first();

                        $post = Postulations::where(['idpost' =>  $answ->id_post])->count();

                        switch (true) 
                        {
                            case ($post == 1):

                                $act = "sininfo";

                                $post = Postulations::where(['idpost' =>  $answ->id_post])->first();

                                $actasini = DB::table('actas')->where(['id' => $idacta] )->count();

                                $sumglobal = 0;

                                $arreglo = array();

                                $defansw = array();

                                $actas = array();

                                $auditores = array();

                                $personal = array();

                                $newhist = array();

                                $fechaini = date('Y-m-d H:i:s');

                                $fechater = date('Y-m-d H:i:s');

                                $fechareu = date('Y-m-d H:i:s');

                                $porcentaje = 0;

                                $numaudit = 0;

                                $evaluado = 0;

                                $resumenactas = "";

                                $resumenacuerdos = "";

                                $resumencompromisos = "";

                                $idantiguasactas = [];
                                
                                //$actascreada = DB::table('actas')->where(['id_proy' => $answ->id_post, 'status' => 'creada'] )->count();

                                //$actasencurso = DB::table('actas')->where(['id_proy' => $answ->id_post, 'status' => 'encurso'] )->count();

                                //$actashistorico = DB::table('actas')->where(['id_proy' => $answ->id_post, 'status' => 'histrorico'] )->count();

                                //$actasfinalizada = DB::table('actas')->where(['id_proy' => $answ->id_post, 'status' => 'finalizada'] )->count();

                                switch (true) 
                                {
                                    case ($actasini  == 1):

                                        $actasini = DB::table('actas')->where(['id' => $idacta] )->first();
                                        
                                        $arreglo = DB::table('actas')
                                        ->join('actasadit', 'actas.id', '=', 'actasadit.idacta')
                                        ->where(['actasadit.status' => 'si', 'actas.id' => $actasini->id])
                                        ->count();
                                        
                                        switch (true) 
                                        {
                                            case ($arreglo == 0):
                                                

                                                return view('docentes.postulaciones.veractas', ["id" => $id, "actas" => $actas, "act" => $act, "count" => count($arreglo), "arreglo" => $arreglo, 'value' => 0, 'idconc' => Crypt::encrypt($post->idconc), 'defansw' => $answ, 'statusacta' => 'sinasesores', 'fechaini' => $fecha_ini, 'fechater' => $fechater, 'fechareu' => $fechareu, "auditores" => $auditores, "personal" => $personal, "porcentaje" => $porcentaje, "evaluado" => $evaluado, "resumenactas" => $resumenactas, "resumenacuerdos" => $resumenacuerdos, "resumencompromisos" => $resumencompromisos, "newhist" => $newhist, 'sumglobal' => (100 - $sumglobal), 'idantiguasactas' => $idantiguasactas ]);

                                            break;

                                            case ($arreglo > 0):

                                                $arreglo = DB::table('actas')->where(['id' => $actasini->id])->orderBy('id', 'asc')->first();

                                                if($arreglo->fecha_ini != null || $arreglo->fecha_ini != '')
                                                {
                                                    $fechaini = date('Y-m-d\TH:i:s', strtotime($arreglo->fecha_ini));
                                                }
                                                if($arreglo->fecha_ter != null || $arreglo->fecha_ter != '')
                                                {
                                                    $fechater = date('Y-m-d\TH:i:s', strtotime($arreglo->fecha_ter));
                                                }
                                                if($arreglo->fecha_reu != null || $arreglo->fecha_reu != '')
                                                {
                                                    $fechareu = date('Y-m-d\TH:i:s', strtotime($arreglo->fecha_reu));
                                                }

                                                $auditores = DB::table('actasadit as aa')->join('actashistorial as ah', 'aa.id', '=', 'ah.idaudit')->join('users as u', 'u.id', '=', 'ah.idusers')->where(['aa.idacta' => $actasini->id, 'aa.status' => 'si' ])->get();

                                                $newhist = DB::table('actashistorial as ah')->where(['idacta' => $actasini->id])->get();
                                                    
                                                $personal = DB::table('actashistorial as ah')->where(['idacta' => $actasini->id, 'idusers' => Auth::user()->id ])->first();
                                                
                                                if($personal->temas != '' || $personal->temas != null)
                                                {
                                                    $resumenactas .= $personal->temas;
                                                }
                                                if($personal->acuerdos != '' || $personal->acuerdos != null)
                                                {
                                                    $resumenacuerdos .= '\n************************\n'.$personal->acuerdos.' ('.$personal->nombreaudit.' - '.$personal->fechaacuerdos.')\n************************\n';
                                                }
                                                if($personal->compromisos != '' || $personal->compromisos != null)
                                                {
                                                    $resumencompromisos .= '\n************************\n'.$personal->compromisos.' ('.$personal->nombreaudit.' - '.$personal->fechacompromisos.')\n************************\n';
                                                }
                                                
                                                foreach($auditores as $aud)
                                                {
                                                    if($aud->temas != '' || $aud->temas != null)
                                                    {
                                                        $resumenactas .= '<br>************************\n'.$aud->temas.' ('.$aud->nombreaudit.' - '.$aud->fechatemas.')\n************************\n';
                                                    }
                                                    if($aud->acuerdos != '' || $aud->acuerdos != null)
                                                    {
                                                        $resumenacuerdos .= '\n************************\n'.$aud->acuerdos.' ('.$aud->nombreaudit.' - '.$aud->fechaacuerdos.')\n************************\n';
                                                    }
                                                    if($aud->compromisos != '' || $aud->compromisos != null)
                                                    {
                                                        $resumencompromisos .= '\n************************\n'.$aud->compromisos.' ('.$aud->nombreaudit.' - '.$aud->fechacompromisos.')\n************************\n';
                                                    }
                                                    $porcentaje = $aud->porcentaje + $porcentaje;
                                                    $numaudit++;
                                                }
                                                if($porcentaje > 0)
                                                {
                                                    $evaluado = round($porcentaje/$numaudit, 0, PHP_ROUND_HALF_UP);
                                                }
                                                
                                                return view('docentes.postulaciones.veractashistorial', ["id" => $id, "actas" => $actas, "act" => $act, "count" => 0, "arreglo" => $arreglo, 'value' => 0, 'idconc' => Crypt::encrypt($post->idconc), 'defansw' => $answ, 'statusacta' => $arreglo->status, 'fechaini' => $fechaini, 'fechater' => $fechater, 'fechareu' => $fechareu, "auditores" => $auditores, "personal" => $personal, "porcentaje" => $porcentaje, "evaluado" => $evaluado, "resumenactas" => $resumenactas, "resumenacuerdos" => $resumenacuerdos, "resumencompromisos" => $resumencompromisos, "newhist" => $newhist, 'sumglobal' => (100 - $sumglobal), 'idantiguasactas' => $idantiguasactas ]);

                                            break;

                                            
                                            
                                            default:
                                                abort(404);
                                            break;
                                        }

                                        

                                    break;
                                    case ($actasini  > 1):

                                        

                                        $actasini = DB::table('actas')->where(['id_proy' => $answ->id_post] )->orderBy('id', 'desc')->first();

                                        $actasantiguas = DB::table('actas')->where('id_proy', $answ->id_post)->where('id', '!=', $actasini->id)->get();
                                        foreach($actasantiguas as $cont)
                                        {
                                            $sumglobal = $sumglobal + $cont->avance;
                                            $idantiguasactas[] = $cont->id;
                                            $idantiguasactas[] = date('d-m-Y H:i:s', strtotime($cont->fecha_ini));
                                            $idantiguasactas[] = date('d-m-Y H:i:s', strtotime($cont->fecha_ter));
                                        }
                                        
                                        $arreglo = DB::table('actas')
                                        ->join('actasadit', 'actas.id', '=', 'actasadit.idacta')
                                        ->where(['actasadit.status' => 'si', 'actas.id' => $actasini->id])
                                        ->count();
                                        switch (true) 
                                        {
                                            case ($arreglo == 0):
                                                

                                                return view('docentes.postulaciones.veractas', ["id" => $id, "actas" => $actas, "act" => $act, "count" => count($arreglo), "arreglo" => $arreglo, 'value' => 0, 'idconc' => Crypt::encrypt($post->idconc), 'defansw' => $answ, 'statusacta' => 'sinasesores', 'fechaini' => $fecha_ini, 'fechater' => $fechater, 'fechareu' => $fechareu, "auditores" => $auditores, "personal" => $personal, "porcentaje" => $porcentaje, "evaluado" => $evaluado, "resumenactas" => $resumenactas, "resumenacuerdos" => $resumenacuerdos, "resumencompromisos" => $resumencompromisos, "newhist" => $newhist, 'sumglobal' => (100 - $sumglobal), 'idantiguasactas' => $idantiguasactas ]);

                                            break;

                                            case ($arreglo > 1):

                                                $arreglo = DB::table('actas')->where(['id' => $actasini->id])->orderBy('id', 'desc')->first();

                                                if($arreglo->fecha_ini != null || $arreglo->fecha_ini != '')
                                                {
                                                    $fechaini = date('Y-m-d\TH:i:s', strtotime($arreglo->fecha_ini));
                                                }
                                                if($arreglo->fecha_ter != null || $arreglo->fecha_ter != '')
                                                {
                                                    $fechater = date('Y-m-d\TH:i:s', strtotime($arreglo->fecha_ter));
                                                }
                                                if($arreglo->fecha_reu != null || $arreglo->fecha_reu != '')
                                                {
                                                    $fechareu = date('Y-m-d\TH:i:s', strtotime($arreglo->fecha_reu));
                                                }

                                                $auditores = DB::table('actasadit as aa')->join('actashistorial as ah', 'aa.id', '=', 'ah.idaudit')->join('users as u', 'u.id', '=', 'ah.idusers')->where(['aa.idacta' => $actasini->id, 'aa.status' => 'si' ])->get();

                                                $newhist = DB::table('actashistorial as ah')->where(['idacta' => $actasini->id])->get();
                                                    
                                                $personal = DB::table('actashistorial as ah')->where(['idacta' => $actasini->id, 'idusers' => Auth::user()->id ])->first();
                                                
                                                if($personal->temas != '' || $personal->temas != null)
                                                {
                                                    $resumenactas .= $personal->temas;
                                                }
                                                if($personal->acuerdos != '' || $personal->acuerdos != null)
                                                {
                                                    $resumenacuerdos .= '\n************************\n'.$personal->acuerdos.' ('.$personal->nombreaudit.' - '.$personal->fechaacuerdos.')\n************************\n';
                                                }
                                                if($personal->compromisos != '' || $personal->compromisos != null)
                                                {
                                                    $resumencompromisos .= '\n************************\n'.$personal->compromisos.' ('.$personal->nombreaudit.' - '.$personal->fechacompromisos.')\n************************\n';
                                                }
                                                
                                                foreach($auditores as $aud)
                                                {
                                                    if($aud->temas != '' || $aud->temas != null)
                                                    {
                                                        $resumenactas .= '<br>************************\n'.$aud->temas.' ('.$aud->nombreaudit.' - '.$aud->fechatemas.')\n************************\n';
                                                    }
                                                    if($aud->acuerdos != '' || $aud->acuerdos != null)
                                                    {
                                                        $resumenacuerdos .= '\n************************\n'.$aud->acuerdos.' ('.$aud->nombreaudit.' - '.$aud->fechaacuerdos.')\n************************\n';
                                                    }
                                                    if($aud->compromisos != '' || $aud->compromisos != null)
                                                    {
                                                        $resumencompromisos .= '\n************************\n'.$aud->compromisos.' ('.$aud->nombreaudit.' - '.$aud->fechacompromisos.')\n************************\n';
                                                    }
                                                    $porcentaje = $aud->porcentaje + $porcentaje;
                                                    $numaudit++;
                                                }
                                                if($porcentaje > 0)
                                                {
                                                    $evaluado = round($porcentaje/$numaudit, 0, PHP_ROUND_HALF_UP);
                                                }
                                                
                                                return view('docentes.postulaciones.veractas', ["id" => $id, "actas" => $actas, "act" => $act, "count" => 0, "arreglo" => $arreglo, 'value' => 0, 'idconc' => Crypt::encrypt($post->idconc), 'defansw' => $answ, 'statusacta' => $arreglo->status, 'fechaini' => $fechaini, 'fechater' => $fechater, 'fechareu' => $fechareu, "auditores" => $auditores, "personal" => $personal, "porcentaje" => $porcentaje, "evaluado" => $evaluado, "resumenactas" => $resumenactas, "resumenacuerdos" => $resumenacuerdos, "resumencompromisos" => $resumencompromisos, "newhist" => $newhist, 'sumglobal' => (100 - $sumglobal), 'idantiguasactas' => $idantiguasactas ]);

                                            break;

                                            
                                            
                                            default:
                                                abort(404);
                                            break;
                                        }
                                    break;
                                    default:

                                        abort(404);
                                        
                                    break;
                                }
                            break;

                            default:

                                abort(404);

                            break;
                        }
                    break;
                    
                    default:
                        abort(404);
                    break;
                }
            break;
            
            default:
                abort(404);
            break;
        }

        
    }
}