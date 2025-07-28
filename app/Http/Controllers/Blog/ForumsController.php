<?php



namespace App\Http\Controllers\Blog;



use App\User;

use App\Category;

use App\Subcategory;

use App\Link;

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
        $link = Link::count();
        
        if($link == 0)
        {
            session(['ver' => 'no']);
            session(['url' => '']);
            return view('admin.link.indexlinkedit', compact('link'));
        }
        if($link == 1)
        {
            $link = Link::first();
            session(['ver' => 'si']);
            session(['url' => $link->url]);
            return view('admin.link.indexlink', compact('link'));
        }
        else
        {
            abort(404);
        }
    }

    

    

}

