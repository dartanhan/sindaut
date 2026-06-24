<?php

namespace App\Http\Controllers;

use App\Models\DepJuridico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class DepJuridicoController extends Controller
{
   
    protected $request,$depjuridico;

    public function __construct(Request $request, DepJuridico $depjuridico){
        $this->request = $request;
        $this->depjuridico = $depjuridico;
    }

    public function index(){
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();
            $depjuridicos = $this->depjuridico::orderBy('id', 'desc')->get();

            return view('admin.depjuridico', compact('user_data','depjuridicos'));
        }
        return redirect()->route('admin.login');
    }

    public function create()
    {
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();
            return view('admin.depjuridico_create', compact('user_data'));
        }
        return redirect()->route('admin.login');
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'tinymce_editor' => ['required', 'string'],
            'status' => ['required', 'in:0,1'],
        ], [
            'tinymce_editor.required' => 'A descrição do departamento jurídico é obrigatória.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'Status inválido.',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return redirect()->route('depjuridico.index')->with('danger', $error);
        }

        $depjuridico = $this->depjuridico->create([
            'conteudo' => $this->request->input('tinymce_editor'),
            'status' => (int) $this->request->input('status'),
        ]);

        if(empty($depjuridico)){
            return redirect()->route('depjuridico.index')->with('danger','Não foi possível salvar o Departamento Jurídico.');
        }
        return redirect()->route('depjuridico.index')->with('success','Departamento Jurídico criado com sucesso.');
    }

    public function edit(int $id)
    {
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();
            $depjuridico = $this->depjuridico::find($id);

            if (!$depjuridico) {
                abort(404);
            }

            return view('admin.depjuridico_edit', compact('user_data', 'depjuridico'));
        }
        return redirect()->route('admin.login');
    }

    public function update(int $id)
    {
        $depjuridico = $this->depjuridico::find($id);

        $depjuridico->conteudo =  $this->request->input('tinymce_editor');
        $depjuridico->status = $this->request->input('status') !== null ? (int)$this->request->input('status') : $depjuridico->status;

        $atualizacaoBemSucedida = $depjuridico->update();

        if (!$atualizacaoBemSucedida) {
            return redirect()->route('depjuridico.index')->with('danger','Erro ao atualizar o Departamento Jurídico.');
        } 

        return redirect()->route('depjuridico.index')->with('success','Departamento Jurídico atualizado com sucesso.');
    }

    public function destroy(int $id)
    {
        $depjuridico = $this->depjuridico::find($id);

        if (!$depjuridico) {
            return response()->json(['success' => false, 'message' => 'Departamento Jurídico não encontrado'], 404);
        }

        $depjuridico->delete();

        return response()->json(['success' => true, 'message' => 'Departamento Jurídico excluído com sucesso']);
    }

    public function status()
    {
        $id = $this->request->input('id');
        $status = $this->request->input('status');

        $depjuridico =  $this->depjuridico->find($id);
        $depjuridico->status = $status;

        $atualizacaoBemSucedida = $depjuridico->update();

        $msg = ($status == 0) ? 'Departamento Jurídico bloqueado com sucesso!' : 'Departamento Jurídico liberado com sucesso';
        
        if ($atualizacaoBemSucedida) {
            return response()->json(['success'=> true, 'message' => $msg], 200);
        }

        return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status'], 500);

    }

}