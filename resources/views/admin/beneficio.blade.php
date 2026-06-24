@extends('layouts.admin')

@section('title', 'Gerenciar Benefícios')
@section('header_title', 'Benefícios')
@section('header_subtitle', 'Gerencie as informações de benefícios dos associados')

@section('header_actions')
<a href="{{ route('beneficio.create') }}" class="bg-blue-600 hover:bg-slate-900 text-white font-black px-8 py-3 rounded-2xl transition flex items-center gap-2 text-sm shadow-xl shadow-blue-600/20">
    <i data-lucide="plus" class="w-5 h-5"></i>
    CADASTRAR BENEFÍCIOS
</a>
@endsection

@section('content')
<div class="space-y-8">
    <!-- Beneficio Table Card -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-black text-lg text-slate-900 uppercase tracking-tight">Status e Ações</h2>
            <span class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ count($beneficios) }} cadastrados</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Criado Em</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Atualizado Em</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($beneficios as $beneficio)
                        <tr class="hover:bg-slate-100/50 transition">
                            <td class="p-6 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {{ $beneficio->created_at ?: '-' }}
                            </td>
                            <td class="p-6 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {{ $beneficio->updated_at ?: '-' }}
                            </td>
                            <td class="p-6 text-center">
                                @if($beneficio->status == 1)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                                        Publicado
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-slate-100 text-slate-800 uppercase tracking-wider">
                                        Rascunho
                                    </span>
                                @endif
                            </td>
                            <td class="p-6">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('beneficio.edit', $beneficio->id) }}" class="w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-blue-600 hover:text-white hover:border-blue-600 transition shadow-sm">
                                        <i data-lucide="edit-3" class="w-5 h-5"></i>
                                    </a>
                                    <button type="button" 
                                            class="w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-rose-600 hover:text-white hover:border-rose-600 transition shadow-sm btn-excluir"
                                            data-rota="{{ route('beneficio.destroy', $beneficio->id) }}">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-12 text-center text-slate-400 font-bold uppercase tracking-wider text-sm">
                                Nenhum benefício cadastrado no momento.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push("scripts")
<script src="{{URL::asset('admin/assets/js/custom.js')}}"></script>
@endpush
