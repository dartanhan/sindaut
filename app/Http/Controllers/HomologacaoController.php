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

    public function index(){
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();
            $homologacao = $this->homologacao->first();

            return view('admin.homologacao', compact('user_data','homologacao'));
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

        $historia = $this->homologacao->create([
            'conteudo' => $this->request->input('tinymce_editor')
        ]);

        if(empty($historia)){
            return redirect()->route('homologacao.index')->with('danger','Não foi possível salvar a homologacão.');
        }
        return redirect()->route('homologacao.index')->with('success','Homologacão criada com sucesso.');
    }

     /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function update(int $id)
    {
        $homologacao = $this->homologacao::find($id);

        $homologacao->conteudo =  $this->request->input('tinymce_editor');

        $atualizacaoBemSucedida = $homologacao->update();

        if (!$atualizacaoBemSucedida) {
            return redirect()->route('homologacao.index')->with('danger','Erro ao atualizar a Homologação.');
        } 

        return redirect()->route('homologacao.index')->with('success','Homologação atualizada com sucesso.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Historia  $historia
     * @return \Illuminate\Http\Response
     */
    public function edit(Homologacao $homologacao)
    {
       // dd($this->homologacao);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Historia  $historia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Homologacao $homologacao)
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
