<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Beneficios;
use App\Models\Homologacao;
use App\Models\Noticia;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class BeneficioSiteController extends Controller
{
    protected $request,$beneficio,$noticia;

    public function __construct(Request $request, Beneficios $beneficio, Noticia $noticia){
        $this->request = $request;
        $this->beneficio = $beneficio;
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

        $beneficio = $this->beneficio->where('status',1)->first();

        return view('site.beneficio', compact('noticias','beneficio'));
    }
}
