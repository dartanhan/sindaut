<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\NoticiaController;

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
    Route::post('/logout',[AuthController::class,'logout'])->name('admin.logout');
    Route::get('/register', function () {
        return view('auth.register');
    })->name('admin.register');

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::post('/noticia/atualizar-status', [NoticiaController::class, 'atualizarStatus'])->name('atualizar-status');
    Route::resource('noticia',NoticiaController::class);
    Route::resource('upload',  UploadController::class);
    Route::post('/upload-imagem', [UploadController::class, 'store'])->name('uploadImagem');
    Route::post('/upload/tmp-upload', [UploadController::class, 'tmpUpload'])->name('tmpUpload');
    Route::delete('/upload/tmp-delete', [UploadController::class, 'tmpDelete'])->name('tmpDelete');
});
