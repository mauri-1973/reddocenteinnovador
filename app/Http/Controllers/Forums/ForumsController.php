<?php



namespace App\Http\Controllers\Forums;



use App\Http\Controllers\Controller;

use App\Http\Requests\StorePostRequest;

use App\Http\Requests\UpdatePostRequest;

use App\User;

use App\Categoryblog;

use App\Post;

use App\Tagblog;

use App\PostTag;

use App\Commentblog;

use App\CategoriesForums;

use App\Resource;

use App\ForumParticipants;

use App\ForumAnswers;

use App\ForumComments;

use App\TagsComments;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Intervention\Image\Facades\Image as Image;

use Symfony\Component\HttpFoundation\Response;

use Illuminate\Http\JsonResponse;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Crypt;

use Yajra\DataTables\DataTables;

use File;



class ForumsController extends Controller

{

    /**

    *

    * allow blog only

    *

    */

    public function __construct() {

        //$this->middleware(['role:admin|creator']);

        $this->middleware('auth');

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function indexforunms()

    {
        $cat = CategoriesForums::select('categoriesforums.idcatfor as idcatfor', 'categoriesforums.created_at as created_at', 'categoriesforums.namecat as namecatfor', 'sub.name as namesub','cat.name as namecat', 'us.name as name', 'us.surname as surname')
                ->join('resources as res', 'res.id_rec', 'categoriesforums.idres')
                ->join('users as us', 'res.user_id', 'us.id')
                ->join('subcategories as sub', 'res.subcategory_id', 'sub.id_sub')
                ->join('categories as cat', 'sub.cat_id', 'cat.id_cat')
                ->get();
        
        $array = array();
        foreach($cat as $row)
        {
            $numfor = "no";
            $idforpar = "";
            $part = ForumParticipants::where(['idcatfor' =>  $row->idcatfor, 'iduser' => Auth::user()->id])->get();
            foreach($part as $p)
            {
                $numfor = (int)$p->statusidfor;
                $idforpar = $p->idforpar;
            }
            array_push($array, array("idcatfor" => $row->idcatfor, "namecatforo" => $row->namecatfor, "fecha" => $row->created_at->format('d-m-Y H:i:s'), "namesub" => $row->namesub, "namecat" => $row->namecat, "numfor" => $numfor, "idforpar" => $idforpar, "namedocente" => $row->name.' '.$row->surname));
             
        }
        
        return view('forums.indexforums', ["array" => $array]);

    }

    public function solaccfordoc($idcat = null)
    {
        $idcat = Crypt::decrypt($idcat);
        $part = ForumParticipants::select('*')->where(["iduser" => Auth::user()->id, "idcatfor" => $idcat ])->count();
        
        if($part == 0)
        {
            $part = new ForumParticipants;
            $part->iduser          = Auth::user()->id;
            $part->idcatfor        = $idcat;
            $part->statusidfor     = 0;
            $part->save();
            if($part->save())
            {
                return redirect()->action('Forums\ForumsController@indexforunms')->with('success', trans('multi-leng.formerror180'));
            }
            else
            {
                return redirect()->route('Forums\ForumsController@indexforunms')->with('warning', trans('multi-leng.formerror81'));
            }
        }
        if($part == 1)
        {
            $part = ForumParticipants::select('*')->where(["iduser" => Auth::user()->id, "idcatfor" => $idcat ])->first();

            if($part->statusidfor == 0)
            {
                return redirect()->action('Forums\ForumsController@indexforunms')->with('success', trans('multi-leng.formerror182'));
            }
            if($part->statusidfor == 1)
            {
                return redirect()->action('Forums\ForumsController@indexforunms')->with('success', trans('multi-leng.formerror183'));
            }
            if($part->statusidfor == 2)
            {
                return redirect()->action('Forums\ForumsController@indexforunms')->with('success', trans('multi-leng.formerror184'));
            }
        }
        if($part > 1)
        {
            return redirect()->route('Forums\ForumsController@indexforunms')->with('warning', trans('multi-leng.formerror81'));
        }
    }

    public function accfordoc(Request $request)
    {
        $cat = CategoriesForums::select('categoriesforums.idcatfor as idcatfor', 'categoriesforums.created_at as created_at', 'categoriesforums.namecat as namecatfor', 'sub.name as namesub','cat.name as namecat', 'us.name as name', 'us.surname as surname')
                ->join('resources as res', 'res.id_rec', 'categoriesforums.idres')
                ->join('users as us', 'res.user_id', 'us.id')
                ->join('subcategories as sub', 'res.subcategory_id', 'sub.id_sub')
                ->join('categories as cat', 'sub.cat_id', 'cat.id_cat')
                ->get();
        foreach($cat as $row)
        {
            $array = array();
            $numfor = "";
            $idforpar = "";
            $part = ForumParticipants::where(['idcatfor' =>  $row->idcatfor, 'iduser' => Auth::user()->id])->get();
            foreach($part as $p)
            {
                $numfor = $p->statusidfor;
                $idforpar = $p->idforpar;
            }
            array_push($array, array("idcatfor" => $row->idcatfor, "namecatforo" => $row->namecatfor, "fecha" => $row->created_at->format('d-m-Y H:i:s'), "namesub" => $row->namesub, "namecat" => $row->namecat, "numfor" => $numfor, "idforpar" => $idforpar, "namedocente" => $row->name.' '.$row->surname));
        }
        return view('forums.indexforums', ["array" => $array]);

    }
    

    public function addforunmsdoc()

    {
        $cat = CategoriesForums::join("resources as res", "res.id_rec", "categoriesforums.idres")
        ->where('res.user_id', Auth::user()->id)
        ->get(['categoriesforums.*']);
        $array = array();
        foreach($cat as $row)
        {
            $statuspen = ForumParticipants::where('statusidfor', 0)->where('iduser', '!=', Auth::user()->id)->count();
            $statusact = ForumParticipants::where('statusidfor', 1)->where('iduser', '!=', Auth::user()->id)->count();
            $statusact = ForumParticipants::where('statusidfor', 2)->where('iduser', '!=', Auth::user()->id)->count(); 
            array_push($array, array("idcat" => $row->idcatfor, "fecha" => $row->created_at->format('d-m-Y H:i:s'), "namecat" => $row->namecat, "uspen" => $statuspen, "usact" => $statusact, "useli" => $statusact));
        }
        $array2 = array();
        $rec = Resource::join('subcategories as sub','sub.id_sub','=','resources.subcategory_id')
        ->where('resources.user_id', Auth::user()->id)
        ->get(['resources.id_rec', 'sub.name']); 
        foreach($rec as $row)
        {
            array_push($array2, array(["id_sub" => Crypt::encrypt($row->id_rec), "name" => $row->name]));
        }
        return view('forums.indexforumsdoc', ["categories" => $array, "rec" => $array2]);

    }

    public function valnomcatfor(Request $request)

    {
        
        $idcat = Crypt::decrypt($request->selectcat);
        $val = 2;
        $val1 = CategoriesForums::where(["idres" => $idcat, "namecat" => $request->name])->count();
        if($val1 == 0)
        {
            $val = 1;
        }
        return response()->json(['status' => $val]);
    }

    public function ingcatdocfor(Request $request)

    {
        $idcat = Crypt::decrypt($request->selectcat);
        $cat = new CategoriesForums;
        $cat->namecat         = $request->namecat;
        $cat->idres          = $idcat;
        if($cat->save())
        {
            return redirect()->route('categorias-forums-docentes-registrados')->with('success', trans('multi-leng.formerror118'));
        }
        else
        {
            return redirect()->route('categorias-forums-docentes-registrados')->with('warning', trans('multi-leng.formerror119'));
        }
               

    }

    public function businffordoc(Request $request)

    {
        $idcat = Crypt::decrypt($request->idcat);
        
        if($request->tipo == 0)
        {
            $array = array();
            $statuspen = ForumParticipants::where('statusidfor', 1)->where('idcatfor', $idcat)->count();
            if($statuspen > 0)
            {
                $for = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
                ->where('forum_participants.statusidfor', 1)
                ->where('forum_participants.iduser', '!=', Auth::user()->id)
                ->where('forum_participants.idcatfor', $idcat)
                ->get(['us.name as nameus', 'us.id as idus' ,'us.surname', 'forum_participants.idforpar']);
                foreach($for as $row) 
                {
                    array_push($array, array("nombre" => $row->nameus.' '.$row->surname, "idus" => $row->idus , "idforpar" => $row->idforpar));
                }
            }
            return response()->json(['tipo' => $request->tipo, "count" => count($array), "array" => $array ]);
        }
        if($request->tipo == 1)
        {
            $array = array();
            $statuspen = ForumParticipants::where('statusidfor', 0)->where('forum_participants.idcatfor', $idcat)->count();
            if($statuspen > 0)
            {
                $for = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
                ->where('forum_participants.statusidfor', 0)
                ->where('forum_participants.iduser', '!=', Auth::user()->id)
                ->where('forum_participants.idcatfor', $idcat)
                ->get(['us.name as nameus', 'us.surname', 'us.id as idus' , 'forum_participants.idforpar']);
                foreach($for as $row) 
                {
                    array_push($array, array("nombre" => $row->nameus.' '.$row->surname, "idus" => $row->idus , "idforpar" => $row->idforpar));
                }
            }
            return response()->json(['tipo' => $request->tipo, "count" => count($array), "array" => $array ]);
        }
        if($request->tipo == 2)
        {
            $array = array();
            $statuspen = ForumParticipants::where('statusidfor', 2)->where('idcatfor', $idcat)->count();
            if($statuspen > 0)
            {
                $for = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
                ->where('forum_participants.statusidfor', 2)
                ->where('forum_participants.iduser', '!=', Auth::user()->id)
                ->where('forum_participants.idcatfor', $idcat)
                ->get(['us.name as nameus', 'us.surname', 'us.id as idus' , 'forum_participants.idforpar']);
                foreach($for as $row) 
                {
                    array_push($array, array("nombre" => $row->nameus.' '.$row->surname, "idus" => $row->idus , "idforpar" => $row->idforpar));
                }
            }
            return response()->json(['tipo' => $request->tipo, "count" => count($array), "array" => $array ]);
        }
        if($request->tipo == 3)
        {
            $array = array();
            $array1 = array();
            $array2 = array();
            $statuspen = ForumParticipants::where('statusidfor', 1)->where('idcatfor', $idcat)->count();
            if($statuspen > 0)
            {
                $for = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
                ->where('forum_participants.statusidfor', 1)
                ->where('forum_participants.idcatfor', $idcat)
                ->get(['us.name as nameus', 'us.surname', 'us.id as idus', 'forum_participants.idforpar']);
                
                foreach($for as $row) 
                {
                    $comm = ForumComments::where('idforpar', $row->idforpar)->get();
                    foreach($comm as $row1)
                    {
                        $array1 = array();
                        $answ = ForumAnswers::where('idforcom', $row1->idforcom)->get();
                        foreach($answ as $row2)
                        {
                            $array2 = array();
                            array_push($array2, array("idforans" => $row2->idforans, "answers" => $row2->answers));
                        }
                        array_push($array1, array("idforcom" => $row1->idforcom, "comments" => $row1->comments, "resp" => $array2));
                    }

                    array_push($array, array("nombre" => $row->nameus.''.$row->surname, "idus" => $row->idus , "idforpar" => $row->idforpar, "comments" => $array1));
                }
            }
            return response()->json(['tipo' => $request->tipo, "count" => count($array), "array" => $array ]);
        }
        if($request->tipo == 5)
        {
            $text1 = "";
            $text2 = "";
            $text3 = "";
            $text4 = "";
            $text5 = "";
            $array = array();
            $array1 = array();
            $comm = ForumComments::where('idforcom', $idcat)->first();
            $tags = TagsComments::where('idcomment', $idcat)->orderBy("idtag","asc")->get();
            
            foreach($tags as $ta => $t)
            {
                if($ta == 0)
                {
                    $text1 = $t->nametag;
                }
                if($ta == 1)
                {
                    $text2 = $t->nametag;
                }
                if($ta == 2)
                {
                    $text3 = $t->nametag;
                }
                if($ta == 3)
                {
                    $text4 = $t->nametag;
                }
                if($ta == 4)
                {
                    $text5 = $t->nametag;
                }
            }
            array_push($array, array("titulo" => $comm->title, "contenido" => $comm->comments ));
            array_push($array1, array("tag1" => $text1, "tag2" => $text2, "tag3" => $text3, "tag4" => $text4, "tag5" => $text5 ));
            return response()->json(['idcat' => $idcat, 'forum' => $array, 'tags' => $array1 ]);
        }
        
    }

    public function editcatdocfor(Request $request)
    {
        $idcat = Crypt::decrypt($request->selectcat);

        $cat = CategoriesForums::firstOrNew(['idcatfor' =>  $idcat]);

        $cat->namecat = $request->namecat;

        if($cat->save())
        {
            return redirect()->route('categorias-forums-docentes-registrados')->with('success', trans('multi-leng.formerror127'));
        }
        else
        {
            return redirect()->route('categorias-forums-docentes-registrados')->with('warning', trans('multi-leng.formerror128'));
        }
    }

    public function elicatdocfor(Request $request)
    {

        $idcat = Crypt::decrypt($request->selectcat);

        $statuspen = ForumParticipants::where('statusidfor', 1)->where('idcatfor', $idcat)->count();

        if($statuspen > 0)
        {
            $for = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
            ->where('forum_participants.statusidfor', 1)
            ->where('forum_participants.idcatfor', $idcat)
            ->get(['us.name as nameus', 'us.surname', 'forum_participants.idforpar']);
            
            foreach($for as $row) 
            {
                $comm = ForumComments::where('idforpar', $row->idforpar)->get();
                foreach($comm as $row1)
                {
                    $answ = ForumAnswers::where('idforcom', $row1->idforcom)->get();
                    foreach($answ as $row2)
                    {
                        $answ = ForumAnswers::where('idforans', $row2->idforans)->delete();
                    }
                    $comm = ForumComments::where('idforpar', $row->idforpar)->delete();
                }
                
            }
            $par = ForumParticipants::where('idcatfor', $row->idforpar)->delete();
        }

        $val1 = CategoriesForums::where(["idcatfor" => $idcat])->delete();

        return redirect()->route('categorias-forums-docentes-registrados')->with('warning', trans('multi-leng.formerror130'));
    }

    public function accforusuact($idcat = null)
    
    {
        setlocale(LC_ALL,"es_ES");
        \Carbon\Carbon::setLocale('es');
        $idcat = Crypt::decrypt($idcat);

        $cat = CategoriesForums::join('resources as res','res.id_rec','=','categoriesforums.idres')
        ->join('subcategories  as sub','sub.id_sub','=','res.subcategory_id')
        ->join('users as us','us.id','=','res.user_id')
        ->where(['categoriesforums.idcatfor' =>  $idcat])
        ->first(['categoriesforums.idcatfor as idcatfor', 'categoriesforums.namecat as namecat', 'categoriesforums.created_at as fecha', 'sub.name as namesubcat', 'us.name as nameus', 'us.surname as surname', 'us.email as email', 'us.id as idus']);
        $array = [];
        $array1 = array();

        $contresp = 0;
        $contvis = 0;
        $contvotos = 0;
        $conttopic = 0;
        $part = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
        ->where(['forum_participants.idcatfor' => $idcat, "statusidfor" => 1])
        ->get(['forum_participants.idforpar', 'us.id as idus', 'us.name as nameus', 'us.surname as surname']);
        $participantes = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
        ->where(['forum_participants.idcatfor' => $idcat, "statusidfor" => 1])
        ->distinct('us.id')
        ->count();
        
        foreach($part as $row)
        {
            $array[] = $row->idforpar;
            
        }
        $commentmore = ForumComments::whereIn('idforpar', $array)->where('visitas', '>=', 1)->orderBy('visitas', 'desc')->skip(0)->take(5)->get();
        $arraysup = array();
        foreach($commentmore as $row)
        {
            foreach($part as $row1)
            {
                if($row1->idforpar == $row->idforpar)
                {
                    $nombreus = $row1->nameus;
                    $surnameus = $row1->surname;
                    $idus = $row1->idus;
                }
                
            }
            array_push($arraysup, array('idcomment' => $row->idforcom, 'usuario' => $nombreus.' '.$surnameus , "idus" => Crypt::encrypt($idus), 'title' => $row->title,'fecha' => $row->created_at->diffForHumans(), 'idcommentcryp' => Crypt::encrypt($row->idforcom)));
        }
        $comment = ForumComments::whereIn('idforpar', $array)->orderBy('idforcom', 'desc')->get();
        foreach($comment as $row)
        {
            $conttopic++;
            foreach($part as $row1)
            {
                if($row1->idforpar == $row->idforpar)
                {
                    $nombreus = $row1->nameus;
                    $surnameus = $row1->surname;
                    $idus = $row1->idus;
                }
                
            }
            $tags = array();
            
            $valtags = TagsComments::where(['idcomment' => $row->idforcom, 'tipotag' => 'comments'])->get();
            foreach($valtags as $valt)
            {
                array_push($tags, array("nametag" => $valt->nametag)); 
            }
            $contresp = $contresp + $row->respuestas;
            $contvis = $contvis + $row->visitas;
            $contvotos = $contvotos + $row->votos;
            array_push($array1, array('idcomment' => $row->idforcom, 'usuario' => $nombreus.' '.$surnameus , "idus" => Crypt::encrypt($idus), 'contenido' => Str::limit(strip_tags($row->comments), 100), 'title' => $row->title,'fecha' => $row->created_at->diffForHumans(), 'votos' => $row->votos, 'respuestas' => $row->respuestas, 'visitas' => $row->visitas, 'tags' => $tags, 'idcommentcryp' => Crypt::encrypt($row->idforcom), 'idforpar' => Crypt::encrypt($row->idforpar), "idcat" => Crypt::encrypt($idcat), "idusreal" => $idus ));
           
        }
        
        return view('forums.vistageneralforum', ["cat" => $cat, "topic" => $array1, 'totalcoment' => $conttopic, 'votos' => $contvotos, 'part' => $participantes, 'visitas' => $contvis, "idcat" => $idcat, 'more' => $arraysup ]);
    }

    public function addnuetemfor(Request $request)

    {
        
        $idcat = Crypt::decrypt($request->idcat);
        /*$par = ForumParticipants::where(['idcatfor' => $idcat, "iduser" => Auth::user()->id])->count();
        if($par == 0)
        {
            $part = new ForumParticipants;
            $part->iduser          = Auth::user()->id;
            $part->idcatfor        = $idcat;
            $part->statusidfor     = 1;
            $part->save();
            $idforpar  = $part->idforpar;
        }
        if($par == 1)
        {
            $part = ForumParticipants::where(['idcatfor' => $idcat, "iduser" => Auth::user()->id, "statusidfor" => 1])->first();
            $idforpar  = $part->idforpar;
        }
        if($par > 1)
        {
            return redirect()->route('categorias-forums-docentes-registrados')->with('danger', trans('multi-leng.formerror138'));
        }*/
        $part = new ForumParticipants;
        $part->iduser          = Auth::user()->id;
        $part->idcatfor        = $idcat;
        $part->statusidfor     = 1;
        $part->save();
        $idforpar  = $part->idforpar;

        $part = new ForumComments;
        $part->idforpar        = $idforpar;
        $part->title           = $request->nametopic;
        $part->comments        = $request->summernote;
        $part->votos           = 0;
        $part->respuestas      = 0;
        $part->visitas         = 0;
        $part->save();
        $val = $part->idforcom;
        if($val)
        {
            if($request->tag1 != "")
            {
                $tag = new TagsComments;
                $tag->idcomment      = $val;
                $tag->nametag        = str_replace("#", "", $request->tag1);
                $tag->tipotag      = 'comments';
                $tag->save();
            }
            if($request->tag2 != "")
            {
                $tag = new TagsComments;
                $tag->idcomment      = $val;
                $tag->nametag        = str_replace("#", "", $request->tag2);
                $tag->tipotag      = 'comments';
                $tag->save();
            }
            if($request->tag3 != "")
            {
                $tag = new TagsComments;
                $tag->idcomment      = $val;
                $tag->nametag        = str_replace("#", "", $request->tag3);
                $tag->tipotag      = 'comments';
                $tag->save();
            }
            if($request->tag4 != "")
            {
                $tag = new TagsComments;
                $tag->idcomment      = $val;
                $tag->nametag        = str_replace("#", "", $request->tag4);
                $tag->tipotag      = 'comments';
                $tag->save();
            }
            if($request->tag5 != "")
            {
                $tag = new TagsComments;
                $tag->idcomment      = $val;
                $tag->nametag        = str_replace("#", "", $request->tag5);
                $tag->tipotag      = 'comments';
                $tag->save();
            }
            return redirect()->route('acceder-forum-usuarios-activos', ["idcat" => $request->idcat])->with('success', trans('multi-leng.formerror139'));
        }
        else
        {
            return redirect()->route('acceder-forum-usuarios-activos', ["idcat" => $request->idcat])->with('warnig', trans('multi-leng.formerror140'));
        }
    }
    public function deletenuetemfor(Request $request)
    {
        $idforpart = Crypt::decrypt($request->idforumpart);
        $idcat = $request->idcat;
        ForumParticipants::where('idforpar', $idforpart)->update(['statusidfor' => 0]);
        return redirect()->route('acceder-forum-usuarios-activos', ['idcat' => Crypt::encrypt((int)$idcat)])->with('success', trans('multi-leng.a257'));
    }
    public function editnuetemfor(Request $request)
    {
       
        $idcript = Crypt::decrypt($request->idcript);
        TagsComments::where('idcomment', $idcript)->delete();
        $eit = ForumComments::where('idforcom', $idcript)->update(["title" => $request->nametopic, "comments" => $request->summernote]);
        if($request->tag1 != "")
        {
            $tag = new TagsComments;
            $tag->idcomment      = $idcript;
            $tag->nametag        = str_replace("#", "", $request->tag1);
            $tag->tipotag      = 'comments';
            $tag->save();
        }
        if($request->tag2 != "")
        {
            $tag = new TagsComments;
            $tag->idcomment      = $idcript;
            $tag->nametag        = str_replace("#", "", $request->tag2);
            $tag->tipotag      = 'comments';
            $tag->save();
        }
        if($request->tag3 != "")
        {
            $tag = new TagsComments;
            $tag->idcomment      = $idcript;
            $tag->nametag        = str_replace("#", "", $request->tag3);
            $tag->tipotag      = 'comments';
            $tag->save();
        }
        if($request->tag4 != "")
        {
            $tag = new TagsComments;
            $tag->idcomment      = $idcript;
            $tag->nametag        = str_replace("#", "", $request->tag4);
            $tag->tipotag      = 'comments';
            $tag->save();
        }
        if($request->tag5 != "")
        {
            $tag = new TagsComments;
            $tag->idcomment      = $idcript;
            $tag->nametag        = str_replace("#", "", $request->tag5);
            $tag->tipotag      = 'comments';
            $tag->save();
        }
        $idcat = $request->idcat;
        return redirect()->route('acceder-forum-usuarios-activos', ['idcat' => Crypt::encrypt((int)$idcat)])->with('success', trans('multi-leng.a258'));
    }

    public function businfusucon(Request $request)
    {
        $idus = Crypt::decrypt($request->idus);

        $user = User::where('id', $idus)->first();

        return response()->json(['name' => $user->name.' '.$user->surname, "email" => $user->email, "mobile" => $user->mobile, "avatar" => $user->avatar, "profesion" => $user->profesion]);
    }

    public function vercontemfor($idcom = null, $idcat = null)
    {
        $display = "none";

        $from = date('Y-m-d').' 00:00:00';

        $to = date('Y-m-d').' 23:59:59';

        $idcom = Crypt::decrypt($idcom);

        $votos = DB::table('forum_votos')->where(['id_commen' => $idcom, 'id_user' => Auth::user()->id])->whereBetween('created_at', [$from, $to])->count();

        if($votos == 0)
        {
            $display = "block";
        }

        $comment = ForumComments::where('idforcom', $idcom)->update(["visitas" => DB::raw('visitas+1')]);

        $comment = ForumComments::where('idforcom', $idcom)->first();

        if($comment->count() > 0)
        {
            $part = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
            ->where(['forum_participants.idforpar' => $comment->idforpar, "statusidfor" => 1])
            ->first(['forum_participants.idforpar', 'us.id as idus', 'us.name as nameus', 'us.surname as surname']);
        }
        
        $tags = TagsComments::where('idcomment', $idcom)->get(); 

        $array = array();

        $idresp = [];

        $resp = ForumAnswers::where('idforcom', $idcom)->orderBy('created_at', 'desc')->get(); 

        foreach($resp as $row)
        {
            $display1 = "none";
            $votosresp = DB::table('forum_votos')->where(['id_answ' => $row->idforans, 'id_user' => Auth::user()->id])->whereBetween('created_at', [$from, $to])->count();
            if($votosresp == 0)
            {
                $display1 = "block";
            }
            $partuno = User::where('id', $row->iduser)->first();
            array_push($array, array('name' => $partuno->name.' '.$partuno->surname, "idus" => $partuno->id, "idresp" => $row->idforans, "respuesta" => $row->answers , "votos" => $row->votos, "fecha" => $row->created_at->diffForHumans(), 'display' => $display1));
            $idresp[] = $row->idforans;
        }
        return view('forums.vistunicoforum', compact('comment', 'tags', 'part'), ["resp" => $array, "idresp" => $idresp, "idcom" => Crypt::encrypt($idcom), "idcat" => (int)$idcat, "display" => $display]);
    }

    public function envresasutem(Request $request)
    {
       
        $idcom = Crypt::decrypt($request->idforcom);

        $commentresp = ForumComments::where('idforcom', $idcom)->first();

        $part = ForumParticipants::where(['idforpar' => $commentresp->idforpar, "statusidfor" => 1])->first();
        
        $comment = new ForumAnswers;
        $comment->idforcom       = $idcom;
        $comment->answers        = $request->summernote;
        $comment->iduser        = Auth::user()->id;
        $comment->save();
        if((int)$request->ratingdos > 0)
        {
            $votos = DB::table('forum_votos')->insert(["id_commen" => $idcom, "id_user" =>  Auth::user()->id ]);
        }
        
        $comment = ForumComments::where('idforcom', $idcom)->update(["votos" => ((int)$commentresp->votos + (int)$request->ratingdos), "respuestas" => ((int)$commentresp->respuestas + 1)]);
        
        return redirect()->action('Forums\ForumsController@vercontemfor',['idcom' => $request->idforcom, 'idcat' => $part->idcatfor ])->with('success', trans('multi-leng.formerror146'));
    }
    
    public function guavotresusu(Request $request)
    {
        $idcom = Crypt::decrypt($request->idresp);
        $votos = ForumAnswers::where('idforans', $idcom)->first();
        if((int)$request->ratingdos > 0)
        {
            $votosresp = DB::table('forum_votos')->insert(["id_answ" => $idcom, "id_user" =>  Auth::user()->id ]);
        }
        $comment = ForumAnswers::where('idforans', $idcom)->update(["votos" => $votos->votos + $request->ratingdos]);
        return redirect()->action('Forums\ForumsController@vercontemfor',['idcom' => $request->idforcom, 'idcat' => $request->idcat])->with('success', trans('multi-leng.formerror145'));
    }
    public function eliresusu(Request $request)
    {
        $idcom = Crypt::decrypt($request->idresp);
        $comment = ForumAnswers::where('idforans', $idcom)->delete();
        return redirect()->action('Forums\ForumsController@vercontemfor',['idcom' => $request->idforcom, 'idcat' => $request->idcat])->with('danger', trans('multi-leng.formerror163'));
    }

    public function lisusuestingdoc($idcat = null, $tipo = null)
    {
        $idcat = Crypt::decrypt($idcat);
        
        if($tipo == 0)
        {
            $array = array();
            $statuspen = ForumParticipants::where('statusidfor', 1)->where('idcatfor', $idcat)->count();
            if($statuspen > 0)
            {
                $for = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
                ->where('forum_participants.statusidfor', 1)
                ->where('forum_participants.iduser', '!=', Auth::user()->id)
                ->where('forum_participants.idcatfor', $idcat)
                ->get(['us.name as nameus', 'us.id as idus' ,'us.surname', 'forum_participants.idforpar', 'forum_participants.created_at as created_at']);
                foreach($for as $row) 
                {
                    array_push($array, array("nombre" => $row->nameus.' '.$row->surname, "idus" => $row->idus , "idforpar" => $row->idforpar, "fecha" => $row->created_at->format('d-m-Y H:i:s')));
                }
            }
            
        }
        if($tipo == 1)
        {
            $array = array();
            $statuspen = ForumParticipants::where('statusidfor', 0)->where('forum_participants.idcatfor', $idcat)->count();
            if($statuspen > 0)
            {
                $for = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
                ->where('forum_participants.statusidfor', 0)
                ->where('forum_participants.iduser', '!=', Auth::user()->id)
                ->where('forum_participants.idcatfor', $idcat)
                ->get(['us.name as nameus', 'us.surname', 'us.id as idus' , 'forum_participants.idforpar', 'forum_participants.created_at as created_at']);
                foreach($for as $row) 
                {
                    array_push($array, array("nombre" => $row->nameus.' '.$row->surname, "idus" => $row->idus , "idforpar" => $row->idforpar, "fecha" => $row->created_at->format('d-m-Y H:i:s')));
                }
            }
            
        }
        if($tipo == 2)
        {
            $array = array();
            $statuspen = ForumParticipants::where('statusidfor', 2)->where('idcatfor', $idcat)->count();
            if($statuspen > 0)
            {
                $for = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
                ->where('forum_participants.statusidfor', 2)
                ->where('forum_participants.iduser', '!=', Auth::user()->id)
                ->where('forum_participants.idcatfor', $idcat)
                ->get(['us.name as nameus', 'us.surname', 'us.id as idus' , 'forum_participants.idforpar' , 'forum_participants.created_at as created_at']);
                foreach($for as $row) 
                {
                    array_push($array, array("nombre" => $row->nameus.' '.$row->surname, "idus" => $row->idus , "idforpar" => $row->idforpar, "fecha" => $row->created_at->format('d-m-Y H:i:s')));
                }
            }
        }
        return view('forums.listadousuariosforum', ['tipo' => $tipo, "count" => count($array), "array" => $array ]);
    }

    public function accusudocfor($tipo = null, $idforpar = null)
    {
        if($tipo == 1)
        {
            $text = trans('multi-leng.formerror187');
            $text1 = "success";
        }
        if($tipo == 2)
        {
            $text = trans('multi-leng.formerror184');
            $text1 = "danger";
        }
        $idforpar = Crypt::decrypt($idforpar);
        $for = ForumParticipants::where('idforpar', $idforpar)->update(['statusidfor' => $tipo]);
        return redirect()->route('categorias-forums-docentes-registrados')->with($text1, $text);
    }


    public function verconforpubusureg()

    {
        
        if (request()->ajax()) 
        {
            $conteos = DB::table('forum_participants')
            ->selectRaw("
                SUM(CASE WHEN statusidfor = 0 AND iduser != ? AND idcatfor IS NULL AND typeforum = 'publico' THEN 1 ELSE 0 END) AS uspen,
                SUM(CASE WHEN statusidfor = 1 AND iduser != ? AND idcatfor IS NULL AND typeforum = 'publico' THEN 1 ELSE 0 END) AS usact,
                SUM(CASE WHEN statusidfor = 2 AND iduser != ? AND idcatfor IS NULL AND typeforum = 'publico' THEN 1 ELSE 0 END) AS useli
            ", [Auth::user()->id, Auth::user()->id, Auth::user()->id])
            ->first();
            $forumQuery = DB::table('forum_public as fp')
                ->select('fp.id', 'fp.created_at', 'fp.nameforum', 'u.name', 'u.surname', 'u.email')
                ->join('users as u', 'fp.iduser', '=', 'u.id')
                ->where('fp.statusforum', 1);
            return DataTables::of($forumQuery)
                ->addColumn('nombre', function($row){
                    return $row->name  . ' ' . $row->surname ;
                })
                ->addColumn('fecha', function($row){
                    return \Carbon\Carbon::parse($row->created_at ?? date('d-m-Y H:i:s'))->format('d-m-Y H:i:s');
                })
                ->addColumn('uspen', function($row) use ($conteos) {
                    return $conteos->uspen ?? 0;
                })
                ->addColumn('usact', function($row) use ($conteos) {
                    return $conteos->usact ?? 0;
                })
                ->addColumn('useli', function($row) use ($conteos) {
                    return $conteos->useli ?? 0;
                })
                ->addColumn('idencrypt', function($row) use ($conteos) {
                    return Crypt::encrypt($row->id);
                })
                ->toJson();
        }

        return view('forums.indexforumpublic');
    }

    public function accforpubusuact($idcat = null)
    
    {
        setlocale(LC_ALL,"es_ES");
        \Carbon\Carbon::setLocale('es');
        
        $idcat = Crypt::decrypt($idcat);

        $cat = DB::table('forum_public as fp')
                ->select('fp.id', 'fp.created_at', 'fp.nameforum', 'u.name', 'u.surname', 'u.email')
                ->join('users as u', 'fp.iduser', '=', 'u.id')
                ->where(['fp.statusforum' => 1, 'fp.id' => $idcat])
                ->orderBy('fp.id', 'desc')
                ->count();
        
        if($cat > 0)
        {

            $cat = DB::table('forum_public as fp')
                ->select('fp.id', 'fp.created_at', 'fp.nameforum', 'u.name', 'u.surname', 'u.email')
                ->join('users as u', 'fp.iduser', '=', 'u.id')
                ->where('fp.statusforum', 1)
                ->orderBy('fp.id', 'desc')
                ->first();

            $us = 0;
            $visitas = 0;
            $the = 0;
            $votos = 0;
            $respuestas = 0;
            $cont = 0;

            $themes =   DB::table('forumpubtheme')
                        ->where("idforpub", $cat->id)
                        ->count();

            if($themes > 0)
            {
                
                $the = $themes;
                $cont =     DB::table('forumpubtheme')
                            ->where('idforpub', $cat->id)
                            ->selectRaw('SUM(visitas) as visitas, SUM(votos) as votos, SUM(respuestas) as respuestas')
                            ->first();
                $visitas = $cont->visitas;
                $votos = $cont->votos;
                $respuestas = $cont->respuestas;

                $conteos = DB::table('forum_participants')
                ->where(["statusidfor" => 1, "idforpub" => $cat->id, "idcatfor" => NULL, "typeforum" => "publico"])
                ->distinct('iduser')
                ->count();
                if($conteos > 0)
                {
                    
                    $us = $conteos;
                    
                }
            }
                
            
            return view('forums.ingresousuarios', compact('cat'), ['usact' => $us, 'visitas' => $visitas, 'votos' => $votos, 'respuestas' => $respuestas, 'themes' => $the] );
        }
        else
        {
            return view('forums.ingresoadminsindatos');
        }
    }

    public function verconforpubusuregcambiar($idcom = null)
    {
        $display = "none";

        $from = date('Y-m-d').' 00:00:00';

        $to = date('Y-m-d').' 23:59:59';

        $idcom = Crypt::decrypt($idcom);
        //$idcom = 16;
        

        $votos = DB::table('forumpub_votos')->where(['id_commen' => $idcom, 'id_user' => Auth::user()->id])->whereBetween('created_at', [$from, $to])->count();

        if($votos == 0)
        {
            $display = "block";
        }

        $comment = DB::table('forumpubtheme')->where('idforthe', $idcom)->update(["visitas" => DB::raw('visitas+1')]);

        $comment = DB::table('forumpubtheme')->where('idforthe', $idcom)->count();

       
        if($comment == 1)
        {
            $comment = DB::table('forumpubtheme')->where('idforthe', $idcom)->first();
            $part = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
            ->where(['forum_participants.idforpub' => $comment->idforpub, "statusidfor" => 1])
            ->first(['forum_participants.idforpub', 'us.id as idus', 'us.name as nameus', 'us.surname as surname']);
        }
        
        $tags = DB::table('tagcommentspub')->where('idforpubthe', $idcom)->get(); 
        
        $array = array();

        $idresp = [];

        $resp = DB::table('forumpub_answers')->where('idforcom', $idcom)->orderBy('created_at', 'desc')->get(); 

        foreach($resp as $row)
        {
            $display1 = "none";
            $votosresp = DB::table('forumpub_votos')->where(['id_answ' => $row->idforans, 'id_user' => Auth::user()->id])->whereBetween('created_at', [$from, $to])->count();
            if($votosresp == 0)
            {
                $display1 = "block";
            }
            $partuno = User::where('id', $row->iduser)->first();
            array_push($array, array('name' => $partuno->name.' '.$partuno->surname, "idus" => $partuno->id, "idresp" => $row->idforans, "respuesta" => $row->answers , "votos" => $row->votos, "fecha" => \Carbon\Carbon::parse($row->created_at)->diffForHumans(null, true), 'display' => $display1));
            $idresp[] = $row->idforans;
        }
        
        return view('forums.vistunicoforumpublic', compact('comment', 'tags', 'part'), ["resp" => $array, "idresp" => $idresp, "idcom" => Crypt::encrypt($idcom), "idcat" => $comment->idforpub, "display" => $display]);
    }
    public function accforusuactaja(Request $request)
    {
        if (request()->ajax()) 
        {
            $idforpub = Crypt::decrypt($request->idfor);
            if($request->type == 'normal')
            {
                $query = DB::table('forumpubtheme as fpt')
                        ->select(
                            'fpt.idforthe',
                            'fpt.title',
                            'fpt.comments',
                            'fpt.votos',
                            'fpt.respuestas',
                            'fpt.visitas',
                            'fpt.created_at',
                            'u.id',
                            DB::raw('CONCAT(u.name, " ", u.surname) as nombre')
                        )
                        ->join('forum_public as fp', 'fp.id', '=', 'fpt.idforpub')
                        ->join('users as u', 'u.id', '=', 'fp.iduser')
                        ->where('fpt.idforpub', $idforpub);

                    // Filtros personalizados de orden
                    $filter = $request->get('filter');
                    switch ($filter) {
                        case '1': // Más Votados
                            $query->orderBy('fpt.votos', 'desc');
                            break;
                        case '2': // Más Respuestas
                            $query->orderBy('fpt.respuestas', 'desc');
                            break;
                        case '3': // Más Vistos
                            $query->orderBy('fpt.visitas', 'desc');
                            break;
                        default:
                            $query->orderBy('fpt.idforthe', 'desc');
                    }

                    return DataTables::of($query)
                        ->addColumn('fecha', function($user) {
                            return \Carbon\Carbon::parse($user->created_at)->diffForHumans(null, true);
                        })
                        ->addColumn('encrypt', function($user) {
                            return Crypt::encrypt($user->idforthe);
                        })
                        ->addColumn('tags', function($user) {
                            // Si necesitas un array
                            return DB::table('tagcommentspub')
                                ->where('idforpubthe', $user->idforthe)
                                ->pluck('nametag')
                                ->values();
                        })
                        ->filterColumn('nombre', function($query, $keyword) {
                            $query->whereRaw("LOWER(CONCAT(u.name, ' ', u.surname)) LIKE ?", ["%".strtolower($keyword)."%"]);
                        })
                        ->filterColumn('tags_item', function($query, $keyword) {
                            $query->whereExists(function ($sub) use ($keyword) {
                                $sub->select(DB::raw(1))
                                    ->from('tagcommentspub')
                                    ->whereColumn('tagcommentspub.idforpubthe', 'fpt.idforthe')
                                    ->where('tagcommentspub.nametag', 'like', "%{$keyword}%");
                            });
                        })
                        ->make(true);
            }
            
        }
    }

    public function vercontemforpub($idcom = null)
    {
        $display = "none";

        $from = date('Y-m-d').' 00:00:00';

        $to = date('Y-m-d').' 23:59:59';

        $idcom = Crypt::decrypt($idcom);
        //$idcom = 16;
        

        $votos = DB::table('forumpub_votos')->where(['id_commen' => $idcom, 'id_user' => Auth::user()->id])->whereBetween('created_at', [$from, $to])->count();

        if($votos == 0)
        {
            $display = "block";
        }

        $comment = DB::table('forumpubtheme')->where('idforthe', $idcom)->update(["visitas" => DB::raw('visitas+1')]);

        $comment = DB::table('forumpubtheme')->where('idforthe', $idcom)->count();

       
        if($comment == 1)
        {
            $comment = DB::table('forumpubtheme')->where('idforthe', $idcom)->first();
            $part = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
            ->where(['forum_participants.idforpub' => $comment->idforpub, "statusidfor" => 1])
            ->first(['forum_participants.idforpub', 'us.id as idus', 'us.name as nameus', 'us.surname as surname']);
        }
        
        $tags = DB::table('tagcommentspub')->where('idforpubthe', $idcom)->get(); 
        
        $array = array();

        $idresp = [];

        $resp = DB::table('forumpub_answers')->where('idforcom', $idcom)->orderBy('created_at', 'desc')->get(); 

        foreach($resp as $row)
        {
            $display1 = "none";
            $votosresp = DB::table('forumpub_votos')->where(['id_answ' => $row->idforans, 'id_user' => Auth::user()->id])->whereBetween('created_at', [$from, $to])->count();
            if($votosresp == 0)
            {
                $display1 = "block";
            }
            $partuno = User::where('id', $row->iduser)->first();
            array_push($array, array('name' => $partuno->name.' '.$partuno->surname, "idus" => $partuno->id, "idresp" => $row->idforans, "respuesta" => $row->answers , "votos" => $row->votos, "fecha" => \Carbon\Carbon::parse($row->created_at)->diffForHumans(null, true), 'display' => $display1));
            $idresp[] = $row->idforans;
        }
        
        return view('forums.vistunicoforumpublic', compact('comment', 'tags', 'part'), ["resp" => $array, "idresp" => $idresp, "idcom" => Crypt::encrypt($idcom), "idcat" => $comment->idforpub, "display" => $display]);
    }
    public function businfforpub(Request $request)
    {
        
        $idcat = Crypt::decrypt($request->idcat);
        
        if($request->tipo == 0)
        {
            $array = array();
            $statuspen = ForumParticipants::where('statusidfor', 1)->where('idcatfor', $idcat)->count();
            if($statuspen > 0)
            {
                $for = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
                ->where('forum_participants.statusidfor', 1)
                ->where('forum_participants.iduser', '!=', Auth::user()->id)
                ->where('forum_participants.idcatfor', $idcat)
                ->get(['us.name as nameus', 'us.id as idus' ,'us.surname', 'forum_participants.idforpar']);
                foreach($for as $row) 
                {
                    array_push($array, array("nombre" => $row->nameus.' '.$row->surname, "idus" => $row->idus , "idforpar" => $row->idforpar));
                }
            }
            return response()->json(['tipo' => $request->tipo, "count" => count($array), "array" => $array ]);
        }
        if($request->tipo == 1)
        {
            $array = array();
            $statuspen = ForumParticipants::where('statusidfor', 0)->where('forum_participants.idcatfor', $idcat)->count();
            if($statuspen > 0)
            {
                $for = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
                ->where('forum_participants.statusidfor', 0)
                ->where('forum_participants.iduser', '!=', Auth::user()->id)
                ->where('forum_participants.idcatfor', $idcat)
                ->get(['us.name as nameus', 'us.surname', 'us.id as idus' , 'forum_participants.idforpar']);
                foreach($for as $row) 
                {
                    array_push($array, array("nombre" => $row->nameus.' '.$row->surname, "idus" => $row->idus , "idforpar" => $row->idforpar));
                }
            }
            return response()->json(['tipo' => $request->tipo, "count" => count($array), "array" => $array ]);
        }
        if($request->tipo == 2)
        {
            $array = array();
            $statuspen = ForumParticipants::where('statusidfor', 2)->where('idcatfor', $idcat)->count();
            if($statuspen > 0)
            {
                $for = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
                ->where('forum_participants.statusidfor', 2)
                ->where('forum_participants.iduser', '!=', Auth::user()->id)
                ->where('forum_participants.idcatfor', $idcat)
                ->get(['us.name as nameus', 'us.surname', 'us.id as idus' , 'forum_participants.idforpar']);
                foreach($for as $row) 
                {
                    array_push($array, array("nombre" => $row->nameus.' '.$row->surname, "idus" => $row->idus , "idforpar" => $row->idforpar));
                }
            }
            return response()->json(['tipo' => $request->tipo, "count" => count($array), "array" => $array ]);
        }
        if($request->tipo == 3)
        {
            $array = array();
            $array1 = array();
            $array2 = array();
            $statuspen = ForumParticipants::where('statusidfor', 1)->where('idcatfor', $idcat)->count();
            if($statuspen > 0)
            {
                $for = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
                ->where('forum_participants.statusidfor', 1)
                ->where('forum_participants.idcatfor', $idcat)
                ->get(['us.name as nameus', 'us.surname', 'us.id as idus', 'forum_participants.idforpar']);
                
                foreach($for as $row) 
                {
                    $comm = ForumComments::where('idforpar', $row->idforpar)->get();
                    foreach($comm as $row1)
                    {
                        $array1 = array();
                        $answ = ForumAnswers::where('idforcom', $row1->idforcom)->get();
                        foreach($answ as $row2)
                        {
                            $array2 = array();
                            array_push($array2, array("idforans" => $row2->idforans, "answers" => $row2->answers));
                        }
                        array_push($array1, array("idforcom" => $row1->idforcom, "comments" => $row1->comments, "resp" => $array2));
                    }

                    array_push($array, array("nombre" => $row->nameus.''.$row->surname, "idus" => $row->idus , "idforpar" => $row->idforpar, "comments" => $array1));
                }
            }
            return response()->json(['tipo' => $request->tipo, "count" => count($array), "array" => $array ]);
        }
        if($request->tipo == 5)
        {
            
            $text1 = "";
            $text2 = "";
            $text3 = "";
            $text4 = "";
            $text5 = "";
            $array = array();
            $array1 = array();
            $comm = DB::table('forumpubtheme')->where('idforthe', $idcat)->first();
            $tags = DB::table('tagcommentspub')->where('idforpubthe', $idcat)->orderBy("idtag","asc")->get();
            
            foreach($tags as $ta => $t)
            {
                if($ta == 0)
                {
                    $text1 = $t->nametag;
                }
                if($ta == 1)
                {
                    $text2 = $t->nametag;
                }
                if($ta == 2)
                {
                    $text3 = $t->nametag;
                }
                if($ta == 3)
                {
                    $text4 = $t->nametag;
                }
                if($ta == 4)
                {
                    $text5 = $t->nametag;
                }
            }
            array_push($array, array("titulo" => $comm->title, "contenido" => $comm->comments ));
            array_push($array1, array("tag1" => $text1, "tag2" => $text2, "tag3" => $text3, "tag4" => $text4, "tag5" => $text5 ));
            return response()->json(['idcat' => $idcat, 'forum' => $array, 'tags' => $array1 ]);
        }
        if($request->tipo == 6)
        {
            $val = DB::table('forumpubtheme')->select('idforpub')->where('idforthe', $idcat)->first();
            $part = DB::table('forumpubtheme')->where('idforthe', $idcat)->update([
                'title' => mb_convert_case(mb_strtolower($request->nametopic, 'UTF-8'), MB_CASE_TITLE, "UTF-8"),
                'comments' => $request->summernote,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            DB::table('tagcommentspub')->where('idforpubthe', $idcat)->delete();
            if($request->tag1 != "")
            {
                DB::table('tagcommentspub')->insertGetId([
                    'idforpubthe' => $idcat,
                    'nametag' => mb_convert_case(mb_strtolower(str_replace("#", "", $request->tag1), 'UTF-8'), MB_CASE_TITLE, "UTF-8"),
                    'tipotag' => 'comments',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
            if($request->tag2 != "")
            {
                DB::table('tagcommentspub')->insertGetId([
                    'idforpubthe' => $idcat,
                    'nametag' => mb_convert_case(mb_strtolower(str_replace("#", "", $request->tag2), 'UTF-8'), MB_CASE_TITLE, "UTF-8"),
                    'tipotag' => 'comments',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
            if($request->tag3 != "")
            {
                DB::table('tagcommentspub')->insertGetId([
                    'idforpubthe' => $idcat,
                    'nametag' => mb_convert_case(mb_strtolower(str_replace("#", "", $request->tag3), 'UTF-8'), MB_CASE_TITLE, "UTF-8"),
                    'tipotag' => 'comments',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
            if($request->tag4 != "")
            {
                DB::table('tagcommentspub')->insertGetId([
                    'idforpubthe' => $idcat,
                    'nametag' => mb_convert_case(mb_strtolower(str_replace("#", "", $request->tag4), 'UTF-8'), MB_CASE_TITLE, "UTF-8"),
                    'tipotag' => 'comments',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
            if($request->tag5 != "")
            {
                DB::table('tagcommentspub')->insertGetId([
                    'idforpubthe' => $idcat,
                    'nametag' => mb_convert_case(mb_strtolower(str_replace("#", "", $request->tag5), 'UTF-8'), MB_CASE_TITLE, "UTF-8"),
                    'tipotag' => 'comments',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
            return redirect()->route('acceder.forum.usuarios.activos.foro.publico', ["idcat" => Crypt::encrypt($val->idforpub)])->with('success', "El tema fue editado correctamente");
        }
        if($request->tipo == 7)
        {
            
            $val = DB::table('forumpubtheme')->select('idforpub')->where('idforthe', $idcat)->first();
            $part = DB::table('forumpubtheme')->where('idforthe', $idcat)->delete();
            
            return redirect()->route('acceder.forum.usuarios.activos.foro.publico', ["idcat" => Crypt::encrypt($val->idforpub)])->with('success', "El tema fue eliminado correctamente");
        }
        if($request->tipo == 8)
        {
            
            $idcom = Crypt::decrypt($request->idcat);
            $commentresp = DB::table('forumpubtheme')->where('idforthe', $idcom)->first();
            $part = ForumParticipants::where(['idforpar' => $commentresp->idforpub, "statusidfor" => 1])->first();
            
            $comment = DB::table('forumpub_answers')->insertGetId([
                    'idforcom' => $idcom,
                    'answers' => $request->summernote,
                    'iduser' => Auth::user()->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            if($comment > 0)
            {
                if((int)$request->ratingdos > 0)
                {
                    $votos = DB::table('forumpub_votos')->insert(["id_commen" => $idcom, "id_user" =>  Auth::user()->id ]);
                }
                $comment = DB::table('forumpubtheme')->where('idforthe', $idcom)->update(["votos" => ((int)$commentresp->votos + (int)$request->ratingdos), "respuestas" => ((int)$commentresp->respuestas + 1)]);

                return redirect()->route('ver.contenido.tema.foro.publico.usuario.registrado', ["idfortem" => $request->idcat])->with('success', trans('multi-leng.formerror146'));
            }
            
            return redirect()->route('ver.contenido.tema.foro.publico', ["idfortem" => $request->idcat])->with('danger', "No pudimos procesar su solicitad. Inténtelo más tarde.");
            
            
        }
        if($request->tipo == 9)
        {
            $idforcom = Crypt::decrypt($request->idforcom);
            $idresp = Crypt::decrypt($request->idresp);
            $idcom = Crypt::decrypt($request->idresp);

            $votos = DB::table('forumpub_answers')->where('idforans', $idcom)->first();
            if((int)$request->ratingdos > 0)
            {
                $votosresp = DB::table('forum_votos')->insert(["id_answ" => $idcom, "id_user" =>  Auth::user()->id ]);
            }
            $comment = DB::table('forumpub_answers')->where('idforans', $idcom)->update(["votos" => $votos->votos + $request->ratingdos]);

            //return redirect()->action('Forums\ForumsController@vercontemfor',['idcom' => $request->idforcom, 'idcat' => $request->idcat])->with('success', trans('multi-leng.formerror145'));
            
            return redirect()->route('ver.contenido.tema.foro.publico.usuario.registrado', ["idfortem" => $request->idforcom])->with('success', trans('multi-leng.formerror145'));
            
            
        }
        if($request->tipo == 10)
        {
            $idcom = Crypt::decrypt($request->idresp);

            $comment = DB::table('forumpub_answers')->where('idforans', $idcom)->delete();

            return redirect()->route('ver.contenido.tema.foro.publico', ["idfortem" => $request->idforcom])->with('success', trans('multi-leng.formerror163'));
            
            
        }
        
        
    }
    
}