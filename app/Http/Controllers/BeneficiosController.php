<?php

namespace App\Http\Controllers;

use App\Models\Beneficios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class BeneficiosController extends Controller
{
    protected $request,$beneficio;

    public function __construct(Request $request, Beneficios $beneficio){
        $this->request = $request;
        $this->beneficio = $beneficio;
    }

    public function index(){
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();
            $beneficios = $this->beneficio::orderBy('id', 'desc')->get();

            return view('admin.beneficio', compact('user_data','beneficios'));
        }
        return redirect()->route('admin.login');
    }

    public function create()
    {
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();
            return view('admin.beneficio_create', compact('user_data'));
        }
        return redirect()->route('admin.login');
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'tinymce_editor' => ['required', 'string'],
            'status' => ['required', 'in:0,1'],
        ], [
            'tinymce_editor.required' => 'A descrição do benefício é obrigatória.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'Status inválido.',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return redirect()->route('beneficio.index')->with('danger', $error);
        }

        $historia = $this->beneficio->create([
            'conteudo' => $this->request->input('tinymce_editor'),
            'status' => (int) $this->request->input('status'),
        ]);

        if(empty($historia)){
            return redirect()->route('beneficio.index')->with('danger','Não foi possível salvar o benefício.');
        }
        return redirect()->route('beneficio.index')->with('success','Benefício criado com sucesso.');
    }

    public function edit(int $id)
    {
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();
            $beneficio = $this->beneficio::find($id);

            if (!$beneficio) {
                abort(404);
            }

            return view('admin.beneficio_edit', compact('user_data', 'beneficio'));
        }
        return redirect()->route('admin.login');
    }

    public function update(int $id)
    {
        $beneficio = $this->beneficio::find($id);

        $beneficio->conteudo =  $this->request->input('tinymce_editor');
        $beneficio->status = $this->request->input('status') !== null ? (int)$this->request->input('status') : $beneficio->status;

        $atualizacaoBemSucedida = $beneficio->update();

        if (!$atualizacaoBemSucedida) {
            return redirect()->route('beneficio.index')->with('danger','Erro ao atualizar o Benefício.');
        } 

        return redirect()->route('beneficio.index')->with('success','Benefício atualizado com sucesso.');
    }

    public function destroy(int $id)
    {
        $beneficio = $this->beneficio::find($id);

        if (!$beneficio) {
            return response()->json(['success' => false, 'message' => 'Benefício não encontrado'], 404);
        }

        $beneficio->delete();

        return response()->json(['success' => true, 'message' => 'Benefício excluído com sucesso']);
    }

    public function status()
    {
        $id = $this->request->input('id');
        $status = $this->request->input('status');

        $beneficio =  $this->beneficio->find($id);
        $beneficio->status = $status;

        $atualizacaoBemSucedida = $beneficio->update();

        $msg = ($status == 0) ? 'Benefício bloqueado com sucesso!' : 'Benefício liberado com sucesso';
        
        if ($atualizacaoBemSucedida) {
            return response()->json(['success'=> true, 'message' => $msg], 200);
        }

        return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status benefício'], 500);

    }
}
