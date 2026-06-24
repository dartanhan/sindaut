<?php

namespace App\Http\Controllers;

use App\Models\Homologacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class HomologacaoController extends Controller
{
   
    protected $request,$homologacao;

    public function __construct(Request $request, Homologacao $homologacao){
        $this->request = $request;
        $this->homologacao = $homologacao;
    }

    public function index()
    {
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();
            $homologacoes = $this->homologacao::orderBy('id', 'desc')->get();

            return view('admin.homologacao', compact('user_data','homologacoes'));
        }
        return redirect()->route('admin.login');
    }

    public function create()
    {
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();
            return view('admin.homologacao_create', compact('user_data'));
        }
        return redirect()->route('admin.login');
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'tinymce_editor' => ['required', 'string'],
            'status' => ['required', 'in:0,1'],
        ], [
            'tinymce_editor.required' => 'A descrição da homologação é obrigatória.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'Status inválido.',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return redirect()->route('homologacao.index')->with('danger', $error);
        }

        $homologacao = $this->homologacao->create([
            'conteudo' => $this->request->input('tinymce_editor'),
            'status' => (int) $this->request->input('status'),
        ]);

        if(empty($homologacao)){
            return redirect()->route('homologacao.index')->with('danger','Não foi possível salvar a homologação.');
        }
        return redirect()->route('homologacao.index')->with('success','Homologação criada com sucesso.');
    }

    public function edit(int $id)
    {
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();
            $homologacao = $this->homologacao::find($id);

            if (!$homologacao) {
                abort(404);
            }

            return view('admin.homologacao_edit', compact('user_data', 'homologacao'));
        }
        return redirect()->route('admin.login');
    }

    public function update(int $id)
    {
        $homologacao = $this->homologacao::find($id);

        if (!$homologacao) {
            return redirect()->route('homologacao.index')->with('danger','Homologação não encontrada.');
        }

        $homologacao->conteudo =  $this->request->input('tinymce_editor');
        $homologacao->status = $this->request->input('status') !== null ? (int)$this->request->input('status') : $homologacao->status;

        $atualizacaoBemSucedida = $homologacao->update();

        if (!$atualizacaoBemSucedida) {
            return redirect()->route('homologacao.index')->with('danger','Erro ao atualizar a Homologação.');
        } 

        return redirect()->route('homologacao.index')->with('success','Homologação atualizada com sucesso.');
    }

    public function destroy(int $id)
    {
        $homologacao = $this->homologacao::find($id);

        if (!$homologacao) {
            return response()->json(['success' => false, 'message' => 'Homologação não encontrada'], 404);
        }

        $homologacao->delete();

        return response()->json(['success' => true, 'message' => 'Homologação excluída com sucesso']);
    }

    public function status()
    {
        $id = $this->request->input('id');
        $status = $this->request->input('status');

        $homologacao =  $this->homologacao->find($id);
        $homologacao->status = $status;

        $atualizacaoBemSucedida = $homologacao->update();

        $msg = ($status == 0) ? 'Homologação bloqueada com sucesso!' : 'Homologação liberada com sucesso';
        
        if ($atualizacaoBemSucedida) {
            return response()->json(['success'=> true, 'message' => $msg], 200);
        }

        return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status Homologação'], 500);
    }

}
