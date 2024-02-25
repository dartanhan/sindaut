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

            $convencoes = Convencao::with('files')->orderBy('id', 'desc')->get();

            return view('admin.convencao',compact('user_data','convencoes'));
        }
        return redirect()->route('admin.login');
    }

    /****
     * Salva a convenção
     * @return RedirectResponse
     */
    public function store(){
      //  dd($request);

        try {

            $temp_file = TemporaryFile::where('folder',$this->request->image)->first();

            if($temp_file){
                Storage::copy('posts/tmp/'.$temp_file->folder.'/'.$temp_file->file,'posts/files/'.$temp_file->file);

                $imagem = GaleriaImagem::create([
                           'path' =>  $temp_file->file
                ]);
                Storage::deleteDirectory('posts/tmp/'.$temp_file->folder);
                $temp_file->delete();

                $convencao = new Convencao();
                $convencao->titulo_cct = $this->request->titulo;
                $convencao->data_cct = $this->request->data_cct;
                $convencao->file_id = $imagem->id;

                if( $convencao->save()){
                    $this->convencaoDescricao->descricao  = $this->request->descricao_cct;
                    $this->convencaoDescricao->save();
                }
                return redirect()->route('convencao.index')->with('success','Convenção criada com sucesso!');
            }
            return redirect()->route('convencao.index')->with('danger','Favor informe o arquivo CCT para upload!');

        } catch (\Exception $th) {
            //throw $th;
        }
    }

    public function edit($id)
    {
        //$noticia = Noticia::find($id);
        $convencao = Convencao::with('files')->find($id);
        $convencaoDescricao = ConvencaoDescricao::first();

        if (!$convencao) {
            abort(404); // Retorna um erro 404 se a notícia não for encontrada
        }
        $convencao['descricao_cct'] = $convencaoDescricao;

        return response()->json(['success' => true, 'data' => $convencao]);
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
    public function update(int $id){
       //dd($this->request);
        //dd($id);
        try {
            $convencao = Convencao::find($id);

            $convencao->titulo_cct = $this->request->input('titulo');
            $convencao->data_cct =  $this->request->input('data_cct');

            $convencao->update();

            $convencao = ConvencaoDescricao::find($this->request->input('convencao_descricao_id'));
            $convencao->descricao = $this->request->input('descricao_cct');
            $convencao->update();

            if($this->request->image){
                $temp_file = TemporaryFile::where('folder',$this->request->image)->first();

                if($temp_file) {
                    Storage::copy('posts/tmp/' . $temp_file->folder . '/' . $temp_file->file, 'posts/files/' . $temp_file->file);

                    $galeriaImagem = GaleriaImagem::find($this->request->input('file_id'));
                    if($galeriaImagem) {
                        //deleta o arquivo antigo
                        Storage::delete('posts/files/' . $galeriaImagem->path);

                        //atualiza a o arquivo
                        $galeriaImagem->path = $temp_file->file;
                        $galeriaImagem->update();

                    }

                    Storage::deleteDirectory('posts/tmp/' . $temp_file->folder);
                    $temp_file->delete();
                }

            }

            return redirect()->route('convencao.index')->with('success','Convenção atualizada com sucesso.');

        }catch (\Exception $ex){
            return redirect()->route('convencao.index')->with('danger','Erro ao atualizar Convenção.');
        }
    }
    /***
     * Atualiza o status para ativo e inativo
     * */
    public function status(){
        //dd($request);
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
}
