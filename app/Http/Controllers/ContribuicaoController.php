<?php

namespace App\Http\Controllers;

use App\Models\Outro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ContribuicaoController extends Controller
{
    protected $request;
    protected $outro;

    public function __construct(Request $request, Outro $outro)
    {
        $this->request = $request;
        $this->outro = $outro;
    }

    public function index()
    {
        if (Auth::check() === true) {
            $user_data = User::where("id", auth()->user()->id)->first();
            $contribuicoes = $this->outro::contribuicoes()->orderBy('id', 'desc')->get();

            return view('admin.contribuicoes', compact('user_data', 'contribuicoes'));
        }
        return redirect()->route('admin.login');
    }

    public function create()
    {
        if (Auth::check() === true) {
            $user_data = User::where("id", auth()->user()->id)->first();
            return view('admin.contribuicoes_create', compact('user_data'));
        }
        return redirect()->route('admin.login');
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'tinymce_editor' => ['required', 'string'],
            'status' => ['required', 'in:0,1'],
        ], [
            'tinymce_editor.required' => 'A descrição das contribuições é obrigatória.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'Status inválido.',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return redirect()->route('contribuicoes.index')->with('danger', $error);
        }

        $contribuicao = $this->outro->create([
            'tipo' => Outro::TIPO_CONTRIBUICOES,
            'tipo_id' => Outro::ID_CONTRIBUICOES,
            'titulo' => 'Contribuições',
            'conteudo' => $this->request->input('tinymce_editor'),
            'status' => (int) $this->request->input('status'),
        ]);

        if (empty($contribuicao)) {
            return redirect()->route('contribuicoes.index')->with('danger', 'Não foi possível salvar as Contribuições.');
        }
        return redirect()->route('contribuicoes.index')->with('success', 'Conteúdo de Contribuições criado com sucesso.');
    }

    public function edit(int $id)
    {
        if (Auth::check() === true) {
            $user_data = User::where("id", auth()->user()->id)->first();
            $contribuicao = $this->outro::contribuicoes()->find($id);

            if (!$contribuicao) {
                abort(404);
            }

            return view('admin.contribuicoes_edit', compact('user_data', 'contribuicao'));
        }
        return redirect()->route('admin.login');
    }

    public function update(int $id)
    {
        $contribuicao = $this->outro::contribuicoes()->find($id);

        if (!$contribuicao) {
            return redirect()->route('contribuicoes.index')->with('danger', 'Registro não encontrado.');
        }

        $contribuicao->conteudo = $this->request->input('tinymce_editor');
        $contribuicao->status = $this->request->input('status') !== null ? (int) $this->request->input('status') : $contribuicao->status;

        $atualizacaoBemSucedida = $contribuicao->update();

        if (!$atualizacaoBemSucedida) {
            return redirect()->route('contribuicoes.index')->with('danger', 'Erro ao atualizar as Contribuições.');
        }

        return redirect()->route('contribuicoes.index')->with('success', 'Contribuições atualizadas com sucesso.');
    }

    public function destroy(int $id)
    {
        $contribuicao = $this->outro::contribuicoes()->find($id);

        if (!$contribuicao) {
            return response()->json(['success' => false, 'message' => 'Registro não encontrado'], 404);
        }

        $contribuicao->delete();

        return response()->json(['success' => true, 'message' => 'Contribuições excluídas com sucesso']);
    }

    public function status()
    {
        $id = $this->request->input('id');
        $status = $this->request->input('status');

        $contribuicao = $this->outro::contribuicoes()->find($id);
        if (!$contribuicao) {
            return response()->json(['success' => false, 'message' => 'Registro não encontrado'], 404);
        }

        $contribuicao->status = $status;
        $atualizacaoBemSucedida = $contribuicao->update();

        $msg = ($status == 0) ? 'Contribuições bloqueadas com sucesso!' : 'Contribuições liberadas com sucesso';

        if ($atualizacaoBemSucedida) {
            return response()->json(['success' => true, 'message' => $msg], 200);
        }

        return response()->json(['success' => false, 'message' => 'Erro ao atualizar o status'], 500);
    }
}