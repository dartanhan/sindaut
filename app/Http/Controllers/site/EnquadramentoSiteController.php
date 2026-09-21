<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Outro;
use Illuminate\Http\Request;

class EnquadramentoSiteController extends Controller
{
    protected $request, $outro;

    public function __construct(Request $request, Outro $outro)
    {
        $this->request = $request;
        $this->outro = $outro;
    }

    public function index()
    {
        $enquadramento = $this->outro::enquadramento()->where('status', 1)->orderBy('id', 'desc')->first();
        return view('site.enquadramento', compact('enquadramento'));
    }
}