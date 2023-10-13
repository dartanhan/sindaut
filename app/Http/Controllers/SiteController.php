<?php

namespace App\Http\Controllers;

use App\Models\GaleriaImagem;
use App\Models\Noticia;
use Illuminate\Http\Request;
use ReCaptcha\ReCaptcha;
use Stevebauman\Purify\Facades\Purify;

class SiteController extends Controller
{
    protected $noticia,$request;

    public function __construct(Request $request, Noticia $noticia){
        $this->noticia = $noticia;
        $this->request = $request;
    }

    public function index(){
        //$noticias =$this->noticia->where('status',1)->orderBy('id', 'desc')->get();
        $noticias = $this->noticia->with('imagens')
            ->where('status',1)
            ->orderBy('id', 'desc')->get();

        return view('site.home',compact('noticias'));
    }

    public function contato(){
        $noticias = $this->noticia->with('imagens')
            ->where('status',1)
            ->orderBy('id', 'desc')->get();

        return view('site.contato',compact('noticias'));
    }

    public function detalheNoticia($id){
        $noticiaDetalhe = $this->noticia->with('imagens')
            ->where('status',1)->where('id',$id)->first();

        $noticias = $this->noticia->with('imagens')
            ->where('status',1)
            ->orderBy('id', 'desc')->get();

        return view('site.detalhe',compact('noticias','noticiaDetalhe'));
    }

    public function enviaContato(){
        $recaptchaSecret = env('DATA_SECRET_KEY');
        $recaptchaResponse = $_POST['g-recaptcha-response'];

       // $response = (new ReCaptcha($recaptchaSecret))->verify($this->request->input('g-recaptcha-response'), $this->request->ip());


        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
        $responseKeys = json_decode($response, true);


        if (intval($responseKeys["success"]) !== 1) {
            return redirect()->back()->withInput()->withErrors(['Você é considerado um Bot / Spammer!']);
        } else {
            // O reCAPTCHA foi validado
            // Processar o formulário
            $name = Purify::clean($_POST['nome']);
            $email = Purify::clean($_POST['email']);
            $message = Purify::clean($_POST['mensagem']);

            $para = "dartanhan.lima@gmail.com";//sindautrj@gmail.com
            $assunto = "Fale Conosco - Sindaut ";
            $mensagem = "Nome:" . $name . "<br>" .  "Email:" . $email . "<br>". $message;

            // Cabeçalhos do e-mail
            $headers = "From: sindaut@sindaut.org.br\r\n";
           // $headers .= "Reply-To: remetente@example.com\r\n";
            $headers .= "Content-type: text/html; charset=utf-8\r\n";

            // Envia o e-mail
            $enviado = mail($para, $assunto, $mensagem, $headers);

            // Verifica se o e-mail foi enviado com sucesso
            if ($enviado) {
               // echo "E-mail enviado com sucesso!";
                return redirect()->route('site.contato')->with('success','Formulário enviado com sucesso!');
            } else {
                return redirect()->route('site.contato')->with('danger','Formulário não enviado! Tente novamente mais tarde!');
            }
        }
    }
}
