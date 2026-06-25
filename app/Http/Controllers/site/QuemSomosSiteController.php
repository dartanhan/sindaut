<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\QuemSomos;
use App\Models\Noticia;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuemSomosSiteController extends Controller
{
    protected $request, $quemsomos, $noticia;

    public function __construct(Request $request, QuemSomos $quemsomos, Noticia $noticia){
        $this->request = $request;
        $this->quemsomos = $quemsomos;
        $this->noticia = $noticia;
    }

    /**
     * Display a listing of the resource.
     *
     * @return RedirectResponse|View
     */
    public function index()
    {
        $quemsomos = $this->quemsomos->where('status', 1)->first();

        return view('site.quemsomos', compact('quemsomos'));
    }
}
