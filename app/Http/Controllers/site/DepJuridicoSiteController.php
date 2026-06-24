<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\DepJuridico;
use App\Models\Noticia;
use Illuminate\Http\Request;

class DepJuridicoSiteController extends Controller
{
    protected $request,$depjuridico,$noticia;

    public function __construct(Request $request, Noticia $noticia, DepJuridico $depJuridico)
    {
        $this->request = $request;
        $this->depjuridico = $depJuridico;
        $this->noticia = $noticia;
    }

    public function index() {

        $depjuridico = $this->depjuridico->where('status',1)->first();

        return view('site.depjuridico', compact('depjuridico'));
    }
}