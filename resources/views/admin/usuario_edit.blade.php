@extends('layouts.admin')

@section('title', 'Editar Usuário')
@section('header_title', 'Editar Usuário')
@section('header_subtitle', 'Modifique os dados do usuário ou redefina a senha')

@section('header_actions')
<div class="flex gap-4">
    <a href="{{ route('usuario.index') }}" class="text-slate-400 hover:text-slate-900 font-bold px-6 py-3 transition text-sm flex items-center">CANCELAR</a>
    <button form="usuarioForm" type="submit" id="btnSubmit" class="bg-blue-600 hover:bg-slate-900 text-white font-black px-8 py-3 rounded-2xl transition shadow-xl shadow-blue-600/20 text-sm flex items-center gap-2">
        <span id="btnText">ATUALIZAR USUÁRIO</span>
        <div id="btnLoader" class="hidden">
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </button>
</div>
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    @if ($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-600 p-6 rounded-2xl mb-8 font-bold space-y-2">
            <div class="flex items-center gap-3">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                <span>Por favor, corrija os erros abaixo:</span>
            </div>
            <ul class="list-disc list-inside text-sm font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="usuarioForm" action="{{ route('usuario.update', $usuario->id) }}" method="POST" class="bg-white p-8 rounded-[2.5rem] border border-slate-200/80 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div class="space-y-2">
            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Nome Completo</label>
            <input type="text" name="name" value="{{ old('name', $usuario->name) }}" placeholder="Ex: João da Silva" 
                   class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 text-sm font-bold text-slate-700 placeholder-slate-400 focus:bg-white focus:border-blue-600 focus:ring-0 transition" required>
        </div>

        <!-- Email -->
        <div class="space-y-2">
            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">E-mail</label>
            <input type="email" name="email" value="{{ old('email', $usuario->email) }}" placeholder="Ex: joao@sindaut.org.br" 
                   class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 text-sm font-bold text-slate-700 placeholder-slate-400 focus:bg-white focus:border-blue-600 focus:ring-0 transition" required>
        </div>

        <div class="border-t border-slate-100 pt-6 mt-6">
            <h4 class="text-sm font-black text-slate-700 uppercase tracking-widest mb-2">Alterar Senha</h4>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-6">Deixe os campos abaixo em branco caso não queira alterar a senha atual do usuário.</p>
            
            <!-- Password Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Nova Senha</label>
                    <input type="password" name="password" placeholder="Mínimo 6 caracteres" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 text-sm font-bold text-slate-700 placeholder-slate-400 focus:bg-white focus:border-blue-600 focus:ring-0 transition">
                </div>
                
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Confirmar Nova Senha</label>
                    <input type="password" name="password_confirmation" placeholder="Repita a nova senha" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 text-sm font-bold text-slate-700 placeholder-slate-400 focus:bg-white focus:border-blue-600 focus:ring-0 transition">
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const usuarioForm = document.getElementById('usuarioForm');
    const btnSubmit = document.getElementById('btnSubmit');
    const btnText = document.getElementById('btnText');
    const btnLoader = document.getElementById('btnLoader');

    if (usuarioForm) {
        usuarioForm.addEventListener('submit', function() {
            btnSubmit.disabled = true;
            btnSubmit.classList.add('opacity-70', 'cursor-not-allowed');
            btnText.textContent = 'PROCESSANDO...';
            btnLoader.classList.remove('hidden');
        });
    }
</script>
@endpush
