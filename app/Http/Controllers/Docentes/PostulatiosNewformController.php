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



class PostulatiosNewformController extends Controller

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

    public function index()

    {

        abort_if(Gate::denies('post_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');



        //$posts = (new \App\Post)->getDashboardPosts()->with('categoriesblog','user')->get();

        $post = Post::join('categoriesblog as p', 'p.category_id', '=', 'categoriesblog.id_cat')

        ->where('p.is_published', 1)

        ->get(['categoriesblog.*']);

        return view('blog.posts.index', compact('posts'));

    }
    
    public function busconregdoc()
    {
        $categories = CategoriesCompetitions::all();

        $posts = Competitions::join('categoriesCompetitions  as cat', 'competitions.category_id', '=', 'cat.idcatcom')

        ->join('users as u', 'u.id', '=', 'competitions.created_by')

        ->where('competitions.is_published', 2)

        ->where('competitions.formulario', 'proceso2')

        ->get(['competitions.*', 'cat.namecat as namecat', 'u.name as nameus', 'u.surname as surnameus']);

        return view('concursos.index', compact('posts','categories'));
    }

    public function verposactdoc()
    {
        $array1 = array();

        $post = Postulations::join('competitions as con', 'postulations.idconc', '=', 'con.idcomp')

        ->join('categoriesCompetitions  as cat', 'con.category_id', '=', 'cat.idcatcom')

        ->join('users  as u', 'con.created_by', '=', 'u.id')

        ->where('postulations.idus', Auth::user()->id)

        ->where('con.formulario', "proceso2")

        ->get(['postulations.status', 'postulations.idpost', 'con.statuspos', 'con.formulario', 'con.title', 'u.name', 'u.surname', 'cat.namecat as namecat']);

        foreach($post as $po)
        {
            
            array_push($array1, array('status' => $po->status, 'statusconcurso' => $po->statuspos, 'formulario' => $po->formulario, 'title' => $po->title, 'name' => $po->name.' '.$po->surname, 'namecat' => $po->namecat, 'idpost' => $po->idpost ) );
        }
        
        return view('cuestionario.indexfasedos', ['data' => $array1]);
    }

    public function vervisconusuregdoc($id = null)
    {
        $id = Crypt::decrypt($id);

        Competitions::where('idcomp', $id)

        ->update([

          'applicants'=> DB::raw('applicants+1'), 

        ]);
        $postulacionnum = 0;

        $post = CategoriesCompetitions::join('competitions as c', 'c.category_id', '=', 'categoriesCompetitions.idcatcom')

        ->join('users as u', 'u.id', '=', 'c.created_by')

        ->where("c.idcomp", $id)

        ->first(['c.*', 'categoriesCompetitions.namecat as titlecat', 'u.name as nameus', 'u.surname as surnameus']);

        $postulacion = Postulations::where(['idconc' => $id, 'status' => 'inicial'])->get();

        if(count($postulacion) > 0)
        {
            $postulacionnum = 1;
        }
        

        $tags = TagsComp::join('competitions_tag as comtag', 'tagcomp.idtag', '=', 'comtag.tag_id')

        ->where("comtag.comp_id", $id)

        ->get(['tagcomp.tagnom']);

        $files = FilesCompetitions::where('idcomp', $id)->get();


        return view('docentes.verconcursosdoc', compact('post', 'tags', 'files'),['postulacion' => $postulacionnum]);
    }
    public function redforcomdoc($id = null)
    {
        $id1 = Crypt::decrypt($id);

        return redirect()->route('ver-vista-concurso-usuario-registrado-docente', [$id])->with('success', trans('multi-leng.a202'));
            
    }

    public function solposcondoc(Request $request)
    {
        $id = Crypt::decrypt($request->idpost); //id-concurso


        $post = Postulations::where(['idconc' =>  $id, 'idus' => Auth::user()->id])->count();

        if($post == 0)
        {
            $post = new Postulations;

            $post->idconc = $id;

            $post->idus = Auth::user()->id;

            $post->status = "inicial";

            $post->save();

            $idpost = $post->idpost; // id postulación

            $answ = new Answers;

            $answ->id_post = $idpost;

            $answ->save();

            $idansw = $answ->idansw; // idpreguntas

            $answdir = new AnswersDirector;

            $answdir->id_answ = $idansw;

            $answdir->typedir = "dir";

            $answdir->save();

            $answdir = new AnswersDirector;

            $answdir->id_answ = $idansw;

            $answdir->typedir = "sub";

            $answdir->save();

            DB::table('answersstatus')->insert(['id_anwsstat' => $idansw, 'etapa1' => 0, 'etapa2' => 0, 'etapa3' => 0, 'etapa4' => 0]);

            DB::table('detailresources')->insert(['id_answ' => $idansw, 'type' => 1, 'name' => 'formerror26', 'valor1' => 0, 'valor2' => 0,  'valor3' => 0, 'valor4' => 0]);
            
            DB::table('detailresources')->insert(['id_answ' => $idansw, 'type' => 2, 'name' => 'a123', 'valor1' => 0, 'valor2' => 0,  'valor3' => 0, 'valor4' => 0]);

            DB::table('detailresources')->insert(['id_answ' => $idansw, 'type' => 3, 'name' => 'a124', 'valor1' => 0, 'valor2' => 0,  'valor3' => 0, 'valor4' => 0]);

            DB::table('detailresources')->insert(['id_answ' => $idansw, 'type' => 4, 'name' => 'Total ($)', 'valor1' => 0, 'valor2' => 0,  'valor3' => 0, 'valor4' => 0]);

            DB::table('detailresources')->insert(['id_answ' => $idansw, 'type' => 5, 'valor1' => 0, 'valor2' => 0,  'valor3' => 0, 'valor4' => 0]);

            $correc = new Corrections;

            $correc->id_answ  = $idansw;

            $correc->save();

            

            $answ = Answers::select('idansw', 'preg1et1', 'preg2et1')->where('idansw', $idansw)->orderBy('idansw', 'asc')->get();

            $dir = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'dir'])->first();

            $subdir = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'sub'])->first();

            $est = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'est'])->get();

            $acad = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'acad'])->get();
        
            return view('cuestionario.etapa1', compact('answ', 'dir', 'subdir', 'est', 'acad'), [ "idconcurso" => Crypt::encrypt($id), 'idpostulacion' => Crypt::encrypt(1) ]);

            
        }
        else
        {
            $post = Postulations::where(['idconc' =>  $id, 'idus' => Auth::user()->id])->first();

            return redirect()->route('ver-vista-concurso-usuario-registrado-docente', [Crypt::encrypt($id)])->with('danger', trans('multi-leng.a172'));
            
        }
    }

    public function solposcondocfin(Request $request)
    {
        $id = Crypt::decrypt($request->idpost); //id-concurso

        $post = Postulations::where(['idconc' =>  $id, 'idus' => Auth::user()->id])->first();

        return redirect()->route('ver-vista-concurso-usuario-registrado-docente', [Crypt::encrypt($id)])->with('danger', trans('multi-leng.a172'));
    }
    public function verfordochist($id = null, $version = null, $tipo = null)
    {
        
        switch (true) 
        {
            case ($tipo == 'enrevision'):
                $ver = 'Formulario en proceso de revisión';
            break;
            case ($tipo == 'rechazado'):
                $ver = 'Formulario Rechazado';
            break;
            case ($tipo == 'aprobado'):
                $ver = 'Formulario Aprobado';
            break;
            case ($tipo == 'historial'):
               $ver = trans('multi-leng.a254').' '.$version;
            break;
            default:
                $ver = '';
            break;
        }
        
        $idansw = Crypt::decrypt($id);

        $answ = Answers::select('idansw', 'id_post', 'preg1et1', 'preg2et1')->where('idansw', $idansw)->orderBy('idansw', 'asc')->get();

        $idpost = $answ[0]->id_post;

        $post = Postulations::where(['idpost' =>  $idpost])->first();

        $display = "block";

        $text = trans('multi-leng.a248');

        $dir = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'dir'])->first();

        $subdir = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'sub'])->first();

        $est = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'est'])->get();

        $acad = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'acad'])->get();

        $finalstus = DB::table('answersstatus')->select('etapa1')->where('id_anwsstat', $idansw)->first();

        $view = 'etapa1soloverhistorial';

        $sumper = 0; $sumcom = 0; $sumfun = 0; $sumotr = 0;

        $id = $idansw;

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

        return view('docentes.'.$view, ["answ" => $answ, 'dir' => $dir, 'subdir' => $subdir, 'est' => $est, 'acad' => $acad, 'files' => $files, "sumper" => (int)$sumper, "sumcom" => (int)$sumcom, "sumfun" => (int)$sumfun, "sumotr" => (int)$sumotr, 'tablaper' => $tablaper, 'tablacom' => $tablacom, 'tablafun' => $tablafun , 'tablaotr' => $tablaotr,  'filesa' => $filesa,  'contda' => $countfilesDA,  'contdn' => $countfilesDN, 'text' => $text, 'idconcurso' => 0, 'idpostulacion' => $idpost, 'display' => $display, 'ver' => $ver, 'tipo' => $tipo ]);

        

    }

    public function verfordocprieta($id = null)
    {
        $id = Crypt::decrypt($id);

        $finalstus = DB::table('etapa1')->select('*')->where('id_post', $id)->first();

        $post = Postulations::where(['idpost' =>  $id])->first();
        
        $correc = 0;

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

        switch (true) 
        {
            case ($post->status == "inicial" || $post->status == "enrevision" || $post->status == "conobservaciones"):

                switch (true) 
                {
                    case ($post->status == "inicial"):

                        $view = 'estapa1newdoc';

                    break;
                    case ($post->status == "enrevision"):

                        $view = 'estapa1newdocrev';

                    break;

                    case ($post->status == "conobservaciones"):

                        #$view = 'etapa1obs';

                        $view = 'estapa1newdocrev';

                    break;
                    
                    default:
                        abort(404);
                    break;
                }
                return view('cuestionario.'.$view, compact('finalstus', 'post'), [ "idconcurso" => Crypt::encrypt($post->idconc), 'idpostulacion' => Crypt::encrypt($id), "status" => $post->status, 'text' => $text , "tipousuario" => Auth::user()->cargo_us, "statusform" => $post->status ]);

            break;
            case ($post->status == "enrevision" || $post->status == "conobservaciones"):

                $dir = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'dir'])->first();

                $subdir = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'sub'])->first();

                $est = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'est'])->get();

                $acad = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'acad'])->get();

                $finalstus = DB::table('answersstatus')->select('etapa1')->where('id_anwsstat', $id)->first();
                
                switch (true) 
                {
                    case ($post->status == "inicial"):

                        $view = 'etapa1';

                    break;
                    case ($post->status == "enrevision"):

                        $view = 'etaparev1';

                    break;

                    case ($post->status == "conobservaciones"):

                        #$view = 'etapa1obs';

                        $view = 'etaparev1';
                        
                        $correc = Answers::where('id_post', $answ[0]->id_post )->skip(1)->take(1)->orderBy('idansw', 'desc')->get();
                        
                        $correc = $correc[0]->idansw;

                    break;
                    
                    default:
                        # code...
                    break;
                }
                
                return view('cuestionario.'.$view, compact('answ', 'dir', 'subdir', 'est', 'acad'), [ "idconcurso" => Crypt::encrypt($answ[0]->id_post), 'idpostulacion' => Crypt::encrypt($answ[0]->id_post), "status" => $finalstus, 'text' => $text , 'correc' => $correc, "tipousuario" => Auth::user()->cargo_us, "statusform" => $post->status ]);

            break;
            
            default:
 
                return redirect()->route('ver-vista-concurso-usuario-registrado-docente', [Crypt::encrypt($post->idconc)])->with('danger', trans('multi-leng.a172'));

            break;
        }

        

    }

    public function verfordocsegeta($id = null)
    {
        $answ = array(); 

        $id = Crypt::decrypt($id);

        $finalstus = DB::table('etapa2')->select('*')->where('id_post', $id)->count();

        switch (true) 
        {
            case ($finalstus > 0):

                $post = Postulations::where(['idpost' =>  $id])->first();

                $correc = 0;

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
                switch (true) 
                {
                    case ($post->status == "inicial" || $post->status == "enrevision" || $post->status == "conobservaciones"):

                        $finalstus = DB::table('etapa2')->select('*')->where('id_post', $id)->first();

                        $files = DB::table('answersfilesnew')->where(['id_post' => $id, 'tipofile' => 'Normal'])->get();

                        switch (true) 
                        {
                            case ($post->status == "inicial"):
                                $view = 'estapa2newdoc';
                            break;
                            case ($post->status == "enrevision"):
                                $view = 'estapa2newdocrev';
                            break;
                            case ($post->status == "conobservaciones"):

                                #$view = 'etapa2obs';
                                $view = 'estapa2newdocrev';
                               

                            break;
                            
                            default:
                                abort(404);
                            break;
                        }
                
                        return view('cuestionario.'.$view, compact('finalstus', 'answ'), [ "idconcurso" => Crypt::encrypt($post->idconc), 'idpostulacion' => Crypt::encrypt($id), "status" => $finalstus->statuset2, 'text' => $text, 'files' => $files ]);

                    break;
                    
                    default:

                        return redirect()->route('ver-vista-concurso-usuario-registrado-docente', [Crypt::encrypt($post->idconc)])->with('danger', trans('multi-leng.a172'));

                    break;
                }
            break;
            
            default:
                abort(404);
            break;
        }

        

        

        

        
    }
    public function verfordoctereta($id = null)
    {
        $id = Crypt::decrypt($id);

        $finalstus = DB::table('etapa3')->select('*')->where('id_post', $id)->count();
        
        switch (true) 
        {
            case ($finalstus > 0):

                $post = Postulations::where(['idpost' =>  $id])->first();

                $array = array();

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
                
                switch (true) 
                {
                    case ($post->status == "inicial" || $post->status == "enrevision" || $post->status == "conobservaciones"):

                        $array = DB::table("gantt")->where([ "id_post" => $id, 'statusgantt' => 1 ] )->orderBy('id', 'asc')->get();

                        $finalstus = DB::table('etapa3')->select('*')->where('id_post', $id)->first();
                        
                        $correc = "";

                        switch (true) 
                        {
                            
                            case ($post->status == "inicial"):
                            
                                $view = 'estapa3newdoc';
                            break;
                            case ($post->status == "enrevision"):
                                $view = 'estapa3newdocrev';
                            break;
                            case ($post->status == "conobservaciones"):
                                
                                #$view = 'etapa3obs';
                                $view = 'estapa3newdocrev';
                                
                                $correc = Answers::where('id_post', $answ[0]->id_post )->skip(1)->take(1)->orderBy('idansw', 'desc')->get();
                                
                                $correc = $correc[0]->idansw;

                            break;
                            
                            default:
                                # code...
                            break;
                        }

                        return view('cuestionario.'.$view, compact('finalstus'), [ "idconcurso" => Crypt::encrypt($post->idconc), 'idpostulacion' => Crypt::encrypt($id), 'idansw' => Crypt::encrypt($finalstus->id), "status" => $finalstus->statuset3, 'text' => $text, 'array' => $array]);

                    break;
                    
                    default:

                        return redirect()->route('ver-vista-concurso-usuario-registrado-docente', [Crypt::encrypt($post->idconc)])->with('danger', trans('multi-leng.a172'));

                    break;
                }

            break;

            default:
                abort(404);
            break;
        }
        

        

    }
    public function verfordoccuaeta($id = null)
    {
        $id = Crypt::decrypt($id);
        
        $data = [
            'titulo' => 'Styde.net'
        ];
    
        /*$pdf = \PDF::loadView('emails/prueba', $data);
    
        return $pdf->download('archivo.pdf');

        $data = [
            'titulo' => 'Styde.net'
        ];
    
        $data = PDF::loadView('emails/prueba', $data)
            ->save(storage_path('app/public/pdfs') . 'archivo.pdf');*/

        $sumper = 0; $sumcom = 0; $sumfun = 0; $sumotr = 0;

        $et4 = DB::table('etapa4')->select('*')->where('id_post', $id)->first();

        $post = Postulations::where(['idpost' =>  $id])->first();

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
                
                switch (true) 
                {
                    case ($post->status == "inicial"):
                        $view = 'estapa4newdoc';
                    break;
                    case ($post->status == "enrevision"):
                        $view = 'estapa4newdocrev';
                    break;
                    case ($post->status == "conobservaciones"):

                        #$view = 'etapa4obs';
                        $view = 'estapa4newdocrev';
                        
                        $correc = Answers::where('id_post', $answ[0]->id_post )->skip(1)->take(1)->orderBy('idansw', 'desc')->get();
                        
                        $correc = $correc[0]->idansw;

                    break;
                    
                    default:
                        # code...
                    break;
                }
                return view('cuestionario.'.$view, compact('et4'), ["idconcurso" => Crypt::encrypt($post->idconc), 'idpostulacion' => Crypt::encrypt($post->idpost), 'idansw' => Crypt::encrypt($et4->id), "sumper" => (int)$sumper, "sumcom" => (int)$sumcom, "sumfun" => (int)$sumfun, "sumotr" => (int)$sumotr, 'tablaper' => $tablaper, 'tablacom' => $tablacom, 'tablafun' => $tablafun , 'tablaotr' => $tablaotr,  'files' => $files,  'contda' => $countfilesDA,  'contdn' => $countfilesDN, "status" => $et4->statuset4, 'text' => $text, 'correc' => $correc, 'tablajust' => $tablajust ]);

            break;
            
            default:

                return redirect()->route('ver-vista-concurso-usuario-registrado-docente', [Crypt::encrypt($post->idconc)])->with('danger', trans('multi-leng.a172'));

            break;
        }

    }

    function actforposdocetauno(Request $request)
    {
        $sum = 0;

        $idetapa = Crypt::decrypt($request->idetapa);
        
        switch (true) 
        {
            case ($request->tipo == "gantt"):

                $array = array();

                $idpost = Crypt::decrypt($request->idpost);

                $val = DB::table("gantt")->insert([ "id_post" => $idpost, 'titulo' => $request->value, 'fechainicio' => $request->col, 'fechatermino' => $request->type, 'descripcion' => $request->data, 'statusgantt' => 1 ] );

                if($val)
                {
                    $array1 = DB::table("gantt")->where([ "id_post" => $idpost, 'statusgantt' => 1 ] )->get();

                    foreach($array1 as $row)
                    {
                        array_push($array, array('id' => Crypt::encrypt($row->id), 'titulo' => $row->titulo, 'fechainicio' => $row->fechainicio, 'fechatermino' => $row->fechatermino, 'descripcion' => str_replace(PHP_EOL, ' ', $row->descripcion ), 'fechatablaini' => date("d-m-Y", strtotime($row->fechainicio)), 'fechatablater' => date("d-m-Y", strtotime($row->fechatermino)) ) );
                    }

                    return response()->json(['status' => 1, 'array' => $array ]);
                }

                return response()->json(['status' => 0, 'array' => $array ]);

            break;
            case ($request->tipo == "editargantt"):

                $array = array();

                $idpost = Crypt::decrypt($request->idpost);

                $idgantt = Crypt::decrypt($request->data1);
                
                $ar = DB::table("gantt")->where('id', $idgantt)->update([ 'titulo' => $request->value, 'fechainicio' => $request->col, 'fechatermino' => $request->type, 'descripcion' => $request->data, 'updated_at' => date('Y-m-d H:i:s') ] );
                
                if($ar)
                {
                    $array1 = DB::table("gantt")->where([ "id_post" => $idpost, 'statusgantt' => 1 ] )->get();

                    foreach($array1 as $row)
                    {
                        array_push($array, array('id' => Crypt::encrypt($row->id), 'titulo' => $row->titulo, 'fechainicio' => $row->fechainicio, 'fechatermino' => $row->fechatermino, 'descripcion' => str_replace(PHP_EOL, ' ', $row->descripcion ), 'fechatablaini' => date("d-m-Y", strtotime($row->fechainicio)), 'fechatablater' => date("d-m-Y", strtotime($row->fechatermino)) ) );
                    }

                    return response()->json(['status' => 1, 'array' => $array ]);
                }

                return response()->json(['status' => 0, 'array' => $array ]);

            break;
            case ($request->tipo == "eliminargantt"):

                $array = array();

                $idpost = Crypt::decrypt($request->idpost);

                $idgantt = Crypt::decrypt($request->data1);
                
                $ar = DB::table("gantt")->where('id', $idgantt)->update([ 'statusgantt' => 0, 'updated_at' => date('Y-m-d H:i:s') ] );

                if($ar)
                {
                    $count = DB::table("gantt")->where([ "id_post" => $idpost, 'statusgantt' => 1 ] )->count();
                    if($count == 0)
                    {
                        DB::table('etapa3')->where('id_post', $idpost)->update(['statuset3' => 0]);
                    }
                    $array1 = DB::table("gantt")->where([ "id_post" => $idpost, 'statusgantt' => 1 ] )->get();

                    foreach($array1 as $row)
                    {
                        array_push($array, array('id' => Crypt::encrypt($row->id), 'titulo' => $row->titulo, 'fechainicio' => $row->fechainicio, 'fechatermino' => $row->fechatermino, 'descripcion' => str_replace(PHP_EOL, ' ', $row->descripcion ), 'fechatablaini' => date("d-m-Y", strtotime($row->fechainicio)), 'fechatablater' => date("d-m-Y", strtotime($row->fechatermino)) ) );
                    }

                    return response()->json(['status' => 1, 'array' => $array ]);
                }

                return response()->json(['status' => 0, 'array' => $array ]);

            break;
            case ($request->tipo == "validar3"):

                $idpost = Crypt::decrypt($request->idpost);
                
                $ar = DB::table('etapa3')->where('id_post', $idpost)->update(['statuset3' => 1]);

                if($ar)
                {
                    return response()->json(['status' => 1]);
                }

                return response()->json(['status' => 0]);

            break;
            case ($request->tipo == "validar2"):

                $idpost = Crypt::decrypt($request->idpost);
                
                $ar = DB::table('etapa2')->where('id_post', $idpost)->update(['statuset2' => 1]);

                if($ar)
                {
                    return response()->json(['status' => 1]);
                }

                return response()->json(['status' => 0]);

            break;
            case ($request->tipo == "validar1"):

                $idpost = Crypt::decrypt($request->idpost);
                
                $ar = DB::table('etapa1')->where('id_post', $idpost)->update(['statuset1' => 1]);

                if($ar)
                {
                    return response()->json(['status' => 1]);
                }

                return response()->json(['status' => 0]);

            break;
            case ($request->type == "file"):

                $idpost = Crypt::decrypt($request->idpost);

                if ($request->hasFile('value'))
    
                {
    
                    $request->validate([
    
                        'value' => 'mimes:jpg,png,jpeg,xlsx,pdf,docx|max:9000'
    
                    ]);
    
                    $destinationPath = storage_path('app/public/adjuntos/docentes');
    
    
    
                    if (is_dir(storage_path('app/public/adjuntos/docentes'))) 
    
                    {
    
                        @chmod(storage_path('app/public/adjuntos/docentes'), 0777);
    
                    }
    
                    $thumbnail = $request->file('value');
    
                    $namecatSanitize = filter_var($request->col, FILTER_SANITIZE_STRING);
    
                    $fileName = time().'.'. $thumbnail->getClientOriginalExtension();
    
                    move_uploaded_file($thumbnail, $destinationPath.'/'.$fileName);


                    $ar = DB::table('answersfilesnew')->insertGetId([
                        'id_post' => $idpost,
                        'descripcion' => $namecatSanitize,
                        'dirfile' => $fileName,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s"),
                    ]);

                    if($ar > 0)
                    {

                        $countfiles = DB::table('answersfilesnew')->where(['id_post' => $idpost, 'tipofile' => 'Normal'])->count();

                        $files = DB::table('answersfilesnew')->where(['id_post' => $idpost, 'tipofile' => 'Normal'])->get();

                        return response()->json(['status' => 1, 'files' => $files, 'countfiles' => $countfiles]);
                    }

                    return response()->json(['status' => 0]);
    
                }

                

            break;
            case ($request->type == "delete"):

                $idpost = Crypt::decrypt($request->idpost);

                $files = DB::table('answersfilesnew')->where(['idfile' => $request->value])->delete();
                
                if(is_file(storage_path('app/public/adjuntos/docentes')."/".$request->col)) {

                    //unlink(storage_path('app/public/adjuntos/docentes')."/".$request->col);
                
                }

                $countfiles = DB::table('answersfilesnew')->where(['id_post' => $idpost, 'tipofile' => 'Normal'])->count();

                $files = DB::table('answersfilesnew')->where(['id_post' => $idpost, 'tipofile' => 'Normal'])->get();

                return response()->json(['status' => 1, 'files' => $files, 'countfiles' => $countfiles]);

            break;
            
            default:
                $val = DB::table($request->type)->where('id', $idetapa)->count();

                switch (true) 
                {
                    case($val > 0):

                        $val = DB::table($request->type)->where('id', $idetapa)->update([$request->col => $request->value, 'updated_at' => date('Y-m-d H:i:s')]);
        
                        if($val)
                        {
                            return response()->json(['status' => 1 ]);
                        }
        
                        return response()->json(['status' => 0 ]);
                    break;
                    
                    default:
                        
                        return response()->json([ 'status' => 0 ]);
        
                    break;
                }
            break;
        }

        
    }
    function actforposdocetados(Request $request)
    {
        $sum = 0;

        switch (true) 
        {
            case ($request->type == "answ"):

                $idansw = Crypt::decrypt($request->idansw);

                Answers::where(['idansw' => $idansw])->update([$request->col => $request->value, 'updated_at' => date("Y-m-d H:i:s")]);

                if($request->value == "" || $request->value == null)
                {
                    DB::table('answersstatus')->where('id_anwsstat', $idansw)->update(['etapa2' => 0]);
                }

                return response()->json(['status' => 1 ]);

            break;
            case ($request->type == "val"):

                $idansw = Crypt::decrypt($request->idansw);
                
                DB::table('answersstatus')->where('id_anwsstat', $idansw)->update(['etapa2' => 1]);

                return response()->json(['status' => 1]);

            break;

            
            default:
                
                return response()->json(['status' => 0 ]);

            break;
        }
    }
    function actforposdocetatres(Request $request)
    {
        $sum = 0;

        switch (true) 
        {
            case ($request->type == "answ"):

                $idansw = Crypt::decrypt($request->idansw);

                Answers::where(['idansw' => $idansw])->update([$request->col => $request->value, 'updated_at' => date("Y-m-d H:i:s")]);

                if($request->value == "" || $request->value == null)
                {
                    DB::table('answersstatus')->where('id_anwsstat', $idansw)->update(['etapa3' => 0]);
                }

                return response()->json(['status' => 1 ]);

            break;
            case ($request->type == "val"):

                $idansw = Crypt::decrypt($request->idansw);
                
                DB::table('answersstatus')->where('id_anwsstat', $idansw)->update(['etapa3' => 1]);

                return response()->json(['status' => 1]);

            break;
            case ($request->type == "file"):

                $id = Crypt::decrypt($request->idansw);

                if ($request->hasFile('value'))
    
                {
    
                    $request->validate([
    
                        'value' => 'mimes:jpg,png,jpeg,xlsx,pdf|max:9000'
    
                    ]);
    
                    $destinationPath = storage_path('app/public/adjuntos/docentes');
    
    
    
                    if (is_dir(storage_path('app/public/adjuntos/docentes'))) 
    
                    {
    
                        @chmod(storage_path('app/public/adjuntos/docentes'), 0777);
    
                    }
    
                    $thumbnail = $request->file('value');
    
                    $namecatSanitize = filter_var($request->col, FILTER_SANITIZE_STRING);
    
                    $fileName = time().'.'. $thumbnail->getClientOriginalExtension();
    
                    move_uploaded_file($thumbnail, $destinationPath.'/'.$fileName);

                    $dataClient1 = new AnswersFiles;
    
                    $dataClient1->id_answ   = $id;

                    $dataClient1->descripcion   = $namecatSanitize;
        
                    $dataClient1->dirfile    = $fileName;
        
                    $dataClient1->created_at    = date("Y-m-d H:i:s");
        
                    $dataClient1->updated_at    = date("Y-m-d H:i:s");
        
                    $dataClient1->save();
    
                }

                $countfiles = AnswersFiles::where(['id_answ' => $id, 'tipofile' => 'Normal'])->count();

                $files = AnswersFiles::where(['id_answ' => $id, 'tipofile' => 'Normal'])->orderBy('idanswfile', 'asc')->get();

                return response()->json(['status' => 1, 'files' => $files, 'countfiles' => $countfiles]);

            break;
            case ($request->type == "delete"):

                $id = Crypt::decrypt($request->idansw);

                $files = AnswersFiles::where(['idanswfile' => $request->value])->delete();
                
                if(is_file(storage_path('app/public/adjuntos/docentes')."/".$request->col)) {

                    //unlink(storage_path('app/public/adjuntos/docentes')."/".$request->col);
                
                }

                $countfiles = AnswersFiles::where(['id_answ' => $id, 'tipofile' => 'Normal'])->count();

                if($countfiles == 0)
                {
                    DB::table('answersstatus')->where('id_anwsstat', $id)->update(['etapa3' => 0]);
                }

                $files = AnswersFiles::where(['id_answ' => $id, 'tipofile' => 'Normal'])->orderBy('idanswfile', 'asc')->get();

                return response()->json(['status' => 1, 'files' => $files, 'countfiles' => $countfiles]);

            break;

            default:
                
                return response()->json(['status' => 0 ]);

            break;
        }
    }

    function actforposdocetacua(Request $request)
    {
        
        $sum = 0;

        switch (true) 
        {
            //actualizardatos(val1, val2, val3, "detresfila", idtab, $("#filatipo").val());

            case ($request->tipo == "answ"):

                $idansw = Crypt::decrypt($request->idansw);

                $idpost = Crypt::decrypt($request->idpost);

                $dataClient = Answers::firstOrNew(['idansw' => $idansw]);

                $dataClient->preg3et4    = $request->value;

                $dataClient->save();

                
                if($request->value == "" || $request->value == null)
                {
                    DB::table('answersstatus')->where('id_anwsstat', $idansw)->update(['etapa4' => 0]);
                }

                return response()->json([ 'sum' => "", 'status' => "0" ]);

            break;

            case ($request->type == "file"):

                $id = Crypt::decrypt($request->idansw);

                if ($request->hasFile('value'))
    
                {
    
                    $request->validate([
    
                        'value' => 'mimes:docx,pdf|max:9000'
    
                    ]);
    
                    $destinationPath = storage_path('app/public/adjuntos/docentes');
    
    
    
                    if (is_dir(storage_path('app/public/adjuntos/docentes'))) 
    
                    {
    
                        @chmod(storage_path('app/public/adjuntos/docentes'), 0777);
    
                    }
    
                    $thumbnail = $request->file('value');
    
                    $namecatSanitize = filter_var($request->col, FILTER_SANITIZE_STRING);
    
                    $fileName = time().'.'. $thumbnail->getClientOriginalExtension();
    
                    move_uploaded_file($thumbnail, $destinationPath.'/'.$fileName);

                    $dataClient1 = new AnswersFiles;
    
                    $dataClient1->id_answ   = $id;

                    $dataClient1->descripcion   = $namecatSanitize;
        
                    $dataClient1->dirfile    = $fileName;

                    if($request->data1 == 1)
                    {
                        $dataClient1->tipofile    = "Director (a) Académico";
                    }
                    if($request->data1 == 2)
                    {
                        $dataClient1->tipofile    = "Director(a) Nacional";
                    }

                    if($request->data1 == 3)
                    {
                        $dataClient1->tipofile    = "Otros Documentos";
                    }
                    
        
                    $dataClient1->created_at    = date("Y-m-d H:i:s");
        
                    $dataClient1->updated_at    = date("Y-m-d H:i:s");
        
                    $dataClient1->save();
    
                }

                $countfilesDA = AnswersFiles::where(['id_answ' => $id, 'tipofile' => 'Director (a) Académico'])->count();

                if($countfilesDA == 0)
                {
                    DB::table('answersstatus')->where('id_anwsstat', $id)->update(['etapa4' => 0]);
                }

                $countfilesDN = AnswersFiles::where(['id_answ' => $id, 'tipofile' => 'Director(a) Nacional'])->count();

                if($countfilesDN == 0)
                {
                    DB::table('answersstatus')->where('id_anwsstat', $id)->update(['etapa4' => 0]);
                }

                $files = AnswersFiles::where(['id_answ' => $id])->where('tipofile', '!=', 'Normal')->orderBy('idanswfile', 'asc')->get();

                return response()->json(['status' => 1, 'files' => $files, 'contda' => $countfilesDA, 'contdn' => $countfilesDN]);


            break;

            case ($request->type == "delete"):

                $id = Crypt::decrypt($request->idansw);

                $files = AnswersFiles::where(['idanswfile' => $request->value])->delete();
                
                if(is_file(storage_path('app/public/adjuntos/docentes')."/".$request->col)) {

                    //unlink(storage_path('app/public/adjuntos/docentes')."/".$request->col);
                
                }

                $countfilesDA = AnswersFiles::where(['id_answ' => $id, 'tipofile' => 'Director (a) Académico'])->count();

                $countfilesDN = AnswersFiles::where(['id_answ' => $id, 'tipofile' => 'Director(a) Nacional'])->count();

                $files = AnswersFiles::where(['id_answ' => $id])->where('tipofile', '!=', 'Normal')->orderBy('idanswfile', 'asc')->get();

                return response()->json(['status' => 1, 'files' => $files, 'contda' => $countfilesDA, 'contdn' => $countfilesDN]);

            break;

            case ($request->tipo == "additems"):

                $idansw = Crypt::decrypt($request->idansw);

                $idpost = Crypt::decrypt($request->idpost);

                switch (true) 
                {

                    case ((int)$request->data == 0):


                        $tablaper = DB::table('detailnewresources')->insert( [ 'id_et4' => $idansw, 'type' => 1, 'name' => '----------', 'descri' => $request->value, 'valor1' => $request->col, 'valor2' => $request->type ] );

                        $datos = DB::table('detailnewresources')->select('iddetres', 'descri','valor1', 'valor2')->where(['id_et4' => $idansw, 'type' => 1 ])->get();

                        return response()->json([ 'datos' => $datos, 'status' => 1 ]);

                    break;
                    case ((int)$request->data != 0 && $request->data1 == 2):

                        DB::table('detailnewresources')->where(['iddetres' => (int)$request->data])->update(['descri' => $request->value, 'valor1' =>$request->col, 'valor2' => $request->type]);

                        $datos = DB::table('detailnewresources')->select('iddetres', 'descri','valor1', 'valor2')->where(['id_et4' => $idansw, 'type' => 1 ])->get();

                        return response()->json([ 'datos' => $datos, 'status' => 1 ]);

                    break;

                    case ((int)$request->data != 0 && $request->data1 == 3):

                        DB::table('detailnewresources')->where(['iddetres' => (int)$request->data])->delete();

                        $datos = DB::table('detailnewresources')->select('iddetres', 'descri','valor1', 'valor2')->where(['id_et4' => $idansw, 'type' => 1 ])->get();
                        
                        return response()->json([ 'datos' => $datos, 'status' => 1 ]);

                    break;
                    
                    default:
                        # code...
                    break;
                }

            break;

            case ($request->tipo == "additemscom"):

                $idansw = Crypt::decrypt($request->idansw);

                $idpost = Crypt::decrypt($request->idpost);

                switch (true) {

                    case ((int)$request->data == 0):

                        
                        $tablaper = DB::table('detailnewresources')->insert( [ 'id_et4' => $idansw, 'type' => 2, 'name' => '----------', 'descri' => $request->value, 'valor1' => $request->col, 'valor2' => $request->type, 'descriplarga' => $request->adicional] );

                        $datos = DB::table('detailnewresources')->select('iddetres', 'descri','valor1', 'valor2', 'descriplarga')->where(['id_et4' => $idansw, 'type' => 2 ])->get();

                        return response()->json([ 'datos' => $datos, 'status' => 1 ]);

                    break;
                    case ((int)$request->data != 0 && $request->data1 == 2):

                        $tablaper = DB::table('detailnewresources')->where(['iddetres' => (int)$request->data])->update(['descri' => $request->value, 'valor1' =>$request->col, 'valor2' => $request->type, 'descriplarga' => $request->adicional]);

                        $datos = DB::table('detailnewresources')->select('iddetres', 'descri', 'valor1', 'valor2', 'descriplarga')->where(['id_et4' => $idansw, 'type' => 2 ])->get();

                        return response()->json([ 'datos' => $datos, 'status' => 1 ]);

                    break;

                    case ((int)$request->data != 0 && $request->data1 == 3):

                        DB::table('detailnewresources')->where(['iddetres' => (int)$request->data])->delete();

                        $datos = DB::table('detailnewresources')->select('iddetres', 'descri', 'valor1', 'valor2', 'descriplarga')->where(['id_et4' => $idansw, 'type' => 2 ])->get();
                        
                        return response()->json([ 'datos' => $datos, 'status' => 1 ]);

                    break;
                    
                    default:
                        # code...
                    break;
                }

            break;

            case ($request->tipo == "additemsfun"):

                $idansw = Crypt::decrypt($request->idansw);

                $idpost = Crypt::decrypt($request->idpost);

                switch (true) {

                    case ((int)$request->data == 0):

                        
                        $tablaper = DB::table('detailnewresources')->insert( [ 'id_et4' => $idansw, 'type' => 3, 'name' => '----------', 'descri' => $request->value, 'valor1' => $request->col, 'valor2' => $request->type ] );

                        $datos = DB::table('detailnewresources')->select('iddetres', 'descri','valor1', 'valor2')->where(['id_et4' => $idansw, 'type' => 3 ])->get();

                        return response()->json([ 'datos' => $datos, 'status' => 1 ]);

                    break;
                    case ((int)$request->data != 0 && $request->data1 == 2):

                        DB::table('detailnewresources')->where(['iddetres' => (int)$request->data])->update(['descri' => $request->value, 'valor1' =>$request->col, 'valor2' => $request->type]);

                        $datos = DB::table('detailnewresources')->select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_et4' => $idansw, 'type' => 3 ])->get();

                        return response()->json([ 'datos' => $datos, 'status' => 1 ]);

                    break;

                    case ((int)$request->data != 0 && $request->data1 == 3):

                        DB::table('detailnewresources')->where(['iddetres' => (int)$request->data])->delete();

                        $datos = DB::table('detailnewresources')->select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_et4' => $idansw, 'type' => 3 ])->get();
                        
                        return response()->json([ 'datos' => $datos, 'status' => 1 ]);

                    break;
                    
                    default:
                        # code...
                    break;
                }

            break;

            case ($request->tipo == "additemsotr"):

                $idansw = Crypt::decrypt($request->idansw);

                $idpost = Crypt::decrypt($request->idpost);

                switch (true) {

                    case ((int)$request->data == 0):

                        $tablaper = DB::table('detailnewresources')->insert( [ 'id_et4' => $idansw, 'type' => 4, 'name' => '----------', 'descri' => $request->value, 'valor1' => $request->col, 'valor2' => $request->type ] );

                        $datos = DB::table('detailnewresources')->select('iddetres', 'descri','valor1', 'valor2')->where(['id_et4' => $idansw, 'type' => 4 ])->get();

                        return response()->json([ 'datos' => $datos, 'status' => 1 ]);

                    break;
                    case ((int)$request->data != 0 && $request->data1 == 2):

                        DB::table('detailnewresources')->where(['iddetres' => (int)$request->data])->update(['descri' => $request->value, 'valor1' =>$request->col, 'valor2' => $request->type]);

                        $datos = DB::table('detailnewresources')->select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_et4' => $idansw, 'type' => 4 ])->get();

                        return response()->json([ 'datos' => $datos, 'status' => 1 ]);

                    break;

                    case ((int)$request->data != 0 && $request->data1 == 3):

                        DB::table('detailnewresources')->where(['iddetres' => (int)$request->data])->delete();

                        $datos = DB::table('detailnewresources')->select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_et4' => $idansw, 'type' => 4 ])->get();
                        
                        return response()->json([ 'datos' => $datos, 'status' => 1 ]);

                    break;
                    
                    default:
                        # code...
                    break;
                }

            break;
            case ($request->tipo == "additemsjust"):

                $idansw = Crypt::decrypt($request->idansw);

                $idpost = Crypt::decrypt($request->idpost);

                

                switch (true) {

                    case ((int)$request->data == 0):

                        $tablaper = DB::table('detailnewresources')->insert( [ 'id_et4' => $idansw, 'type' => 5, 'name' => $request->value, 'descri' => $request->col ] );

                        $datos = DB::table('detailnewresources')->select('iddetres', 'name','descri')->where(['id_et4' => $idansw, 'type' => 5 ])->get();

                        return response()->json([ 'datos' => $datos, 'status' => 1 ]);

                    break;
                    case ((int)$request->data != 0 && $request->data1 == 2):
                        
                        DB::table('detailnewresources')->where(['iddetres' => (int)$request->data])->update(['name' => $request->value, 'descri' =>$request->col]);

                        $datos = DB::table('detailnewresources')->select('iddetres', 'name', 'descri')->where(['id_et4' => $idansw, 'type' => 5 ])->get();

                        return response()->json([ 'datos' => $datos, 'status' => 1 ]);

                    break;

                    case ((int)$request->data != 0 && $request->data1 == 3):

                        DB::table('detailnewresources')->where(['iddetres' => (int)$request->data])->delete();

                        $datos = DB::table('detailnewresources')->select('iddetres', 'name', 'descri')->where(['id_et4' => $idansw, 'type' => 4 ])->get();
                        
                        return response()->json([ 'datos' => $datos, 'status' => 1 ]);

                    break;
                    
                    default:
                        # code...
                    break;
                }

            break;

            case ($request->type == "val"):

                $idansw = Crypt::decrypt($request->idansw);

                $idpost = Crypt::decrypt($request->idpost);

                $error = "";
                
                DB::table('etapa4')->where('id_post', $idpost)->update(['statuset4' => 1]);

                return response()->json(['status' => 2, 'error' => $error]);
            break;

            case ($request->type == "final"):

                $idansw = Crypt::decrypt($request->idansw);

                $idpost = Crypt::decrypt($request->idpost);

                $error = "";

                $final0 = DB::table('etapa1')->where('id_post', $idpost)->first();
                $final1 = DB::table('etapa2')->where('id_post', $idpost)->first();
                $final2 = DB::table('etapa3')->where('id_post', $idpost)->first();
                $final3 = DB::table('etapa4')->where('id_post', $idpost)->first();

                if($final0->statuset1 == 0)
                {
                    $error .= trans('multi-leng.a165');
                }
                if($final1->statuset2 == 0)
                {
                    $error .= trans('multi-leng.a166');
                }
                if($final2->statuset3 == 0)
                {
                    $error .= trans('multi-leng.a167');
                }
                if($final3->statuset4 == 0)
                {
                    $error .= trans('multi-leng.a168');
                }
                if($error == "")
                {
                    $post = Postulations::where('idpost', $idpost)->update(['status' => 'enrevision']);
                    
                    $post = Postulations::where('idpost', $idpost)->first();
                    
                    return response()->json(['status' => 1, 'error' => $error, "id" => Crypt::encrypt($idpost) ]);
                }
                else
                {
                    return response()->json(['status' => 0, 'error' => $error, "id" => ""]);
                }

            break;
            
            default:
                
                return response()->json([ 'sum' => 0, 'status' => "0" ]);

            break;
        }
    }

    public function impfordoc($id = null)
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
    public function impfordocobsconfin($id = null)
    {
        $sumper = 0; $sumcom = 0; $sumfun = 0; $sumotr = 0; 

        $id = Crypt::decrypt($id);

        $idansw1 = Answers::select('id_post')->where('idansw', $id)->orderBy('idansw', 'asc')->count();
        
        switch (true) {
            case ($idansw1 == 1):

                $idansw1 = Answers::select('id_post')->where('idansw', $id)->first();
               
                $idpost1 = Answers::select('id_post')->where('idansw', $idansw1->id_post)->first();
                
                $answ = Answers::select('idansw')->where('id_post', $idpost1->id_post)->orderBy('idansw', 'asc')->first();

                $val = Corrections::where('id_answ', $answ->idansw)->count();
                
                $correc = Corrections::where('id_answ', $answ->idansw)->first();
                
                $idconc = Postulations::select('idpost')->where(['idpost' =>  $idpost1->id_post])->first();

                $post = Postulations::join('competitions as con', 'postulations.idconc', '=', 'con.idcomp')

                ->join('users as u', 'u.id', '=', 'postulations.idus')

                ->where('postulations.idpost', $idconc->idpost )

                ->first(['postulations.created_at', 'con.title', 'u.name', 'u.surname']);

                $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");

                $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                
                switch (true) {
                    case ($val == 1):
                        $pdf = \PDF::loadView('emails/observaciones', ["correc" => $correc, 'conc' => $post->title, 'nombre' => $post->name.' '.$post->surname, 'fecha' => $dias[date("w", strtotime($post->created_at))]." ".date("d", strtotime($post->created_at))." de ".$meses[date("n", strtotime($post->created_at))-1]. " del ".date("Y", strtotime($post->created_at))]);

                        return $pdf->download(trans('multi-leng.a250').'.pdf');
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
    public function impfordocobs($id = null)
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

    public function verobsdocnueven($id = null)
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
        
        return view('docentes.observacionesnew', [ "id" => Crypt::encrypt($id), 'correc' => $correc, 'conc' => $post->title, 'nombre' => $post->name.''.$post->surname, 'fecha' => $dias[date("w", strtotime($post->created_at))]." ".date("d", strtotime($post->created_at))." de ".$meses[date("n", strtotime($post->created_at))-1]. " del ".date("Y", strtotime($post->created_at))]);
    }

    public function verfordocconfin($id = null)
    {
        $idansw = Crypt::decrypt($id);

        $answ = Answers::select('idansw', 'id_post', 'preg1et1', 'preg2et1')->where('idansw', $idansw)->orderBy('idansw', 'asc')->count();

        switch (true) 
        {
            case ($answ == 1):

                $answ = Answers::select('idansw', 'id_post', 'preg1et1', 'preg2et1')->where('idansw', $idansw)->orderBy('idansw', 'asc')->first();

                $post = Postulations::where(['idpost' =>  $answ->id_post])->count();

                switch (true) 
                {

                    case ($post == 1):

                        $post = Postulations::where(['idpost' =>  $answ->id_post])->first();

                        $idpost = $answ->id_post;
                        
                        $answ = Answers::select('idansw', 'id_post', 'preg1et1', 'preg2et1')->where('idansw', $idansw)->orderBy('idansw', 'asc')->get();

                        $idconcurso = $post->idconc;

                        $statusconc = Competitions::where('idcomp', $idconcurso)->count();

                        switch (true) 
                        {
                            case ($statusconc == 1):

                                $statusconc = Competitions::where('idcomp', $idconcurso)->first();
                                
                                switch (true) 
                                {
                                    case ($statusconc->statuspos == "activo"):
                                        abort(404);
                                    break;
                                    case ($statusconc->statuspos == "seleccionados"):

                                            $arraynot = array();

                                            $not = DB::table('notifications')->where(['tipo' => 'general', 'id_con' => (int)$idconcurso])->get();

                                            foreach($not as $n)
                                            {
                                                array_push($arraynot, array('mens' => '<strong>Notificación: '.$n->mensaje.'. Fecha : '.Carbon::createFromFormat('Y-m-d H:i:s', $n->created_at)->format('d-m-Y H:i:s').'</strong>' ));
                                            }

                                            $text = "Proceso de selección finalizado. Postulación no seleccionada";

                                            $dir = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'dir'])->first();

                                            $subdir = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'sub'])->first();

                                            $est = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'est'])->get();

                                            $acad = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'acad'])->get();

                                            $finalstus = DB::table('answersstatus')->select('etapa1')->where('id_anwsstat', $idansw)->first();

                                            $view = 'etapa1solover';
                                            
                                            $display = "block";

                                            $sumper = 0; $sumcom = 0; $sumfun = 0; $sumotr = 0;

                                            $id = $idansw;

                                            $answ = Answers::select('*')->where('idansw', $id)->orderBy('idansw', 'asc')->get();

                                            $dir = AnswersDirector::where(['id_answ' => (int)$answ[0]->idansw, 'typedir' => 'dir'])->count();
                                            
                                            if($dir == 0)
                                            {
                                                $answtemp = Answers::select('idansw')->where('id_post', (int)$idpost)->orderBy('idansw', 'asc')->get();
                                                
                                                foreach($answtemp as $key => $slice)
                                                {
                                                    
                                                    if((int)$answtemp[$key]->idansw != (int)$idansw && !empty($answtemp[$key+1]->idansw))
                                                    {
                                                        
                                                        $dirtemp = AnswersDirector::where(['id_answ' => (int)$answtemp[($key)]->idansw, 'typedir' => 'dir'])->count();
                                                        $dirtemp1 = AnswersDirector::where(['id_answ' => (int)$answtemp[$key+1]->idansw, 'typedir' => 'dir'])->count();
                                                        
                                                        if($dirtemp > 0 && $dirtemp1 == 0)
                                                        {
                                                            $dirtemp = AnswersDirector::where(['id_answ' => (int)$answtemp[$key]->idansw, 'typedir' => 'dir'])->get();
                                                            foreach($dirtemp as $row)
                                                            {
                                                                DB::table('answersdirector')->insert(['id_answ' => (int)$answtemp[$key+1]->idansw, 'namedir' => $row->namedir, 'rutdir' => $row->rutdir, 'faculdir' => $row->faculdir, 'jordir' => $row->jordir, 'tipodir' => $row->tipodir, 'antidir' => $row->antidir, 'teldir' => $row->teldir, 'emaildir' => $row->emaildir, 'horasdir' => $row->horasdir, 'niveldir' => $row->niveldir, 'typedir' => $row->typedir, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
                                                            }
                                                        }
                                                        
                                                    }
                                                }
                                            }
                                            $dir = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'dir'])->first();
                                            
                                            $subdir = AnswersDirector::where(['id_answ' => (int)$answ[0]->idansw, 'typedir' => 'sub'])->count();

                                            if($subdir == 0)
                                            {
                                                $answtemp = Answers::select('idansw')->where('id_post', (int)$idpost)->orderBy('idansw', 'asc')->get();
                                                
                                                foreach($answtemp as $key => $slice)
                                                {
                                                    
                                                    if((int)$answtemp[$key]->idansw != (int)$idansw && !empty($answtemp[$key+1]->idansw) )
                                                    {
                                                        
                                                        $dirtemp = AnswersDirector::where(['id_answ' => (int)$answtemp[($key)]->idansw, 'typedir' => 'sub'])->count();
                                                        $dirtemp1 = AnswersDirector::where(['id_answ' => (int)$answtemp[$key+1]->idansw, 'typedir' => 'sub'])->count();
                                                        
                                                        if($dirtemp > 0 && $dirtemp1 == 0)
                                                        {
                                                            $dirtemp = AnswersDirector::where(['id_answ' => (int)$answtemp[$key]->idansw, 'typedir' => 'sub'])->get();
                                                            foreach($dirtemp as $row)
                                                            {
                                                                DB::table('answersdirector')->insert(['id_answ' => (int)$answtemp[$key+1]->idansw, 'namedir' => $row->namedir, 'rutdir' => $row->rutdir, 'faculdir' => $row->faculdir, 'jordir' => $row->jordir, 'tipodir' => $row->tipodir, 'antidir' => $row->antidir, 'teldir' => $row->teldir, 'emaildir' => $row->emaildir, 'horasdir' => $row->horasdir, 'niveldir' => $row->niveldir, 'typedir' => $row->typedir, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
                                                            }
                                                        }
                                                        
                                                    }
                                                }
                                            }

                                            $subdir = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'sub'])->first();
                                            
                                            $est = AnswersDirector::where(['id_answ' => (int)$answ[0]->idansw, 'typedir' => 'est'])->count();

                                            if($est == 0)
                                            {
                                                $answtemp = Answers::select('idansw')->where('id_post', (int)$idpost)->orderBy('idansw', 'asc')->get();
                                                
                                                foreach($answtemp as $key => $slice)
                                                {
                                                    
                                                    if((int)$answtemp[$key]->idansw != (int)$idansw && !empty($answtemp[$key+1]->idansw))
                                                    {
                                                        
                                                        $dirtemp = AnswersDirector::where(['id_answ' => (int)$answtemp[($key)]->idansw, 'typedir' => 'est'])->count();
                                                        $dirtemp1 = AnswersDirector::where(['id_answ' => (int)$answtemp[$key+1]->idansw, 'typedir' => 'est'])->count();
                                                        
                                                        if($dirtemp > 0 && $dirtemp1 == 0)
                                                        {
                                                            $dirtemp = AnswersDirector::where(['id_answ' => (int)$answtemp[$key]->idansw, 'typedir' => 'est'])->get();
                                                            foreach($dirtemp as $row)
                                                            {
                                                                DB::table('answersdirector')->insert(['id_answ' => (int)$answtemp[$key+1]->idansw, 'namedir' => $row->namedir, 'rutdir' => $row->rutdir, 'faculdir' => $row->faculdir, 'jordir' => $row->jordir, 'tipodir' => $row->tipodir, 'antidir' => $row->antidir, 'teldir' => $row->teldir, 'emaildir' => $row->emaildir, 'horasdir' => $row->horasdir, 'niveldir' => $row->niveldir, 'typedir' => $row->typedir, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
                                                            }
                                                        }
                                                        
                                                    }
                                                }
                                            }

                                            $est = AnswersDirector::where(['id_answ' => $answ[0]->idansw, 'typedir' => 'est'])->get();
                                            
                                            $acad = AnswersDirector::where(['id_answ' => (int)$answ[0]->idansw, 'typedir' => 'acad'])->count();

                                            if($acad == 0)
                                            {
                                                $answtemp = Answers::select('idansw')->where('id_post', (int)$idpost)->orderBy('idansw', 'asc')->get();
                                                
                                                foreach($answtemp as $key => $slice)
                                                {
                                                    
                                                    if((int)$answtemp[$key]->idansw != (int)$idansw && !empty($answtemp[$key+1]->idansw) )
                                                    {
                                                        
                                                        $dirtemp = AnswersDirector::where(['id_answ' => (int)$answtemp[($key)]->idansw, 'typedir' => 'acad'])->count();
                                                        $dirtemp1 = AnswersDirector::where(['id_answ' => (int)$answtemp[$key+1]->idansw, 'typedir' => 'acad'])->count();
                                                        
                                                        if($dirtemp > 0 && $dirtemp1 == 0)
                                                        {
                                                            $dirtemp = AnswersDirector::where(['id_answ' => (int)$answtemp[$key]->idansw, 'typedir' => 'acad'])->get();
                                                            foreach($dirtemp as $row)
                                                            {
                                                                DB::table('answersdirector')->insert(['id_answ' => (int)$answtemp[$key+1]->idansw, 'namedir' => $row->namedir, 'rutdir' => $row->rutdir, 'faculdir' => $row->faculdir, 'jordir' => $row->jordir, 'tipodir' => $row->tipodir, 'antidir' => $row->antidir, 'teldir' => $row->teldir, 'emaildir' => $row->emaildir, 'horasdir' => $row->horasdir, 'niveldir' => $row->niveldir, 'typedir' => $row->typedir, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
                                                            }
                                                        }
                                                    }
                                                }
                                            }

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
                                            
                                            
                                        switch (true) 
                                        {
                                            case ($post->status == "seleccionado" ):

                                                $text = "Proceso de selección finalizado. Proyecto seleccionado";

                                                $display = "block";

                                                return view('docentes.seleccionado', ["answ" => $answ, 'dir' => $dir, 'subdir' => $subdir, 'est' => $est, 'acad' => $acad, 'files' => $files, "sumper" => (int)$sumper, "sumcom" => (int)$sumcom, "sumfun" => (int)$sumfun, "sumotr" => (int)$sumotr, 'tablaper' => $tablaper, 'tablacom' => $tablacom, 'tablafun' => $tablafun , 'tablaotr' => $tablaotr,  'filesa' => $filesa,  'contda' => $countfilesDA,  'contdn' => $countfilesDN, 'text' => $text, 'idconcurso' => Crypt::encrypt($post->idconc), 'idpostulacion' => $idpost, 'display' => $display, "statuspost" => $post->status, "not" => $arraynot]);
                                                
                                            break;

                                            default:
                                                
                                                return view('docentes.noseleccionado', ["answ" => $answ, 'dir' => $dir, 'subdir' => $subdir, 'est' => $est, 'acad' => $acad, 'files' => $files, "sumper" => (int)$sumper, "sumcom" => (int)$sumcom, "sumfun" => (int)$sumfun, "sumotr" => (int)$sumotr, 'tablaper' => $tablaper, 'tablacom' => $tablacom, 'tablafun' => $tablafun , 'tablaotr' => $tablaotr,  'filesa' => $filesa,  'contda' => $countfilesDA,  'contdn' => $countfilesDN, 'text' => $text, 'idconcurso' => Crypt::encrypt($post->idconc), 'idpostulacion' => $idpost, 'display' => $display, "statuspost" => $post->status]);


                                            break;
                                        }
                                    break;
                                    
                                    default:
                                        abort(400);
                                    break;
                                }
                                
                            break;
                            
                            default:
                                abort(400);
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

    public function veractfordocconsel($id = null)
    {
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

                                return view('docentes.postulaciones.veractas', ["id" => $id, "text" => $text, "actas" => $actas, "act" => $act, "count" => count($arreglo), "arreglo" => $arreglo, 'value' => 0, 'idconc' => Crypt::encrypt($post->idconc), 'defansw' => $defansw ]);

                            break;
                            case ($actas == 1):

                                $actas = DB::table('actas')->where('id_proy', $answ->id_post )->get();

                                $defansw = Answers::select('answers.idansw as id', 'answers.id_post as idpost', 'answers.preg1et1 as titulo', 'u.name', 'u.surname', 'u.email', 'u.mobile', 'u.id')
                                ->join('postulations as p', 'p.idpost', '=', 'answers.id_post')
                                ->join('users as u', 'p.idus', '=', 'u.id')
                                ->where('answers.idansw', $idansw)
                                ->orderBy('answers.idansw', 'asc')
                                ->first();

                                

                                $act = "coninfo";

                                $text = "Actas asignadas al proyecto.";
                                
                                
                                return view('docentes.postulaciones.veractas', ["id" => $id, "text" => $text, "actas" => $actas, "act" => $act, "count" => count($arreglo), "arreglo" => $arreglo, 'value' => 1, 'idconc' => Crypt::encrypt($post->idconc),  'defansw' => $defansw ]); 
                                
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
}