<?php



namespace App\Http\Controllers\Admin;



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

use Illuminate\Support\Facades\Storage; // Para manejar el almacenamiento
use Illuminate\Support\Str; // Para generar nombres únicos

use NumberFormatter;

class PresupuestosController extends Controller

{

    /**

    *

    * allow blog only

    *

    */

    public function __construct() {

        //$this->middleware(['role:admin|creator']);

        $this->middleware(['role:admin']);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    

    public function actprefordocconsel($id = null)
    {
        $idansw = Crypt::decrypt($id);

        $sumper = 0;

        $sumperegresos = 0;

        $sumcom = 0;

        $sumcomegresos = 0;

        $sumfun = 0;

        $sumfunegresos = 0;

        $sumotr = 0;

        $sumotregresos = 0;

        $tablaper = array();

        $tablacom = array();

        $tablafun = array();

        $tablaotr = array();

        $tablaperegresos = array();

        $tablaconegresos = array();

        $tablafunegresos = array();

        $tablaotregresos = array();

        $answ = array();

        $post = array();

        $not = array();

        $status = '';

        $idpost = '';


        $answ1 = Answers::select('*')->where('idansw', $idansw)->orderBy('idansw', 'asc')->count();

        switch (true) 
        {
            case ($answ > 0):
                
                $answ1 = Answers::select('*')->where('idansw', $idansw)->orderBy('idansw', 'asc')->first();

                $answ = Answers::select('*')->where('id_post', $answ1->id_post)->orderBy('idansw', 'asc')->count();

                switch (true) 
                {
                    case ($answ > 0):
                    
                        $answ = Answers::select('*')->where('id_post', $answ1->id_post)->orderBy('idansw', 'asc')->first();

                        $idansw = $answ->idansw;

                        $idpost = $answ->id_post;

                        $post = Postulations::where(['idpost' =>  $idpost])->count();
                        
                        switch (true) {
                            case ($post > 0):

                                $post = Postulations::where(['idpost' =>  $idpost])->first();

                                $idconcurso = $post->idconc;

                                $actas = DB::table('actas')->where(['id_proy' => $idpost])->count();

                                switch (true) 
                                {
                                    case ($actas == 1):

                                        $not = DB::table('notifications')->where(['tipo' => 'general', 'id_con' => (int)$idconcurso])->get();

                                        $actas = DB::table('actas')->where(['id_proy' => $idpost])->first();

                                        $status = $actas->status;
                                
                                        $tablaper = DetailsResources::select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_answ' =>  $idansw, 'type' => 1])->orderBy('iddetres', 'asc')->get();
                                
                                        foreach($tablaper as $tabla)
                                        {
                                            $sumper = ($tabla->valor1 * $tabla->valor2) + $sumper;
                                        }
                                
                                        $tablaperegresos = DetailsResources::select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_answ' =>  $idansw, 'type' => 6])->orderBy('iddetres', 'asc')->get();
                                
                                        foreach($tablaperegresos as $tabla)
                                        {
                                            $sumperegresos = ($tabla->valor1 * $tabla->valor2) + $sumperegresos;
                                        }
                                
                                        $tablacom = DetailsResources::select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_answ' =>  $idansw, 'type' => 2])->orderBy('iddetres', 'asc')->get();
                                        
                                        foreach($tablacom as $tabla)
                                        {
                                            $sumcom = ($tabla->valor1 * $tabla->valor2) + $sumcom;
                                        }
                                
                                        $tablacomegresos = DetailsResources::select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_answ' =>  $idansw, 'type' => 7])->orderBy('iddetres', 'asc')->get();
                                        
                                        foreach($tablacomegresos as $tabla)
                                        {
                                            $sumcomegresos = ($tabla->valor1 * $tabla->valor2) + $sumcomegresos;
                                        }
                                
                                        $tablafun = DetailsResources::select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_answ' =>  $idansw, 'type' => 3])->orderBy('iddetres', 'asc')->get();
                                        
                                        foreach($tablafun as $tabla)
                                        {
                                            $sumfun = ($tabla->valor1 * $tabla->valor2) + $sumfun;
                                        }
                                        $tablafunegresos = DetailsResources::select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_answ' =>  $idansw, 'type' => 8])->orderBy('iddetres', 'asc')->get();
                                        
                                        foreach($tablafunegresos as $tabla)
                                        {
                                            $sumfunegresos = ($tabla->valor1 * $tabla->valor2) + $sumfunegresos;
                                        }
                                        $tablaotr = DetailsResources::select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_answ' =>  $idansw, 'type' => 4])->orderBy('iddetres', 'asc')->get();
                
                                        foreach($tablaotr as $tabla)
                                        {
                                            $sumotr = ($tabla->valor1 * $tabla->valor2) + $sumotr;
                                        }
                                        $tablaotregresos = DetailsResources::select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_answ' =>  $idansw, 'type' => 9])->orderBy('iddetres', 'asc')->get();
                                        
                                        foreach($tablaotregresos as $tabla)
                                        {
                                            
                                            $sumotregresos = ($tabla->valor1 * $tabla->valor2) + $sumotregresos;
                                            
                                        }
                                        
                                        return view('admin.historialpresup.presupuesto', ["sumper" => $sumper, "sumcom" => $sumcom, "sumfun" => $sumfun, "sumotr" => $sumotr, "tablaper" => $tablaper, "tablacom" => $tablacom, "tablafun" => $tablafun, "tablaotr" => $tablaotr, "idansw" => $idansw, "not" => $not, "idconcurso" => $idconcurso, "idpostulacion" => $idpost, "answ" => $answ, "tablaperegresos" => $tablaperegresos, "sumperegresos" => $sumperegresos, "tablacomegresos" => $tablacomegresos, "sumcomegresos" => $sumcomegresos, "tablafunegresos" => $tablafunegresos, "sumfunegresos" => $sumfunegresos, "tablaotregresos" => $tablaotregresos, "sumotregresos" => $sumotregresos, 'status' => $status, 'idpost' => $idpost, 'id' => $idansw  ]);
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
                        # code...
                        break;
                }


            break;
            
            default:
                abort(404);
            break;
        }
    }

    public function funajaasudocpre(Request $request)
    {
        

        
        switch (true) 
        {
            case ($request->tipo == 'emailteacher'):

                $idact = Crypt::decrypt($request->idact);
                
                $datos = [
                    'id_us' => Auth::user()->id, 'id_act' => $idact, 'asunto' => $request->asunto, 'mensaje' => $request->mensaje, 'tipo' => $request->tipo,
                    'nombredocente' => Auth::user()->name.' '.Auth::user()->surname, 'emaildocente' => Auth::user()->email, 'telaudit' => Auth::user()->mobile
                ];
                
                $jsonData = json_encode($datos);

                $emailjob = DB::table('emailjobs')->insert([

                    'contenido' => $jsonData, 'template' => 'newnotificationadminpresupuesto', 'status' => 0

                ]);

                return response()->json(['status' => "ok", "idact" => $request->idact, "idus" => Auth::user()->id ], 200);

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

                    $mens = DB::table('notifications as n')->select('n.*')->where('n.id', $idact)->update(["n.respuesta" => $text, 'fechares' => date('Y-m-d H:i:s')]);

                    return response()->json(['status' => "ok", "idact" => $request->idmensresp ], 200);

                }
                return response()->json(['status' => "error", "idact" => $request->idmensresp ], 200);

            break;
            case ($request->tipo == 'notificaciones' ):
                $array = array();
                $array1 = array();
                $idact = Crypt::decrypt($request->idact);
                $idus = Crypt::decrypt($request->idus);
                
                $actasaudit = DB::table('notifications as n')->select('u.name', 'u.surname', 'u.email', 'u.mobile','n.*')->join('users as u', 'u.id', '=', 'n.id_us')->where(['n.id_answ' => $idact])->whereIn('n.tipo', ['docentepresupuesto', 'adminpresupuesto'])->count();
                if($actasaudit > 0)
                {
                    $array = json_encode(DB::table('notifications as n')->select('u.name', 'u.surname', 'u.email', 'u.mobile','n.*')->join('users as u', 'u.id', '=', 'n.id_us')->where(['n.id_answ' => $idact])->whereIn('n.tipo', ['docentepresupuesto', 'adminpresupuesto'])->get());
                }
                
                return response()->json(['status' => "ok", "idact" => $idact, "idus" => $idus, "html" => $array, "html1" => $array1 ], 200);

            break;
            case ($request->tipo == "egresopersonal"):

                $idansw = Crypt::decrypt($request->idansw);

                $tipoegreso = (int)$request->tipoegreso;

                $actasin = DB::table('detailresources')->insertGetId([ 'id_answ' => $idansw, 'type' => $tipoegreso, 'descri' => $request->descripcion, 'valor1' => (int)$request->cantidad, 'valor2' => (int)$request->valorunitario, 'descriplarga' => $request->carac, 'name' => '----------' ]);

                $sumperegresos = 0;

                $array1 = array();

                $idegre = Crypt::encrypt($actasin);

                $tablaperegresos = DetailsResources::select('*')->where(['id_answ' =>  $idansw, 'type' => $tipoegreso])->orderBy('iddetres', 'asc')->get();

                foreach($tablaperegresos as $tabla)
                {
                    $sumperegresos = ($tabla->valor1 * $tabla->valor2) + $sumperegresos;

                    array_push($array1, array("descri" => $tabla->descri, "valor1" => $tabla->valor1, "valor2" => $tabla->valor2, "id" => Crypt::encrypt($tabla->iddetres) ) );
                }
                


                $errorfile = "";

                if ($request->hasFile('fileToUpload')) 
                {
                    $allowedExtensions = ['png', 'jpg', 'jpeg', 'pdf', 'docx'];

                    $maxSize = 5 * 1024 * 1024; // 5MB

                    $files = $request->file('fileToUpload');

                    $filePaths = [];

                    foreach ($files as $file) 
                    {
                        $val = "";

                        if (!$file->isValid()) 
                        {
                            
                            $errorfile .= "El archivo {$file->getClientOriginalName()} no es válido.";

                            $val = "error";

                        }

                        $extension = strtolower($file->getClientOriginalExtension());

                        if (!in_array($extension, $allowedExtensions)) 
                        {
                            
                            $errorfile .= "Formato no permitido: {$file->getClientOriginalName()}.";

                            $val = "error";

                        }

                        if ($file->getSize() > $maxSize) 
                        {

                            $errorfile .= "El archivo {$file->getClientOriginalName()} supera el tamaño máximo de 5MB.";

                            $val = "error";

                        }

                        if($val == "")
                        {
                            $filename = Str::uuid() . '.' . $extension;

                            $path = 'adjuntos/docentes/presupuestos';

                            $storedPath = $file->storeAs($path, $filename, 'public');
                            

                            $url = Storage::url($path);

                            $filePaths[] = $url;

                            $filesdata = DB::table('detailresourcesfiles')->insert([ 'id_detres' => $actasin, 'nomfile' => $filename, 'nomori' => $file->getClientOriginalName()]);

                        }
                    }
                }

                return response()->json([
                    'status' => 'ok',
                    'files' => $filePaths,
                    'errorfiles' => $errorfile,
                    'data' => $array1,
                    'id' => $idegre,
                    'adic' => $request->adic,
                    'sumperegresos' => $sumperegresos,
                    'tipoegreso' => $tipoegreso,
                ], 200);
            break;
            case ($request->tipo == "veregresopersonal" || $request->tipo == "eliminaregresopersonal" || $request->tipo == 'editaregresopersonal'):

                $idegre = Crypt::decrypt($request->idegresoper);

                $tipoegreso = (int)$request->tipoegreso;
                
                $tablaperegresos = DetailsResources::select('*')->where(['iddetres' =>  $idegre])->orderBy('iddetres', 'asc')->first();

                $filesperegresos = DB::table('detailresourcesfiles')->where(['id_detres' =>  $idegre])->orderBy('id', 'asc')->get();
                
                return response()->json([
                    'status' => 'ok',
                    'data' => $tablaperegresos,
                    'data1' => $filesperegresos,
                    'idbus' => $request->idegresoper, 
                    'idus' => $request->idus,
                    'adic' => $request->adic,
                    'tipoegreso' => $tipoegreso,
                ], 200);

            break;
            case ($request->tipo == "validareliminaritem"):

                $sumperegresos = 0;

                $sumperegresos1 = 0;

                $sumperegresos2 = 0;

                $eliminados = "";

                $array1 = array();

                $tipoegreso = (int)$request->tipoegreso;

                $idegre = Crypt::decrypt($request->idegresoper);	
                

                $tablaperegresos = DetailsResources::select('*')->where(['iddetres' =>  $idegre])->orderBy('iddetres', 'asc')->first();

                $temp = $tablaperegresos->type;

                $temp1 = $tablaperegresos->id_answ;
                
                

                $filesdelete = DB::table('detailresourcesfiles')->where(['id_detres' =>  $idegre])->get();

                $a = "";

                foreach($filesdelete as $file)
                {
                    
                    if (Storage::disk('public')->exists('/adjuntos/docentes/presupuestos/'.$file->nomfile)) 
                    {
                        chmod(storage_path('app/public').'/adjuntos/docentes/presupuestos/'.$file->nomfile, 0777);

                        if(Storage::disk('public')->delete('/adjuntos/docentes/presupuestos/'.$file->nomfile))
                        {
                            $a .= "eliminado------";
                        }
                        else
                        {
                            $a .= "no-eliminado-----";
                        }
                    }
                }

                $tablaperegresos =  DB::table('detailresources')->where(['iddetres' =>  $idegre])->delete();

                $files = DB::table('detailresourcesfiles')->where(['id' =>  $idegre])->delete();

                $tablaperegresos = DetailsResources::select('*')->where(['type' => $tipoegreso, 'id_answ' => $temp1])->orderBy('iddetres', 'asc')->get();

                foreach($tablaperegresos as $tabla)
                { 
                    array_push($array1, array("descri" => $tabla->descri, "valor1" => $tabla->valor1, "valor2" => $tabla->valor2, "id" => Crypt::encrypt($tabla->iddetres) ) );

                    $sumperegresos = ($tabla->valor1 * $tabla->valor2) + $sumperegresos;
                }

                return response()->json([
                    'status' => 'ok',
                    'data' => $array1,
                    'idbus' => $request->idegresoper, 
                    'idus' => $request->idus,
                    'adic' => $request->adic,
                    'sumperegresos' => $sumperegresos,
                    'temp' => $temp, 
                    'id' => $request->idegresoper,
                    'tipoegreso' => $tipoegreso,
                    'eliminados' => $a,
                ], 200);

            break;
            case ($request->tipo == "validareliminarfile"):

                $idegre = $request->idegresoper;

                $a = '';
                
                $files = DB::table('detailresourcesfiles')->where(['id' =>  $idegre])->get();
                
                foreach($files as $file)
                {
                    
                    if (Storage::disk('public')->exists('/adjuntos/docentes/presupuestos/'.$file->nomfile)) 
                    {
                        chmod(storage_path('app/public').'/adjuntos/docentes/presupuestos/'.$file->nomfile, 0777);

                        if(Storage::disk('public')->delete('/adjuntos/docentes/presupuestos/'.$file->nomfile))
                        {
                            $a .= "eliminado------";
                        }
                        else
                        {
                            $a .= "no-eliminado-----";
                        }
                    }
                    
                }
                
                $files = DB::table('detailresourcesfiles')->where(['id' =>  $idegre])->delete();

                
                
                return response()->json([
                    'status' => 'ok',
                    'id' => $request->idegresoper,
                ], 200);

            break;

            case ($request->tipo == "validareditaritem"): 

                $idegre = Crypt::decrypt($request->idansw);  

                $tipoegreso = $request->tipoegreso;

                $desrec = DB::table('detailresources')->where('iddetres', $idegre)->first();

                $type = $desrec->type;

                $idansw = $desrec->id_answ;

                $actasin = DB::table('detailresources')->where('iddetres', $idegre)->update([ 'descri' => $request->descripcion, 'valor1' => (int)$request->cantidad, 'valor2' => (int)$request->valorunitario, 'descriplarga' => $request->carac ]);

                $sumperegresos = 0;

                $array1 = array();

                $tablaperegresos = DetailsResources::select('*')->where(['id_answ' =>  $idansw, 'type' => $type])->orderBy('iddetres', 'asc')->get();

                foreach($tablaperegresos as $tabla)
                {
                    $sumperegresos = ($tabla->valor1 * $tabla->valor2) + $sumperegresos;
                    array_push($array1, array("descri" => $tabla->descri, "valor1" => $tabla->valor1, "valor2" => $tabla->valor2, "id" => Crypt::encrypt($tabla->iddetres) ) );
                }

                $errorfile = "";

                if ($request->hasFile('fileToUpload')) 
                {
                    $allowedExtensions = ['png', 'jpg', 'jpeg', 'pdf', 'docx'];

                    $maxSize = 5 * 1024 * 1024; // 5MB

                    $files = $request->file('fileToUpload');

                    $filePaths = [];

                    foreach ($files as $file) 
                    {
                        $val = "";

                        if (!$file->isValid()) 
                        {
                            
                            $errorfile .= "El archivo {$file->getClientOriginalName()} no es válido.";

                            $val = "error";

                        }

                        $extension = strtolower($file->getClientOriginalExtension());

                        if (!in_array($extension, $allowedExtensions)) 
                        {
                            
                            $errorfile .= "Formato no permitido: {$file->getClientOriginalName()}.";

                            $val = "error";

                        }

                        if ($file->getSize() > $maxSize) 
                        {

                            $errorfile .= "El archivo {$file->getClientOriginalName()} supera el tamaño máximo de 5MB.";

                            $val = "error";

                        }

                        if($val == "")
                        {

                            // Generar un nombre único para evitar conflictos
                            $filename = Str::uuid() . '.' . $extension;

                            // Definir la ruta donde se almacenará el archivo (por ejemplo, en 'public/uploads')

                            $path = 'adjuntos/docentes/presupuestos'; // Puedes cambiar a la carpeta que prefieras dentro de 'public'

                            // Almacenar el archivo en la ruta especificada dentro del disco 'public'
                            $storedPath = $file->storeAs($path, $filename, 'public');

                            // Obtener la URL o ruta pública del archivo (opcional)
                            $url = Storage::url($path);

                            // Almacenar la ruta en el array
                            $filePaths[] = $url;

                            $filesdata = DB::table('detailresourcesfiles')->insert([ 'id_detres' => $idegre, 'nomfile' => $filename, 'nomori' => $file->getClientOriginalName()]);

                        }
                    }
                }
                
                return response()->json([
                    'status' => 'ok',
                    'id' => $idegre,
                    'sumperegresos' => $sumperegresos,
                    'data' => $array1,
                    'type' => $type,
                    'adic' => $request->adic,
                    'tipoegreso' => $tipoegreso,
                ], 200);

            break;
            default:
                return response()->json([
                    'status' => 'error',
                    'data' => "error",
                ], 200);
            break;
        }
    }
    public function impfordocpreconsel($id = null)
    {

        $idansw = Crypt::decrypt($id);

        $sumper = 0;

        $sumperegresos = 0;

        $sumcom = 0;

        $sumcomegresos = 0;

        $sumfun = 0;

        $sumfunegresos = 0;

        $sumotr = 0;

        $sumotregresos = 0;

        $tablaper = array();

        $tablacom = array();

        $tablafun = array();

        $tablaotr = array();

        $tablaperegresos = array();

        $tablaconegresos = array();

        $tablafunegresos = array();

        $tablaotregresos = array();

        $answ = array();

        $post = array();

        $not = array();

        $status = '';

        $idpost = '';


        $answ1 = Answers::select('*')->where('idansw', $idansw)->orderBy('idansw', 'asc')->count();

        switch (true) 
        {
            case ($answ > 0):
                
                $answ1 = Answers::select('*')->where('idansw', $idansw)->orderBy('idansw', 'asc')->first();

                $answ = Answers::select('*')->join('postulations as pos', 'answers.id_post', '=', 'pos.idpost')->join('users as u', 'u.id', '=', 'pos.idus')->where('answers.id_post', $answ1->id_post)->orderBy('answers.idansw', 'asc')->count();
                

                switch (true) 
                {
                    case ($answ > 0):
                    
                        $answ = Answers::select('*')->join('postulations as pos', 'answers.id_post', '=', 'pos.idpost')->join('users as u', 'u.id', '=', 'pos.idus')->where('answers.id_post', $answ1->id_post)->orderBy('answers.idansw', 'asc')->first();
                       
                        $idansw = $answ->idansw;

                        $idpost = $answ->id_post;

                        $post = Postulations::where(['idpost' =>  $idpost])->count();
                        
                        switch (true) {
                            case ($post > 0):

                                $post = Postulations::where(['idpost' =>  $idpost])->first();

                                $idconcurso = $post->idconc;

                                $actas = DB::table('actas')->where(['id_proy' => $idpost])->count();

                                switch (true) 
                                {
                                    case ($actas == 1):

                                        $formatter = new NumberFormatter('es_CL', NumberFormatter::DECIMAL);

                                        $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);

                                        $not = DB::table('notifications')->where(['tipo' => 'general', 'id_con' => (int)$idconcurso])->get();

                                        $actas = DB::table('actas')->where(['id_proy' => $idpost])->first();

                                        $status = $actas->status;
                                
                                        $tablaper = DetailsResources::select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_answ' =>  $idansw, 'type' => 1])->orderBy('iddetres', 'asc')->get();
                                
                                        foreach($tablaper as $tabla)
                                        {
                                            $sumper = ($tabla->valor1 * $tabla->valor2) + $sumper;
                                        }
                                
                                        $tablaperegresos = DetailsResources::select('*')->where(['id_answ' =>  $idansw, 'type' => 6])->orderBy('iddetres', 'asc')->get();
                                
                                        foreach($tablaperegresos as $tabla)
                                        {
                                            $sumperegresos = ($tabla->valor1 * $tabla->valor2) + $sumperegresos;
                                        }
                                
                                        $tablacom = DetailsResources::select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_answ' =>  $idansw, 'type' => 2])->orderBy('iddetres', 'asc')->get();
                                        
                                        foreach($tablacom as $tabla)
                                        {
                                            $sumcom = ($tabla->valor1 * $tabla->valor2) + $sumcom;
                                        }
                                
                                        $tablacomegresos = DetailsResources::select('*')->where(['id_answ' =>  $idansw, 'type' => 7])->orderBy('iddetres', 'asc')->get();
                                        
                                        foreach($tablacomegresos as $tabla)
                                        {
                                            $sumcomegresos = ($tabla->valor1 * $tabla->valor2) + $sumcomegresos;
                                        }
                                
                                        $tablafun = DetailsResources::select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_answ' =>  $idansw, 'type' => 3])->orderBy('iddetres', 'asc')->get();
                                        
                                        foreach($tablafun as $tabla)
                                        {
                                            $sumfun = ($tabla->valor1 * $tabla->valor2) + $sumfun;
                                        }
                                        $tablafunegresos = DetailsResources::select('*')->where(['id_answ' =>  $idansw, 'type' => 8])->orderBy('iddetres', 'asc')->get();
                                        
                                        foreach($tablafunegresos as $tabla)
                                        {
                                            $sumfunegresos = ($tabla->valor1 * $tabla->valor2) + $sumfunegresos;
                                        }
                                        $tablaotr = DetailsResources::select('iddetres', 'descri', 'valor1', 'valor2')->where(['id_answ' =>  $idansw, 'type' => 4])->orderBy('iddetres', 'asc')->get();
                
                                        foreach($tablaotr as $tabla)
                                        {
                                            $sumotr = ($tabla->valor1 * $tabla->valor2) + $sumotr;
                                        }
                                        $tablaotregresos = DetailsResources::select('*')->where(['id_answ' =>  $idansw, 'type' => 9])->orderBy('iddetres', 'asc')->get();
                                        
                                        foreach($tablaotregresos as $tabla)
                                        {
                                            
                                            $sumotregresos = ($tabla->valor1 * $tabla->valor2) + $sumotregresos;
                                            
                                        }
                                        
                                        $pdf = \PDF::loadView('pdfs/presupuestos', ["sumper" => $formatter->format($sumper), "sumcom" => $formatter->format($sumcom), "sumfun" => $formatter->format($sumfun), "sumotr" => $formatter->format($sumotr), "tablaper" => $tablaper, "tablacom" => $tablacom, "tablafun" => $tablafun, "tablaotr" => $tablaotr, "idansw" => $idansw, "not" => $not, "idconcurso" => $idconcurso, "idpostulacion" => $idpost, "answ" => $answ, "tablaperegresos" => $tablaperegresos, "sumperegresos" => $formatter->format($sumperegresos), "tablacomegresos" => $tablacomegresos, "sumcomegresos" => $formatter->format($sumcomegresos), "tablafunegresos" => $tablafunegresos, "sumfunegresos" => $formatter->format($sumfunegresos), "tablaotregresos" => $tablaotregresos, "sumotregresos" => $formatter->format($sumotregresos), 'status' => $status, 'idpost' => $idpost, "sum1" => $formatter->format($sumper - $sumperegresos), "sum2" => $formatter->format($sumcom - $sumcomegresos), "sum3" => $formatter->format($sumfun - $sumfunegresos), "sum4" => $formatter->format($sumotr - $sumotregresos)  ]);

                                        return $pdf->download('Presupuestos'.date('YmdHis').'.pdf');

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