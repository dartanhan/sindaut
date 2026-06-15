@extends('layouts.admin')

@section('title', 'Departamento Jurídico')
@section('header_title', 'Dep. Jurídico')
@section('header_subtitle', 'Gerencie as orientações e documentos do departamento jurídico')

@section('header_actions')
@if(empty($depjuridico))
<button type="button" class="bg-blue-600 hover:bg-slate-900 text-white font-black px-8 py-3 rounded-2xl transition flex items-center gap-2 text-sm shadow-xl shadow-blue-600/20"
        data-toggle="modal" data-target="#exampleModal">
    <i data-lucide="plus" class="w-5 h-5"></i>
    CADASTRAR CONTEÚDO
</button>
@endif
@endsection

@section('content')
<div class="space-y-8">
    <!-- Dep Juridico Table Card -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-black text-lg text-slate-900 uppercase tracking-tight">Status e Ações</h2>
            <span class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ empty($depjuridico) ? 'Nenhum' : '1' }} cadastrado</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Resumo do Conteúdo</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Criado Em</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Atualizado Em</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @if(!empty($depjuridico))
                        <tr class="hover:bg-slate-100/50 transition">
                            <td class="p-6">
                                <div class="text-sm font-bold text-slate-700 max-w-md truncate">
                                    {{ strip_tags($depjuridico->conteudo) }}
                                </div>
                            </td>
                            <td class="p-6 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {{ $depjuridico->created_at ?: '-' }}
                            </td>
                            <td class="p-6 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {{ $depjuridico->updated_at ?: '-' }}
                            </td>
                            <td class="p-6 text-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input class="sr-only peer statusSwitch" 
                                           type="checkbox"
                                           data-id="{{ $depjuridico->id }}"
                                           data-rota="{{ route('depjuridico.status') }}"
                                           {{ $depjuridico->status == 0 ? '' : 'checked' }}>
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </td>
                            <td class="p-6">
                                <div class="flex items-center justify-end gap-3">
                                    <button type="button" class="w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-emerald-600 hover:text-white hover:border-emerald-600 transition shadow-sm"
                                            data-toggle="modal" data-target="#modalConteudo">
                                        <i data-lucide="eye" class="w-5 h-5"></i>
                                    </button>
                                    <button type="button" class="w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-blue-600 hover:text-white hover:border-blue-600 transition shadow-sm"
                                            data-toggle="modal" data-target="#editModal">
                                        <i data-lucide="edit-3" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="5" class="p-12 text-center text-slate-400 font-bold uppercase tracking-wider text-sm">
                                Nenhum conteúdo cadastrado no momento.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= MODALS ================= -->

@if(empty($depjuridico))
<!-- Create Modal -->
<div id="exampleModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4 overflow-y-auto">
    <div class="bg-white rounded-[2rem] shadow-2xl border border-slate-100 max-w-4xl w-full max-h-[90vh] flex flex-col overflow-hidden">
        <form method="POST" action="{{ route('depjuridico.store') }}" name="uploadForm" id="uploadForm" class="flex flex-col h-full overflow-hidden">
            @csrf
            <!-- Header -->
            <div class="bg-slate-900 text-white px-8 py-6 flex justify-between items-center">
                <h5 class="font-black text-lg uppercase tracking-tight">Cadastrar Conteúdo Jurídico</h5>
                <button type="button" class="text-slate-400 hover:text-white transition" onclick="$('#exampleModal').modal('hide')">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <!-- Body -->
            <div class="p-8 overflow-y-auto space-y-6 flex-1 text-slate-700">
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase text-slate-400 tracking-wider">Documentos Necessários / Orientação</label>
                    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                        <textarea class="tinymce_editor" name="tinymce_editor" id="tinymce_editor"></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="bg-slate-50 border-t border-slate-100 px-8 py-6 flex justify-end gap-3">
                <button type="button" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-black text-xs uppercase tracking-widest px-6 py-4 rounded-2xl transition" 
                        onclick="$('#exampleModal').modal('hide')">
                    Fechar
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-black text-xs uppercase tracking-widest px-8 py-4 rounded-2xl transition shadow-lg shadow-blue-600/20">
                    Salvar Conteúdo
                </button>
            </div>
        </form>
    </div>
</div>
@endif

@if(!empty($depjuridico))
<!-- View Modal -->
<div id="modalConteudo" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-[2rem] shadow-2xl border border-slate-100 max-w-3xl w-full max-h-[85vh] flex flex-col overflow-hidden">
        <!-- Header -->
        <div class="bg-slate-900 text-white px-8 py-6 flex justify-between items-center">
            <h5 class="font-black text-lg uppercase tracking-tight">Visualizar Conteúdo Jurídico</h5>
            <button type="button" class="text-slate-400 hover:text-white transition" onclick="$('#modalConteudo').modal('hide')">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        
        <!-- Body -->
        <div class="p-8 overflow-y-auto flex-1 bg-white text-slate-800 leading-relaxed modal-conteudo">
            {!! $depjuridico->conteudo !!}
        </div>
        
        <!-- Footer -->
        <div class="bg-slate-50 border-t border-slate-100 px-8 py-4 flex justify-end">
            <button type="button" class="bg-slate-850 hover:bg-slate-900 text-white font-black text-xs uppercase tracking-widest px-6 py-3 rounded-xl transition" onclick="$('#modalConteudo').modal('hide')">
                Fechar
            </button>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4 overflow-y-auto">
    <div class="bg-white rounded-[2rem] shadow-2xl border border-slate-100 max-w-4xl w-full max-h-[90vh] flex flex-col overflow-hidden">
        <form method="POST" action="{{ route('depjuridico.update', $depjuridico->id) }}" name="uploadForm" id="uploadForm" class="flex flex-col h-full overflow-hidden">
            @csrf
            @method('put')
            <!-- Header -->
            <div class="bg-slate-900 text-white px-8 py-6 flex justify-between items-center">
                <h5 class="font-black text-lg uppercase tracking-tight">Editar Conteúdo Jurídico</h5>
                <button type="button" class="text-slate-400 hover:text-white transition" onclick="$('#editModal').modal('hide')">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <!-- Body -->
            <div class="p-8 overflow-y-auto space-y-6 flex-1 text-slate-700">
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase text-slate-400 tracking-wider">Documentos Necessários / Orientação</label>
                    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                        <textarea class="tinymce_editor" name="tinymce_editor" id="tinymce_editor">{!! $depjuridico->conteudo !!}</textarea>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="bg-slate-50 border-t border-slate-100 px-8 py-6 flex justify-end gap-3">
                <button type="button" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-black text-xs uppercase tracking-widest px-6 py-4 rounded-2xl transition" 
                        onclick="$('#editModal').modal('hide')">
                    Fechar
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-black text-xs uppercase tracking-widest px-8 py-4 rounded-2xl transition shadow-lg shadow-blue-600/20">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>
@endif

@endsection

@push("scripts")
<script>
    // Shim to support Bootstrap Modal API via jQuery using Tailwind classes
    if (typeof jQuery !== 'undefined') {
        jQuery.fn.modal = function(action) {
            return this.each(function() {
                var $el = jQuery(this);
                if (action === 'show') {
                    // Close others
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
</script>
<script src="{{URL::asset('admin/assets/js/custom.js')}}"></script>
@endpush
