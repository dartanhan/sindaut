@extends('layouts.admin')

@section('title', 'História do Sindicato')
@section('header_title', 'História')
@section('header_subtitle', 'Gerencie a página institucional de história e fundação do sindicato')

@section('header_actions')
@if(empty($historia))
<button type="button" class="bg-blue-600 hover:bg-slate-900 text-white font-black px-8 py-3 rounded-2xl transition flex items-center gap-2 text-sm shadow-xl shadow-blue-600/20"
        data-toggle="modal" data-target="#exampleModal">
    <i data-lucide="plus" class="w-5 h-5"></i>
    CADASTRAR HISTÓRIA
</button>
@else
<button type="button" class="bg-blue-600 hover:bg-slate-900 text-white font-black px-8 py-3 rounded-2xl transition flex items-center gap-2 text-sm shadow-xl shadow-blue-600/20"
        data-toggle="modal" data-target="#editModal">
    <i data-lucide="edit-3" class="w-5 h-5"></i>
    EDITAR HISTÓRIA
</button>
@endif
@endsection

@section('content')
<div class="space-y-8">
    <!-- Historia Preview Card -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8 space-y-8">
        <div class="flex items-center justify-between border-b border-slate-100 pb-6">
            <h2 class="font-black text-lg text-slate-900 uppercase tracking-tight">História Cadastrada</h2>
            <span class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ empty($historia) ? 'Sem registro' : 'Publicado' }}</span>
        </div>

        @if(!empty($historia))
            <div class="prose prose-slate max-w-none text-slate-800 leading-relaxed bg-slate-50 rounded-3xl p-8 border border-slate-100">
                {!! $historia->conteudo !!}
            </div>
        @else
            <div class="py-16 text-center text-slate-400 font-bold uppercase tracking-wider text-sm bg-slate-50 rounded-3xl border border-slate-100">
                Nenhum texto de história cadastrado no momento.
            </div>
        @endif
    </div>
</div>

<!-- ================= MODALS ================= -->

@if(empty($historia))
<!-- Create Modal -->
<div id="exampleModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4 overflow-y-auto">
    <div class="bg-white rounded-[2rem] shadow-2xl border border-slate-100 max-w-4xl w-full max-h-[90vh] flex flex-col overflow-hidden">
        <form method="POST" action="{{ route('historia.store') }}" name="uploadForm" id="uploadForm" class="flex flex-col h-full overflow-hidden">
            @csrf
            <!-- Header -->
            <div class="bg-slate-900 text-white px-8 py-6 flex justify-between items-center">
                <h5 class="font-black text-lg uppercase tracking-tight">Cadastrar História</h5>
                <button type="button" class="text-slate-400 hover:text-white transition" onclick="$('#exampleModal').modal('hide')">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <!-- Body -->
            <div class="p-8 overflow-y-auto space-y-6 flex-1 text-slate-700">
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase text-slate-400 tracking-wider font-bold">Conteúdo da História</label>
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
                    Salvar História
                </button>
            </div>
        </form>
    </div>
</div>
@endif

@if(!empty($historia))
<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4 overflow-y-auto">
    <div class="bg-white rounded-[2rem] shadow-2xl border border-slate-100 max-w-4xl w-full max-h-[90vh] flex flex-col overflow-hidden">
        <form method="POST" action="{{ route('historia.update', $historia->id) }}" name="uploadForm" id="uploadForm" class="flex flex-col h-full overflow-hidden">
            @csrf
            @method('put')
            <!-- Header -->
            <div class="bg-slate-900 text-white px-8 py-6 flex justify-between items-center">
                <h5 class="font-black text-lg uppercase tracking-tight">Editar História</h5>
                <button type="button" class="text-slate-400 hover:text-white transition" onclick="$('#editModal').modal('hide')">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <!-- Body -->
            <div class="p-8 overflow-y-auto space-y-6 flex-1 text-slate-700">
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase text-slate-400 tracking-wider font-bold">Conteúdo da História</label>
                    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                        <textarea class="tinymce_editor" name="tinymce_editor" id="tinymce_editor">{!! $historia->conteudo !!}</textarea>
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
@endpush
