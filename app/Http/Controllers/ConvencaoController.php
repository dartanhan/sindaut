<?php

namespace App\Http\Controllers;

use App\Models\Convencao;
use App\Models\ConvencaoDescricao;
use App\Models\GaleriaImagem;
use App\Models\TemporaryFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ConvencaoController extends Controller
{
    protected $request,$convencao,$convencaoDescricao;

    public function __construct(Request $request, Convencao $convencao , ConvencaoDescricao $convencaoDescricao){
        $this->request = $request;
        $this->convencao = $convencao;
        $this->convencaoDescricao = $convencaoDescricao;
    }

    public function index(){

        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();

            $convencoes = Convencao::with('files')->orderBy('ordem', 'asc')->get();

            return view('admin.convencao',compact('user_data','convencoes'));
        }
        return redirect()->route('admin.login');
    }

    public function create()
    {
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();
            $convencaoDescricao = ConvencaoDescricao::first();
            return view('admin.convencao_create', compact('user_data', 'convencaoDescricao'));
        }
        return redirect()->route('admin.login');
    }

    /****
     * Salva a convenção
     * @return RedirectResponse
     */
    public function store()
    {
        $this->request->validate([
            'titulo' => 'required|max:500',
            'data_cct' => 'required|max:10',
            'image' => 'required|file|mimes:pdf|max:10240',
            'status' => 'required|in:0,1',
        ], [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.max' => 'O título não pode ter mais de 500 caracteres.',
            'data_cct.required' => 'A vigência é obrigatória.',
            'data_cct.max' => 'A vigência não pode ter mais de 10 caracteres.',
            'image.required' => 'O arquivo PDF da convenção é obrigatório.',
            'image.file' => 'O arquivo enviado deve ser um arquivo válido.',
            'image.mimes' => 'O arquivo deve ser do tipo PDF.',
            'image.max' => 'O arquivo não pode ser maior que 10MB.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'Status inválido.',
        ]);

        try {
            $imagem_id = null;
            if ($this->request->hasFile('image')) {
                $pdfFile = $this->request->file('image');
                $nome_unico = \Illuminate\Support\Str::uuid() . '.' . $pdfFile->getClientOriginalExtension();
                $pdfFile->storeAs('posts/files', $nome_unico, 'public');

                $imagem = GaleriaImagem::create([
                    'path' => $nome_unico
                ]);
                $imagem_id = $imagem->id;
            }

            if ($imagem_id) {
                $maxOrdem = Convencao::max('ordem') ?? 0;

                $convencao = new Convencao();
                $convencao->titulo_cct = $this->request->titulo;
                $convencao->data_cct = $this->request->data_cct;
                $convencao->file_id = $imagem_id;
                $convencao->status = (int)$this->request->status;
                $convencao->ordem = $maxOrdem + 1;

                if ($convencao->save()) {
                    ConvencaoDescricao::updateOrCreate(
                        ['id' => $this->request->input('convencao_descricao_id')],
                        ['descricao' => $this->request->input('descricao_cct') !== null ? $this->request->input('descricao_cct') : ""]
                    );
                }
                return redirect()->route('convencao.index')->with('success','Convenção criada com sucesso!');
            }
            return redirect()->route('convencao.index')->with('danger','Favor informe o arquivo CCT para upload!');

        } catch (\Exception $th) {
            return redirect()->route('convencao.index')->with('danger','Erro ao cadastrar convenção: ' . $th->getMessage());
        }
    }

    public function edit($id)
    {
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();
            $convencao = Convencao::with('files')->find($id);

            if (!$convencao) {
                abort(404);
            }

            $convencaoDescricao = ConvencaoDescricao::first();

            return view('admin.convencao_edit', compact('user_data', 'convencao', 'convencaoDescricao'));
        }
        return redirect()->route('admin.login');
    }

    /**
     * @param int $id
     */
    public function destroy(int $id){
        $convencao = Convencao::find($id);

        if (!$convencao) {
            return response()->json(['success' => false, 'message' => 'Convenção não encontrada'], 404);
        }

        $convencao->delete();

        return response()->json(['success' => true, 'message' => 'Convenção excluída com sucesso']);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function update(int $id)
    {
        $this->request->validate([
            'titulo' => 'required|max:500',
            'data_cct' => 'required|max:10',
            'image' => 'nullable|file|mimes:pdf|max:10240',
            'status' => 'required|in:0,1',
        ], [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.max' => 'O título não pode ter mais de 500 caracteres.',
            'data_cct.required' => 'A vigência é obrigatória.',
            'data_cct.max' => 'A vigência não pode ter mais de 10 caracteres.',
            'image.file' => 'O arquivo enviado deve ser um arquivo válido.',
            'image.mimes' => 'O arquivo deve ser do tipo PDF.',
            'image.max' => 'O arquivo não pode ser maior que 10MB.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'Status inválido.',
        ]);

        try {
            $convencao = Convencao::find($id);
            if (!$convencao) {
                return redirect()->route('convencao.index')->with('danger', 'Convenção não encontrada.');
            }

            //atualiza a convenção
            $convencao->titulo_cct = $this->request->input('titulo');
            $convencao->data_cct =  $this->request->input('data_cct');
            $convencao->status = (int)$this->request->input('status');
            $convencao->update();

            // Atualiza ou cria o registro a descrição da convenção
            ConvencaoDescricao::updateOrCreate(
                ['id' => $this->request->input('convencao_descricao_id')], // Condição de busca
                ['descricao' => $this->request->input('descricao_cct') !== null ? $this->request->input('descricao_cct') : ""] // Valores a serem atualizados ou criados
            );

            //se tiver imagem , atualiza
            if ($this->request->hasFile('image')) {
                $pdfFile = $this->request->file('image');
                $nome_unico = \Illuminate\Support\Str::uuid() . '.' . $pdfFile->getClientOriginalExtension();
                $pdfFile->storeAs('posts/files', $nome_unico, 'public');

                $galeriaImagem = GaleriaImagem::find($this->request->input('file_id'));
                if($galeriaImagem) {
                    //deleta o arquivo antigo
                    Storage::disk('public')->delete('posts/files/' . $galeriaImagem->path);

                    //atualiza o arquivo
                    $galeriaImagem->path = $nome_unico;
                    $galeriaImagem->update();
                } else {
                    $imagem = GaleriaImagem::create([
                        'path' => $nome_unico
                    ]);
                    $convencao->file_id = $imagem->id;
                    $convencao->update();
                }
            }

            return redirect()->route('convencao.index')->with('success','Convenção atualizada com sucesso.');

        }catch (\Exception $ex){
            return redirect()->route('convencao.index')->with('danger','Erro ao atualizar Convenção: ' . $ex->getMessage());
        }
    }

    /***
     * Atualiza o status para ativo e inativo
     * */
    public function status(){
        $id = $this->request->input('id');
        $status = $this->request->input('status');

        $convencao =  $this->convencao->find($id);
        $convencao->status = $status;

        $atualizacaoBemSucedida = $convencao->update();

        $msg = 'Convenção liberada com sucesso';
        if($status == 0){
            $msg = 'Convenção bloqueada com sucesso!';
        }
        if ($atualizacaoBemSucedida) {
            return response()->json(['success'=> true, 'message' => $msg], 200);
        }

        return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status'], 500);
    }

    /***
     * Reordena as convenções via drag-and-drop
     */
    public function reorder()
    {
        $order = $this->request->input('order');
        if (is_array($order)) {
            foreach ($order as $item) {
                Convencao::where('id', $item['id'])->update(['ordem' => (int) $item['position']]);
            }
            return response()->json(['success' => true, 'message' => 'Ordem atualizada com sucesso'], 200);
        }
        return response()->json(['success' => false, 'message' => 'Payload inválido'], 400);
    }
}
