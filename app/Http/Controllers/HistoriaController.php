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
            $historias = $this->historia::orderBy('id', 'desc')->get();

            return view('admin.historia', compact('user_data','historias'));
        }
        return redirect()->route('admin.login');
    }

    public function create()
    {
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();
            return view('admin.historia_create', compact('user_data'));
        }
        return redirect()->route('admin.login');
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'tinymce_editor' => ['required', 'string'],
            'status' => ['required', 'in:0,1'],
        ], [
            'tinymce_editor.required' => 'A história é obrigatória.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'Status inválido.',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return redirect()->route('historia.index')->with('danger', $error);
        }

        $historia = $this->historia->create([
            'conteudo' => $this->request->input('tinymce_editor'),
            'status' => (int) $this->request->input('status'),
        ]);

        if(empty($historia)){
            return redirect()->route('historia.index')->with('danger','Não foi possível salvar a história.');
        }
        return redirect()->route('historia.index')->with('success','História criada com sucesso.');
    }

    public function show(Historia $historia)
    {
        //
    }

    public function edit(int $id)
    {
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();
            $historia = $this->historia::find($id);

            if (!$historia) {
                abort(404);
            }

            return view('admin.historia_edit', compact('user_data', 'historia'));
        }
        return redirect()->route('admin.login');
    }

    public function update(int $id)
    {
        $historia = $this->historia::find($id);

        if (!$historia) {
            return redirect()->route('historia.index')->with('danger','História não encontrada.');
        }

        $historia->conteudo =  $this->request->input('tinymce_editor');
        $historia->status = $this->request->input('status') !== null ? (int)$this->request->input('status') : $historia->status;

        $atualizacaoBemSucedida = $historia->update();

        if (!$atualizacaoBemSucedida) {
            return redirect()->route('historia.index')->with('danger','Erro ao atualizar a Hitória.');
        }
        
        return redirect()->route('historia.index')->with('success','História atualizada com sucesso.');
    }

    public function destroy(int $id)
    {
        $historia = $this->historia::find($id);

        if (!$historia) {
            return response()->json(['success' => false, 'message' => 'História não encontrada'], 404);
        }

        $historia->delete();

        return response()->json(['success' => true, 'message' => 'História excluída com sucesso']);
    }
}
