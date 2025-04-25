<?php



namespace App\Http\Controllers\Auditor;



use App\Http\Controllers\Controller;

use App\Http\Requests\StorePostRequest;

use App\Http\Requests\UpdatePostRequest;

use App\Answers;

use App\AnswersDirector;

use App\DetailsResources;

use App\AnswersFiles;

use App\Categoryblog;

use App\User;

use App\Post;

use App\Tagblog;

use App\TagsComp;

use App\PostTag;

use App\Commentblog;

use App\CategoriesCompetitions;

use App\Postulations;

use App\Competitions;

use App\FilesCompetitions;

use App\CompetitionsTags;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Intervention\Image\Facades\Image as Image;

use Symfony\Component\HttpFoundation\Response;

use Illuminate\Http\JsonResponse;

use App\Mail\EmailNewActas;

use App\Mail\EmailNotifications;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Str;

use File;

use Crypt;

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

        $this->middleware(['role:auditor|admin']);

    }

    public function actestaudprosel(Request $request)
    {
        $iduser = Crypt::decrypt($request->iduser);
        $idpost = Crypt::decrypt($request->idpost);
        $status = $request->status;

        $idactas = DB::table('actas')->where([
            'id_proy' => $idpost
        ])->count();

        switch (true) 
        {
            case ($idactas == 0):

                $idactas = $this->addactas($idpost);

                switch (true) 
                {
                    case ($idactas > 0):

                        $idaudit = DB::table('actasadit')->where([
                            'idacta' => $idactas, "idaudit" => $iduser
                        ])->count();

                        switch (true) 
                        {
                            case ($idaudit == 0):

                                $idaudit = $this->addactasaudit($idactas, $iduser, $status, $idaudit);

                                switch (true) 
                                {
                                    case ($idaudit > 0):

                                        return response()->json(['status' => "error", "iduser" => "addauditor", "idpost" => $idpost, "statusact" => $status]);

                                    break;
                                    
                                    default:

                                        return response()->json(['status' => "error", "iduser" => "erroraddauditor", "idpost" => $idpost, "statusact" => $status]);

                                    break;
                                }
                            break;
                            case ($idaudit == 1):

                                $idaudit = $this->addactasaudit($idactas, $iduser, $status, $idaudit);

                                switch (true) 
                                {
                                    case ($idaudit > 0):

                                        return response()->json(['status' => "error", "iduser" => "updateauditor", "idpost" => $idpost, "statusact" => $status]);

                                    break;
                                    
                                    default:

                                        return response()->json(['status' => "error", "iduser" => "errorupdateauditor", "idpost" => $idpost, "statusact" => $status]);

                                    break;
                                }
                            break;
                            
                            default:

                                return response()->json(['status' => "error", "iduser" => "erroridauditor", "idpost" => $idpost, "statusact" => $status]);

                            break;
                        }
                        
                        
                    break;
                    
                    default:

                        return response()->json(['status' => "error", "iduser" => "nosecreaacta", "idpost" => $idpost, "statusact" => $status]);

                    break;
                }
                
            break;
            case ($idactas == 1):

                $idaudit = DB::table('actasadit')->where([
                    'idacta' => $idactas, "idaudit" => $iduser
                ])->count();

                switch (true) 
                {
                    case ($idaudit == 0):

                        $idaudit = $this->addactasaudit($idactas, $iduser, $status, $idaudit);

                        switch (true) 
                        {
                            case ($idaudit > 0):

                                return response()->json(['status' => "error", "iduser" => "addauditor", "idpost" => $idpost, "statusact" => $status]);

                            break;
                            
                            default:

                                return response()->json(['status' => "error", "iduser" => "erroraddauditor", "idpost" => $idpost, "statusact" => $status]);

                            break;
                        }
                    break;
                    case ($idaudit == 1):

                        $idaudit = $this->addactasaudit($idactas, $iduser, $status, $idaudit);

                        switch (true) 
                        {
                            case ($idaudit > 0):

                                return response()->json(['status' => "error", "iduser" => "updateauditor", "idpost" => $idpost, "statusact" => $status]);

                            break;
                            
                            default:

                                return response()->json(['status' => "error", "iduser" => "errorupdateauditor", "idpost" => $idpost, "statusact" => $status]);

                            break;
                        }
                    break;
                    
                    default:

                        return response()->json(['status' => "error", "iduser" => "erroridauditor", "idpost" => $idpost, "statusact" => $status]);

                    break;
                }

            break;
            case ($idactas > 1):

                return response()->json(['status' => "error", "iduser" => "masdeunaacta", "idpost" => $idpost, "statusact" => $status]);

            break;
            
            default:

                return response()->json(['status' => "error", "iduser" => "instanciaactas", "idpost" => $idpost, "statusact" => $status]);

            break;
        }

        
    }
    public function busconselaud()
    {
        $idaudit = DB::table('competitions')
        ->select('competitions.idcomp', 'competitions.title', 'competitions.created_at', 'catcomp.namecat', 'u.name', 'u.surname' )
        ->join('categoriesCompetitions as catcomp', 'competitions.category_id', '=', 'catcomp.idcatcom')
        ->join('users as u', 'competitions.created_by', '=', 'u.id')
        ->where([
            'competitions.statuspos' => "seleccionados"
        ])->get();
        
        return view('auditor.postulaciones.asignaciones', ['array1' => $idaudit ]);
    }
    public function verasiaudidpos($id = null)
    {
        $id = Crypt::decrypt($id);

        $array = array();


        $idaudit = DB::table('competitions')
        ->select('competitions.idcomp', 'competitions.title', 'competitions.created_at', 'catcomp.namecat', 'u.name', 'u.surname', 'p.*', 'a.id as idactas' )
        ->join('categoriesCompetitions as catcomp', 'competitions.category_id', '=', 'catcomp.idcatcom')
        ->join('users as u', 'competitions.created_by', '=', 'u.id')
        ->join('postulations as p', 'competitions.idcomp', '=', 'p.idconc')
        ->join('actas as a', 'p.idpost', '=', 'a.id_proy')
        ->join('actasadit as audit', 'a.id', '=', 'audit.idacta')
        ->where([
            'competitions.idcomp' => $id,
            'audit.status' => 'si',
            'audit.idaudit' => Auth::user()->id
        ])->count();

        switch (true) 
        {
            case ($idaudit > 0):

                $idaudit = DB::table('competitions')
                ->select('competitions.idcomp', 'competitions.title', 'competitions.created_at', 'catcomp.namecat', 'u.name', 'u.surname', 'p.*', 'a.id as idactas', 'a.fecha_ini as fi', 'a.fecha_ter as ft' )
                ->join('categoriesCompetitions as catcomp', 'competitions.category_id', '=', 'catcomp.idcatcom')
                ->join('postulations as p', 'competitions.idcomp', '=', 'p.idconc')
                ->join('actas as a', 'p.idpost', '=', 'a.id_proy')
                ->join('users as u', 'p.idus', '=', 'u.id')
                ->join('actasadit as audit', 'a.id', '=', 'audit.idacta')
                ->where([
                    'competitions.idcomp' => $id,
                    'audit.status' => 'si',
                    'audit.idaudit' => Auth::user()->id
                ])->get();

                foreach($idaudit as $row)
                {
                   $answers = DB::table('answers')->where( [ 'id_post' => $row->idpost] )->orderBy('idansw', 'asc')->first();
                   if($row->fi == '' || $row->fi == null)
                   {
                        $fechaini = "Sin Inicio de Acta";
                   }
                   else
                   {
                        $fechaini = date('d-m-Y H:i:s', strtotime($row->fi));
                   }
                   if($row->ft == '' || $row->ft == null)
                   {
                        $fechater = "Sin Cierre de Acta";
                   }
                   else
                   {
                        $fechater = date('d-m-Y H:i:s', strtotime($row->ft));
                   }
                   array_push($array, array( 'idacta' => Crypt::encrypt($row->idactas), 'nombre' => $row->name.' '.$row->surname, 'titproy' => $answers->preg1et1, 'fecha_ini' => $fechaini, 'fecha_ter' => $fechater, 'idansw' => Crypt::encrypt($answers->idansw) ));

                   $nombre = $row->title;
                  
                }
                return view('auditor.postulaciones.asignacionesactivas', ['array1' => $array, "nombrecom" => $nombre, 'idcomp' => Crypt::encrypt($id), 'idaudit' => $idaudit->count() ]);
                
            break;
            case ($idaudit == 0):

                $idaudit = DB::table('competitions')
                ->select('competitions.idcomp', 'competitions.title')
                ->where([
                    'competitions.idcomp' => $id,
                ])->count();
                switch (true) 
                {
                    case ($idaudit > 0):
                        
                        $idaudit = DB::table('competitions')
                        ->select('competitions.idcomp', 'competitions.title')
                        ->where([
                            'competitions.idcomp' => $id,
                        ])->first();
                        array_push($array, array( 'idacta' => Crypt::encrypt(0), 'title' => '', 'nombre' => '', 'titproy' => '', 'fecha_ini' => '', 'fecha_ter' => '', 'idansw' => Crypt::encrypt(0), 'idcomp' =>  Crypt::encrypt($id) ));
                        
                        return view('auditor.postulaciones.asignacionesactivas', ['array1' => $array, "nombrecom" => $idaudit->title, 'idcomp' => Crypt::encrypt($id), 'idaudit' => "sinasignaciones" ]);
                    break;
                    
                    default:
                        abort(403);
                    break;
                }
            break;
            
            default:
                abort(403);
            break;
        }
    }
    public function verfordocconfinact($id = null)
    {

        $array1 = array();

        $id = Crypt::decrypt($id);
        
        $actas = DB::table('actas')->where('id_proy', $id)->count();

        $answ = DB::table('answers')->where('id_post', $id)->count();
        
        switch (true) 
        {
            case ($actas == 0 && $answ == 0): //no existen actas y tampoco respuestas al formulario evaluado error

                abort(404);

            break;
            case ($answ > 0): //existen actas, y respuesta al formulario evaluado ok

                switch (true) 
                {
                    case ($answ == 0):

                        return view('auditor.postulaciones.veractas', ["statusacta" => "crearacta"]);

                    break;   
                    case ($answ > 0):

                        $answ = DB::table('answers as an')->select('an.idansw', 'an.id_post', 'an.preg1et1', 'an.preg2et1', 'u.*')
                        ->join('postulations as p', 'an.id_post', '=', 'p.idpost')
                        ->join('users as u', 'p.idus', '=', 'u.id')
                        ->where('an.id_post', $id)->orderBy('an.idansw', 'asc')->first();
                       
                        $post = Postulations::where(['idpost' =>  $answ->id_post])->count();

                        switch (true) 
                        {
                            case ($post == 1):
                                $actasadit = array();

                                $auditores = array();

                                $idansw = $answ->idansw;

                                $sumglobal = 0;

                                $arreglo = array();

                                $defansw = array();

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

                                $display = 'block';

                                $disabled = '';

                                $contaux = 0;

                                $sumaux = 0;

                                $totaux = 0;

                                $avanceaux = 0;

                                

                                

                                switch (true) 
                                {
                                    case ($actas == 0):

                                        $post = Postulations::where(['idpost' =>  $answ->id_post])->first();

                                        return view('auditor.postulaciones.veractas', ["statusacta" => "crearacta", "idconc" => Crypt::encrypt($post->idconc), "idansw" => Crypt::encrypt($id), 'actas' => $actas, 'defansw' => $defansw, 'evaluado' => $evaluado, 'arreglo' => $arreglo, 'newhist' => $newhist, 'personal' => $personal, 'id' => $id, 'sumglobal' => (100 - $sumglobal), 'fechaini' => $fechaini, 'fechater' => $fechater, 'fechareu' => $fechareu, 'idansw' => Crypt::encrypt($id), 'idantiguasactas'=> $idantiguasactas, 'actasadit' => $actasadit, "avanceaux" => $avanceaux, 'display' => $display, 'disabled' => $disabled ]);

                                    break;
                                    case ($actas > 0):

                                        $actas = DB::table('actas')->where('id_proy', $id)->orderBy('id', 'desc')->first();
                                        
                                        $actasaditaux = DB::table('actasadit')->where(['idacta' => $actas->id, "status" => "si"])->get();

                                        foreach($actasaditaux as $row)
                                        {
                                            $temp = DB::table('actashistorial')->where(['idaudit' => $row->id ])->first();
                                            $sumaux = (int)$temp->porcentaje;
                                            $contaux++;
                                        }
                                        
                                        if($contaux > 0)
                                        {
                                            $totaux = round(($sumaux/$contaux), 0, PHP_ROUND_HALF_UP);
                                            
                                            $avanceaux = (int)round(($actas->avance*$totaux)/100, 0, PHP_ROUND_HALF_UP);
                                        }

                                        $defansw = Answers::select('answers.idansw as id', 'answers.id_post as idpost', 'answers.preg1et1 as titulo', 'u.name', 'u.surname', 'u.email', 'u.mobile', 'u.id', 'u.id as idus')
                                        ->join('postulations as p', 'p.idpost', '=', 'answers.id_post')
                                        ->join('users as u', 'p.idus', '=', 'u.id')
                                        ->where('answers.idansw', $answ->idansw)
                                        ->orderBy('answers.idansw', 'asc')
                                        ->first();

                                        $post = Postulations::where(['idpost' =>  $answ->id_post])->first();

                                        $actasini = DB::table('actas')->where(['id_proy' => $answ->id_post] )->orderBy('id', 'desc')->first(); //Acta a mostrar inicialmente

                                        switch (true) 
                                        {
                                            

                                            case ($actasini->status == "encurso"):

                                                
                                        
                                                $arreglo = DB::table('actas')->where(['id' => $actasini->id])->orderBy('id', 'desc')->first();
                                                
                                                $actasadit = DB::table('actasadit')
                                                ->select('idaudit', 'status', 'users.*')
                                                ->join('users','actasadit.idaudit', '=', 'users.id')
                                                ->where('idacta', $actasini->id)
                                                ->where('actasadit.status', "si")
                                                ->distinct('idaudit', 'status')
                                                ->get();
                                                
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

                                                $auditores = DB::table('actasadit as aa')->join('actashistorial as ah', 'aa.id', '=', 'ah.idaudit')->join('users as u', 'u.id', '=', 'ah.idusers')->where(['aa.idacta' => $actasini->id, 'aa.status' => 'si' ])->whereNotIn('aa.idaudit', [Auth::user()->id])->get();

                                                

                                                $temporal = [];

                                                if(count($auditores) > 0)
                                                {
                                                    $auditoresaux = DB::table('actasadit as aa')->select('aa.id')->join('actashistorial as ah', 'aa.id', '=', 'ah.idaudit')->join('users as u', 'u.id', '=', 'ah.idusers')->where(['aa.idacta' => $actasini->id, 'aa.status' => 'si' ])->whereNotIn('aa.idaudit', [Auth::user()->id])->get();
                                                    foreach($auditoresaux as $row)
                                                    {
                                                        $temporal[] = $row->id;
                                                    }
                                                }

                                                $temporal[] = $defansw->idus;

                                                $auditores = DB::table('actashistorial as ah')->where(['ah.idacta' => $actasini->id])->whereIn('ah.idusers', $temporal)->get();

                                                $newhist = DB::table('actashistorial as ah')->where(['idacta' => $actasini->id])->get();
                                                            
                                                $personal = DB::table('actashistorial as ah')->where(['idacta' => $actasini->id, "idusers" => Auth::user()->id])->first();
                                                   
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
                                                $actasantiguas = DB::table('actas')->where('id_proy', $answ->id_post)->where('id', '!=', $actasini->id)->get();
                                                foreach($actasantiguas as $cont)
                                                {
                                                    $sumglobal = $sumglobal + $cont->avance;
                                                    $idantiguasactas[] = $cont->id;
                                                    $idantiguasactas[] = date('d-m-Y H:i:s', strtotime($cont->fecha_ini));
                                                    $idantiguasactas[] = date('d-m-Y H:i:s', strtotime($cont->fecha_ter));
                                                }
                                                if($actasini->status == "finalizada" || $actasini->status == "cerrada")
                                                {
                                                    $display = "none";
                                                    $disabled = "disabled";
                                                }
                                                return view('auditor.postulaciones.veractas', ["statusacta" => $actasini->status, "idconc" => Crypt::encrypt($post->idconc), "idansw" => Crypt::encrypt($id), 'actas' => $actas, 'defansw' => $defansw, 'evaluado' => $evaluado, 'arreglo' => $arreglo, 'newhist' => $newhist, 'personal' => $personal, 'id' => $id, 'sumglobal' => (100 - $sumglobal), 'fechaini' => $fechaini, 'fechater' => $fechater, 'fechareu' => $fechareu, 'idansw' => Crypt::encrypt($id), 'idantiguasactas'=> $idantiguasactas, 'actasadit' => $actasadit, "avanceaux" => $avanceaux, 'display' => $display, 'disabled' => $disabled ]);
                                               
                                                //return view('admin.postulaciones.actas.veractas', ["statusacta" => "sinhistorial", "acciones" => 'mostrar', 'evaluado' => $evaluado, 'arreglo' => $arreglo, 'newhist' => $newhist, 'personal' => $personal, 'id' => $id, 'sumglobal' => (100 - $sumglobal), 'fechaini' => $fechaini, 'fechater' => $fechater, 'fechareu' => $fechareu, 'idansw' => Crypt::encrypt($id), 'defansw' => $answ, 'idantiguasactas'=> $idantiguasactas, 'actasadit' => $actasadit]);
                                                
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




        
        







        $idansw = Crypt::decrypt($id);
        
        $answ = Answers::select('idansw', 'id_post', 'preg1et1', 'preg2et1')->where('idansw', $idansw)->orderBy('idansw', 'asc')->count();

        $arreglo = array();

        $defansw = array();

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
                            case ($actas == 0):

                                $arrayactas = array();

                                $arrayactasext = array();

                                $act = "coninfo";

                                $text = "Actas asignadas al proyecto.";

                                return view('auditor.postulaciones.veractas', ["id" => $id, "text" => $text, "actas" => $actas, "act" => $act, "count" => count($arreglo), "arreglo" => $arreglo, 'value' => 0, 'idconc' => Crypt::encrypt($post->idconc), 'defansw' => $defansw ]);

                            break;
                            case ($actas == 1):

                                $actas = DB::table('actas')->where('id_proy', $answ->id_post )->get();

                                $defansw = Answers::select('answers.idansw as id', 'answers.id_post as idpost', 'answers.preg1et1 as titulo', 'u.name', 'u.surname', 'u.email', 'u.mobile', 'u.id')
                                ->join('postulations as p', 'p.idpost', '=', 'answers.id_post')
                                ->join('users as u', 'p.idus', '=', 'u.id')
                                ->where('answers.idansw', $idansw)
                                ->orderBy('answers.idansw', 'asc')
                                ->first();

                                $arrayactas = array();

                                $arrayactasext = array();

                                foreach($actas as $row)
                                {
                                    
                                    $arrayaudit = array();
                                    
                                    
                                    $actasaudit = DB::table('actasadit as ac')->select('*')->where( ['ac.idacta' => $row->id, 'ac.idaudit' => Auth::user()->id, 'ac.status' => 'si'] )->join('users as u', 'u.id', '=', 'ac.idaudit')->count();

                                    if($actasaudit > 0)
                                    {
                                        $actasaudit = DB::table('actasadit as ac')->select('*')->where( ['ac.idacta' => $row->id, 'ac.idaudit' => Auth::user()->id, 'ac.status' => 'si'] )->join('users as u', 'u.id', '=', 'ac.idaudit')->get();
                                        foreach($actasaudit as $adt)
                                        {
                                            $arrayhisto = array();

                                            $historial = DB::table('actashistorial as ah')->select('*')->where( ['ah.idaudit' => $adt->id, 'ah.idacta' => $row->id ] )->get();

                                            foreach($historial as $his)
                                            {
                                                array_push($arrayhisto, array('idaudit'=> $adt->id, 'nombreaudit' => $his->nombreaudit, 'status' => $his->status));
                                            }

                                            array_push($arrayaudit, array('idacta'=> $row->id, 'emailauditor' => $adt->email, 'mobauditor' => $adt->mobile, 'idauditor' => $adt->id, "nombreaudit" => $adt->name.' '.$adt->surname, 'status' => $adt->status));
                                        }
                                    }
                                    else
                                    {
                                        array_push($arrayaudit, array('idacta'=> $row->id, 'emailauditor' => "sininfo", 'mobauditor' => "sininfo", 'idauditor' => "sininfo", "nombreaudit" => "sininfo", 'status' => "sininfo"));
                                    }

                                    array_push($arrayactas, array("actas" => $row->id, "auditores" => $arrayaudit,  "historial" => $arrayhisto ) );
                                    
                                    $arrayauditext = array();

                                    $actasauditext = DB::table('actasadit as ac')->select('*')->where( ['ac.idacta' => $row->id] )->where('ac.idaudit', '!=', Auth::user()->id)->join('users as u', 'u.id', '=', 'ac.idaudit')->count();

                                    if($actasauditext > 0)
                                    {
                                        $actasauditext = DB::table('actasadit as ac')->select('*')->where( ['ac.idacta' => $row->id] )->where('ac.idaudit', '!=', Auth::user()->id)->join('users as u', 'u.id', '=', 'ac.idaudit')->get();
                                        foreach($actasauditext as $adt)
                                        {
                                            $arrayhistoext = array();

                                            $historialext = DB::table('actashistorial as ah')->select('*')->where( ['ah.idaudit' => $adt->id, 'ah.idacta' => $row->id ] )->get();

                                            foreach($historialext as $his)
                                            {
                                                array_push($arrayhistoext, array('idaudit'=> $adt->id, 'nombreaudit' => $his->nombreaudit, 'status' => $his->status));
                                            }

                                            array_push($arrayauditext, array('idacta'=> $row->id, 'emailauditor' => $adt->email, 'mobauditor' => $adt->mobile, 'idauditor' => $adt->id, "nombreaudit" => $adt->name.' '.$adt->surname, 'idauditor' => $adt->id, 'status' => $adt->status));
                                        }

                                        array_push($arrayactasext, array("actas" => $row->id, "auditores" => $arrayauditext, "historial" => $arrayhistoext ) );
                                    }
                                    else
                                    {
                                        array_push($arrayauditext, array('idacta'=> $row->id, 'emailauditor' => "sininfo", 'mobauditor' => "sininfo", 'idauditor' => "sininfo", "nombreaudit" => "sininfo", 'status' => "sininfo"));

                                        array_push($arrayactasext, array("actas" => $row->id, "auditores" => $arrayauditext, "historial" => $arrayhistoext ) );
                                    }
                                    
                                    
                                    array_push($arreglo, array("arrayactas" => $this->eliminarDuplicados($arrayaudit), "arrayactasext" => $this->eliminarDuplicados($arrayauditext)));
                                }

                                $act = "coninfo";

                                $text = "Actas asignadas al proyecto.";
                                
                                
                                return view('auditor.postulaciones.veractas', ["id" => $id, "text" => $text, "actas" => $actas, "act" => $act, "count" => count($arreglo), "arreglo" => $arreglo, 'value' => 1, 'idconc' => Crypt::encrypt($post->idconc),  'defansw' => $defansw ]); 
                                
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
    public function funajausuaud(Request $request)
    {
        switch (true) 
        {
            case ($request->tipo == "imprimir"):

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

                $postu = DB::table('postulations')->where('idpost', $actas->id_proy )->first();

                $auditores = DB::table('actasadit as aa')->join('actashistorial as ah', 'aa.id', '=', 'ah.idaudit')->join('users as u', 'u.id', '=', 'ah.idusers')->where(['aa.idacta' => $idacta, 'aa.status' => 'si' ])->get();
                
                $personal = DB::table('actashistorial as ah')->where(['ah.idacta' => $idacta, 'idusers' => $postu->idus ])->join('users as u', 'u.id', '=', 'ah.idusers')->first(); 
                
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
                
                $pdf = \PDF::loadView('pdfs/actas', [ "fechaini" => $fechaini, "fechater" => $fechater, "fechareu" => $fechareu, "evaluado" => $evaluado, "actas" => $actas, "auditores" => $auditores, "personal" => $personal, "nombre" => $personal->name.' '.$personal->surname, "email" => $personal->email, "mobile" => $personal->mobile, "answers" => $answers ]);

                // Opciones adicionales (opcional)
                 $pdf->setPaper('A4', 'portrait');

                // Descargar el PDF
                //return $pdf->download('factura.pdf');
                //dd($pdf->download('factura.pdf'));
                // También puedes mostrarlo en el navegador:
                 //return $pdf->stream('factura.pdf');

                // O guardarlo en el servidor:
                $randomString = Str::random(16).'pdf';

                $pdf->save(storage_path('app/public').'/'.$randomString);

                $archivo = base64_encode($pdf->output());

                $var1 = "ok";

                if (file_exists(storage_path('app/public').'/'.$randomString)) 
                {
                    if (unlink(storage_path('app/public').'/'.$randomString)) 
                    {
                        $var1 = "ok";
                    } 
                    else 
                    {
                        $var1 = "error";
                    }
                } 
                else 
                {
                    $var1 = "error";
                }

                return response()->json(['status' => "ok", "pdf" => $archivo, "mensaje" => $var1 ], 200);

            break;
            case ($request->acta):
                $idacta = Crypt::decrypt($request->idacta);
                $acta = DB::table('actas')->where([ 'id' => $idacta ] )->count();
                switch (true) 
                {
                    case ($acta  == 1):
                        
                        $acta = DB::table('actas as a')->select('an.preg1et1', 'u.name', 'u.surname', 'u.email')->join('postulations as p', 'a.id_proy', '=', 'p.idpost')->join('users as u', 'u.id', '=', 'p.idus')->where([ 'a.id' => $idacta ] )->join('answers as an', 'an.id_post', '=', 'p.idpost')->first();
                        
                        

                        $actaupdate = DB::table('actas as a')->where( [ 'id' => $idacta ] )->update(['fecha_ini' => date('Y-m-d H:i:s') ]);

                        if($actaupdate)
                        {
                            Mail::to('mauri-1973@outlook.cl')->send(new EmailNewActas($acta->name.' '.$acta->surname, $acta->preg1et1));

                            if(Mail::failures() != 0) 
                            {
                                $mensaje1 = trans('multi-new.0058');
                            }   
                            else
                            {
                                $mensaje1 = trans('multi-new.0060').$acta->email;
                            }

                            return redirect()->route('ver-formulario-docente-concurso-finalizado-actas', $request->idansw)->with('success', $mensaje1);
                        }
                        else
                        {
                            return redirect()->route('ver-formulario-docente-concurso-finalizado-actas', $request->idansw)->with('success', trans('multi-new.0061'));
                        }

                        

                    break;
                    
                    default:

                        return redirect()->route('ver-formulario-docente-concurso-finalizado-actas', $request->idansw)->with('danger', trans('multi-new.0059') );

                    break;
                }
            break;

            case ($request->tipo == "actualizarporcentaje"):

                $answ = Crypt::decrypt($request->idansw);
                
                $acthis = Crypt::decrypt($request->idacta);

                $actashist = DB::table('actashistorial')->where(['id' => $acthis])->first();

                $newhist = DB::table('actashistorial')->where(['id' => $acthis])->update(["porcentaje" => (int)$request->porcentajeact]);

                $idacta = $actashist->idacta;

                $actas = DB::table('actas')->where(['id' => $idacta])->first();

                $actasadit = DB::table('actasadit')->where(['idacta' => $idacta, "status" => "si"])->get();

                $cont = 0;

                $sum = 0;

                $tot = 0;

                $avance = 0;

                foreach($actasadit as $row)
                {
                    $temp = DB::table('actashistorial')->where(['idaudit' => $row->id ])->first();
                    $sum = (int)$temp->porcentaje;
                    $cont++;
                }
                
                if($cont > 0)
                {
                    $tot = round(($sum/$cont), 0, PHP_ROUND_HALF_UP);
                    
                    $avance = (int)round(($actas->avance*$tot)/100, 0, PHP_ROUND_HALF_UP);
                }
                  

                

                if ($newhist > 0) 
                {
                    return redirect()->route('ver-formulario-docente-concurso-finalizado-actas', $request->idansw)->with('success', trans('multi-new.0061'));
                } 
                else 
                {
                    return redirect()->route('ver-formulario-docente-concurso-finalizado-actas', $request->idansw)->with('danger', trans('multi-new.0061'));
                }

                

            break;
            
            case ($request->tipo == "emailteacher"):

                $idacta = Crypt::decrypt($request->idact);

                $iduser = Crypt::decrypt($request->idus);

                $idactas = DB::table('notifications')->insertGetId([
                    'id_us' => $iduser, 'id_act' => $idacta, 'asunto' => $request->asunto, 'mensaje' => $request->mensaje, 'tipo' => 'asesor', 'fechanot' => date('Y-m-d H:i:s')
                ]);
                
        
                if($idactas > 0)
                {
                    $datos = [
                        'id_us' => $iduser, 'id_act' => $idacta, 'asunto' => $request->asunto, 'mensaje' => $request->mensaje, 'tipo' => 'asesor',
                        'nombredocente' => Auth::user()->name.' '.Auth::user()->surname, 'emailaudit' => Auth::user()->email, 'telaudit' => Auth::user()->mobile
                    ];
                    
                    $jsonData = json_encode($datos);

                    $emailjob = DB::table('emailjobs')->insert([
                        'contenido' => $jsonData, 'template' => 'newnotificationsauditor', 'status' => 0
                    ]);

                    return response()->json(['status' => "ok", 'idacta' => $idactas, 'idus' => $iduser], 200);
                }
                else
                {
                    return response()->json(['status' => "errorsiningreso", 'idacta' => $idactas, 'idus' => $iduser], 200);
                }
                
                

            break;
            case ($request->tipo == 'notificaciones'):

                $idacta = Crypt::decrypt($request->idact);

                $iduser = Crypt::decrypt($request->idus);

                $array = array();

                $actasaudit = DB::table('notifications as n')->select('u.name', 'u.surname', 'u.email', 'u.mobile','n.*')->join('users as u', 'u.id', '=', 'n.id_us')->where('n.id_act', $idacta)->count();
                if($actasaudit > 0)
                {
                    $array = json_encode(DB::table('notifications as n')->select('u.name', 'u.surname', 'u.email', 'u.mobile','n.*')->join('users as u', 'u.id', '=', 'n.id_us')->where('n.id_act', $idacta)->get());
                }
                

                return response()->json(['status' => "ok", "html" => $array], 200);

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
            case ($request->tipo == 'crearacta'):

                $idproy = Crypt::decrypt($request->idact);
                $idus = Crypt::decrypt($request->idus);
                $actas = DB::table('actas')->select('*')->where('id_proy', $idproy)->count();
                switch (true) {
                    case ($actas == 0):

                        $proy = DB::table('postulations as p')->select('*')->join('users as u', 'p.idus', '=', 'u.id')->where('p.idpost', $idproy)->count();

                        switch (true) 
                        {
                            case ($proy == 1):

                                $proy = DB::table('postulations as p')->select('p.*', 'u.id as idusper')->join('users as u', 'p.idus', '=', 'u.id')->where('p.idpost', $idproy)->first();

                                $idactas = DB::table('actas')->insertGetId([
                                    'id_proy' => $idproy, 'status' => "creada", 'avance' => 0, 'fecha_ini' => date('Y-m-d H:i:s'), 'fecha_ter' => date('Y-m-d H:i:s'), 'fecha_reu' => date('Y-m-d H:i:s')
                                ]);

                                
                
                                $datos = [
                                    'id_us' => $proy->idusper, 'id_act' => $idactas, 'asunto' => "Configurar Acta Inicial", 'mensaje' => trans('multi-new.0284'), 'tipo' => Auth::user()->id,
                                    'nombredocente' => Auth::user()->name.' '.Auth::user()->surname, 'emaildocente' => Auth::user()->email, 'telaudit' => Auth::user()->mobile
                                ];
                                
                                $jsonData = json_encode($datos);

                                $emailjob = DB::table('emailjobs')->insert([

                                    'contenido' => $jsonData, 'template' => 'newnotificationdocact', 'status' => 0

                                ]);

                                return response()->json(['status' => "ok", "html" => trans('multi-new.0281')], 200);

                            break;
                            
                            default:

                                return response()->json(['status' => "error", "html" => trans('multi-new.0283')], 200);

                            break;
                        }

                        
                        
                    break;
                    case ($actas > 0):
                        
                        return response()->json(['status' => "ok", "html" => trans('multi-new.0282')], 200);

                    break;
                    default:

                        return response()->json(['status' => "error", "html" => trans('multi-new.0283')], 200);

                    break;
                }

            break;
            case ($request->tipo == 'creada'):

                $idproy = Crypt::decrypt($request->idact);
                $idus = Crypt::decrypt($request->idus);
                $actas = DB::table('actas')->select('*')->where(['id_proy'=> $idproy, 'status' => 'creada'])->count();
                
                switch (true) 
                {
                    case ($actas == 0):

                        return response()->json(['status' => "error", "html" => trans('multi-new.0283')], 200);

                    break;
                    case ($actas == 1):
                        $actas = DB::table('actas')->select('*')->where(['id_proy'=> $idproy, 'status' => 'creada'])->first();
                        $proy = DB::table('postulations as p')->select('*')->join('users as u', 'p.idus', '=', 'u.id')->where('p.idpost', $idproy)->count();
                        switch (true) 
                        {
                            case ($proy == 1):

                                $proy = DB::table('postulations as p')->select('p.*', 'u.id as idusper')->join('users as u', 'p.idus', '=', 'u.id')->where('p.idpost', $idproy)->first();

                                $datos = [
                                    'id_us' => $proy->idusper, 'id_act' => $actas->id, 'asunto' => "Acta creada", 'mensaje' => trans('multi-new.0285'), 'tipo' => Auth::user()->id,
                                    'nombredocente' => Auth::user()->name.' '.Auth::user()->surname, 'emaildocente' => Auth::user()->email, 'telaudit' => Auth::user()->mobile
                                ];
                                
                                $jsonData = json_encode($datos);

                                $emailjob = DB::table('emailjobs')->insert([

                                    'contenido' => $jsonData, 'template' => 'newnotificationdocactcreada', 'status' => 0

                                ]);

                                return response()->json(['status' => "ok", "html" => trans('multi-new.0281')], 200);

                            break;
                            
                            default:

                                return response()->json(['status' => "error", "html" => trans('multi-new.0283')], 200);

                            break;
                        }
                        
                        return response()->json(['status' => "ok", "html" => trans('multi-new.0282')], 200);

                    break;
                    case ($actas > 1):
                        
                        return response()->json(['status' => "error", "html" => trans('multi-new.0282')], 200);

                    break;
                    default:

                        return response()->json(['status' => "error", "html" => trans('multi-new.0283')], 200);

                    break;
                }

            break;
            
            default:

                return response()->json(['status' => "error"], 500);

            break;
        }
        
        
    }
    public function impforaud($id = null)
    {
        $sumper = 0; $sumcom = 0; $sumfun = 0; $sumotr = 0; 

        $id = Crypt::decrypt($id);

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
        
        
        $pdf = \PDF::loadView('emails/prueba', ["answ" => $answ, 'dir' => $dir, 'subdir' => $subdir, 'est' => $est, 'acad' => $acad, 'files' => $files, "sumper" => (int)$sumper, "sumcom" => (int)$sumcom, "sumfun" => (int)$sumfun, "sumotr" => (int)$sumotr, 'tablaper' => $tablaper, 'tablacom' => $tablacom, 'tablafun' => $tablafun , 'tablaotr' => $tablaotr,  'filesa' => $filesa,  'contda' => $countfilesDA,  'contdn' => $countfilesDN]);
        
    
        return $pdf->download('Formulario.pdf');
    }
    public function veractaudhis($id = null)
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
    private function addactas($idpost = null)
    {
        $idactas = DB::table('actas')->insertGetId([
            'id_proy' => $idpost
        ]);

        return $idactas;
    }
    private function addactasaudit($idact = null, $iduser = null, $status = null, $idaudit = null)
    {
        switch (true) 
        {
            case ($idaudit == 0):

                $idaudit = DB::table('actasadit')->insertGetId([
                    'idacta' => $idact, "idaudit" => $iduser, "status" => $status
                ]);

                return $idaudit;
            break;
            case ($idaudit == 1):

                $idaudit = DB::table('actasadit')->where([
                    'idacta' => $idact, "idaudit" => $iduser
                ])->update( [ "status" => $status, "updated_at" => date('Y-m-d H:i:s') ] );

                if($idaudit)
                {

                    return $idact;

                }
                else
                {

                    return false;

                }

            break;
            default:
                return "error";
            break;
        }
    }

    private function eliminarDuplicados($array) {
        $resultado = [];
        $idauditorsUnicos = [];

        foreach ($array as $item) {
            
            if (!in_array($item['idauditor'], $idauditorsUnicos)) {
                $idauditorsUnicos[] = $item['idauditor'];
                $resultado[] = $item;
            }
        }

        return $resultado;
    }
}