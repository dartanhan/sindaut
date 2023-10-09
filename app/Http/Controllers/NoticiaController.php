<?php

namespace App\Http\Controllers;

use App\Models\GaleriaImagem;
use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticiaController extends Controller
{
    protected $request,$noticia,$galleryImage;

    public function __construct(Request $request, Noticia $noticia, GaleriaImagem $galleryImage){

        $this->request = $request;
        $this->galleryImage = $galleryImage;
        $this->noticia = $noticia;
    }
    public function index(){
        if(Auth::check() === true){

            $images = $this->galleryImage->get();
            $noticias = $this->noticia->get();

            return  view('admin.noticia',compact('noticias','images'));

        }
        return redirect()->route('admin.login');
    }

    public function store(){

        $this->noticia->create([
            'titulo' => $this->request->input('titulo'),
            'conteudo' => $this->request->input('tinymce_editor'),
            'status' => false
        ]);

        return redirect()->route('noticia.index')->with('success','Notícia criada com sucesso.');
    }

    public function create(){

    }

    public function atualizarStatus()
    {
        $id = $this->request->input('id');
        $status = $this->request->input('status');

        $noticia =  $this->noticia->find($id);
        $noticia->status = $status;

        $atualizacaoBemSucedida = $noticia->update();

        if ($atualizacaoBemSucedida) {
            return response()->json(['success'=> true, 'message' => 'Status atualizado com sucesso'], 200);
        } else {
            return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status'], 500);
        }

    }

    public function destroy(int $id)
    {
        $noticia = Noticia::find($id);

        if (!$noticia) {
            return response()->json(['success' => false, 'message' => 'Notícia não encontrada'], 404);
        }

        $noticia->delete();

        return response()->json(['success' => true, 'message' => 'Notícia excluída com sucesso']);
    }

    public function edit($id)
    {
        $noticia = Noticia::find($id);

        if (!$noticia) {
            abort(404); // Retorna um erro 404 se a notícia não for encontrada
        }


        return response()->json(['success' => true, 'data' => $noticia]);
    }

    public function update($id)
    {
        $noticia = Noticia::find($id);



        $noticia->titulo = $this->request->input('titulo');
        $noticia->subtitulo =  $this->request->input('subtitulo');
        $noticia->conteudo =  $this->request->input('tinymce_editor');

        $atualizacaoBemSucedida = $noticia->update();

        if ($atualizacaoBemSucedida) {
           // return response()->json(['success'=> true, 'message' => 'Notícia atualizada com sucesso'], 200);
            return redirect()->route('noticia.index')->with('success','Notícia atualizada com sucesso.');
        } else {
            //return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status'], 500);
            return redirect()->route('noticia.index')->with('danger','Erro ao atualizar o status.');
        }

    }


}
