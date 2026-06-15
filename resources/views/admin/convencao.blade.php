@extends('layouts.admin')

@section('title', 'Convenção Coletiva de Trabalho')
@section('header_title', 'Convenção Coletiva')
@section('header_subtitle', 'Gerencie as CCTs e descrições para os trabalhadores')

@section('header_actions')
<button type="button" class="bg-blue-600 hover:bg-slate-900 text-white font-black px-8 py-3 rounded-2xl transition flex items-center gap-2 text-sm shadow-xl shadow-blue-600/20"
        data-toggle="modal" data-target="#convencaoModal">
    <i data-lucide="plus" class="w-5 h-5"></i>
    CADASTRAR CONVENÇÃO
</button>
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
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Título</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-center">Ano/Vigência</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-center">Arquivo PDF</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Criado Em</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Atualizado Em</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($convencoes as $convencao)
                        @php
                            $filePath = '';
                            $fileId = '';
                            if (isset($convencao['files']) && count($convencao['files']) > 0) {
                                $filePath = $convencao['files'][0]->path;
                                $fileId = $convencao['files'][0]->id;
                            }
                        @endphp
                        <tr class="odd:bg-white even:bg-slate-50/40 hover:bg-slate-100/50 transition">
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
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input class="sr-only peer statusSwitch" 
                                           type="checkbox"
                                           data-id="{{ $convencao->id }}"
                                           data-rota="{{ route('convencao.status') }}"
                                           {{ $convencao->status == 0 ? '' : 'checked' }}>
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </td>
                            <td class="p-6">
                                <div class="flex items-center justify-end gap-3">
                                    <button type="button" 
                                            class="w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-blue-600 hover:text-white hover:border-blue-600 transition shadow-sm btn-editar-convencao"
                                            data-rota="{{ route('convencao.edit', $convencao->id) }}"
                                            data-rota-update="{{ route('convencao.update', $convencao->id) }}"
                                            data-file-id="{{ $fileId }}">
                                        <i data-lucide="edit-3" class="w-5 h-5"></i>
                                    </button>
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
                            <td colspan="7" class="p-12 text-center text-slate-400 font-bold uppercase tracking-wider text-sm">
                                Nenhuma Convenção cadastrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= MODALS ================= -->

<!-- Convenção Modal (Criar / Editar) -->
<div id="convencaoModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4 overflow-y-auto">
    <div class="bg-white rounded-[2rem] shadow-2xl border border-slate-100 max-w-4xl w-full max-h-[90vh] flex flex-col overflow-hidden">
        <form method="POST" action="{{ route('convencao.store') }}" name="uploadForm" id="uploadForm" enctype="multipart/form-data" class="flex flex-col h-full overflow-hidden">
            @csrf
            
            <!-- Header -->
            <div class="bg-slate-900 text-white px-8 py-6 flex justify-between items-center">
                <h5 class="font-black text-lg uppercase tracking-tight" id="modalTitle">Cadastrar Convenção Coletiva (CCT)</h5>
                <button type="button" class="text-slate-400 hover:text-white transition" onclick="$('#convencaoModal').modal('hide')">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <!-- Body -->
            <div class="p-8 overflow-y-auto space-y-6 flex-1 text-slate-700">
                <!-- Title Field -->
                <div class="space-y-2">
                    <label for="titulo" class="text-xs font-black uppercase text-slate-400 tracking-wider">Título da CCT</label>
                    <input type="text" name="titulo" id="titulo" required
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 outline-none focus:border-blue-600 focus:bg-white transition"
                           placeholder="Ex: Convenção Coletiva de Trabalho Comércio 2023/2024">
                </div>

                <!-- Date Field -->
                <div class="space-y-2">
                    <label for="data_cct" class="text-xs font-black uppercase text-slate-400 tracking-wider">Vigência (Ex: 2023/2024)</label>
                    <input type="text" name="data_cct" id="data_cct" maxlength="9" required
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 outline-none focus:border-blue-600 focus:bg-white transition"
                           placeholder="Ex: 2023/2024">
                </div>

                <!-- Description Field (TinyMCE) -->
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase text-slate-400 tracking-wider">Descrição da CCT (Opcional)</label>
                    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                        <textarea class="tinymce_editor" name="descricao_cct" id="descricao_cct"></textarea>
                    </div>
                </div>

                <!-- PDF File Upload Field -->
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase text-slate-400 tracking-wider font-bold">Arquivo PDF da Convenção</label>
                    <div class="border-2 border-dashed border-slate-200 rounded-3xl p-6 bg-slate-50">
                        <input type="file" name="image" id="image" class="filepond"/>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="bg-slate-50 border-t border-slate-100 px-8 py-6 flex justify-end gap-3">
                <button type="button" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-black text-xs uppercase tracking-widest px-6 py-4 rounded-2xl transition" 
                        onclick="$('#convencaoModal').modal('hide')">
                    Fechar
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-black text-xs uppercase tracking-widest px-8 py-4 rounded-2xl transition shadow-lg shadow-blue-600/20">
                    Salvar Convenção
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push("styles")
<link href="{{URL::asset('/admin/assets/filepond/dist/filepond.css')}}" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>
@endpush

@push("scripts")
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="{{URL::asset('/admin/assets/filepond/dist/filepond.js')}}"></script>
<script>
    // Shim to support Bootstrap Modal API via jQuery using Tailwind classes
    if (typeof jQuery !== 'undefined') {
        jQuery.fn.modal = function(action) {
            return this.each(function() {
                var $el = jQuery(this);
                if (action === 'show') {
                    // Remove hidden and show flex
                    jQuery('.fixed.inset-0.z-50').not($el).addClass('hidden').removeClass('flex');
                    $el.removeClass('hidden').addClass('flex');
                    jQuery('body').addClass('overflow-hidden');
                } else if (action === 'hide') {
                    $el.addClass('hidden').removeClass('flex');
                    if (jQuery('.fixed.inset-0.z-50:not(.hidden)').length === 0) {
                        jQuery('body').removeClass('overflow-hidden');
                    }
                }
            });
        };
    }

    // Modal Title customization
    document.addEventListener('DOMContentLoaded', function() {
        $('[data-target="#convencaoModal"]').on('click', function() {
            $('#modalTitle').text('Cadastrar Convenção Coletiva (CCT)');
            // Clear inputs
            $('#titulo').val('');
            $('#data_cct').val('');
            if (typeof tinymce !== 'undefined' && tinymce.get('descricao_cct')) {
                tinymce.get('descricao_cct').setContent('');
            }
            // Clear any previously appended hidden method overrides
            $('#uploadForm input[name="_method"]').remove();
            $('#uploadForm input[name="convencao-id"]').remove();
            $('#uploadForm input[name="convencao_descricao_id"]').remove();
            $('#uploadForm input[name="file_id"]').remove();
            $('#uploadForm').attr('action', "{{ route('convencao.store') }}");
        });
        $(document).on('click', '.btn-editar-convencao', function() {
            $('#modalTitle').text('Editar Convenção Coletiva (CCT)');
        });
    });
</script>
<script src="{{URL::asset('admin/assets/js/file-pond.js')}}"></script>
<script src="{{URL::asset('admin/assets/js/custom.js')}}"></script>
@endpush
