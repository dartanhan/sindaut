<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;

use App\Models\Convencao;
use App\Models\ConvencaoDescricao;
use App\Models\Noticia;
use Illuminate\Http\Request;

class ConvencaoSiteController extends Controller
{
    protected $request,$convencao,$noticia,$convencaoDescricao;

    public function __construct(Request $request, Convencao $convencao, Noticia $noticia, ConvencaoDescricao $convencaoDescricao)
    {
        $this->request = $request;
        $this->convencao = $convencao;
        $this->noticia = $noticia;
        $this->convencaoDescricao = $convencaoDescricao;
    }

    public function index() {

        $convencoes = $this->convencao->with('files')
            ->where('status',1)
            ->orderBy('id', 'desc')->get();

        $noticias = $this->noticia->with('imagens')
            ->where('status',1)
            ->orderBy('id', 'desc')->get();

        $convencao_descricao = $this->convencaoDescricao->first();

        return view('site.convencao', compact('noticias','convencoes','convencao_descricao'));
    }
}
