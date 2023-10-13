<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\SiteController;
use App\Http\Livewire\PostManager;
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
//Route::get('/', function () {
//    return view('site.home');
//})->name('home');

Route::get('/',[SiteController::class,'index'])->name('site.home');
Route::get('/contato',[SiteController::class,'contato'])->name('site.contato');
Route::post('/enviaContato',[SiteController::class,'enviaContato'])->name('site.enviaContato');
Route::get('/detalhe-noticia/{id}',[SiteController::class,'detalheNoticia'])->name('site.detalhe-noticia');

/***
 * Login
*/
Route::get('/admin',[AuthController::class,'dashboard'])->name('admin');
Route::get('/admin/login',[AuthController::class,'showLoginForm'])->name('admin.login');
Route::post('/admin/login/do',[AuthController::class,'login'])->name('admin.login.do');

Route::get('/post', PostManager::class)->name('admin.post');
/**
 * Admin
*/
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'admin',config('jetstream.auth_session')], function(){
    Route::get('/logout',[AuthController::class,'logout'])->name('admin.logout');
    Route::get('/dashboard',[AuthController::class,'dashboard'])->name('admin.dashboard');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('admin.register');


    Route::post('/noticia/atualizar-status', [NoticiaController::class, 'atualizarStatus'])->name('atualizar-status');
    Route::post('/noticia/atualizar-destaque', [NoticiaController::class, 'atualizarDestaque'])->name('atualizar-destaque');

    Route::resource('noticia',NoticiaController::class);
    Route::resource('upload',  UploadController::class);
    Route::post('/upload-imagem', [UploadController::class, 'store'])->name('uploadImagem');
    Route::post('/upload/tmp-upload', [UploadController::class, 'tmpUpload'])->name('tmpUpload');
    Route::delete('/upload/tmp-delete', [UploadController::class, 'tmpDelete'])->name('tmpDelete');
});
