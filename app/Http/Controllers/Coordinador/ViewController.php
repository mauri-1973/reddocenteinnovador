<?php



namespace App\Http\Controllers\Coordinador;



use App\Http\Controllers\Controller;

use App\Categoryblog;

use App\Tagblog;

use App\CategoriesCompetitions;

use App\Postulations;

use App\Competitions;

use App\Answers;

use App\AnswersDirector;

use App\FilesCompetitions;

use App\CompetitionsTags;

use App\TagsComp;

use App\Corrections;

use App\AnswersFiles;

use App\DetailsResources;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Gate;

use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

use File;

use Crypt;

class ViewController extends Controller

{

     /**

    *

    * allow blog only

    *

    */

    public function __construct() {

        //$this->middleware(['role:admin|creator']);

        $this->middleware(['role:coordinador|admin']);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function busconregdoc()

    {

        abort_if(Gate::denies('coordi'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $array = array();

        $concursos = DB::table('competitions as c')->select('c.*')->join('competitionscoordinador as cc', 'c.idcomp', '=', 'cc.idcomp')->where('cc.idcoor', Auth::user()->id)->get();

        foreach($concursos as $row)
        {
            $count = DB::table('postulations')->where('idconc', $row->idcomp)->count();
            array_push($array, ["id" => $row->idcomp, "title" => $row->title, "status" => $row->statuspos, "formulario" => $row->formulario, "post" => $count]);
        }

        return view('coor.index', compact('array'));

    }
    public function busconregcoo()
    {
        abort_if(Gate::denies('coordi'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = CategoriesCompetitions::all();

        $posts = Competitions::join('categoriesCompetitions  as cat', 'competitions.category_id', '=', 'cat.idcatcom')

        ->join('users as u', 'u.id', '=', 'competitions.created_by')

        ->where(['competitions.formulario' => 'proceso1'])

        ->orWhere(['competitions.formulario' => 'proceso1', 'competitions.formulario' => 'proceso2'])

        ->get(['competitions.*', 'cat.namecat as namecat', 'u.name as nameus', 'u.surname as surnameus']);

        return view('concursos.indexcoo', compact('posts','categories'));
    }
    
    public function vervisconusucoo($id = null)
    {
        abort_if(Gate::denies('coordi'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = Crypt::decrypt($id);
        /*Competitions::where('id', $id)

        ->update([

          'read_count'=> DB::raw('read_count+1'), 

        ]);*/

        $post = CategoriesCompetitions::join('competitions as c', 'c.category_id', '=', 'categoriesCompetitions.idcatcom')

        ->join('users as u', 'u.id', '=', 'c.created_by')

        ->where("c.idcomp", $id)

        ->first(['c.*', 'categoriesCompetitions.namecat as titlecat', 'u.name as nameus', 'u.surname as surnameus']);

        $tags = TagsComp::join('competitions_tag as comtag', 'tagcomp.idtag', '=', 'comtag.tag_id')

        ->where("comtag.comp_id", $id)

        ->get(['tagcomp.tagnom']);

        $files = FilesCompetitions::where('idcomp', $id)->get();

        return view('concursos.verconcursoscoo', compact('post', 'tags', 'files'));
    }
    public function verposconcoo($id = null)
    {
        abort_if(Gate::denies('coordi'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = Crypt::decrypt($id);

        $post = Postulations::join('users as u', 'u.id', '=', 'postulations.idus')

        ->where("postulations.idconc", $id)

        ->get(['postulations.*', 'u.name as nameus', 'u.surname as surnameus']);

        return view('coor.verpostulantes', compact('post'));
    }

    public function detposdoccoo($idpost = null, $idconc = null)
    {
        abort_if(Gate::denies('coordi'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $idpost = $idpost;

        $idconc = Crypt::decrypt($idconc);

        $comp = DB::table('competitions')->where('idcomp', $idconc)->count();

        switch (true) 
        {
            case ($comp > 0):

                $comp = DB::table('competitions')->where('idcomp', $idconc)->first();

                $tipo = $comp->formulario;

                switch (true) 
                {
                    case ($tipo == "proceso1"):

                        $answ = Answers::select('idansw', 'id_post', 'preg1et1', 'preg2et1')->where('id_post', $idpost)->orderBy('idansw', 'asc')->first();
                        
                        $post = Postulations::where(['idpost' =>  $idpost])->first();
                        
                        $correc = 0;

                        if($post->status == "conobservaciones")
                        {
                            $text = trans('inst.188');
                        }
                        if($post->status == "inicial")
                        {
                            $text = trans('inst.189');
                        }
                        if($post->status == "seleccionado")
                        {
                           $text = trans('inst.190'); 
                        }
                        if($post->status == "enrevision")
                        {
                            $text = trans('inst.191'); 
                        }
                        if($post->status == "rechazado")
                        {
                            $text = trans('inst.192');
                        }
                        if($post->status == "revisada")
                        {
                           $text = trans('inst.193'); 
                        }
                        ///////////////////////////////////////Validar en producción
                        ///////////////////////////////////////Validar en producción
                        ///////////////////////////////////////Validar en producción
                        ///////////////////////////////////////Validar en producción
                        ini_set('memory_limit', '512M');
                        ///////////////////////////////////////Validar en producción
                        ///////////////////////////////////////Validar en producción
                        ///////////////////////////////////////Validar en producción
                        ///////////////////////////////////////Validar en producción
                        $dir = AnswersDirector::where(['id_answ' => $answ->idansw, 'typedir' => 'dir'])->first();

                        $subdir = AnswersDirector::where(['id_answ' => $answ->idansw, 'typedir' => 'sub'])->first();

                        $est = AnswersDirector::where(['id_answ' => $answ->idansw, 'typedir' => 'est'])->get();

                        $acad = AnswersDirector::where(['id_answ' => $answ->idansw, 'typedir' => 'acad'])->get();

                        $finalstus = DB::table('answersstatus')->select('etapa1')->where('id_anwsstat', $answ->idansw )->first();

                        $view = 'etaparev1';
                        
                        $correc = DB::table('corrections')->where('id_answ', $answ->idansw )->first();
                        
                        $correc = $correc->id_answ;

                        return view('coor.proceso1.'.$view, compact('answ', 'dir', 'subdir', 'est', 'acad'), [ "idconcurso" => Crypt::encrypt($idconc), 'idpostulacion' => Crypt::encrypt($answ->id_post), "status" => $finalstus, 'text' => $text , 'correc' => $correc, "tipousuario" => Auth::user()->cargo_us, "statusform" => $post->status ]);

                    break;
                    case ($tipo == "proceso2"):

                        $val = DB::table('postulations as p')->select('p.idpost', 'e.*', 'c.obspreg1')->join('correctionsprocesodos as  c', 'p.idpost', '=', 'c.id_post')->join('etapa1 as  e', 'p.idpost', '=', 'e.id_post')->where('p.idpost', $idpost)->count();

                        switch (true) 
                        {
                            case ($val > 0):
                                
                                $finalstus = DB::table('postulations as p')->select('p.idpost', 'e.*', 'c.obspreg1', 'c.obspreg2', 'c.obspreg3', 'c.obspreg4', 'c.obspreg5', 'c.obspreg6', 'c.obspreg7', 'c.obspreg8', 'c.obspreg9')->join('correctionsprocesodos as  c', 'p.idpost', '=', 'c.id_post')->join('etapa1 as  e', 'p.idpost', '=', 'e.id_post')->where('p.idpost', $idpost)->first();
                
                                $post = Postulations::where(['idpost' =>  $idpost])->first();
                        
                                $correc = 0;

                                if($post->status == "conobservaciones")
                                {
                                    $text = trans('inst.188');
                                }
                                if($post->status == "inicial")
                                {
                                    $text = trans('inst.189');
                                }
                                if($post->status == "seleccionado")
                                {
                                $text = trans('inst.190'); 
                                }
                                if($post->status == "enrevision")
                                {
                                    $text = trans('inst.191'); 
                                }
                                if($post->status == "rechazado")
                                {
                                    $text = trans('inst.192');
                                }
                                if($post->status == "revisada")
                                {
                                $text = trans('inst.193'); 
                                }
                                
                                switch (true) 
                                { 
                                    case ($post->status == "inicial" || $post->status == "enrevision" || $post->status == "conobservaciones" ||$post->status == "rechazado" || $post->status == "revisada"):
                                        
                                        
                                        $view = 'estapa1newdocrev';
                                        
                                        return view('coor.proceso2.'.$view, compact('finalstus', 'post'), [ "idconcurso" => Crypt::encrypt($post->idconc), 'idpostulacion' => Crypt::encrypt($idpost), "status" => $post->status, 'text' => $text , "tipousuario" => Auth::user()->cargo_us, "statusform" => $post->status ]);

                                    break;
                                    case ($post->status == "seleccionado"):

                                        $view = 'fasedos';
                                        return view('coor.proceso2.seleccionado.'.$view, compact('finalstus', 'post'), [ "idconcurso" => Crypt::encrypt($post->idconc), 'idpostulacion' => Crypt::encrypt($idpost), "status" => $post->status, 'text' => $text , "tipousuario" => Auth::user()->cargo_us, "statusform" => $post->status ]);
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

    public function impforcoorobs($id = null)
    {
        $sumper = 0; $sumcom = 0; $sumfun = 0; $sumotr = 0; 

        $id = Crypt::decrypt($id);

        $correc = Corrections::where('id_answ', $id)->first();

        $answ = Answers::select('id_post')->where('idansw', $id)->orderBy('idansw', 'asc')->first();

        $idconc = Postulations::select('idpost')->where(['idpost' =>  $answ->id_post])->first();

        $post = Postulations::join('competitions as con', 'postulations.idconc', '=', 'con.idcomp')

        ->join('users as u', 'u.id', '=', 'postulations.idus')

        ->where('postulations.idpost', $idconc->idpost )

        ->first(['postulations.created_at', 'con.title', 'u.name', 'u.surname']);

        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");

        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        $pdf = \PDF::loadView('emails/observaciones', ["correc" => $correc, 'conc' => $post->title, 'nombre' => $post->name.' '.$post->surname, 'fecha' => $dias[date("w", strtotime($post->created_at))]." ".date("d", strtotime($post->created_at))." de ".$meses[date("n", strtotime($post->created_at))-1]. " del ".date("Y", strtotime($post->created_at))]);

        return $pdf->download(trans('multi-leng.a250').'.pdf');
    }

    public function verobscoornueven($id = null)
    {
        $id = Crypt::decrypt($id);

        $correc = Corrections::where('id_answ', $id)->first();

        $answ = Answers::select('id_post')->where('idansw', $id)->orderBy('idansw', 'asc')->first();

        $idconc = Postulations::select('idconc')->where(['idpost' =>  $answ->id_post])->first();

        $post = Postulations::join('competitions as con', 'postulations.idconc', '=', 'con.idcomp')

        ->join('users as u', 'u.id', '=', 'postulations.idus')

        ->where('con.idcomp', $idconc->idconc )

        ->first(['postulations.created_at', 'con.title', 'u.name', 'u.surname']);

        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");

        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        
        return view('coor.proceso1.observacionesnew', [ "id" => Crypt::encrypt($id), 'correc' => $correc, 'conc' => $post->title, 'nombre' => $post->name.''.$post->surname, 'fecha' => $dias[date("w", strtotime($post->created_at))]." ".date("d", strtotime($post->created_at))." de ".$meses[date("n", strtotime($post->created_at))-1]. " del ".date("Y", strtotime($post->created_at))]);
    }

    public function impforcoor($id = null)
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

    public function verforcoorsegeta($id = null)
    {
        abort_if(Gate::denies('coordi'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = Crypt::decrypt($id);

        $answ = Answers::select('idansw', 'id_post', 'preg1et2', 'preg2et2', 'preg3et2', 'preg4et2', 'preg5et2')->where(['idansw' => $id])->orderBy('idansw', 'asc')->count();

        switch (true) 
        {
            case ($answ > 0):

                $answ = Answers::select('idansw', 'id_post', 'preg1et2', 'preg2et2', 'preg3et2', 'preg4et2', 'preg5et2')->where(['idansw' => $id])->orderBy('idansw', 'asc')->first();

                $post = Postulations::where(['idpost' =>  $answ->id_post])->first();

                $correc = 0;

                if($post->status == "conobservaciones")
                {
                    $text = trans('inst.188');
                }
                if($post->status == "inicial")
                {
                    $text = trans('inst.189');
                }
                if($post->status == "seleccionado")
                {
                    $text = trans('inst.190'); 
                }
                if($post->status == "enrevision")
                {
                    $text = trans('inst.191'); 
                }
                if($post->status == "rechazado")
                {
                    $text = trans('inst.192');
                }
                if($post->status == "revisada")
                {
                    $text = trans('inst.193'); 
                }

                $finalstus = DB::table('answersstatus')->select('etapa2')->where('id_anwsstat', $id)->first();

                $view = 'etaparev2';
                                
                $correc = Answers::where('id_post', $answ->id_post )->skip(1)->take(1)->orderBy('idansw', 'desc')->get();
                
                $correc = $correc[0]->idansw;
                
                return view('coor.proceso1.'.$view, compact('answ'), [ "idconcurso" => Crypt::encrypt($post->idconc), 'idpostulacion' => Crypt::encrypt($answ->id_post), 'idansw' => Crypt::encrypt($id), "status" => $finalstus, 'text' => $text, 'correc' => $correc, 'idpost' => $post->idpost]);


            break;
            
            default:
                abort(404);
            break;
        }
        
    }

    public function verforcoortereta($id = null)
    {

        abort_if(Gate::denies('coordi'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = Crypt::decrypt($id);

        $answ = Answers::select('idansw', 'id_post', 'preg1et3', 'preg2et3', 'preg3et3')->where(['idansw' => $id])->orderBy('idansw', 'asc')->first();

        $post = Postulations::where(['idpost' =>  $answ->id_post])->count();

        switch (true) {
            case ($post > 0 ):
                
                $post = Postulations::where(['idpost' =>  $answ->id_post])->first();

                if($post->status == "conobservaciones")
                {
                    $text = trans('inst.188');
                }
                if($post->status == "inicial")
                {
                    $text = trans('inst.189');
                }
                if($post->status == "seleccionado")
                {
                    $text = trans('inst.190'); 
                }
                if($post->status == "enrevision")
                {
                    $text = trans('inst.191'); 
                }
                if($post->status == "rechazado")
                {
                    $text = trans('inst.192');
                }
                if($post->status == "revisada")
                {
                    $text = trans('inst.193'); 
                }

                $countfiles = AnswersFiles::where(['id_answ' => $id, 'tipofile' => 'Normal'])->count();

                $files = AnswersFiles::where(['id_answ' => $id, 'tipofile' => 'Normal'])->orderBy('idanswfile', 'asc')->get();

                $finalstus = DB::table('answersstatus')->select('etapa3')->where('id_anwsstat', $id)->first();
                
                $correc = "";

                $view = 'etaparev3';
                        
                $correc = Answers::where('id_post', $answ->id_post )->first();
                
                $correc = $correc->idansw;

                return view('coor.proceso1.'.$view, compact('answ'), [ "idconcurso" => Crypt::encrypt($post->idconc), 'idpostulacion' => Crypt::encrypt($answ->id_post), 'idansw' => Crypt::encrypt($id), 'countfiles' => $countfiles, 'files' => $files, "status" => $finalstus, 'text' => $text, 'correc' => $correc ]);

            break;
            
            default:

                abort(404);

            break;
        }

    }
    public function verforcoorcuaeta($id = null)
    {
        $id = Crypt::decrypt($id);

        $sumper = 0; $sumcom = 0; $sumfun = 0; $sumotr = 0;

        $answ = Answers::select('idansw', 'id_post', 'preg3et4')->where('idansw', $id)->orderBy('idansw', 'asc')->first();

        $post = Postulations::where(['idpost' =>  $answ->id_post])->count();

        switch (true) {
            case ($post > 0):

                $post = Postulations::where(['idpost' =>  $answ->id_post])->first();

                if($post->status == "conobservaciones")
                {
                    $text = trans('inst.188');
                }
                if($post->status == "inicial")
                {
                    $text = trans('inst.189');
                }
                if($post->status == "seleccionado")
                {
                    $text = trans('inst.190'); 
                }
                if($post->status == "enrevision")
                {
                    $text = trans('inst.191'); 
                }
                if($post->status == "rechazado")
                {
                    $text = trans('inst.192');
                }
                if($post->status == "revisada")
                {
                    $text = trans('inst.193'); 
                }

                $tablaper = DetailsResources::select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_answ' =>  $id, 'type' => 1])->orderBy('iddetres', 'asc')->get();

                foreach($tablaper as $tabla)
                {
                    $sumper = ($tabla->valor1 * $tabla->valor2) + $sumper;
                }

                $tablacom = DetailsResources::select('iddetres', 'descri', 'valor1', 'valor2', 'descriplarga')->where(['id_answ' =>  $id, 'type' => 2])->orderBy('iddetres', 'asc')->get();
                
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

                $files = AnswersFiles::where(['id_answ' => $id])->where('tipofile', '!=', 'Normal')->orderBy('idanswfile', 'asc')->get();

                $finalstus = DB::table('answersstatus')->select('etapa4')->where('id_anwsstat', $id)->first();
                
                $view = 'etaparev4';
                
                $correc = Answers::where('id_post', $answ->id_post )->first();
                
                $correc = $correc->idansw;

                return view('coor.proceso1.'.$view, compact('answ'), ["idconcurso" => Crypt::encrypt($post->idconc), 'idpostulacion' => Crypt::encrypt($answ->id_post), 'idansw' => Crypt::encrypt($id), "sumper" => (int)$sumper, "sumcom" => (int)$sumcom, "sumfun" => (int)$sumfun, "sumotr" => (int)$sumotr, 'tablaper' => $tablaper, 'tablacom' => $tablacom, 'tablafun' => $tablafun , 'tablaotr' => $tablaotr,  'files' => $files,  'contda' => $countfilesDA,  'contdn' => $countfilesDN, "status" => $finalstus, 'text' => $text, 'correc' => $correc ]);

            break;
            
            default:

                abort(404);

            break;
        }




        if($post->status == "inicial")
        {
            $text = trans('multi-leng.a206');
        }
        if($post->status == "enrevision")
        {
            $text = trans('multi-leng.a207');
        }
        if($post->status == "conobservaciones")
        {
            #$text = trans('multi-leng.a253');
            $text = "En proceso de Validación";
        }

        $correc = "";
        
        switch (true) 
        {
            case ($post->status == "inicial" || $post->status == "enrevision" || $post->status == "conobservaciones"):

                $tablaper = DetailsResources::select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_answ' =>  $id, 'type' => 1])->orderBy('iddetres', 'asc')->get();

                foreach($tablaper as $tabla)
                {
                    $sumper = ($tabla->valor1 * $tabla->valor2) + $sumper;
                }

                $tablacom = DetailsResources::select('iddetres', 'descri', 'valor1', 'valor2', 'descriplarga')->where(['id_answ' =>  $id, 'type' => 2])->orderBy('iddetres', 'asc')->get();
                
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

                $files = AnswersFiles::where(['id_answ' => $id])->where('tipofile', '!=', 'Normal')->orderBy('idanswfile', 'asc')->get();

                $finalstus = DB::table('answersstatus')->select('etapa4')->where('id_anwsstat', $id)->first();
                
                switch (true) 
                {
                    case ($post->status == "inicial"):
                        $view = 'etapa4';
                    break;
                    case ($post->status == "enrevision"):
                        $view = 'etaparev4';
                    break;
                    case ($post->status == "conobservaciones"):

                        #$view = 'etapa4obs';
                        $view = 'etaparev4';
                        
                        $correc = Answers::where('id_post', $answ[0]->id_post )->skip(1)->take(1)->orderBy('idansw', 'desc')->get();
                        
                        $correc = $correc[0]->idansw;

                    break;
                    
                    default:
                        # code...
                    break;
                }
                return view('cuestionario.'.$view, compact('answ'), ["idconcurso" => Crypt::encrypt($answ[0]->id_post), 'idpostulacion' => Crypt::encrypt($answ[0]->id_post), 'idansw' => Crypt::encrypt($id), "sumper" => (int)$sumper, "sumcom" => (int)$sumcom, "sumfun" => (int)$sumfun, "sumotr" => (int)$sumotr, 'tablaper' => $tablaper, 'tablacom' => $tablacom, 'tablafun' => $tablafun , 'tablaotr' => $tablaotr,  'files' => $files,  'contda' => $countfilesDA,  'contdn' => $countfilesDN, "status" => $finalstus, 'text' => $text, 'correc' => $correc ]);

            break;
            
            default:

                return redirect()->route('ver-vista-concurso-usuario-registrado-docente', [Crypt::encrypt($post->idconc)])->with('danger', trans('multi-leng.a172'));

            break;
        }

    }


    public function vernuefordocsegetacoo($id = null)
    {
        $answ = array(); 

        $id = Crypt::decrypt($id);

        $finalstus = DB::table('postulations as p')->select('p.idpost', 'p.idconc', 'e.*', 'c.obspreg1')->join('correctionsprocesodos as  c', 'p.idpost', '=', 'c.id_post')->join('etapa2 as  e', 'p.idpost', '=', 'e.id_post')->where('p.idpost', $id)->count();

        switch (true) 
        {
            case ($finalstus > 0):

                $post = Postulations::where(['idpost' =>  $id])->first();

                $correc = 0;

                if($post->status == "conobservaciones")
                {
                    $text = trans('inst.188');
                }
                if($post->status == "inicial")
                {
                    $text = trans('inst.189');
                }
                if($post->status == "seleccionado")
                {
                    $text = trans('inst.190'); 
                }
                if($post->status == "enrevision")
                {
                    $text = trans('inst.191'); 
                }
                if($post->status == "rechazado")
                {
                    $text = trans('inst.192');
                }
                if($post->status == "revisada")
                {
                    $text = trans('inst.193'); 
                }
                switch (true) 
                { 
                    case ($post->status == "inicial" || $post->status == "enrevision" || $post->status == "conobservaciones" ||$post->status == "rechazado" || $post->status == "revisada"):
                        
                        
                        $finalstus = DB::table('postulations as p')->select('p.idpost', 'p.idconc', 'e.*', 'c.obspreg10', 'c.obspreg11', 'c.obspreg12', 'c.obspreg13', 'c.obspreg14')->join('correctionsprocesodos as  c', 'p.idpost', '=', 'c.id_post')->join('etapa2 as  e', 'p.idpost', '=', 'e.id_post')->where('p.idpost', $id)->first();

                        $files = DB::table('answersfilesnew')->where(['id_post' => $id, 'tipofile' => 'Normal'])->get();

                        $view = 'estapa2newdocrev';
                
                        return view('coor.proceso2.'.$view, compact('finalstus', 'answ'), [ "idconcurso" => Crypt::encrypt($post->idconc), 'idpostulacion' => Crypt::encrypt($id), "status" => $finalstus->statuset2, 'text' => $text, 'files' => $files, 'poststatus' => $post->status, 'idpost' => $post->idpost ]);

                    break;
                    case ($post->status == "seleccionado"):

                        $finalstus = DB::table('postulations as p')->select('p.idpost', 'p.idconc', 'e.*', 'c.obspreg10', 'c.obspreg11', 'c.obspreg12', 'c.obspreg13', 'c.obspreg14')->join('correctionsprocesodos as  c', 'p.idpost', '=', 'c.id_post')->join('etapa2 as  e', 'p.idpost', '=', 'e.id_post')->where('p.idpost', $id)->first();

                        $files = DB::table('answersfilesnew')->where(['id_post' => $id, 'tipofile' => 'Normal'])->get();

                        $view = 'estapa2newdocrev';
                
                        return view('coor.proceso2.'.$view, compact('finalstus', 'answ'), [ "idconcurso" => Crypt::encrypt($post->idconc), 'idpostulacion' => Crypt::encrypt($id), "status" => $finalstus->statuset2, 'text' => $text, 'files' => $files, 'poststatus' => $post->status, 'idpost' => $post->idpost ]);
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

    public function vernuefordocteretacoo($id = null)
    {
        $id = Crypt::decrypt($id);

        $finalstus = DB::table('postulations as p')->select('p.idpost', 'p.idconc', 'e.*', 'c.obspreg1')->join('correctionsprocesodos as  c', 'p.idpost', '=', 'c.id_post')->join('etapa3 as  e', 'p.idpost', '=', 'e.id_post')->where('p.idpost', $id)->count();
        
        switch (true) 
        {
            case ($finalstus > 0):

                $post = Postulations::where(['idpost' =>  $id])->first();

                $array = array();

                if($post->status == "conobservaciones")
                {
                    $text = trans('inst.188');
                }
                if($post->status == "inicial")
                {
                    $text = trans('inst.189');
                }
                if($post->status == "seleccionado")
                {
                    $text = trans('inst.190'); 
                }
                if($post->status == "enrevision")
                {
                    $text = trans('inst.191'); 
                }
                if($post->status == "rechazado")
                {
                    $text = trans('inst.192');
                }
                if($post->status == "revisada")
                {
                    $text = trans('inst.193'); 
                }
                switch (true) 
                { 
                    case ($post->status == "inicial" || $post->status == "enrevision" || $post->status == "conobservaciones" ||$post->status == "rechazado" || $post->status == "revisada"):
                        
                        $array = DB::table("gantt")->where([ "id_post" => $id, 'statusgantt' => 1 ] )->orderBy('id', 'asc')->get();

                        $finalstus = DB::table('postulations as p')->select('p.idpost', 'p.idconc', 'e.*', 'c.obspreg15', 'c.obspreg16', 'c.obspreg17', 'c.obspreg18', 'c.obspreg19')->join('correctionsprocesodos as  c', 'p.idpost', '=', 'c.id_post')->join('etapa3 as  e', 'p.idpost', '=', 'e.id_post')->where('p.idpost', $id)->first();
                        
                        $correc = "";

                        $view = 'estapa3newdocrev';

                        return view('coor.proceso2.'.$view, compact('finalstus'), [ "idconcurso" => Crypt::encrypt($post->idconc), 'idpostulacion' => Crypt::encrypt($id), 'idansw' => Crypt::encrypt($finalstus->id), "status" => $finalstus->statuset3, 'text' => $text, 'array' => $array]);

                    break;
                    case ($post->status == "seleccionado"):

                        $array = DB::table("gantt")->where([ "id_post" => $id, 'statusgantt' => 1 ] )->orderBy('id', 'asc')->get();

                        $finalstus = DB::table('postulations as p')->select('p.idpost', 'p.idconc', 'e.*', 'c.obspreg15', 'c.obspreg16', 'c.obspreg17', 'c.obspreg18', 'c.obspreg19')->join('correctionsprocesodos as  c', 'p.idpost', '=', 'c.id_post')->join('etapa3 as  e', 'p.idpost', '=', 'e.id_post')->where('p.idpost', $id)->first();
                        
                        $correc = "";

                        $view = 'estapa3newdocrev';

                        return view('coor.proceso2.'.$view, compact('finalstus'), [ "idconcurso" => Crypt::encrypt($post->idconc), 'idpostulacion' => Crypt::encrypt($id), 'idansw' => Crypt::encrypt($finalstus->id), "status" => $finalstus->statuset3, 'text' => $text, 'array' => $array]);

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

    public function vernuefordoccuaetacoo($id = null)
    {
        $id = Crypt::decrypt($id);
        
        $finalstus1 = DB::table('postulations as p')->select('p.idpost', 'p.idconc', 'e.*', 'c.obspreg1')->join('correctionsprocesodos as  c', 'p.idpost', '=', 'c.id_post')->join('etapa4 as  e', 'p.idpost', '=', 'e.id_post')->where('p.idpost', $id)->count();
        
        switch (true) 
        {
            case ($finalstus1 > 0):

                $finalstus1 = DB::table('postulations as p')->select('p.idpost', 'p.idconc', 'e.*', 'c.obspreg20' , 'c.obspreg21', 'c.obspreg22', 'c.obspreg23', 'c.obspreg24')->join('correctionsprocesodos as  c', 'p.idpost', '=', 'c.id_post')->join('etapa4 as  e', 'p.idpost', '=', 'e.id_post')->where('p.idpost', $id)->first();

                
                $sumper = 0; $sumcom = 0; $sumfun = 0; $sumotr = 0;

                $et4 = DB::table('etapa4')->select('*')->where('id_post', $id)->first();

                $post = Postulations::where(['idpost' =>  $id])->first();
                
                if($post->status == "conobservaciones")
                {
                    $text = trans('inst.188');
                }
                if($post->status == "inicial")
                {
                    $text = trans('inst.189');
                }
                if($post->status == "seleccionado")
                {
                    $text = trans('inst.190'); 
                }
                if($post->status == "enrevision")
                {
                    $text = trans('inst.191'); 
                }
                if($post->status == "rechazado")
                {
                    $text = trans('inst.192');
                }
                if($post->status == "revisada")
                {
                    $text = trans('inst.193'); 
                }

                $correc = "";
                switch (true) 
                { 
                    case ($post->status == "inicial" || $post->status == "enrevision" || $post->status == "conobservaciones" ||$post->status == "rechazado" || $post->status == "revisada"):
                        
                        $tablaper = DB::table('detailnewresources')->select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_et4' =>  $et4->id, 'type' => 1])->orderBy('iddetres', 'asc')->get();

                        foreach($tablaper as $tabla)
                        {
                            $sumper = ($tabla->valor1 * $tabla->valor2) + $sumper;
                        }

                        $tablacom = DB::table('detailnewresources')->select('iddetres', 'descri', 'valor1', 'valor2', 'descriplarga')->where(['id_et4' =>  $et4->id, 'type' => 2])->orderBy('iddetres', 'asc')->get();
                        
                        foreach($tablacom as $tabla)
                        {
                            $sumcom = ($tabla->valor1 * $tabla->valor2) + $sumcom;
                        }

                        $tablafun = DB::table('detailnewresources')->select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_et4' =>  $et4->id, 'type' => 3])->orderBy('iddetres', 'asc')->get();
                        
                        foreach($tablafun as $tabla)
                        {
                            $sumfun = ($tabla->valor1 * $tabla->valor2) + $sumfun;
                        }

                        $tablaotr = DB::table('detailnewresources')->select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_et4' =>  $et4->id, 'type' => 4])->orderBy('iddetres', 'asc')->get();
                        
                        foreach($tablaotr as $tabla)
                        {
                            $sumotr = ($tabla->valor1 * $tabla->valor2) + $sumotr;
                        }
                        $tablajust = DB::table('detailnewresources')->select('iddetres', 'descri', 'name')->where(['id_et4' =>  $et4->id, 'type' => 5])->orderBy('iddetres', 'asc')->get();
                        
                        

                        $countfilesDA = AnswersFiles::where(['id_answ' => $id, 'tipofile' => 'Director (a) Académico'])->count();

                        $countfilesDN = AnswersFiles::where(['id_answ' => $id, 'tipofile' => 'Director(a) Nacional'])->count();

                        //$sumper = DetailsResources::where(['id_answ' =>  $id, 'type' => 1])->selectRaw('(SUM(valor1) * SUM(valor2)) as sumaTotal')->get();

                        $files = AnswersFiles::where(['id_answ' => $id])->where('tipofile', '!=', 'Normal')->orderBy('idanswfile', 'asc')->get();

                        $finalstus = DB::table('answersstatus')->select('etapa4')->where('id_anwsstat', $id)->first();

                        
                        $view = 'estapa4newdocrev';


                        return view('coor.proceso2.'.$view, compact('et4'), ["idconcurso" => Crypt::encrypt($post->idconc), 'idpostulacion' => Crypt::encrypt($post->idpost), 'idansw' => Crypt::encrypt($et4->id), "sumper" => (int)$sumper, "sumcom" => (int)$sumcom, "sumfun" => (int)$sumfun, "sumotr" => (int)$sumotr, 'tablaper' => $tablaper, 'tablacom' => $tablacom, 'tablafun' => $tablafun , 'tablaotr' => $tablaotr,  'files' => $files,  'contda' => $countfilesDA,  'contdn' => $countfilesDN, "status" => $et4->statuset4, 'text' => $text, 'correc' => $correc, 'tablajust' => $tablajust, 'finalstus' => $finalstus1 ]);

                    break;
                    case ($post->status == "seleccionado"):

                        $tablaper = DB::table('detailnewresources')->select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_et4' =>  $et4->id, 'type' => 1])->orderBy('iddetres', 'asc')->get();

                        foreach($tablaper as $tabla)
                        {
                            $sumper = ($tabla->valor1 * $tabla->valor2) + $sumper;
                        }

                        $tablacom = DB::table('detailnewresources')->select('iddetres', 'descri', 'valor1', 'valor2', 'descriplarga')->where(['id_et4' =>  $et4->id, 'type' => 2])->orderBy('iddetres', 'asc')->get();
                        
                        foreach($tablacom as $tabla)
                        {
                            $sumcom = ($tabla->valor1 * $tabla->valor2) + $sumcom;
                        }

                        $tablafun = DB::table('detailnewresources')->select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_et4' =>  $et4->id, 'type' => 3])->orderBy('iddetres', 'asc')->get();
                        
                        foreach($tablafun as $tabla)
                        {
                            $sumfun = ($tabla->valor1 * $tabla->valor2) + $sumfun;
                        }

                        $tablaotr = DB::table('detailnewresources')->select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_et4' =>  $et4->id, 'type' => 4])->orderBy('iddetres', 'asc')->get();
                        
                        foreach($tablaotr as $tabla)
                        {
                            $sumotr = ($tabla->valor1 * $tabla->valor2) + $sumotr;
                        }
                        $tablajust = DB::table('detailnewresources')->select('iddetres', 'descri', 'name')->where(['id_et4' =>  $et4->id, 'type' => 5])->orderBy('iddetres', 'asc')->get();
                        
                        

                        $countfilesDA = AnswersFiles::where(['id_answ' => $id, 'tipofile' => 'Director (a) Académico'])->count();

                        $countfilesDN = AnswersFiles::where(['id_answ' => $id, 'tipofile' => 'Director(a) Nacional'])->count();

                        //$sumper = DetailsResources::where(['id_answ' =>  $id, 'type' => 1])->selectRaw('(SUM(valor1) * SUM(valor2)) as sumaTotal')->get();

                        $files = AnswersFiles::where(['id_answ' => $id])->where('tipofile', '!=', 'Normal')->orderBy('idanswfile', 'asc')->get();

                        $finalstus = DB::table('answersstatus')->select('etapa4')->where('id_anwsstat', $id)->first();

                        
                        $view = 'estapa4newdocrev';


                        return view('coor.proceso2.'.$view, compact('et4'), ["idconcurso" => Crypt::encrypt($post->idconc), 'idpostulacion' => Crypt::encrypt($post->idpost), 'idansw' => Crypt::encrypt($et4->id), "sumper" => (int)$sumper, "sumcom" => (int)$sumcom, "sumfun" => (int)$sumfun, "sumotr" => (int)$sumotr, 'tablaper' => $tablaper, 'tablacom' => $tablacom, 'tablafun' => $tablafun , 'tablaotr' => $tablaotr,  'files' => $files,  'contda' => $countfilesDA,  'contdn' => $countfilesDN, "status" => $et4->statuset4, 'text' => $text, 'correc' => $correc, 'tablajust' => $tablajust, 'finalstus' => $finalstus1 ]);

                    break;
                    default:
        
                        abort(404);

                    break;
                }

            break;
            default:
                return redirect()->route('ver-postulaciones-concursos-registrados-administrador', [Crypt::encrypt($post->idconc)])->with('danger', trans('inst.73'));
            break;
        }
    }
    
}