<?php

namespace App\Http\Controllers;

use App\Models\GaleriaImagem;
use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

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
            $user_data = User::where("id",auth()->user()->id)->first();

            $images = $this->galleryImage->get();
            
            $query = Noticia::with('imagens')->orderBy('id', 'desc');
            
            if ($this->request->has('search') && !empty($this->request->input('search'))) {
                $search = $this->request->input('search');
                $query->where(function($q) use ($search) {
                    $q->where('titulo', 'like', "%{$search}%")
                      ->orWhere('subtitulo', 'like', "%{$search}%")
                      ->orWhere('conteudo', 'like', "%{$search}%");
                });
            }
            
            $noticias = $query->paginate(10)->withQueryString();

            return  view('admin.noticia',compact('noticias','images','user_data'));

        }
        return redirect()->route('admin.login');
    }

    public function store()
    {
        $this->request->validate([
            'titulo' => 'required|max:80',
            'subtitulo' => 'nullable|max:250',
            'tinymce_editor' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ], [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.max' => 'O título não pode ter mais de 80 caracteres.',
            'subtitulo.max' => 'O subtítulo não pode ter mais de 250 caracteres.',
            'tinymce_editor.required' => 'O conteúdo é obrigatório.',
            'image.image' => 'O arquivo selecionado deve ser uma imagem.',
            'image.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif ou webp.',
            'image.max' => 'A imagem não pode ser maior que 5MB.',
        ]);

        $dataCadastro = $this->request->input('data_cadastro') 
            ? Carbon::parse($this->request->input('data_cadastro')) 
            : Carbon::now();

        $imagem_id = $this->request->input('idImagemDestaque') ?: null;

        if ($this->request->hasFile('image')) {
            $imageFile = $this->request->file('image');
            $nome_unico = Str::uuid() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->storeAs('posts/files', $nome_unico, 'public');
            
            $galeriaImagem = GaleriaImagem::create([
                'path' => $nome_unico
            ]);
            
            $imagem_id = $galeriaImagem->id;
        }

        $noticia = $this->noticia->create([
            'titulo' => $this->request->input('titulo'),
            'subtitulo' => $this->request->input('subtitulo'),
            'imagem_id' => $imagem_id,
            'conteudo' => $this->request->input('tinymce_editor'),
            'status' => $this->request->input('status') !== null ? (int)$this->request->input('status') : 0,
            'destaque' => $this->request->has('destaque') ? 1 : 0,
            'created_at' => $dataCadastro,
        ]);

        if(!$noticia){
            return redirect()->route('noticia.index')->with('danger','Não foi possível criar a notícia.');
        }
        return redirect()->route('noticia.index')->with('success','Notícia criada com sucesso.');
    }

    public function create()
    {
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();
            $images = $this->galleryImage->get();
            return view('admin.noticia_create', compact('images', 'user_data'));
        }
        return redirect()->route('admin.login');
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
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();
            $noticia = Noticia::with('imagens')->find($id);

            if (!$noticia) {
                abort(404);
            }
            $images = $this->galleryImage->get();
            return view('admin.noticia_edit', compact('noticia', 'images', 'user_data'));
        }
        return redirect()->route('admin.login');
    }

    public function update($id)
    {
        $this->request->validate([
            'titulo' => 'required|max:80',
            'subtitulo' => 'nullable|max:250',
            'tinymce_editor' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ], [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.max' => 'O título não pode ter mais de 80 caracteres.',
            'subtitulo.max' => 'O subtítulo não pode ter mais de 250 caracteres.',
            'tinymce_editor.required' => 'O conteúdo é obrigatório.',
            'image.image' => 'O arquivo selecionado deve ser uma imagem.',
            'image.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif ou webp.',
            'image.max' => 'A imagem não pode ser maior que 5MB.',
        ]);

        $noticia = Noticia::find($id);
        if (!$noticia) {
            return redirect()->route('noticia.index')->with('danger', 'Notícia não encontrada.');
        }

        $dataCadastro = $this->request->input('data_cadastro') 
            ? Carbon::parse($this->request->input('data_cadastro')) 
            : Carbon::parse($noticia->getRawOriginal('created_at'));

        $imagem_id = $this->request->input('idImagemDestaque') ?: null;

        if ($this->request->hasFile('image')) {
            $imageFile = $this->request->file('image');
            $nome_unico = Str::uuid() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->storeAs('posts/files', $nome_unico, 'public');
            
            $galeriaImagem = GaleriaImagem::create([
                'path' => $nome_unico
            ]);
            
            $imagem_id = $galeriaImagem->id;
        }

        $noticia->titulo = $this->request->input('titulo');
        $noticia->subtitulo =  $this->request->input('subtitulo');
        $noticia->conteudo =  $this->request->input('tinymce_editor');
        $noticia->imagem_id = $imagem_id;
        $noticia->status = $this->request->input('status') !== null ? (int)$this->request->input('status') : $noticia->status;
        $noticia->destaque = $this->request->has('destaque') ? 1 : 0;
        $noticia->created_at = $dataCadastro;

        $atualizacaoBemSucedida = $noticia->update();

        if ($atualizacaoBemSucedida) {
            return redirect()->route('noticia.index')->with('success','Notícia atualizada com sucesso.');
        } else {
            return redirect()->route('noticia.index')->with('danger','Erro ao atualizar a notícia.');
        }
    }

    /***
     * Atualiza o status para ativo e inativo
     * */
    public function atualizarStatus()
    {
        $id = $this->request->input('id');
        $status = $this->request->input('status');

        $noticia =  $this->noticia->find($id);
        $noticia->status = $status;

        $atualizacaoBemSucedida = $noticia->update();

        $msg = 'Notícia liberada com sucesso';
        if($status == 0){
            $msg = 'Notícia bloqueada com sucesso!';
        }
        if ($atualizacaoBemSucedida) {
            return response()->json(['success'=> true, 'message' => $msg], 200);
        }

        return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status'], 500);

    }

    /***
     * Atualiza o se é destaque ou não para ativo e inativo
     * */
    public function atualizarDestaque()
    {
        $id = $this->request->input('id');
        $status = $this->request->input('destaque');

        $noticia =  $this->noticia->find($id);
        $noticia->destaque = $status;

        $atualizacaoBemSucedida = $noticia->update();

        $msg = 'Notícia ativada como destaque com sucesso!';
        if($status == 0){
            $msg = 'Notícia desativada como destaque com sucesso!';
        }

        if ($atualizacaoBemSucedida) {
            return response()->json(['success'=> true, 'message' => $msg], 200);
        }
            return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status'], 500);
    }

}
