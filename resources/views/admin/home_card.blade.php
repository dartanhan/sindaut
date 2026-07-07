@extends('layouts.admin')

@section('title', 'Gerenciar Cards da Home')
@section('header_title', 'Cards da Home')
@section('header_subtitle', 'Gerencie os 3 cards da página inicial')

@section('header_actions')
@if(count($cards) < 3)
<a href="{{ route('home-card.create') }}" class="bg-blue-600 hover:bg-slate-900 text-white font-black px-8 py-3 rounded-2xl transition flex items-center gap-2 text-sm shadow-xl shadow-blue-600/20">
    <i data-lucide="plus" class="w-5 h-5"></i>
    CADASTRAR CARD
</a>
@else
<button disabled class="bg-slate-200 text-slate-400 font-black px-8 py-3 rounded-2xl flex items-center gap-2 text-sm cursor-not-allowed border border-slate-300" title="Limite máximo de 3 cards atingido">
    <i data-lucide="plus" class="w-5 h-5"></i>
    LIMITE DE 3 CARDS ATINGIDO
</button>
@endif
@endsection

@section('content')
<div class="space-y-8">
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-black text-lg text-slate-900 uppercase tracking-tight">Lista de Cards</h2>
            <span class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ count($cards) }} cadastrados</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest" style="width: 100px;">Imagem</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Título</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest" style="width: 100px;">Ordem</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-center" style="width: 150px;">Status</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-right" style="width: 150px;">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($cards as $card)
                        <tr class="hover:bg-slate-100/50 transition">
                            <td class="p-6">
                                @if($card->imagens && count($card->imagens) > 0 && !empty($card->imagens[0]->path))
                                    <img src="{{ asset('storage/posts/files/'.$card->imagens[0]->path) }}" class="w-16 h-12 object-cover rounded-lg shadow-sm">
                                @else
                                    <span class="text-xs font-bold text-slate-400">Sem imagem</span>
                                @endif
                            </td>
                            <td class="p-6">
                                <div class="text-sm font-bold text-slate-700">
                                    {{ $card->titulo }}
                                </div>
                            </td>
                            <td class="p-6 text-sm font-bold text-slate-500">
                                {{ $card->ordem }}
                            </td>
                            <td class="p-6 text-center">
                                <div class="flex justify-center">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input statusSwitch" type="checkbox" role="switch" 
                                               data-id="{{ $card->id }}" 
                                               data-rota="{{ route('home-card.atualizar-status') }}" 
                                               {{ $card->status == 1 ? 'checked' : '' }}
                                               style="width: 40px; height: 20px; cursor: pointer;">
                                    </div>
                                </div>
                            </td>
                            <td class="p-6">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('home-card.edit', $card->id) }}" class="w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-blue-600 hover:text-white hover:border-blue-600 transition shadow-sm">
                                        <i data-lucide="edit-3" class="w-5 h-5"></i>
                                    </a>
                                    <button type="button" 
                                             class="w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-rose-600 hover:text-white hover:border-rose-600 transition shadow-sm btn-excluir"
                                             data-rota="{{ route('home-card.destroy', $card->id) }}">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-slate-400 font-bold uppercase tracking-wider text-sm">
                                Nenhum card cadastrado no momento.
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
