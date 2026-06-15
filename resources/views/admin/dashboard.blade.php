@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header_title', 'Dashboard')
@section('header_subtitle', 'Bem-vindo ao painel de controle')

@section('content')
<div class="space-y-12">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-[2rem] p-8 lg:p-12 text-white shadow-xl relative overflow-hidden">
        <div class="relative z-10 max-w-2xl space-y-4">
            <span class="bg-blue-500/30 text-blue-100 text-xs font-black uppercase tracking-widest px-4 py-2 rounded-full backdrop-blur-sm">Painel do Administrador</span>
            <h2 class="text-3xl lg:text-4xl font-black tracking-tight">Olá, {{ auth()->user()->name }}!</h2>
            <p class="text-blue-100/80 font-medium leading-relaxed">
                Bem-vindo ao novo painel de administração do SINDAUT. Este espaço foi projetado para ser intuitivo, rápido e seguro, permitindo o gerenciamento eficiente de notícias, convenções, benefícios e conteúdo do portal.
            </p>
        </div>
        <!-- Abstract shape decoration -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 space-y-4 transition hover:shadow-md">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                <i data-lucide="newspaper" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-4xl font-black text-slate-900">{{ $noticiasAtivas }}</p>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Notícias Ativas</p>
            </div>
        </div>
        
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 space-y-4 transition hover:shadow-md">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                <i data-lucide="file-signature" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-4xl font-black text-slate-900">{{ $totalConvencoes }}</p>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Convenções Coletivas</p>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 space-y-4 transition hover:shadow-md">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-4xl font-black text-slate-900">{{ $totalUsuarios }}</p>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Usuários do Painel</p>
            </div>
        </div>
    </div>

    <!-- Quick Shortcuts Card -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-100">
            <h2 class="font-black text-lg text-slate-900 uppercase tracking-tight">Atalhos Rápidos</h2>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1">Acesso rápido aos principais recursos do portal</p>
        </div>
        <div class="p-8 lg:p-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <a href="{{ route('noticia.index') }}" class="group p-6 rounded-3xl border-2 border-dashed border-slate-200 hover:border-blue-600 hover:bg-blue-50 transition flex flex-col items-center justify-center gap-4 text-center">
                <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center group-hover:scale-110 transition">
                    <i data-lucide="plus" class="w-7 h-7"></i>
                </div>
                <span class="font-black text-slate-900 text-sm">Postar Notícia</span>
            </a>
            
            <a href="{{ route('upload.index') }}" class="group p-6 rounded-3xl border-2 border-dashed border-slate-200 hover:border-emerald-600 hover:bg-emerald-50 transition flex flex-col items-center justify-center gap-4 text-center">
                <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center group-hover:scale-110 transition">
                    <i data-lucide="image" class="w-7 h-7"></i>
                </div>
                <span class="font-black text-slate-900 text-sm">Galeria de Imagens</span>
            </a>

            <a href="{{ route('convencao.index') }}" class="group p-6 rounded-3xl border-2 border-dashed border-slate-200 hover:border-amber-600 hover:bg-amber-50 transition flex flex-col items-center justify-center gap-4 text-center">
                <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center group-hover:scale-110 transition">
                    <i data-lucide="file-signature" class="w-7 h-7"></i>
                </div>
                <span class="font-black text-slate-900 text-sm">Convenções</span>
            </a>

            <a href="{{ route('admin.register') }}" class="group p-6 rounded-3xl border-2 border-dashed border-slate-200 hover:border-purple-600 hover:bg-purple-50 transition flex flex-col items-center justify-center gap-4 text-center">
                <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center group-hover:scale-110 transition">
                    <i data-lucide="user-plus" class="w-7 h-7"></i>
                </div>
                <span class="font-black text-slate-900 text-sm">Registrar Usuário</span>
            </a>
        </div>
    </div>
</div>
@endsection
