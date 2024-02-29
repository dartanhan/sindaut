<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Beneficios;
use App\Models\Homologacao;
use App\Models\Noticia;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;;

class NoticiaSiteController extends Controller
{
    protected $request,$noticia;

    public function __construct(Request $request, Noticia $noticia){
        $this->request = $request;
        $this->noticia = $noticia;
    }
    /**
     * Display a listing of the resource.
     *
     * @return RedirectResponse|View
     */
    public function index()
    {
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();

            $noticias = $this->noticia->with('imagens')->where('status',1)->orderBy('id', 'desc')->get();

            $noticias_site = $this->noticia->with('imagens')->where('status',1)->orderBy('id', 'desc')->paginate(10);

                return view('site.noticias', compact('user_data','noticias','noticias_site'));
        }
        return redirect()->route('admin.login');
    }
}
