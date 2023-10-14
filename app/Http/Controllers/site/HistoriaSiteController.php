<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;

use App\Models\Historia;
use App\Models\Noticia;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class HistoriaSiteController extends Controller
{
    protected $request,$historia,$noticia;

    public function __construct(Request $request, Historia $historia, Noticia $noticia){
        $this->request = $request;
        $this->historia = $historia;
        $this->noticia = $noticia;
    }
    /**
     * Display a listing of the resource.
     *
     * @return RedirectResponse|View
     */
    public function index()
    {
        $noticias = $this->noticia->with('imagens')
            ->where('status',1)
            ->orderBy('id', 'desc')->get();

        $historia = $this->historia->first();

        return view('site.historia', compact('noticias','historia'));
    }
}
