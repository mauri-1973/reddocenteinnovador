<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Categoryblog;
use App\Post;
use App\Tagblog;
use App\PostTag;
use App\Link;
use App\Corrections;
use App\Commentblog;
use Crypt;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $link = Link::count();
        
        if($link == 0 || $link > 1)
        {
            session(['ver' => 'no']);
            session(['url' => '']);
        }
        if($link == 1)
        {
            $link = Link::first();
            session(['ver' => 'si']);
            session(['url' => $link->url]);
        }
        
        if(Auth::user()->hasRole('admin'))
        {
            return view('admin.dashboard');
        }
        if(Auth::user()->hasRole('docente'))
        {
            $post = Post::join('categoriesblog as cat', 'posts.category_id', '=', 'cat.id')
            ->join('users as u', 'u.id', '=', 'posts.created_by')
            //->where('posts.is_published', 1)
            ->get(['posts.*', 'cat.title as titlecat', 'u.name as nameus', 'u.surname as surnameus']);
            $arraytagas = array();
            foreach($post as $row)
            {
                $temp = array();
                $tags = PostTag::join('tagsblog as tag', 'tag.id', '=', 'post_tag.tag_id')
                ->where("post_tag.post_id", $row->id)
                ->get(['tag.title']);
                foreach($tags as $r)
                {
                    array_push($temp, array("titulo" => $r->title));
                }
                $comments = Commentblog::where('post_id', $row->id)
                ->count();
                array_push($arraytagas, array("tags" => $temp, "nomcom" => $comments, "idpost" => $row->id));
            }
            
            return view('docentes.dashboard', ["post" => $post, "info" => $arraytagas, "cont" => 0 ]);
        }
        if(Auth::user()->hasRole('blog'))
        {
            $post = Post::all()->count();
            $cat = Categoryblog::all()->count();
            $tags = Tagblog::all()->count();
            $visit = Post::all()->sum('read_count');
            return view('blog.dashboard', ["post" => $post, "cat" => $cat, "tags" => $tags, "visit" => $visit]);
        }
        if(Auth::user()->hasRole('user'))
        {
            
            $post = Post::join('categoriesblog as cat', 'posts.category_id', '=', 'cat.id')
            ->join('users as u', 'u.id', '=', 'posts.created_by')
            //->where('posts.is_published', 1)
            ->get(['posts.*', 'cat.title as titlecat', 'u.name as nameus', 'u.surname as surnameus']);
            $arraytagas = array();
            foreach($post as $row)
            {
                $temp = array();
                $tags = PostTag::join('tagsblog as tag', 'tag.id', '=', 'post_tag.tag_id')
                ->where("post_tag.post_id", $row->id)
                ->get(['tag.title']);
                foreach($tags as $r)
                {
                    array_push($temp, array("titulo" => $r->title));
                }
                $comments = Commentblog::where('post_id', $row->id)
                ->count();
                array_push($arraytagas, array("tags" => $temp, "nomcom" => $comments, "idpost" => $row->id));
            }

            return view('users.dashboard', ["post" => $post, "info" => $arraytagas, "cont" => 0 ]);
        }
        if(Auth::user()->hasRole('revisor'))
        {
            
            $post = Post::all()->count();
            $cat = Categoryblog::all()->count();
            $tags = Tagblog::all()->count();
            $visit = Post::all()->sum('read_count');
            return view('blog.dashboard', ["post" => $post, "cat" => $cat, "tags" => $tags, "visit" => $visit]);
        }
        if(Auth::user()->hasRole('auditor'))
        {
            $post = Post::all()->count();
            $cat = Categoryblog::all()->count();
            $tags = Tagblog::all()->count();
            $visit = Post::all()->sum('read_count');
            return view('blog.dashboard', ["post" => $post, "cat" => $cat, "tags" => $tags, "visit" => $visit]);
        }
        if(Auth::user()->hasRole('coordinador'))
        {
            $cont = 0;
            $cont1 = 0;
            $array = array();
            $post = DB::table('competitions as c')->select('*')->join('competitionscoordinador as cc', 'cc.idcomp', '=', 'c.idcomp')->where('cc.idcoor', Auth::user()->id)->get();
            
            foreach($post as $p)
            {
                $val = DB::table('postulations')->select('*')->where('idconc', $p->idcomp)->count();
                $cont = $cont + $val;
                array_push($array, ["idcomp" => $p->idcomp, "title" => $p->title, "formulario" => $p->formulario, "total" => $val]);
                $cont1++;
            }
            
            $cat = Categoryblog::all()->count();
            $tags = Tagblog::all()->count();
            $visit = Post::all()->sum('read_count');
            return view('coor.dashboard', ["post" => $array, "cat" => $cat, "tags" => $tags, "asig" => $cont1, "postu" => $cont ]);
        }
        else
        {
            return view('errors.403');
        }
    }

    
}
