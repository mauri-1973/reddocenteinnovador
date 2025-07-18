<?php



namespace App\Http\Controllers\Users;



use App\Http\Controllers\Controller;

use App\Http\Requests\StorePostRequest;

use App\Http\Requests\UpdatePostRequest;

use App\User;

use App\EmailContact;

use App\TagUsers;

use App\Categoryblog;

use App\Post;

use App\Tagblog;

use App\PostTag;

use App\Commentblog;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Intervention\Image\Facades\Image as Image;

use Symfony\Component\HttpFoundation\Response;

use Illuminate\Http\JsonResponse;

use App\Mail\SendEmailContact;

use Illuminate\Support\Facades\Mail;

use Yajra\DataTables\DataTables;

use File;

use Crypt;



class ConectController extends Controller

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
    public function conusureg()
    {
        $env = array();
       
        
        return view('users.conectar', ["array" => $env]);
    }

    public function conusuregdatatables()
    {
        if (request()->ajax()) 
        {
            $query = User::select('id', 'profesion', 'name', 'surname', 'email', 'mobile', 'avatar')
            ->where(['status_us' => 1, 'conectar' => 1])
            ->where('id', '!=', Auth::user()->id)
            ->with(['tagUsers:tagidus,tagnom,idtag']);

            return datatables()->of($query)
                    ->addColumn('tags', function($user) {
                        return $user->tagUsers->map(function($tag) {
                            return [
                                'tagnom' => $tag->tagnom,
                                'idtag' => $tag->idtag
                            ];
                        })->values();
                    })
                    ->addColumn('tags_flat', function($user) {
                        return $user->tagUsers->pluck('tagnom')->implode(', ');
                    })
                    ->addColumn('encrypted_id', function($user) {
                        return Crypt::encrypt($user->id);
                    })

                    // --- ¡Esto es lo importante que debes agregar! ---
                    ->filterColumn('tags_flat', function($query, $keyword) {
                        // Asumiendo que la relación se llama tagUsers y el nombre de la columna es tagnom
                        $query->whereHas('tagUsers', function ($q) use ($keyword) {
                            $q->where('tagnom', 'like', "%{$keyword}%");
                        });
                    })

                    ->make(true);
        }
    }

    public function envemaconusureg(Request $request)
    {
        
        $user = User::where('id', Auth::user()->id)->first();
        $idhacia = Crypt::decrypt($request->idhacia);
        $email = new EmailContact;
        $email->iddesde =  Auth::user()->id;
        $email->idhacia =  $idhacia;
        $email->asunto =  $request->asunto;
        $email->mensaje =  $request->summernote;
        if($email->save())
        {
            $em = EmailContact::where('idemcon', $email->idemcon)->first();
            $data['nombredesde'] = $user->name.' '.$user->surname;
            $data['asunto'] = $request->asunto;
            $data['nombrehacia'] = $request->name;
            //Mail::to($request->email)->send(new SendEmailContact($request->name, $request->asunto, $request->summernote, $user->name.' '.$user->surname));
            Mail::to('mauri-1973@outlook.cl')->send(new SendEmailContact($request->name, $request->asunto, $em->mensaje, $user->name.' '.$user->surname));
            return redirect()->route('conectar-usuarios-registrado')->with('success', trans('multi-leng.formerror245'));
        }
        else
        {
            return redirect()->route('conectar-usuarios-registrado')->with('danger', trans('multi-leng.formerror246'));
        }
        
    }
    
    

}