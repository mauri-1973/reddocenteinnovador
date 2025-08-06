<?php



namespace App\Http\Controllers\Blog;



use App\User;

use App\Category;

use App\Subcategory;

use App\Link;

use App\ForumParticipants;

use App\CategoriesForums;

use App\Resource;
/******************* */
use App\ForumComments;

use App\TagsComments;

use App\ForumAnswers;
/******************* */

use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\Controller;

use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

use App\UserLoginLog;

use Illuminate\Support\Facades\Crypt;

use Yajra\DataTables\DataTables;

class ForumsController extends Controller

{

     /**

    *

    * allow admin only

    *

    */

    public function __construct() {

        $this->middleware(['role:blog']);

    }



    /**

     * Display a listing of User.

     *

     * @return \Illuminate\Http\Response

     */

    public function accforpubblo()

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
                ->where(['fp.statusforum' => 1, 'fp.iduser' => Auth::user()->id ]);
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

        return view('forums.indexforumpublicblog');
    }
    public function ingforpubblo(Request $request)
    {
        switch (true) 
        {
            case ($request->type == "add"):
                $name = DB::table('forum_public')->where('nameforum', mb_convert_case(mb_strtolower($request->namecat, 'UTF-8'), MB_CASE_TITLE, "UTF-8"))->count();
                switch (true) 
                {
                    case ($name == 0):

                        $add = DB::table('forum_public')->insert(["iduser" => Auth::user()->id, "nameforum" => mb_convert_case(mb_strtolower($request->namecat, 'UTF-8'), MB_CASE_TITLE, "UTF-8"), "statusforum" =>  1]);
                        if($add)
                        {
                            return redirect()->route('acciones.foro.publico.blog')->with('success', "El foro ha sido creado correctamente.");
                        }
                        else
                        {
                            return redirect()->route('acciones.foro.publico.blog')->with('danger', "El foro no ha sido creado, Inténtelo nuevamente.");
                        }
                        
                    break;

                    case ($name == 1):
                        return redirect()->route('acciones.foro.publico.blog')->with('info', "El nombre del foro ya existe.");
                    break;
                    
                    default:
                        return redirect()->route('acciones.foro.publico.blog')->with('danger', "Hay un error al ingresar el nombre del foro.");
                    break;
                }
            break;
            case ($request->type == "edi"):
                $id = Crypt::decrypt($request->idfor);
                $name = DB::table('forum_public')->where('nameforum', mb_convert_case(mb_strtolower($request->namecat, 'UTF-8'), MB_CASE_TITLE, "UTF-8"))->where('id', '!=', $id)->count();
                switch (true) 
                {
                    case ($name == 0):

                        $add = DB::table('forum_public')->where('id', $id)->update(["nameforum" => mb_convert_case(mb_strtolower($request->namecat, 'UTF-8'), MB_CASE_TITLE, "UTF-8"), 'updated_at' => date('Y-m-d H:i:s')]);
                        if($add)
                        {
                            return redirect()->route('acciones.foro.publico.blog')->with('success', "El nombre de foro ha sido editado correctamente.");
                        }
                        else
                        {
                            return redirect()->route('acciones.foro.publico.blog')->with('danger', "El foro no ha sido editado, Inténtelo nuevamente.");
                        }
                        
                    break;

                    case ($name == 1):

                        return redirect()->route('acciones.foro.publico.blog')->with('info', "El nombre del foro ya existe.");

                    break;
                    
                    default:
                        return redirect()->route('acciones.foro.publico.blog')->with('danger', "Hay un error al editar el nombre del foro.");
                    break;
                }
            break;
            case ($request->type == "del"):

                $id = Crypt::decrypt($request->idfor);

                $add = DB::table('forum_public')->where('id', $id)->update(["statusforum" => 0, 'updated_at' => date('Y-m-d H:i:s')]);
                        if($add)
                        {
                            return redirect()->route('acciones.foro.publico.blog')->with('success', "El foro ha sido eliminado correctamente.");
                        }
                        else
                        {
                            return redirect()->route('acciones.foro.publico.blog')->with('danger', "El foro no ha sido eliminado, Inténtelo nuevamente.");
                        }
            break;
            case((int)$request->tipo == 0):

                $idcat = Crypt::decrypt($request->idcat);
                $array = array();
                $statuspen = ForumParticipants::where(["statusidfor" => 1, "idforpub" => $idcat, "idcatfor" => NULL, "typeforum" => "publico"])->where('iduser', '!=', Auth::user()->id)->count();
                
                if($statuspen > 0)
                {
                    $for = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
                    ->where(["forum_participants.statusidfor" => 1, "forum_participants.idforpub" => $idcat, "forum_participants.idcatfor" => NULL, "forum_participants.typeforum" => "publico"])
                    ->where('forum_participants.iduser', '!=', Auth::user()->id)
                    ->get(['us.name as nameus', 'us.id as idus' ,'us.surname', 'forum_participants.idforpar']);
                    foreach($for as $row) 
                    {
                        array_push($array, array("nombre" => $row->nameus.' '.$row->surname, "idus" => $row->idus , "idforpar" => $row->idforpar));
                    }
                }
                return response()->json(['tipo' => $request->tipo, "count" => count($array), "array" => $array ]);
            break;
            case ((int)$request->tipo == 1):
            
                $idcat = Crypt::decrypt($request->idcat);
                $array = array();
                $statuspen = ForumParticipants::where(["statusidfor" => 0, "idforpub" => $idcat, "idcatfor" => NULL, "typeforum" => "publico"])->where('iduser', '!=', Auth::user()->id)->count();
                if($statuspen > 0)
                {
                    $for = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
                    ->where(["forum_participants.statusidfor" => 0, "forum_participants.idforpub" => $idcat, "forum_participants.idcatfor" => NULL, "forum_participants.typeforum" => "publico"])
                    ->where('forum_participants.iduser', '!=', Auth::user()->id)
                    ->get(['us.name as nameus', 'us.id as idus' ,'us.surname', 'forum_participants.idforpar']);
                    foreach($for as $row) 
                    {
                        array_push($array, array("nombre" => $row->nameus.' '.$row->surname, "idus" => $row->idus , "idforpar" => $row->idforpar));
                    }
                }
                return response()->json(['tipo' => $request->tipo, "count" => count($array), "array" => $array ]);
            break;
            case ((int)$request->tipo == 2):
            
                $idcat = Crypt::decrypt($request->idcat);
                $array = array();
                $statuspen = ForumParticipants::where(["statusidfor" => 2, "idforpub" => $idcat, "idcatfor" => NULL, "typeforum" => "publico"])->where('iduser', '!=', Auth::user()->id)->count();
                if($statuspen > 0)
                {
                    $for = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
                    ->where(["forum_participants.statusidfor" => 2, "forum_participants.idforpub" => $idcat, "forum_participants.idcatfor" => NULL, "forum_participants.typeforum" => "publico"])
                    ->where('forum_participants.iduser', '!=', Auth::user()->id)
                    ->get(['us.name as nameus', 'us.id as idus' ,'us.surname', 'forum_participants.idforpar']);
                    foreach($for as $row) 
                    {
                        array_push($array, array("nombre" => $row->nameus.' '.$row->surname, "idus" => $row->idus , "idforpar" => $row->idforpar));
                    }
                }
                return response()->json(['tipo' => $request->tipo, "count" => count($array), "array" => $array ]);
            break;
            case ((int)$request->tipo == 3):
            
                $idcat = Crypt::decrypt($request->idfor);
                $statuspen = ForumParticipants::where(["idforpar" => $idcat])->count();
                switch (true) {
                    case ($statuspen == 1):
                        $statuspen = ForumParticipants::select('idforpub')->where(["idforpar" => $idcat])->first();
                        $val = Crypt::encrypt($statuspen->idforpub);
                        $statuspen = ForumParticipants::select('idforpub')->where(["idforpar" => $idcat])->update(['statusidfor' => 2]);
                    break;
                    
                    default:
                        abort(404);
                    break;
                }
                
                return redirect()->route('listado.usuarios.estado.ingreso.foro.publico', ["idcat" => $val, "tipo" => 2 ])->with('danger', trans('multi-leng.a295'));
            break;
            case ((int)$request->tipo == 4):
            
                $idcat = Crypt::decrypt($request->idfor);
                $statuspen = ForumParticipants::where(["idforpar" => $idcat])->count();
                switch (true) {
                    case ($statuspen == 1):
                        $statuspen = ForumParticipants::select('idforpub')->where(["idforpar" => $idcat])->first();
                        $val = Crypt::encrypt($statuspen->idforpub);
                        $statuspen = ForumParticipants::select('idforpub')->where(["idforpar" => $idcat])->update(['statusidfor' => 1]);
                    break;
                    
                    default:
                        abort(404);
                    break;
                }
                return redirect()->route('listado.usuarios.estado.ingreso.foro.publico', ["idcat" => $val, "tipo" => 0 ])->with('success', trans('multi-leng.a296'));
            break;
            
            default:
                abort(404);
            break;
        }
    }
    public function lisusuestingforpubblo($idcat = null, $tipo = null)
    {
        $idcat = Crypt::decrypt($idcat);
        
        if($tipo == 0)
        {
            $array = array();
            $statuspen = ForumParticipants::where(["statusidfor" => 1, "idforpub" => $idcat, "idcatfor" => NULL, "typeforum" => "publico"])->where('iduser', '!=', Auth::user()->id)->count();
            if($statuspen > 0)
            {
                $for = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
                ->where(["forum_participants.statusidfor" => 1, "forum_participants.idforpub" => $idcat, "forum_participants.idcatfor" => NULL, "forum_participants.typeforum" => "publico"])
                ->where('forum_participants.iduser', '!=', Auth::user()->id)
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
            $statuspen = ForumParticipants::where(["statusidfor" => 0, "idforpub" => $idcat, "idcatfor" => NULL, "typeforum" => "publico"])->where('iduser', '!=', Auth::user()->id)->count();
            if($statuspen > 0)
            {
                $for = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
                ->where(["forum_participants.statusidfor" => 0, "forum_participants.idforpub" => $idcat, "forum_participants.idcatfor" => NULL, "forum_participants.typeforum" => "publico"])
                ->where('forum_participants.iduser', '!=', Auth::user()->id)
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
            $statuspen = ForumParticipants::where(["statusidfor" => 2, "idforpub" => $idcat, "idcatfor" => NULL, "typeforum" => "publico"])->where('iduser', '!=', Auth::user()->id)->count();
            if($statuspen > 0)
            {
                $for = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
                ->where(["forum_participants.statusidfor" => 2, "forum_participants.idforpub" => $idcat, "forum_participants.idcatfor" => NULL, "forum_participants.typeforum" => "publico"])
                ->where('forum_participants.iduser', '!=', Auth::user()->id)
                ->get(['us.name as nameus', 'us.surname', 'us.id as idus' , 'forum_participants.idforpar' , 'forum_participants.created_at as created_at']);
                foreach($for as $row) 
                {
                    array_push($array, array("nombre" => $row->nameus.' '.$row->surname, "idus" => $row->idus , "idforpar" => $row->idforpar, "fecha" => $row->created_at->format('d-m-Y H:i:s')));
                }
            }
        }
        
        return view('forums.listadousuariosforumpublicoblog', ['tipo' => $tipo, "count" => count($array), "array" => $array ]);
    }
    public function accforusuactblo($idcat = null)
    
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
                ->select('fp.id', 'fp.created_at', 'fp.nameforum', 'u.name', 'u.surname', 'u.email', 'u.id as iduser')
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
                
            
            return view('forums.ingresoadminblog', compact('cat'), ['usact' => $us, 'visitas' => $visitas, 'votos' => $votos, 'respuestas' => $respuestas, 'themes' => $the] );
        }
        else
        {
            return view('forums.ingresoadminsindatos');
        }
    }
    public function accforusuactajablo(Request $request)
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
                            'fp.iduser',
                            'fpt.created_at',
                            'u.id',
                            DB::raw('CONCAT(u.name, " ", u.surname) as nombre')
                        )
                        ->join('forum_public as fp', 'fp.id', '=', 'fpt.idforpub')
                        ->join('users as u', 'u.id', '=', 'fp.iduser')
                        ->where(['fpt.idforpub'=> $idforpub, 'fp.iduser' => Auth::user()->id]);

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
                        break;
                    }

                    return DataTables::of($query)
                        ->addColumn('fecha', function($user) {
                            return \Carbon\Carbon::parse($user->created_at)->diffForHumans(null, true);
                        })
                        ->addColumn('idusuario', function($user) {
                            return Auth::user()->id;
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
    public function businfforpubblo(Request $request)
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
            return redirect()->route('acceder.forum.usuarios.activos.foro.publico.blog', ["idcat" => Crypt::encrypt($val->idforpub)])->with('success', "El tema fue editado correctamente");
        }
        if($request->tipo == 7)
        {
            
            $val = DB::table('forumpubtheme')->select('idforpub')->where('idforthe', $idcat)->first();
            $part = DB::table('forumpubtheme')->where('idforthe', $idcat)->delete();
            
            return redirect()->route('acceder.forum.usuarios.activos.foro.publico.blog', ["idcat" => Crypt::encrypt($val->idforpub)])->with('success', "El tema fue eliminado correctamente");
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
            
            return redirect()->route('ver.contenido.tema.foro.publico.usuario.registrado', ["idfortem" => $request->idcat])->with('danger', "No pudimos procesar su solicitad. Inténtelo más tarde.");
            
            
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
    public function vercontemforpubblo($idcom = null)
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

    public function addnuetemforpubadmblo(Request $request)
    {
        
        $idcat = Crypt::decrypt($request->idcat);

        $us =   DB::table('forum_participants')
                ->where([
                    'iduser' => Auth::user()->id,
                    'idforpub' => $idcat,
                    'typeforum' => 'publico'
                ])
                ->count();
        switch (true) 
        {
            case ($us == 0):

                $part = DB::table('forum_participants')->insertGetId([
                            'iduser' => Auth::user()->id,
                            'idforpub' => $idcat,
                            'typeforum' => 'publico', 
                            'statusidfor' => 1, 
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                ]);

            break;
            case ($us == 1):

                $us =   DB::table('forum_participants')
                ->select('idforpar')
                ->where([
                    'iduser' => Auth::user()->id,
                    'idforpub' => $idcat,
                    'typeforum' => 'publico'
                ])
                ->first();

                $part = $us->idforpar;

            break;
            default:
                return redirect()->route('acceder.forum.usuarios.activos.foro.publico.blog', ["idcat" => $request->idcat])->with('warnig', trans('multi-leng.formerror140'));
            break;
        }
        
        if($part > 0)
        {

            $idforpar  = $part;

            $us =   DB::table('forum_participants')
                ->where([
                    'iduser' => Auth::user()->id,
                    'idforpub' => $idcat,
                    'typeforum' => 'publico'
                ])
                ->count();
            switch (true) 
            {
                case ($us == 0):

                    $part = DB::table('forum_participants')->insertGetId([
                                'iduser' => Auth::user()->id,
                                'idforpub' => $idcat,
                                'typeforum' => 'publico', 
                                'statusidfor' => 1, 
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                    ]);

                break;

                default:
                
                break;
            }

            $part = DB::table('forumpubtheme')->insertGetId([
                        'idforpub' => $idcat,
                        'title' => mb_convert_case(mb_strtolower($request->nametopic, 'UTF-8'), MB_CASE_TITLE, "UTF-8"),
                        'comments' => $request->summernote, 
                        'votos' => 0,
                        'respuestas' => 0,
                        'visitas' => 0,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
            $val = $part;

            if($val > 0)
            {
                if($request->tag1 != "")
                {
                    DB::table('tagcommentspub')->insertGetId([
                        'idforpubthe' => $val,
                        'nametag' => mb_convert_case(mb_strtolower(str_replace("#", "", $request->tag1), 'UTF-8'), MB_CASE_TITLE, "UTF-8"),
                        'tipotag' => 'comments',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
                if($request->tag2 != "")
                {
                    DB::table('tagcommentspub')->insertGetId([
                        'idforpubthe' => $val,
                        'nametag' => mb_convert_case(mb_strtolower(str_replace("#", "", $request->tag2), 'UTF-8'), MB_CASE_TITLE, "UTF-8"),
                        'tipotag' => 'comments',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
                if($request->tag3 != "")
                {
                    DB::table('tagcommentspub')->insertGetId([
                        'idforpubthe' => $val,
                        'nametag' => mb_convert_case(mb_strtolower(str_replace("#", "", $request->tag3), 'UTF-8'), MB_CASE_TITLE, "UTF-8"),
                        'tipotag' => 'comments',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
                if($request->tag4 != "")
                {
                    DB::table('tagcommentspub')->insertGetId([
                        'idforpubthe' => $val,
                        'nametag' => mb_convert_case(mb_strtolower(str_replace("#", "", $request->tag4), 'UTF-8'), MB_CASE_TITLE, "UTF-8"),
                        'tipotag' => 'comments',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
                if($request->tag5 != "")
                {
                    DB::table('tagcommentspub')->insertGetId([
                        'idforpubthe' => $val,
                        'nametag' => mb_convert_case(mb_strtolower(str_replace("#", "", $request->tag5), 'UTF-8'), MB_CASE_TITLE, "UTF-8"),
                        'tipotag' => 'comments',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
                return redirect()->route('acceder.forum.usuarios.activos.foro.publico.blog', ["idcat" => $request->idcat])->with('success', trans('multi-leng.formerror139'));
            }
            else
            {
                return redirect()->route('acceder.forum.usuarios.activos.foro.publico.blog', ["idcat" => $request->idcat])->with('warnig', trans('multi-leng.formerror140'));
            }
        }

        return redirect()->route('acceder.forum.usuarios.activos.foro.publico.blog', ["idcat" => $request->idcat])->with('warnig', trans('multi-leng.formerror140'));
    }
    public function ingforpubadmblo(Request $request)
    {
        switch (true) 
        {
            case ($request->type == "add"):
                $name = DB::table('forum_public')->where('nameforum', mb_convert_case(mb_strtolower($request->namecat, 'UTF-8'), MB_CASE_TITLE, "UTF-8"))->count();
                switch (true) 
                {
                    case ($name == 0):

                        $add = DB::table('forum_public')->insert(["iduser" => Auth::user()->id, "nameforum" => mb_convert_case(mb_strtolower($request->namecat, 'UTF-8'), MB_CASE_TITLE, "UTF-8"), "statusforum" =>  1]);
                        if($add)
                        {
                            return redirect()->route('acciones.foro.publico.administrador.blog')->with('success', "El foro ha sido creado correctamente.");
                        }
                        else
                        {
                            return redirect()->route('acciones.foro.publico.administrador.blog')->with('danger', "El foro no ha sido creado, Inténtelo nuevamente.");
                        }
                        
                    break;

                    case ($name == 1):
                        return redirect()->route('acciones.foro.publico.administrador.blog')->with('info', "El nombre del foro ya existe.");
                    break;
                    
                    default:
                        return redirect()->route('acciones.foro.publico.administrador.blog')->with('danger', "Hay un error al ingresar el nombre del foro.");
                    break;
                }
            break;
            case ($request->type == "edi"):
                $id = Crypt::decrypt($request->idfor);
                $name = DB::table('forum_public')->where('nameforum', mb_convert_case(mb_strtolower($request->namecat, 'UTF-8'), MB_CASE_TITLE, "UTF-8"))->where('id', '!=', $id)->count();
                switch (true) 
                {
                    case ($name == 0):

                        $add = DB::table('forum_public')->where('id', $id)->update(["nameforum" => mb_convert_case(mb_strtolower($request->namecat, 'UTF-8'), MB_CASE_TITLE, "UTF-8"), 'updated_at' => date('Y-m-d H:i:s')]);
                        if($add)
                        {
                            return redirect()->route('acciones.foro.publico.administrador.blog')->with('success', "El nombre de foro ha sido editado correctamente.");
                        }
                        else
                        {
                            return redirect()->route('acciones.foro.publico.administrador.blog')->with('danger', "El foro no ha sido editado, Inténtelo nuevamente.");
                        }
                        
                    break;

                    case ($name == 1):

                        return redirect()->route('acciones.foro.publico.administrador.blog')->with('info', "El nombre del foro ya existe.");

                    break;
                    
                    default:
                        return redirect()->route('acciones.foro.publico.administrador.blog')->with('danger', "Hay un error al editar el nombre del foro.");
                    break;
                }
            break;
            case ($request->type == "del"):

                $id = Crypt::decrypt($request->idfor);

                $add = DB::table('forum_public')->where('id', $id)->update(["statusforum" => 0, 'updated_at' => date('Y-m-d H:i:s')]);
                        if($add)
                        {
                            return redirect()->route('acciones.foro.publico.administrador.blog')->with('success', "El foro ha sido eliminado correctamente.");
                        }
                        else
                        {
                            return redirect()->route('acciones.foro.publico.administrador.blog')->with('danger', "El foro no ha sido eliminado, Inténtelo nuevamente.");
                        }
            break;
            case((int)$request->tipo == 0):

                $idcat = Crypt::decrypt($request->idcat);
                $array = array();
                $statuspen = ForumParticipants::where(["statusidfor" => 1, "idforpub" => $idcat, "idcatfor" => NULL, "typeforum" => "publico"])->where('iduser', '!=', Auth::user()->id)->count();
                
                if($statuspen > 0)
                {
                    $for = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
                    ->where(["forum_participants.statusidfor" => 1, "forum_participants.idforpub" => $idcat, "forum_participants.idcatfor" => NULL, "forum_participants.typeforum" => "publico"])
                    ->where('forum_participants.iduser', '!=', Auth::user()->id)
                    ->get(['us.name as nameus', 'us.id as idus' ,'us.surname', 'forum_participants.idforpar']);
                    foreach($for as $row) 
                    {
                        array_push($array, array("nombre" => $row->nameus.' '.$row->surname, "idus" => $row->idus , "idforpar" => $row->idforpar));
                    }
                }
                return response()->json(['tipo' => $request->tipo, "count" => count($array), "array" => $array ]);
            break;
            case ((int)$request->tipo == 1):
            
                $idcat = Crypt::decrypt($request->idcat);
                $array = array();
                $statuspen = ForumParticipants::where(["statusidfor" => 0, "idforpub" => $idcat, "idcatfor" => NULL, "typeforum" => "publico"])->where('iduser', '!=', Auth::user()->id)->count();
                if($statuspen > 0)
                {
                    $for = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
                    ->where(["forum_participants.statusidfor" => 0, "forum_participants.idforpub" => $idcat, "forum_participants.idcatfor" => NULL, "forum_participants.typeforum" => "publico"])
                    ->where('forum_participants.iduser', '!=', Auth::user()->id)
                    ->get(['us.name as nameus', 'us.id as idus' ,'us.surname', 'forum_participants.idforpar']);
                    foreach($for as $row) 
                    {
                        array_push($array, array("nombre" => $row->nameus.' '.$row->surname, "idus" => $row->idus , "idforpar" => $row->idforpar));
                    }
                }
                return response()->json(['tipo' => $request->tipo, "count" => count($array), "array" => $array ]);
            break;
            case ((int)$request->tipo == 2):
            
                $idcat = Crypt::decrypt($request->idcat);
                $array = array();
                $statuspen = ForumParticipants::where(["statusidfor" => 2, "idforpub" => $idcat, "idcatfor" => NULL, "typeforum" => "publico"])->where('iduser', '!=', Auth::user()->id)->count();
                if($statuspen > 0)
                {
                    $for = ForumParticipants::join('users as us','us.id','=','forum_participants.iduser')
                    ->where(["forum_participants.statusidfor" => 2, "forum_participants.idforpub" => $idcat, "forum_participants.idcatfor" => NULL, "forum_participants.typeforum" => "publico"])
                    ->where('forum_participants.iduser', '!=', Auth::user()->id)
                    ->get(['us.name as nameus', 'us.id as idus' ,'us.surname', 'forum_participants.idforpar']);
                    foreach($for as $row) 
                    {
                        array_push($array, array("nombre" => $row->nameus.' '.$row->surname, "idus" => $row->idus , "idforpar" => $row->idforpar));
                    }
                }
                return response()->json(['tipo' => $request->tipo, "count" => count($array), "array" => $array ]);
            break;
            case ((int)$request->tipo == 3):
            
                $idcat = Crypt::decrypt($request->idfor);
                $statuspen = ForumParticipants::where(["idforpar" => $idcat])->count();
                switch (true) {
                    case ($statuspen == 1):
                        $statuspen = ForumParticipants::select('idforpub')->where(["idforpar" => $idcat])->first();
                        $val = Crypt::encrypt($statuspen->idforpub);
                        $statuspen = ForumParticipants::select('idforpub')->where(["idforpar" => $idcat])->update(['statusidfor' => 2]);
                    break;
                    
                    default:
                        abort(404);
                    break;
                }
                
                return redirect()->route('listado.usuarios.estado.ingreso.foro.publico.blog', ["idcat" => $val, "tipo" => 2 ])->with('danger', trans('multi-leng.a295'));
            break;
            case ((int)$request->tipo == 4):
            
                $idcat = Crypt::decrypt($request->idfor);
                $statuspen = ForumParticipants::where(["idforpar" => $idcat])->count();
                switch (true) {
                    case ($statuspen == 1):
                        $statuspen = ForumParticipants::select('idforpub')->where(["idforpar" => $idcat])->first();
                        $val = Crypt::encrypt($statuspen->idforpub);
                        $statuspen = ForumParticipants::select('idforpub')->where(["idforpar" => $idcat])->update(['statusidfor' => 1]);
                    break;
                    
                    default:
                        abort(404);
                    break;
                }
                return redirect()->route('listado.usuarios.estado.ingreso.foro.publico.blog', ["idcat" => $val, "tipo" => 0 ])->with('success', trans('multi-leng.a296'));
            break;
            
            default:
                abort(404);
            break;
        }
    }

}

