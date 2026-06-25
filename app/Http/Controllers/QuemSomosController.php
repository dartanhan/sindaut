<?php

namespace App\Http\Controllers;

use App\Models\QuemSomos;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuemSomosController extends Controller
{
    protected $request, $quemsomos;

    public function __construct(Request $request, QuemSomos $quemsomos){
        $this->request = $request;
        $this->quemsomos = $quemsomos;
    }

    /**
     * Display a listing of the resource.
     *
     * @return RedirectResponse|View
     */
    public function index()
    {
        if(Auth::check() === true){
            $user_data = User::where("id", auth()->user()->id)->first();
            $quemsomos_list = $this->quemsomos::orderBy('id', 'desc')->get();

            return view('admin.quemsomos', compact('user_data', 'quemsomos_list'));
        }
        return redirect()->route('admin.login');
    }

    public function create()
    {
        if(Auth::check() === true){
            $user_data = User::where("id", auth()->user()->id)->first();
            return view('admin.quemsomos_create', compact('user_data'));
        }
        return redirect()->route('admin.login');
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'tinymce_editor' => ['required', 'string'],
            'status' => ['required', 'in:0,1'],
        ], [
            'tinymce_editor.required' => 'O conteúdo é obrigatório.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'Status inválido.',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return redirect()->route('quemsomos.index')->with('danger', $error);
        }

        $quemsomos = $this->quemsomos->create([
            'conteudo' => $this->request->input('tinymce_editor'),
            'status' => (int) $this->request->input('status'),
        ]);

        if(empty($quemsomos)){
            return redirect()->route('quemsomos.index')->with('danger', 'Não foi possível salvar o conteúdo de Quem Somos.');
        }
        return redirect()->route('quemsomos.index')->with('success', 'Quem Somos criado com sucesso.');
    }

    public function show(QuemSomos $quemsomos)
    {
        //
    }

    public function edit(int $id)
    {
        if(Auth::check() === true){
            $user_data = User::where("id", auth()->user()->id)->first();
            $quemsomos = $this->quemsomos::find($id);

            if (!$quemsomos) {
                abort(404);
            }

            return view('admin.quemsomos_edit', compact('user_data', 'quemsomos'));
        }
        return redirect()->route('admin.login');
    }

    public function update(int $id)
    {
        $quemsomos = $this->quemsomos::find($id);

        if (!$quemsomos) {
            return redirect()->route('quemsomos.index')->with('danger', 'Quem Somos não encontrado.');
        }

        $quemsomos->conteudo = $this->request->input('tinymce_editor');
        $quemsomos->status = $this->request->input('status') !== null ? (int)$this->request->input('status') : $quemsomos->status;

        $atualizacaoBemSucedida = $quemsomos->update();

        if (!$atualizacaoBemSucedida) {
            return redirect()->route('quemsomos.index')->with('danger', 'Erro ao atualizar o Quem Somos.');
        }
        
        return redirect()->route('quemsomos.index')->with('success', 'Quem Somos atualizado com sucesso.');
    }

    public function destroy(int $id)
    {
        $quemsomos = $this->quemsomos::find($id);

        if (!$quemsomos) {
            return response()->json(['success' => false, 'message' => 'Quem Somos não encontrado'], 404);
        }

        $quemsomos->delete();

        return response()->json(['success' => true, 'message' => 'Quem Somos excluído com sucesso']);
    }
}
