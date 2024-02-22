<?php

namespace App\Http\Controllers;

use App\Models\Convencao;
use App\Models\GaleriaImagem;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ConvencaoController extends Controller
{
    protected $request,$convencao;

    public function __construct(Request $request, Convencao $convencao ){
        $this->request = $request;
        $this->convencao = $convencao;
    }

    public function index(){

        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();
            
            $convencoes = $this->convencao::with('files')->orderBy('id', 'desc')->get();

           // dd($convencoes);
            return view('admin.convencao',compact('user_data','convencoes'));
        }
        return redirect()->route('admin.login');
    }

    /****
     * Salva a convenção
     * 
     */
    public function store(Request $request){
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
                $convencao->titulo_cct = $request->titulo;
                $convencao->data_cct = $request->data_cct;
                $convencao->descricao_cct = $request->descricao_cct;
                $convencao->file_id = $imagem->id;
                $convencao->save();

                return redirect()->route('convencao.index')->with('success','Convenção criada com sucesso!');
            }
            return redirect()->route('convencao.index')->with('danger','Favor informe o arquivo CCT para upload!');
            
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
