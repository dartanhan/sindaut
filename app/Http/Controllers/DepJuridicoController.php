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
            $depjuridico = $this->depjuridico->first();

            return view('admin.depjuridico', compact('user_data','depjuridico'));
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
            'tinymce_editor.required' => 'A descrição da homologação é obrigatória.'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return redirect()->route('homologacao.index')->with('danger', $error);
        }

        $depjuridico = $this->depjuridico->create([
            'conteudo' => $this->request->input('tinymce_editor')
        ]);

        if(empty($depjuridico)){
            return redirect()->route('depjuridico.index')->with('danger','Não foi possível salvar o Departmento Jurídico.');
        }
        return redirect()->route('depjuridico.index')->with('success','Departmento Jurídico criado com sucesso.');
    }

     /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function update(int $id)
    {
        $depjuridico = $this->depjuridico::find($id);

        $depjuridico->conteudo =  $this->request->input('tinymce_editor');

        $atualizacaoBemSucedida = $depjuridico->update();

        if (!$atualizacaoBemSucedida) {
            return redirect()->route('depjuridico.index')->with('danger','Erro ao atualizar Departmento Jurídico.');
        } 

        return redirect()->route('depjuridico.index')->with('success','Departmento Jurídico atualizado com sucesso.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Historia  $historia
     * @return \Illuminate\Http\Response
     */
    public function edit(DepJuridico $depjuridico)
    {
       // dd($this->homologacao);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Historia  $historia
     * @return \Illuminate\Http\Response
     */
    public function destroy(DepJuridico $depjuridico)
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

        $depjuridico =  $this->depjuridico->find($id);
        $depjuridico->status = $status;

        $atualizacaoBemSucedida = $depjuridico->update();

        $msg = ($status == 0) ? 'Departmento Jurídico bloqueado com sucesso!' : 'Departmento Jurídico liberado com sucesso';
        
        if ($atualizacaoBemSucedida) {
            return response()->json(['success'=> true, 'message' => $msg], 200);
        }

        return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status'], 500);

    }

}