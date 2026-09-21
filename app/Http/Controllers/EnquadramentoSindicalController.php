<?php

namespace App\Http\Controllers;

use App\Models\Outro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class EnquadramentoSindicalController extends Controller
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
            $enquadramentos = $this->outro::enquadramento()->orderBy('id', 'desc')->get();

            return view('admin.enquadramento', compact('user_data', 'enquadramentos'));
        }
        return redirect()->route('admin.login');
    }

    public function create()
    {
        if (Auth::check() === true) {
            $user_data = User::where("id", auth()->user()->id)->first();
            return view('admin.enquadramento_create', compact('user_data'));
        }
        return redirect()->route('admin.login');
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'tinymce_editor' => ['required', 'string'],
            'status' => ['required', 'in:0,1'],
        ], [
            'tinymce_editor.required' => 'A descrição do enquadramento sindical é obrigatória.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'Status inválido.',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return redirect()->route('enquadramento.index')->with('danger', $error);
        }

        $enquadramento = $this->outro->create([
            'tipo' => Outro::TIPO_ENQUADRAMENTO,
            'tipo_id' => Outro::ID_ENQUADRAMENTO,
            'titulo' => 'Enquadramento Sindical',
            'conteudo' => $this->request->input('tinymce_editor'),
            'status' => (int) $this->request->input('status'),
        ]);

        if (empty($enquadramento)) {
            return redirect()->route('enquadramento.index')->with('danger', 'Não foi possível salvar o Enquadramento Sindical.');
        }
        return redirect()->route('enquadramento.index')->with('success', 'Conteúdo de Enquadramento Sindical criado com sucesso.');
    }

    public function edit(int $id)
    {
        if (Auth::check() === true) {
            $user_data = User::where("id", auth()->user()->id)->first();
            $enquadramento = $this->outro::enquadramento()->find($id);

            if (!$enquadramento) {
                abort(404);
            }

            return view('admin.enquadramento_edit', compact('user_data', 'enquadramento'));
        }
        return redirect()->route('admin.login');
    }

    public function update(int $id)
    {
        $enquadramento = $this->outro::enquadramento()->find($id);

        if (!$enquadramento) {
            return redirect()->route('enquadramento.index')->with('danger', 'Registro não encontrado.');
        }

        $enquadramento->conteudo = $this->request->input('tinymce_editor');
        $enquadramento->status = $this->request->input('status') !== null ? (int) $this->request->input('status') : $enquadramento->status;

        $atualizacaoBemSucedida = $enquadramento->update();

        if (!$atualizacaoBemSucedida) {
            return redirect()->route('enquadramento.index')->with('danger', 'Erro ao atualizar o Enquadramento Sindical.');
        }

        return redirect()->route('enquadramento.index')->with('success', 'Enquadramento Sindical atualizado com sucesso.');
    }

    public function destroy(int $id)
    {
        $enquadramento = $this->outro::enquadramento()->find($id);

        if (!$enquadramento) {
            return response()->json(['success' => false, 'message' => 'Registro não encontrado'], 404);
        }

        $enquadramento->delete();

        return response()->json(['success' => true, 'message' => 'Enquadramento Sindical excluído com sucesso']);
    }

    public function status()
    {
        $id = $this->request->input('id');
        $status = $this->request->input('status');

        $enquadramento = $this->outro::enquadramento()->find($id);
        if (!$enquadramento) {
            return response()->json(['success' => false, 'message' => 'Registro não encontrado'], 404);
        }

        $enquadramento->status = $status;
        $atualizacaoBemSucedida = $enquadramento->update();

        $msg = ($status == 0) ? 'Enquadramento Sindical bloqueado com sucesso!' : 'Enquadramento Sindical liberado com sucesso';

        if ($atualizacaoBemSucedida) {
            return response()->json(['success' => true, 'message' => $msg], 200);
        }

        return response()->json(['success' => false, 'message' => 'Erro ao atualizar o status'], 500);
    }
}