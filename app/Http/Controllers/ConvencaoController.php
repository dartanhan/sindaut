<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ConvencaoController extends Controller
{
    public function index(){

        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();

            return view('admin.convencao',compact('user_data'));
        }
        return redirect()->route('admin.login');
    }
}
