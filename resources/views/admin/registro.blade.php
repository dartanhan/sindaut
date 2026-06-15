@extends('layouts.admin')

@section('title', 'Usuários do Painel')
@section('header_title', 'Usuários')
@section('header_subtitle', 'Gerencie as credenciais do painel administrativo')

@section('header_actions')
<button type="button" class="bg-blue-600 hover:bg-slate-900 text-white font-black px-8 py-3 rounded-2xl transition flex items-center gap-2 text-sm shadow-xl shadow-blue-600/20"
        data-toggle="modal" data-target="#exampleModal">
    <i data-lucide="user-plus" class="w-5 h-5"></i>
    REGISTRAR USUÁRIO
</button>
@endsection

@section('content')
<div class="space-y-8">
    <!-- Users Table Card -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-black text-lg text-slate-900 uppercase tracking-tight">Lista de Usuários</h2>
            <span class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ count($usuarios) }} cadastrados</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-center">#</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Nome</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">E-mail</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Criado Em</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Atualizado Em</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($usuarios as $usuario)
                        <tr class="odd:bg-white even:bg-slate-50/40 hover:bg-slate-100/50 transition">
                            <td class="p-6 text-center text-sm font-bold text-slate-500">{{ $usuario->id }}</td>
                            <td class="p-6">
                                <div class="font-black text-slate-900 text-sm uppercase leading-tight">{{ $usuario->name }}</div>
                            </td>
                            <td class="p-6">
                                <div class="text-xs font-bold text-slate-500 italic">{{ $usuario->email }}</div>
                            </td>
                            <td class="p-6 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                {{ $usuario->created_at ?: '-' }}
                            </td>
                            <td class="p-6 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                {{ $usuario->updated_at ?: '-' }}
                            </td>
                            <td class="p-6">
                                <div class="flex items-center justify-end gap-3 opacity-40 cursor-not-allowed" title="Ações indisponíveis">
                                    <button type="button" class="w-10 h-10 bg-white border border-slate-100 text-slate-300 rounded-xl flex items-center justify-center pointer-events-none">
                                        <i data-lucide="edit-3" class="w-5 h-5"></i>
                                    </button>
                                    <button type="button" class="w-10 h-10 bg-white border border-slate-100 text-slate-300 rounded-xl flex items-center justify-center pointer-events-none">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= MODALS ================= -->

<!-- Register Modal -->
<div id="exampleModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-[2rem] shadow-2xl border border-slate-100 max-w-lg w-full max-h-[85vh] flex flex-col overflow-hidden">
        <form method="POST" action="{{ route('admin.store') }}" name="register" id="register">
            @csrf
            <!-- Header -->
            <div class="bg-slate-900 text-white px-8 py-6 flex justify-between items-center">
                <h5 class="font-black text-lg uppercase tracking-tight">Registrar Novo Administrador</h5>
                <button type="button" class="text-slate-400 hover:text-white transition" onclick="$('#exampleModal').modal('hide')">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <!-- Body -->
            <div class="p-8 space-y-6 overflow-y-auto flex-1 text-slate-700">
                <!-- Name Field -->
                <div class="space-y-2">
                    <label for="name" class="text-xs font-black uppercase text-slate-400 tracking-wider">Nome Completo</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 outline-none focus:border-blue-600 focus:bg-white transition"
                           placeholder="Ex: João da Silva">
                </div>

                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="text-xs font-black uppercase text-slate-400 tracking-wider">Endereço de E-mail</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 outline-none focus:border-blue-600 focus:bg-white transition"
                           placeholder="Ex: joao@sindaut.org.br">
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <label for="password" class="text-xs font-black uppercase text-slate-400 tracking-wider">Senha (Mínimo 8 Caracteres)</label>
                    <input id="password" type="password" name="password" required
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 outline-none focus:border-blue-600 focus:bg-white transition"
                           placeholder="••••••••">
                </div>

                <!-- Confirm Password Field -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="text-xs font-black uppercase text-slate-400 tracking-wider">Confirme a Senha</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 outline-none focus:border-blue-600 focus:bg-white transition"
                           placeholder="••••••••">
                </div>
            </div>
            
            <!-- Footer -->
            <div class="bg-slate-50 border-t border-slate-100 px-8 py-6 flex justify-end gap-3">
                <button type="button" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-black text-xs uppercase tracking-widest px-6 py-4 rounded-2xl transition" 
                        onclick="$('#exampleModal').modal('hide')">
                    Fechar
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-black text-xs uppercase tracking-widest px-8 py-4 rounded-2xl transition shadow-lg shadow-blue-600/20">
                    Salvar Usuário
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push("scripts")
<script>
    // Shim to support Bootstrap Modal API via jQuery using Tailwind classes
    if (typeof jQuery !== 'undefined') {
        jQuery.fn.modal = function(action) {
            return this.each(function() {
                var $el = jQuery(this);
                if (action === 'show') {
                    $el.removeClass('hidden').addClass('flex');
                    jQuery('body').addClass('overflow-hidden');
                } else if (action === 'hide') {
                    $el.addClass('hidden').removeClass('flex');
                    jQuery('body').removeClass('overflow-hidden');
                }
            });
        };
    }
</script>
@endpush
