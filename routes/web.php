<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UploadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/***
 * Site
 */
Route::get('/', function () {
    return view('site.home');
})->name('home');


/***
 * Login
*/
Route::get('/admin',[AuthController::class,'dashboard'])->name('admin');
Route::get('/admin/login', function () {
    return view('auth.login');
})->name('admin.login');
Route::post('/admin/login/do',[AuthController::class,'login'])->name('admin.login.do');

/**
 * Admin
*/
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'admin',config('jetstream.auth_session')], function(){
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('admin.register');

    Route::get('/noticia', function () {
        return view('admin.noticia');
    })->name('admin.noticia');

    Route::get('/galeria', function () {
        return view('admin.galeria');
    })->name('admin.galeria');

    Route::post('/logout',[AuthController::class,'logout'])->name('admin.logout');
    Route::post('/upload-imagem', [UploadController::class, 'uploadImagem'])->name('uploadImagem');
});
