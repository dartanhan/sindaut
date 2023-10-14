<?php

namespace App\Http\Controllers;

use App\Models\Historia;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HistoriaController extends Controller
{
    protected $request,$historia;

    public function __construct(Request $request, Historia $historia){
        $this->request = $request;
        $this->historia = $historia;
    }
    /**
     * Display a listing of the resource.
     *
     * @return RedirectResponse|View
     */
    public function index()
    {
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();
            $historia = $this->historia->first();

            return view('admin.historia', compact('user_data','historia'));
        }
        return redirect()->route('admin.login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'tinymce_editor' => ['required', 'string'],
        ], [
            'tinymce_editor.required' => 'A história é obrigatória.'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return redirect()->route('historia.index')->with('danger', $error);
        }

        $historia = $this->historia->create([
            'conteudo' => $this->request->input('tinymce_editor')
        ]);

        if(empty($historia)){
            return redirect()->route('historia.index')->with('danger','Não foi possível salvar a história.');
        }
        return redirect()->route('historia.index')->with('success','História criada com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Historia  $historia
     * @return \Illuminate\Http\Response
     */
    public function show(Historia $historia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Historia  $historia
     * @return \Illuminate\Http\Response
     */
    public function edit(Historia $historia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function update(int $id)
    {
        $historia = Historia::find($id);

        $historia->conteudo =  $this->request->input('tinymce_editor');

        $atualizacaoBemSucedida = $historia->update();

        if ($atualizacaoBemSucedida) {
            return redirect()->route('historia.index')->with('success','História atualizada com sucesso.');
        } else {
            return redirect()->route('historia.index')->with('danger','Erro ao atualizar a Hitória.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Historia  $historia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Historia $historia)
    {
        //
    }
}
