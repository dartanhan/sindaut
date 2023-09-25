<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ReCaptcha\ReCaptcha;


class AuthController extends Controller
{

    public function dashboard() {

        if(Auth::check() === true){
            view('admin.dashboard');
        }
        return redirect()->route('admin.login');

    }

    function showLoginForm() {
        //return view('admin.formLogin');
        return view('auth.login');
    }

    function login(Request $request) {

        //$secret = env('DATA_SECRET_KEY');

       // $response = (new ReCaptcha($secret))->verify($request->input('g-recaptcha-response'), $request->ip());
          //  ->setExpectedHostname('127.0.0.1')
            //->setExpectedAction('homepage')


       // if ($response->getScore()  < 0.5) {
       //     return redirect()->back()->withInput()->withErrors(['Você é considerado um Bot / Spammer!' . $response->getScore()]);
       // }

       // if ($response->isSuccess()) {
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
       // } else {
            //$errors = $response->getErrorCodes();
       //     return redirect()->back()->withInput()->withErrors(['Parece que você é um robô!']);
       // }
    }

    function logout(Request $request) {
       // Auth::logout();

        $this->guard->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('admin.login');
    }
}
