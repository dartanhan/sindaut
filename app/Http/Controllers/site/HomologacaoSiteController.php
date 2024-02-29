<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;

use App\Models\Homologacao;
use App\Models\Noticia;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class HomologacaoSiteController extends Controller
{
    protected $request,$homologacao,$noticia;

    public function __construct(Request $request, Homologacao $homologacao, Noticia $noticia){
        $this->request = $request;
        $this->homologacao = $homologacao;
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

        $homologacao = $this->homologacao->where('status',1)->first();

        return view('site.homologacao', compact('noticias','homologacao'));
    }
}
