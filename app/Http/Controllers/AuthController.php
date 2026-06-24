<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use ReCaptcha\ReCaptcha;


class AuthController extends Controller
{

    public function dashboard() {

        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();
            $noticiasAtivas = \App\Models\Noticia::where('status', 1)->count();
            $totalUsuarios = User::count();
            $totalConvencoes = \App\Models\Convencao::count();

            return view('admin.dashboard', compact('user_data', 'noticiasAtivas', 'totalUsuarios', 'totalConvencoes'));
        }
        return redirect()->route('admin.login');

    }

    function showLoginForm() {
        //return view('admin.formLogin');
        return view('auth.login');
    }

    function login(Request $request) {

        if (!app()->environment('local')) {
            $secret = env('DATA_SECRET_KEY');
            $recaptchaResponse = $request->input('g-recaptcha-response');

            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$recaptchaResponse");
            $responseKeys = json_decode($response, true);

            if (intval($responseKeys["success"]) !== 1) {
                return redirect()->back()->withInput()->withErrors(['Você é considerado um Bot / Spammer!']);
            }
        }

        if (true) {
            if(!filter_var($request->input("email") , FILTER_VALIDATE_EMAIL)){
                return redirect()->back()->withInput()->withErrors(['Login informado não é valido!']);
            }

            $credentials = [
                'email' => $request->input("email"),
                'password' => $request->input("password")
            ];

            if(Auth::attempt($credentials)){
                return redirect()->route('admin.dashboard');
            }
            return redirect()->back()->withInput()->withErrors(['Dados informados são inválidos!']);
        }
    }

    function logout(Request $request) {
        //Auth::logout();

       // $this->guard->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('admin.login');
    }

}


