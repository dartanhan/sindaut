@extends('layouts.admin')

@section('title', 'Nova Convenção Coletiva')
@section('header_title', 'Nova Convenção')
@section('header_subtitle', 'Cadastre um novo documento de Convenção Coletiva (CCT)')

@section('header_actions')
<div class="flex gap-4">
    <a href="{{ route('convencao.index') }}" class="text-slate-400 hover:text-slate-900 font-bold px-6 py-3 transition text-sm flex items-center">CANCELAR</a>
    <button form="convencaoForm" type="submit" id="btnSubmit" class="bg-blue-600 hover:bg-slate-900 text-white font-black px-8 py-3 rounded-2xl transition shadow-xl shadow-blue-600/20 text-sm flex items-center gap-2">
        <span id="btnText">SALVAR CONVENÇÃO</span>
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
<div class="max-w-5xl mx-auto">
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
        @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Erro de Validação!',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3b82f6',
                    borderRadius: '1.5rem',
                    customClass: {
                        popup: 'rounded-[2rem]',
                        confirmButton: 'rounded-xl px-6 py-3 font-black text-xs uppercase tracking-widest'
                    }
                });
            });
        </script>
        @endpush
    @endif

    <form id="convencaoForm" action="{{ route('convencao.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8 pb-20">
        @csrf
        <input type="hidden" name="convencao_descricao_id" value="{{ $convencaoDescricao->id ?? '' }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Column: CCT Data -->
            <div class="space-y-6">
                <!-- Title -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Título da CCT (Máximo 500 Caracteres)</label>
                    <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" required maxlength="500" placeholder="Ex: Convenção Coletiva de Trabalho Comércio 2023/2024" class="w-full bg-white border border-slate-200 rounded-2xl p-4 font-bold text-slate-900 focus:border-blue-600 focus:ring-0 transition">
                </div>
                
                <!-- Vigencia / Ano -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Vigência (Ex: 2023/2024)</label>
                    <input type="text" name="data_cct" id="data_cct" value="{{ old('data_cct') }}" required maxlength="10" placeholder="Ex: 2023/2024" class="w-full bg-white border border-slate-200 rounded-2xl p-4 font-bold text-slate-900 focus:border-blue-600 focus:ring-0 transition">
                </div>
                
                <!-- Status -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Status</label>
                    <select name="status" class="w-full bg-white border border-slate-200 rounded-2xl p-4 text-xs font-bold uppercase tracking-widest focus:border-blue-600 focus:ring-0 transition">
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Ativo / Publicado</option>
                        <option value="0" {{ old('status', '0') == '0' ? 'selected' : '' }}>Inativo / Rascunho</option>
                    </select>
                </div>
            </div>

            <!-- Right Column: PDF Upload -->
            <div class="space-y-2 flex flex-col justify-end">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Arquivo PDF da Convenção</label>
                
                <div id="fileUploadContainer" 
                     class="relative h-full min-h-[220px] bg-white border-2 border-dashed border-slate-200 rounded-[2.5rem] flex flex-col items-center justify-center p-8 text-center hover:border-blue-600 transition group cursor-pointer overflow-hidden">
                    
                    <input type="file" name="image" id="fileInput" accept="application/pdf" required class="absolute inset-0 opacity-0 cursor-pointer z-20 w-full h-full" onchange="previewFile(event)">
                    
                    <div id="uploadPlaceholder" class="space-y-3 group-hover:scale-105 transition relative z-10">
                        <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-3xl flex items-center justify-center mx-auto shadow-sm">
                            <i data-lucide="file-text" class="w-10 h-10 text-slate-400"></i>
                        </div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest" id="fileNamePlaceholder">Clique ou arraste para selecionar o PDF</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description Content Area (TinyMCE) -->
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Descrição da CCT (Geral para todas as CCTs)</label>
            </div>
            <div class="bg-white rounded-[2.5rem] overflow-hidden border border-slate-200 shadow-sm">
                <textarea class="tinymce_editor" name="descricao_cct" id="descricao_cct">{{ old('descricao_cct', $convencaoDescricao->descricao ?? '') }}</textarea>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const convencaoForm = document.getElementById('convencaoForm');
    const btnSubmit = document.getElementById('btnSubmit');
    const btnText = document.getElementById('btnText');
    const btnLoader = document.getElementById('btnLoader');

    if (convencaoForm) {
        convencaoForm.addEventListener('submit', function() {
            btnSubmit.disabled = true;
            btnSubmit.classList.add('opacity-70', 'cursor-not-allowed');
            btnText.textContent = 'PROCESSANDO...';
            btnLoader.classList.remove('hidden');
        });
    }

    function previewFile(event) {
        const file = event.target.files[0];
        const placeholder = document.getElementById('fileNamePlaceholder');
        const container = document.getElementById('fileUploadContainer');
        if (file) {
            placeholder.textContent = file.name + ' (' + (file.size/1024/1024).toFixed(2) + ' MB)';
            placeholder.classList.remove('text-slate-500');
            placeholder.classList.add('text-blue-600', 'font-black');
            container.classList.remove('border-dashed');
            container.classList.add('border-solid', 'border-blue-600', 'bg-blue-50/10');
        }
    }
</script>
@endpush
