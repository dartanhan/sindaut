<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use HTMLPurifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UploadController extends Controller
{
    public function index(){
        if(Auth::check() === true){
            view('admin.galeria');
        }
        return redirect()->route('admin.login');
    }

    public function uploadImagem(Request $request)
    {
        $dados = $request->all();

        $request->validate([
            'file' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adicione as validações necessárias
        ]);

        // Filtra o conteúdo usando o HTMLPurifier
        $purifier = new HTMLPurifier();
        $conteudoFiltrado = $purifier->purify($dados['tinymce-editor']);

        $noticia = new Noticia();
        $noticia->titulo = $dados['titulo'] !== null ? $dados['titulo'] : '';
        $noticia->conteudo = $conteudoFiltrado;
        $noticia->status = true;
        $noticia->data =  now();
        $noticia->save();

        return redirect()->back()->with('success', 'Dados salvos com sucesso');

      /*  print_r($request->all());
die();

        $imagem = $request->file('file');
        $nomeImagem = time().'.'.$imagem->getClientOriginalExtension();
        $imagem->storeAs('public/images', $nomeImagem);

        return response()->json(['location' => asset('storage/images/'.$nomeImagem)]);*/
    }
}
