<?php

namespace App\Http\Controllers;

use App\Models\GaleriaImagem;
use App\Models\HomeCard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class HomeCardController extends Controller
{
    protected $request, $homeCard, $galleryImage;

    public function __construct(Request $request, HomeCard $homeCard, GaleriaImagem $galleryImage)
    {
        $this->request = $request;
        $this->homeCard = $homeCard;
        $this->galleryImage = $galleryImage;
    }

    public function index()
    {
        if (Auth::check() === true) {
            $user_data = User::where("id", auth()->user()->id)->first();
            $images = $this->galleryImage->get();
            $cards = $this->homeCard->with('imagens')->orderBy('ordem', 'asc')->orderBy('id', 'desc')->get();

            return view('admin.home_card', compact('cards', 'images', 'user_data'));
        }
        return redirect()->route('admin.login');
    }

    public function create()
    {
        if (Auth::check() === true) {
            if ($this->homeCard->count() >= 3) {
                return redirect()->route('home-card.index')->with('danger', 'Limite máximo de 3 cards atingido. Exclua um existente para cadastrar outro.');
            }
            $user_data = User::where("id", auth()->user()->id)->first();
            $images = $this->galleryImage->get();
            return view('admin.home_card_create', compact('images', 'user_data'));
        }
        return redirect()->route('admin.login');
    }

    public function store()
    {
        if ($this->homeCard->count() >= 3) {
            return redirect()->route('home-card.index')->with('danger', 'Limite máximo de 3 cards atingido. Exclua um existente para cadastrar outro.');
        }

        $this->request->validate([
            'titulo' => 'required|max:80',
            'ordem' => 'nullable|integer',
            'tinymce_editor' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ], [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.max' => 'O título não pode ter mais de 80 caracteres.',
            'tinymce_editor.required' => 'O conteúdo é obrigatório.',
            'image.image' => 'O arquivo selecionado deve ser uma imagem.',
            'image.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif ou webp.',
            'image.max' => 'A imagem não pode ser maior que 5MB.',
        ]);

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

        $card = $this->homeCard->create([
            'titulo' => $this->request->input('titulo'),
            'ordem' => $this->request->input('ordem') !== null ? (int)$this->request->input('ordem') : 0,
            'imagem_id' => $imagem_id,
            'conteudo' => $this->request->input('tinymce_editor'),
            'status' => $this->request->input('status') !== null ? (int)$this->request->input('status') : 1,
        ]);

        if (!$card) {
            return redirect()->route('home-card.index')->with('danger', 'Não foi possível criar o card.');
        }
        return redirect()->route('home-card.index')->with('success', 'Card criado com sucesso.');
    }

    public function edit($id)
    {
        if (Auth::check() === true) {
            $user_data = User::where("id", auth()->user()->id)->first();
            $card = $this->homeCard->with('imagens')->find($id);

            if (!$card) {
                abort(404);
            }
            $images = $this->galleryImage->get();
            return view('admin.home_card_edit', compact('card', 'images', 'user_data'));
        }
        return redirect()->route('admin.login');
    }

    public function update($id)
    {
        $this->request->validate([
            'titulo' => 'required|max:80',
            'ordem' => 'nullable|integer',
            'tinymce_editor' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ], [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.max' => 'O título não pode ter mais de 80 caracteres.',
            'tinymce_editor.required' => 'O conteúdo é obrigatório.',
            'image.image' => 'O arquivo selecionado deve ser uma imagem.',
            'image.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif ou webp.',
            'image.max' => 'A imagem não pode ser maior que 5MB.',
        ]);

        $card = $this->homeCard->find($id);
        if (!$card) {
            return redirect()->route('home-card.index')->with('danger', 'Card não encontrado.');
        }

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

        $card->titulo = $this->request->input('titulo');
        $card->ordem = $this->request->input('ordem') !== null ? (int)$this->request->input('ordem') : $card->ordem;
        $card->conteudo = $this->request->input('tinymce_editor');
        $card->imagem_id = $imagem_id;
        $card->status = $this->request->input('status') !== null ? (int)$this->request->input('status') : $card->status;

        $atualizacaoBemSucedida = $card->update();

        if ($atualizacaoBemSucedida) {
            return redirect()->route('home-card.index')->with('success', 'Card atualizado com sucesso.');
        } else {
            return redirect()->route('home-card.index')->with('danger', 'Erro ao atualizar o card.');
        }
    }

    public function destroy(int $id)
    {
        $card = $this->homeCard->find($id);

        if (!$card) {
            return response()->json(['success' => false, 'message' => 'Card não encontrado'], 404);
        }

        $card->delete();

        return response()->json(['success' => true, 'message' => 'Card excluído com sucesso']);
    }

    public function atualizarStatus()
    {
        $id = $this->request->input('id');
        $status = $this->request->input('status');

        $card = $this->homeCard->find($id);
        if (!$card) {
            return response()->json(['success'=> false, 'message' => 'Card não encontrado'], 404);
        }
        $card->status = $status;

        $atualizacaoBemSucedida = $card->update();

        $msg = 'Card liberado com sucesso';
        if ($status == 0) {
            $msg = 'Card bloqueado com sucesso!';
        }
        if ($atualizacaoBemSucedida) {
            return response()->json(['success'=> true, 'message' => $msg], 200);
        }

        return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status'], 500);
    }
}
