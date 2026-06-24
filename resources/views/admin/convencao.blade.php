@extends('layouts.admin')

@section('title', 'Convenção Coletiva de Trabalho')
@section('header_title', 'Convenção Coletiva')
@section('header_subtitle', 'Gerencie as CCTs e descrições para os trabalhadores')

@section('header_actions')
<a href="{{ route('convencao.create') }}" class="bg-blue-600 hover:bg-slate-900 text-white font-black px-8 py-3 rounded-2xl transition flex items-center gap-2 text-sm shadow-xl shadow-blue-600/20">
    <i data-lucide="plus" class="w-5 h-5"></i>
    CADASTRAR CONVENÇÃO
</a>
@endsection

@section('content')
<div class="space-y-8">
    <!-- CCT Table Card -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-black text-lg text-slate-900 uppercase tracking-tight">CCTs Cadastradas</h2>
            <span class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ count($convencoes) }} registradas</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-center w-16">Ordem</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Título</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-center">Ano/Vigência</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-center">Arquivo PDF</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Criado Em</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Atualizado Em</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-right">Ações</th>
                    </tr>
                </thead>
                <tbody id="convencao-table-body" class="divide-y divide-slate-100">
                    @forelse($convencoes as $convencao)
                        @php
                            $filePath = '';
                            $fileId = '';
                            if (isset($convencao['files']) && count($convencao['files']) > 0) {
                                $filePath = $convencao['files'][0]->path;
                                $fileId = $convencao['files'][0]->id;
                            }
                        @endphp
                        <tr class="odd:bg-white even:bg-slate-50/40 hover:bg-slate-100/50 transition draggable-row" data-id="{{ $convencao->id }}">
                            <td class="p-6 text-center cursor-move drag-handle">
                                <i data-lucide="grip-vertical" class="w-5 h-5 text-slate-400 hover:text-slate-600 transition mx-auto"></i>
                            </td>
                            <td class="p-6">
                                <div class="font-black text-slate-900 text-sm uppercase leading-tight">{{ $convencao->titulo_cct }}</div>
                            </td>
                            <td class="p-6 text-center text-sm font-bold text-slate-500">{{ $convencao->data_cct }}</td>
                            <td class="p-6 text-center">
                                @if($filePath)
                                    <a href="{{ asset('storage/posts/files/'.$filePath) }}" target="_blank"
                                       class="inline-flex items-center justify-center w-10 h-10 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl transition"
                                       title="Visualizar PDF">
                                        <i data-lucide="file-text" class="w-5 h-5"></i>
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400 font-bold italic">Sem arquivo</span>
                                @endif
                            </td>
                            <td class="p-6 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {{ $convencao->created_at ?: '-' }}
                            </td>
                            <td class="p-6 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {{ $convencao->updated_at ?: '-' }}
                            </td>
                            <td class="p-6 text-center">
                                @if($convencao->status == 1)
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
                                    <a href="{{ route('convencao.edit', $convencao->id) }}" 
                                       class="w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-blue-600 hover:text-white hover:border-blue-600 transition shadow-sm">
                                        <i data-lucide="edit-3" class="w-5 h-5"></i>
                                    </a>
                                    <button type="button" 
                                            class="w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-rose-600 hover:text-white hover:border-rose-600 transition shadow-sm btn-excluir"
                                            data-rota="{{ route('convencao.destroy', $convencao->id) }}">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-12 text-center text-slate-400 font-bold uppercase tracking-wider text-sm">
                                Nenhuma Convenção cadastrada.
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
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var el = document.getElementById('convencao-table-body');
        if (el) {
            var sortable = Sortable.create(el, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'bg-blue-50/50',
                onEnd: function(evt) {
                    var order = [];
                    document.querySelectorAll('#convencao-table-body tr').forEach(function(tr, index) {
                        order.push({
                            id: tr.getAttribute('data-id'),
                            position: index + 1
                        });
                    });

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch("{{ route('convencao.reorder') }}", {
                        method: 'POST',
                        body: JSON.stringify({ order: order }),
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true
                            });
                            Toast.fire({
                                icon: 'success',
                                title: data.message
                            });
                        } else {
                            Swal.fire({
                                title: 'Erro!',
                                text: data.message,
                                icon: 'error'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Erro!',
                            text: 'Ocorreu um erro ao reordenar.',
                            icon: 'error'
                        });
                    });
                }
            });
        }
    });
</script>
<script src="{{URL::asset('admin/assets/js/custom.js')}}"></script>
@endpush
