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
            $beneficio = $this->beneficio->first();

            return view('admin.beneficio', compact('user_data','beneficio'));
        }
        return redirect()->route('admin.login');
    }

     /** 
     * 
    */
    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'tinymce_editor' => ['required', 'string'],
        ], [
            'tinymce_editor.required' => 'A descrição do benefício é obrigatória.'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return redirect()->route('beneficio.index')->with('danger', $error);
        }

        $historia = $this->beneficio->create([
            'conteudo' => $this->request->input('tinymce_editor')
        ]);

        if(empty($historia)){
            return redirect()->route('beneficio.index')->with('danger','Não foi possível salvar o benefício.');
        }
        return redirect()->route('beneficio.index')->with('success','Benefício criado com sucesso.');
    }

     /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function update(int $id)
    {
        $beneficio = $this->beneficio::find($id);

        $beneficio->conteudo =  $this->request->input('tinymce_editor');

        $atualizacaoBemSucedida = $beneficio->update();

        if (!$atualizacaoBemSucedida) {
            return redirect()->route('beneficio.index')->with('danger','Erro ao atualizar a Benefício.');
        } 

        return redirect()->route('beneficio.index')->with('success','Benefício atualizada com sucesso.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Historia  $historia
     * @return \Illuminate\Http\Response
     */
    public function edit(Beneficios $beneficio)
    {
       // dd($this->homologacao);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Historia  $historia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Beneficios $beneficio)
    {
        //
    }

        /***
     * Atualiza o status para ativo e inativo
     * */
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
