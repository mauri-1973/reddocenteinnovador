<?php



namespace App\Http\Controllers\Competitions;



use App\Http\Controllers\Controller;

use App\Http\Requests\StorePostRequest;

use App\Http\Requests\UpdatePostRequest;

use App\Answers;

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

use File;

use Crypt;



class CompetitionsController extends Controller

{

    /**

    *

    * allow blog only

    *

    */

    public function __construct() {

        //$this->middleware(['role:admin|creator']);

        $this->middleware(['role:revisor|admin']);

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

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function verposregadm()

    {

        $posts = Post::join('categoriesblog as cp', 'posts.category_id', '=', 'cp.id')

        ->join('users as u', 'u.id', '=', 'posts.created_by')

        ->where('posts.is_published', 1)

        ->get(['posts.*', 'cp.title as titlecat', 'u.name as nameus', 'u.surname as surnameus']);

        return view('concursos.index', compact('posts'));

    }

    public function verconregadm()

    {
        $categories = CategoriesCompetitions::all();

        $posts = Competitions::join('categoriesCompetitions  as cat', 'competitions.category_id', '=', 'cat.idcatcom')

        ->join('users as u', 'u.id', '=', 'competitions.created_by')

        ->where('competitions.formulario', 'proceso1')

        ->get(['competitions.*', 'cat.namecat as namecat', 'u.name as nameus', 'u.surname as surnameus']);

        return view('concursos.index', compact('posts','categories'), ["formulario" => "proceso1"] );

    }

    public function verconregadmfasedos()

    {
        
        $categories = CategoriesCompetitions::all();

        $posts = Competitions::join('categoriesCompetitions  as cat', 'competitions.category_id', '=', 'cat.idcatcom')

        ->join('users as u', 'u.id', '=', 'competitions.created_by')

        ->where('competitions.formulario', 'proceso2')

        ->get(['competitions.*', 'cat.namecat as namecat', 'u.name as nameus', 'u.surname as surnameus']);

        return view('concursos.indexform', compact('posts','categories'), ["formulario" => "proceso2"] );

    }


    public function creteconcurso($form = null)
    {

        $categories = CategoriesCompetitions::all();

        //$tags = Tagblog::pluck('title', 'title')->all();
        $tags = TagsComp::all();
        return view('concursos.create', compact('categories', 'tags'), ["numtags" => count($tags), 'form' => $form]);

    }

    public function vertagsadmin()
    {

        $tags = TagsComp::get();

        return view('concursos.tagsindex', compact('tags'));

    }

    public function ingtagadm(Request $request)

    {

        $namecatSanitize = filter_var($request->namecat, FILTER_SANITIZE_STRING);

        

        $dataClient = new TagsComp;

        $dataClient->tagnom    = $namecatSanitize;

        $dataClient->tagidus    = Auth::user()->id;

        $dataClient->save();

        

        return redirect()->route('agregar-nuevos-tags-administrador')->with('success', trans('multi-leng.a6'));

    }
    public function valnomtag(Request $request)

    {

        $val = 1;

        $tags = Tagblog::select()->where('title', $request->name)->count();

        if($tags > 0)

        {

            $val = 2;

        }

        return response()->json(['val' => $val]);

    }
    public function edittagadm(Request $request)

    {

        $namecatSanitize = filter_var($request->namecat, FILTER_SANITIZE_STRING);

        $post = TagsComp::firstOrNew(['idtag' => $request->idcat]); 

        $post->tagnom = $namecatSanitize;

        $post->save();

        return redirect()->route('agregar-nuevos-tags-administrador')->with('success', trans('multi-leng.a7'));

    }

    public function elimtagadm(Request $request)

    {

        $namecatSanitize = filter_var($request->namecat, FILTER_SANITIZE_STRING);

        $model = DB::table('posts')->join('post_tag as po', 'posts.id', '=', 'po.post_id')->where(['po.tag_id' => $request->idcat])->count();

        if($model > 0)

        {

            return redirect()->route('agregar-nuevos-tags-administrador')->with('danger', trans('multi-leng.formerror64'));

        }

        else

        {
            $model = DB::table('post_tag')->where(['tag_id' => $request->idcat])->count();

            if($model > 0)
            {
                $model = DB::table('post_tag')->where(['tag_id' => $request->idcat])->forceDelete();
            }

            $model = Tagblog::where(['id' => $request->idcat])->forceDelete();

            return redirect()->route('agregar-nuevos-tags-administrador')->with('success', trans('multi-leng.a8'));

        }

    }

    public function vercatcon()

    {

        $categories = CategoriesCompetitions::get();

        return view('concursos.catindex', compact('categories'));

    }
    

    public function ingcatconadm(Request $request)

    {

        $namecatSanitize = filter_var($request->namecat, FILTER_SANITIZE_STRING);

        $dataClient = new CategoriesCompetitions;

        $dataClient->namecat    = $namecatSanitize;

        $dataClient->save();

        

        return redirect()->route('agregar-nuevas-categorias-concursos')->with('success', trans('multi-leng.a11'));

    }

    public function valnomcatconadm(Request $request)

    {

        $val = 1;

        $tags = CategoriesCompetitions::select()->where('namecat', $request->name)->count();

        if($tags > 0)

        {

            $val = 2;

        }

        return response()->json(['val' => $val]);

    }

    public function edinomcatconadm(Request $request)

    {

        $namecatSanitize = filter_var($request->namecat, FILTER_SANITIZE_STRING);

        $post = CategoriesCompetitions::firstOrNew(['idcatcom' => $request->idcat]); 

        $post->namecat = $namecatSanitize;

        $post->save();

        return redirect()->route('agregar-nuevas-categorias-concursos')->with('success', trans('multi-leng.a12'));

    }

    public function elinomcatconadm(Request $request)

    {

        $namecatSanitize = filter_var($request->namecat, FILTER_SANITIZE_STRING);

        $model = CategoriesCompetitions::where(['idcatcom' => $request->idcat])->count();

        if($model == 0)

        {

            return redirect()->route('agregar-nuevas-categorias-concursos')->with('danger', trans('multi-leng.a14'));

        }

        else

        {
            
            $model = CategoriesCompetitions::where(['idcatcom' => $request->idcat])->forceDelete();

            return redirect()->route('agregar-nuevas-categorias-concursos')->with('success', trans('multi-leng.a13'));

        }

    }

    public function actdatconadm(Request $request)

    {
        $idcomp = $request->id;

        $files = "";

        $formulario = "proceso1";

        if($request->form == "proceso2")
        {
            $formulario = "proceso2";
        }

        switch (true) {
            case ($request->id == "" && $request->type == 1):
                
                $namecatSanitize = filter_var($request->value, FILTER_SANITIZE_STRING);

                $dataClient = new Competitions;

                $dataClient->title    = $namecatSanitize;

                $dataClient->created_by    = Auth::user()->id;

                $dataClient->is_published    = $request->status;

                $dataClient->formulario    = $formulario;

                $dataClient->created_at    = date("Y-m-d H:i:s");

                $dataClient->updated_at    = date("Y-m-d H:i:s");

                $dataClient->save(); 

                $idcomp = $dataClient->idcomp;
                
            break;
            case ($request->id != "" && $request->type == 1):

                $namecatSanitize = filter_var($request->value, FILTER_SANITIZE_STRING);

                $dataClient = Competitions::firstOrNew(['idcomp' => $idcomp]); 

                $dataClient->title    = $namecatSanitize;

                $dataClient->created_by    = Auth::user()->id;

                $dataClient->is_published    = $request->status;

                $dataClient->updated_at    = date("Y-m-d H:i:s");

                $dataClient->save();

            break;
            case ($request->id == "" && $request->type == 2):
                
                $namecatSanitize = filter_var($request->value, FILTER_SANITIZE_STRING);

                $dataClient = new Competitions;

                $dataClient->category_id    = $namecatSanitize;

                $dataClient->created_by    = Auth::user()->id;

                $dataClient->is_published    = $request->status;

                $dataClient->formulario    = $formulario;

                $dataClient->created_at    = date("Y-m-d H:i:s");

                $dataClient->updated_at    = date("Y-m-d H:i:s");

                $dataClient->save(); 

                $idcomp = $dataClient->idcomp;
                
            break;
            case ($request->id != "" && $request->type == 2):

                $namecatSanitize = filter_var($request->value, FILTER_SANITIZE_STRING);

                $dataClient = Competitions::firstOrNew(['idcomp' => $idcomp]); 

                $dataClient->category_id    = $namecatSanitize;

                $dataClient->created_by    = Auth::user()->id;

                $dataClient->is_published    = $request->status;

                $dataClient->updated_at    = date("Y-m-d H:i:s");

                $dataClient->save();

            break;
            case ($request->id == "" && $request->type == 3):
                
                $namecatSanitize = filter_var($request->value, FILTER_SANITIZE_STRING);

                $dataClient = new Competitions;

                $dataClient->body   = $request->value;

                $dataClient->created_by    = Auth::user()->id;

                $dataClient->is_published    = $request->status;

                $dataClient->formulario    = $formulario;

                $dataClient->created_at    = date("Y-m-d H:i:s");

                $dataClient->updated_at    = date("Y-m-d H:i:s");

                $dataClient->save(); 

                $idcomp = $dataClient->idcomp;
                
            break;
            case ($request->id != "" && $request->type == 3):

                $output = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($request->codificado)); 

                $namecatSanitize = filter_var($request->value, FILTER_SANITIZE_STRING);

                $dataClient = Competitions::firstOrNew(['idcomp' => $idcomp]); 

                $dataClient->body    = html_entity_decode($output,null,'UTF-8');

                $dataClient->created_by    = Auth::user()->id;

                $dataClient->is_published    = $request->status;

                $dataClient->updated_at    = date("Y-m-d H:i:s");

                $dataClient->save();

            break;
            case ($request->id == "" && $request->type == 4):

                $dataClient = new Competitions;

                $dataClient->created_by    = Auth::user()->id;

                $dataClient->is_published    = $request->status;

                $dataClient->formulario    = $formulario;

                $dataClient->created_at    = date("Y-m-d H:i:s");

                $dataClient->updated_at    = date("Y-m-d H:i:s");

                $dataClient->save(); 

                $idcomp = $dataClient->idcomp;

                if($request->value != "")
                {
                    $porciones = explode(",", $request->value);

                    $tags = CompetitionsTags::where('comp_id', $idcomp)->whereIn('tag_id', $porciones)->count();

                    if($tags == 0)
                    {
                        for($i = 0; $i < count($porciones); $i++)
                        {
                            $dataClient1 = new CompetitionsTags;

                            $dataClient1->comp_id   =  $idcomp;

                            $dataClient1->tag_id    = (int)$porciones[$i];

                            $dataClient1->save();
                        }
                    }
                }
            break;
            case ($request->id != "" && $request->type == 4):

                $dataClient = Competitions::firstOrNew(['idcomp' => $idcomp]); 

                $dataClient->created_by    = Auth::user()->id;

                $dataClient->is_published    = $request->status;

                $dataClient->updated_at    = date("Y-m-d H:i:s");

                $dataClient->save();

                if($request->value == "")
                {
                    $tags = CompetitionsTags::where('comp_id', $idcomp)->forceDelete();
                }
                else
                {
                    $porciones = explode(",", $request->value);

                    $tags = CompetitionsTags::where('comp_id', $idcomp)->forceDelete();

                    for($i = 0; $i < count($porciones); $i++)
                    {
                        $dataClient1 = new CompetitionsTags;

                        $dataClient1->comp_id   =  $idcomp;

                        $dataClient1->tag_id    = (int)$porciones[$i];

                        $dataClient1->save();
                    }

                }

                

            break;
            
            case ($request->id == "" && $request->type == 5):


                $fileName = "ust3.png";

                if ($request->hasFile('value'))

                {

                    $request->validate([

                        'value' => 'image|mimes:jpg,png,jpeg|max:9000|dimensions:min_width=600,min_height=400,max_width=600,max_height=400'

                    ]);

                    $destinationPath = storage_path('app/public/adjuntos');



                    if (is_dir(storage_path('app/public/adjuntos'))) 

                    {

                        @chmod(storage_path('app/public/adjuntos'), 0777);

                    }



                    $thumbnail = $request->file('value');



                    $fileName = time().'.'. $thumbnail->getClientOriginalExtension();



                    Image::make($thumbnail)->resize(600, 400, function ($constraint) {

                        $constraint->aspectRatio();

                    })->save($destinationPath.'/'.$fileName);

                }
                

                $dataClient = new Competitions;

                $dataClient->thumbnail   = $fileName ;

                $dataClient->created_by    = Auth::user()->id;

                $dataClient->is_published    = $request->status;

                $dataClient->formulario    = $formulario;

                $dataClient->created_at    = date("Y-m-d H:i:s");

                $dataClient->updated_at    = date("Y-m-d H:i:s");

                $dataClient->save(); 

                $idcomp = $dataClient->idcomp;
                
            break;
            case ($request->id != "" && $request->type == 5):

                $fileName = "ust3.png";

                if ($request->hasFile('value'))

                {

                    $request->validate([

                        'value' => 'image|mimes:jpg,png,jpeg|max:9000|dimensions:min_width=600,min_height=400,max_width=600,max_height=400'

                    ]);

                    $destinationPath = storage_path('app/public/adjuntos');



                    if (is_dir(storage_path('app/public/adjuntos'))) 

                    {

                        @chmod(storage_path('app/public/adjuntoss'), 0777);

                    }



                    $thumbnail = $request->file('value');



                    $fileName = time().'.'. $thumbnail->getClientOriginalExtension();



                    Image::make($thumbnail)->resize(600, 400, function ($constraint) {

                        $constraint->aspectRatio();

                    })->save($destinationPath.'/'.$fileName);

                }

                $dataClient = Competitions::firstOrNew(['idcomp' => $idcomp]); 
                

                if(is_file(storage_path('app/public/adjuntos')."/".$dataClient->thumbnail)) {

                    unlink(storage_path('app/public/adjuntos')."/".$dataClient->thumbnail);
                
                }

                $dataClient->thumbnail   = $fileName;

                $dataClient->created_by    = Auth::user()->id;

                $dataClient->is_published    = $request->status;

                $dataClient->updated_at    = date("Y-m-d H:i:s");

                $dataClient->save();

            break;
            case ($request->id == "" && $request->type == 6):
                
                $namecatSanitize = filter_var($request->value, FILTER_SANITIZE_STRING);

                $dataClient = new Competitions;

                $dataClient->date_on   = $namecatSanitize;

                $dataClient->created_by    = Auth::user()->id;

                $dataClient->is_published    = $request->status;

                $dataClient->formulario    = $formulario;

                $dataClient->created_at    = date("Y-m-d H:i:s");

                $dataClient->updated_at    = date("Y-m-d H:i:s");

                $dataClient->save(); 

                $idcomp = $dataClient->idcomp;
                
            break;
            case ($request->id != "" && $request->type == 6):

                $namecatSanitize = filter_var($request->value, FILTER_SANITIZE_STRING);

                $dataClient = Competitions::firstOrNew(['idcomp' => $idcomp]); 

                $dataClient->date_on   = $namecatSanitize;

                $dataClient->created_by    = Auth::user()->id;

                $dataClient->is_published    = $request->status;

                $dataClient->updated_at    = date("Y-m-d H:i:s");

                $dataClient->save();

            break;
            case ($request->id == "" && $request->type == 7):
                
                $namecatSanitize = filter_var($request->value, FILTER_SANITIZE_STRING);

                $dataClient = new Competitions;

                $dataClient->date_off   = $namecatSanitize;

                $dataClient->created_by    = Auth::user()->id;

                $dataClient->is_published    = $request->status;

                $dataClient->formulario    = $formulario;

                $dataClient->created_at    = date("Y-m-d H:i:s");

                $dataClient->updated_at    = date("Y-m-d H:i:s");

                $dataClient->save(); 

                $idcomp = $dataClient->idcomp;
                
            break;
            case ($request->id != "" && $request->type == 7):

                $namecatSanitize = filter_var($request->value, FILTER_SANITIZE_STRING);

                $dataClient = Competitions::firstOrNew(['idcomp' => $idcomp]); 

                $dataClient->date_off   = $namecatSanitize;

                $dataClient->created_by    = Auth::user()->id;

                $dataClient->is_published    = $request->status;

                $dataClient->updated_at    = date("Y-m-d H:i:s");

                $dataClient->save();

                $idcomp = $dataClient->idcomp;

            break;
            case ($request->id == "" && $request->type == 8):


                if ($request->hasFile('value'))
    
                {
    
                    $request->validate([
    
                        'value' => 'mimes:jpg,png,jpeg,xlsx,pdf|max:9000'
    
                    ]);
    
                    $destinationPath = storage_path('app/public/adjuntos/files');
    
    
    
                    if (is_dir(storage_path('app/public/adjuntos/files'))) 
    
                    {
    
                        @chmod(storage_path('app/public/adjuntos/files'), 0777);
    
                    }
    
                    
                    
    
                    $thumbnail = $request->file('value');
    
    
    
                    $fileName = time().'.'. $thumbnail->getClientOriginalExtension();
    
    
    
                    move_uploaded_file($thumbnail, $destinationPath.'/'.$fileName);
    
                }
                    
                $namecatSanitize = filter_var($request->desc, FILTER_SANITIZE_STRING);
    
                $dataClient = new Competitions;
    
                $dataClient->created_by    = Auth::user()->id;
    
                $dataClient->is_published    = $request->status;
    
                $dataClient->created_at    = date("Y-m-d H:i:s");
    
                $dataClient->updated_at    = date("Y-m-d H:i:s");

                $dataClient->formulario    = $formulario;
    
                $dataClient->save(); 
    
                $idcomp = $dataClient->idcomp;
    
                $dataClient1 = new FilesCompetitions;
    
                $dataClient1->idcomp   = $idcomp;

                $dataClient1->descripcion   = $namecatSanitize;
    
                $dataClient1->filename   = $fileName;
    
                $dataClient1->created_at    = date("Y-m-d H:i:s");
    
                $dataClient1->updated_at    = date("Y-m-d H:i:s");
    
                $dataClient1->save(); 

                $files = FilesCompetitions::firstOrNew(['idcomp' => $idcomp]);
                
            break;
            case ($request->id != "" && $request->type == 8):

                if ($request->hasFile('value'))
    
                {
    
                    $request->validate([
    
                        'value' => 'mimes:jpg,png,jpeg,xlsx,pdf|max:9000'
    
                    ]);
    
                    $destinationPath = storage_path('app/public/adjuntos/files');
    
    
    
                    if (is_dir(storage_path('app/public/adjuntos/files'))) 
    
                    {
    
                        @chmod(storage_path('app/public/adjuntos/files'), 0777);
    
                    }
    
                    
                    
    
                    $thumbnail = $request->file('value');
    
    
    
                    $fileName = time().'.'. $thumbnail->getClientOriginalExtension();
    
    
    
                    move_uploaded_file($thumbnail, $destinationPath.'/'.$fileName);
    
                }
                 
                $namecatSanitize = filter_var($request->desc, FILTER_SANITIZE_STRING);

                $dataClient = Competitions::firstOrNew(['idcomp' => $idcomp]); 
    
                $dataClient->created_by    = Auth::user()->id;
    
                $dataClient->is_published    = $request->status;
    
                $dataClient->updated_at    = date("Y-m-d H:i:s");
    
                $dataClient->save(); 
    
                $idcomp = $dataClient->idcomp;
    
                $dataClient1 = new FilesCompetitions;
    
                $dataClient1->idcomp   = $idcomp;

                $dataClient1->descripcion   = $namecatSanitize;
    
                $dataClient1->filename   = $fileName;
    
                $dataClient1->created_at    = date("Y-m-d H:i:s");
    
                $dataClient1->updated_at    = date("Y-m-d H:i:s");
    
                $dataClient1->save();

                $files = FilesCompetitions::where(['idcomp' => $idcomp])->get();
    
            break;
            
            default:
                # code...
            break;
        }

        return response()->json(['id' => $dataClient->idcomp, 'type' => $request->type, 'files' => $files]);

    }

    public function eliarcadjconadm(Request $request)
    {
        $files = FilesCompetitions::where(['idfile' => $request->id])->delete();

        if(is_file(storage_path('app/public/adjuntos/files')."/".$request->name)) {

            unlink(storage_path('app/public/adjuntos/files')."/".$request->name);
        
        }
        
        $files = FilesCompetitions::where(['idcomp' => $request->idcon])->get();

        return response()->json(['id' => $request->id, 'type' => $request->idcon, 'files' => $files]);
    }

    public function finingconadm(Request $request)
    {
        
        $id = $request->idconval;

        $dataClient = Competitions::firstOrNew(['idcomp' => $id]);

        $dataClient->created_by    = Auth::user()->id;

        $dataClient->is_published    = 2;

        $dataClient->updated_at    = date("Y-m-d H:i:s");

        $dataClient->save();

        if($request->form == "proceso1")
        {
            return redirect()->route('buscar-concursos-registrados-administradores')->with('success', trans('multi-leng.a35'));
        }
        return redirect()->route('buscar.concursos.registrados.administradores.fase.dos')->with('success', trans('multi-leng.a35'));
        
    }

    public function vervisconusureg($id = null)
    {
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

        return view('concursos.verconcursos', compact('post', 'tags', 'files'));
    }

    public function edivisconadm($id = null)
    {
        $new = $id;

        $id = Crypt::decrypt($id);
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $post = CategoriesCompetitions::join('competitions as c', 'c.category_id', '=', 'categoriesCompetitions.idcatcom')

        ->join('users as u', 'u.id', '=', 'c.created_by')

        ->where("c.idcomp", $id)

        ->first(['c.*', 'categoriesCompetitions.namecat as titlecat', 'u.name as nameus', 'u.surname as surnameus']);

        $catall = CategoriesCompetitions::all();

        $arreglocat = array();
        if($post->category_id == 6)
        {
            array_push($arreglocat, array('title' => "Seleccione al menos una Categoría", 'id' => 0, 'tipo' => 'selected'));
        }
        else
        {
            array_push($arreglocat, array('title' => "Seleccione al menos una Categoría", 'id' => 0, 'tipo' => ''));
        }
        

        foreach($catall as $row)

        {
            if($post->category_id == $row->idcatcom && $post->category_id != 6)
            {
                array_push($arreglocat, array('title' => $row->namecat, 'id' => $row->idcatcom, 'tipo' => 'selected'));
            }
            else
            {
                array_push($arreglocat, array('title' => $row->namecat, 'id' => $row->idcatcom, 'tipo' => ''));
            }

        }

        $arreglo = array();

        $tagsselect = TagsComp::join('competitions_tag as comtag', 'tagcomp.idtag', '=', 'comtag.tag_id')

        ->where("comtag.comp_id", $id)

        ->get(['tagcomp.tagnom', 'tagcomp.idtag']);

        foreach($tagsselect as $row)

        {

            array_push($arreglo, array('title' => $row->tagnom, 'id' => $row->idtag, 'tipo' => 'selected'));

        }

        

        $tags = TagsComp::select('tagcomp.tagnom', 'tagcomp.idtag')

        ->whereNotIn('idtag', CompetitionsTags::join('tagcomp as tag', 'tag.idtag', '=', 'competitions_tag.tag_id')

        ->where("competitions_tag.comp_id", $id)

        ->get(['competitions_tag.tag_id'])->toArray())

        ->get();

        foreach($tags as $row)

        {

            array_push($arreglo, array('title' => $row->tagnom, 'id' => $row->idtag, 'tipo' => ''));

        }

        $files = FilesCompetitions::where('idcomp', $id)->get();
        //dd(compact('post', 'tagsselect', 'tags', 'catall', 'arreglo'));
        return view('concursos.editnew', compact('post', 'tagsselect', 'tags', 'catall', 'arreglo', 'arreglocat', 'files'), ["idnew" => $id]);

    }
    public function elivisconadm(Request $request)
    {
        $new = $request->idpost;

        $id = Crypt::decrypt($request->idpost);

        $dataClient = Competitions::firstOrNew(['idcomp' => $id]);

        $dataClient->created_by    = Auth::user()->id;

        $dataClient->is_published    = 0;

        $dataClient->updated_at    = date("Y-m-d H:i:s");

        $dataClient->save();

        return redirect()->route('buscar-concursos-registrados-administradores')->with('success', trans('multi-leng.a35'));
    }


    public function busconregrev()
    {
        $categories = CategoriesCompetitions::all();

        $posts = Competitions::join('categoriesCompetitions  as cat', 'competitions.category_id', '=', 'cat.idcatcom')

        ->join('users as u', 'u.id', '=', 'competitions.created_by')

        ->where('competitions.is_published', 2)

        ->get(['competitions.*', 'cat.namecat as namecat', 'u.name as nameus', 'u.surname as surnameus']);

        return view('revisor.index', compact('posts','categories'));
    }

    public function verposconreg($id = null)
    {
        $array1 = array();

        $id = Crypt::decrypt($id);

        $conttemp = Competitions::select('statuspos', 'formulario')->where('idcomp', $id)->count();

        $useraudit = User::select('*')->where('cargo_us', 'Auditor')->get();

        switch (true) 
        {
            case ($conttemp == 1):

                $not = DB::table('notifications')->where(['tipo' => 'general'])->get();
            
                $statusconc = Competitions::select('statuspos', 'formulario')->where('idcomp', $id)->first();

                switch (true) 
                {
                    case ($statusconc->formulario == "proceso1"):

                        $comp = Competitions::join('postulations as post', 'post.idconc', '=', 'competitions.idcomp')

                        ->join('categoriesCompetitions  as cat', 'competitions.category_id', '=', 'cat.idcatcom')

                        ->join('users as u', 'u.id', '=', 'post.idus')

                        ->where('competitions.idcomp', $id)

                        ->get(['post.status', 'post.idpost', 'competitions.title', 'cat.namecat as namecat', 'u.name as nameuser', 'u.surname as surnameuser']);
                        
                        

                        $auditcomp = array();

                        $val1 = 0;

                        foreach($comp as $c)
                        {
                            $audit = array();

                            

                            $array2 = array();

                            $answ = Answers::select('idansw')->where('id_post', $c->idpost)->orderBy('idansw', 'desc')->get();

                            $cont = 1;

                            $maxvalue = [];

                            $val = 1;

                            $newarray = Answers::select('idansw')->where('id_post', $c->idpost)->orderBy('idansw', 'asc')->first();
                            
                            foreach($newarray as $n)
                            {
                                $auditnew = array();

                                $astasnew = DB::table('actas')->where( ['id_proy' => $c->idpost])->count();
                                
                                switch (true) 
                                {
                                    case ($astasnew == 0):

                                        foreach( $useraudit as $u )
                                        {
                                            array_push($auditnew, array('status' => $c->status, "idpost" => $c->idpost, "iduser" => $u->id, "idactadit" => 0, "nombre" => $u->name.' '.$u->surname, "seleccionado" => "ninguno", "statusaudit" => "ninguno"));
                                        }
                                        
                                    break;
                                    
                                    default:
                                        
                                        foreach( $useraudit as $u )
                                        {
                                            if(DB::table('actas')->where( ['actas.id_proy' => $c->idpost, 'ac.idaudit' => $u->id] )->join('actasadit as ac', 'actas.id', '=', 'ac.idacta')->exists())
                                            {
                                                $newconsult = DB::table('actas')->select('ac.id', 'ac.status')->where( ['actas.id_proy' => $c->idpost, 'ac.idaudit' => $u->id] )->join('actasadit as ac', 'actas.id', '=', 'ac.idacta')->first();
                                                array_push($auditnew, array('status' => $c->status, "idpost" => $c->idpost, "iduser" => $u->id, "idactadit" => $newconsult->id, "nombre" => $u->name.' '.$u->surname, "seleccionado" => "si", "statusaudit" => $newconsult->status));
                                            }
                                            else
                                            {
                                                array_push($auditnew, array('status' => $c->status, "idpost" => $c->idpost, "iduser" => $u->id, "idactadit" => 0, "nombre" => $u->name.' '.$u->surname, "seleccionado" => "no", "statusaudit" => "no"));
                                            }
                                            
                                        }

                                    break;
                                }
                            }
                            
                            $val1 = 0;

                            foreach($answ as $a)
                            {

                                if (DB::table('corrections')->where(['id_answ' => $a->idansw])->exists()) 
                                {
                                    $tot = DB::table('corrections')->where(['id_answ' => $a->idansw])->first();
                                    
                                    $exist = 'si';

                                    $sum = (int)$tot->resp1 + (int)$tot->resp2 + (int)$tot->resp3 + (int)$tot->resp4 + (int)$tot->resp5 + (int)$tot->resp6 + (int)$tot->resp7 + (int)$tot->ptje1 + (int)$tot->ptje2 + (int)$tot->ptje3 + (int)$tot->ptje4 + (int)$tot->ptje5 + (int)$tot->ptje6 + (int)$tot->ptje7 + (int)$tot->ptje8 + (int)$tot->ptje9 + (int)$tot->ptje10 + (int)$tot->ptje11  + (int)$tot->ptje12;
                                    
                                }
                                else
                                {
                                    $sum = 0;

                                    $exist = 'no';

                                }
                                array_push($array2, array('idansw' => $a->idansw, 'cont' => $cont, 'puntaje' => $sum, 'existe' => $exist));

                                $maxvalue[] = $sum;

                                $cont++;
                            }

                            array_push($array1, array('idpost' => $c->idpost, 'status' => $c->status, 'titlecat' => $c->title, 'namecat' => $c->namecat, 'user' => $c->nameuser.' '.$c->surnameuser, 'puntajemax' => max($maxvalue),  'answ' => $array2, "cont1" => $c->count(), "auditores" => $auditnew ) );
                            
                        }
                        //dd($array1);
                        return view('admin.postulaciones.userspost', ['array1' => $array1, "idconc" => Crypt::encrypt($id), 'statusconc' => $statusconc->statuspos, 'not' => $not, "useraudit" => $useraudit ]);
                    break;
                    case ($statusconc->formulario == "proceso2"):
                        
                        $comp = Competitions::join('postulations as post', 'post.idconc', '=', 'competitions.idcomp')

                        ->join('categoriesCompetitions  as cat', 'competitions.category_id', '=', 'cat.idcatcom')

                        ->join('users as u', 'u.id', '=', 'post.idus')

                        ->where('competitions.idcomp', $id)

                        ->get(['post.status', 'post.idpost', 'competitions.title', 'cat.namecat as namecat', 'u.name as nameuser', 'u.surname as surnameuser']);
                        
                        $auditcomp = array();

                        $val1 = 0;

                        foreach($comp as $c)
                        {
                            $audit = array();

                            $array2 = array();

                            $answ = DB::table('etapa1')->select('id')->where('id_post', $c->idpost)->orderBy('id', 'desc')->get();

                            $cont = 1;

                            $maxvalue = [];

                            $val = 1;

                            $newarray = DB::table('etapa1')->select('id')->where('id_post', $c->idpost)->orderBy('id', 'desc')->first();
                            
                            foreach($newarray as $n)
                            {
                                $auditnew = array();

                                $astasnew = DB::table('actas')->where( ['id_proy' => $c->idpost])->count();
                                
                                switch (true) 
                                {
                                    case ($astasnew == 0):

                                        foreach( $useraudit as $u )
                                        {
                                            array_push($auditnew, array('status' => $c->status, "idpost" => $c->idpost, "iduser" => $u->id, "idactadit" => 0, "nombre" => $u->name.' '.$u->surname, "seleccionado" => "ninguno", "statusaudit" => "ninguno"));
                                        }
                                        
                                    break;
                                    
                                    default:
                                        
                                        foreach( $useraudit as $u )
                                        {
                                            if(DB::table('actas')->where( ['actas.id_proy' => $c->idpost, 'ac.idaudit' => $u->id] )->join('actasadit as ac', 'actas.id', '=', 'ac.idacta')->exists())
                                            {
                                                $newconsult = DB::table('actas')->select('ac.id', 'ac.status')->where( ['actas.id_proy' => $c->idpost, 'ac.idaudit' => $u->id] )->join('actasadit as ac', 'actas.id', '=', 'ac.idacta')->first();
                                                array_push($auditnew, array('status' => $c->status, "idpost" => $c->idpost, "iduser" => $u->id, "idactadit" => $newconsult->id, "nombre" => $u->name.' '.$u->surname, "seleccionado" => "si", "statusaudit" => $newconsult->status));
                                            }
                                            else
                                            {
                                                array_push($auditnew, array('status' => $c->status, "idpost" => $c->idpost, "iduser" => $u->id, "idactadit" => 0, "nombre" => $u->name.' '.$u->surname, "seleccionado" => "no", "statusaudit" => "no"));
                                            }
                                            
                                        }

                                    break;
                                }
                            }
                            $val1 = 0;

                            foreach($answ as $a)
                            {
                                
                                if (DB::table('correctionsprocesodos')->where(['id_post' => $c->idpost])->exists()) 
                                {
                                    $tot = DB::table('correctionsprocesodos')->where(['id_post' => $c->idpost])->first();
                                    
                                    $exist = 'si';

                                    $sum = (int)$tot->eval1;
                                    
                                }
                                else
                                {
                                    $sum = 0;

                                    $exist = 'no';

                                }
                                array_push($array2, array('idansw' => $a->id, 'cont' => $cont, 'puntaje' => $sum, 'existe' => $exist));

                                $maxvalue[] = $sum;

                                $cont++;
                            }
                            
                            array_push($array1, array('idpost' => $c->idpost, 'status' => $c->status, 'titlecat' => $c->title, 'namecat' => $c->namecat, 'user' => $c->nameuser.' '.$c->surnameuser, 'puntajemax' => max($maxvalue),  'answ' => $array2, "cont1" => $c->count(), "auditores" => $auditnew ) );
                        }
                        
                        return view('admin.postulaciones.userpostfasedos', ['statusconc' => $statusconc->statuspos, "idconc" => Crypt::encrypt($id), 'array1' => $array1, 'not' => $not, "useraudit" => $useraudit ]);
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
    
    
    public function verposregrev()
    {
        
    }

    public function forzarpost()
    {
        
        $id = 235;
        $idusua = 2849;
        $post = Postulations::where(['idconc' =>  $id, 'idus' => $idusua])->count();

        if($post == 0)
        {
            $post = new Postulations;

            $post->idconc = $id;

            $post->idus = $idusua;

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
        
            dd("postulada");

            
        }
        else
        {
            dd("ya se encuentran postulada");
        }
    }
}