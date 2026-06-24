@extends('layouts.admin')

@section('title', 'Novo Conteúdo Jurídico')
@section('header_title', 'Novo Conteúdo Jurídico')
@section('header_subtitle', 'Crie um novo conteúdo ou orientação para o departamento jurídico')

@section('header_actions')
<div class="flex gap-4">
    <a href="{{ route('depjuridico.index') }}" class="text-slate-400 hover:text-slate-900 font-bold px-6 py-3 transition text-sm flex items-center">CANCELAR</a>
    <button form="depjuridicoForm" type="submit" id="btnSubmit" class="bg-blue-600 hover:bg-slate-900 text-white font-black px-8 py-3 rounded-2xl transition shadow-xl shadow-blue-600/20 text-sm flex items-center gap-2">
        <span id="btnText">SALVAR CONTEÚDO</span>
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
    @endif

    <form id="depjuridicoForm" action="{{ route('depjuridico.store') }}" method="POST" class="space-y-8 pb-20">
        @csrf

        <!-- Status -->
        <div class="space-y-2 max-w-xs">
            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Status</label>
            <select name="status" class="w-full bg-white border border-slate-200 rounded-2xl p-4 text-xs font-bold uppercase tracking-widest focus:border-blue-600 focus:ring-0 transition">
                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Ativo / Publicado</option>
                <option value="0" {{ old('status', '0') == '0' ? 'selected' : '' }}>Inativo / Rascunho</option>
            </select>
        </div>

        <!-- Content Area -->
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Documentos Necessários / Orientação</label>
            </div>
            <div class="bg-white rounded-[2.5rem] overflow-hidden border border-slate-200 shadow-sm">
                <textarea class="tinymce_editor" name="tinymce_editor" id="tinymce_editor">{{ old('tinymce_editor') }}</textarea>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const depjuridicoForm = document.getElementById('depjuridicoForm');
    const btnSubmit = document.getElementById('btnSubmit');
    const btnText = document.getElementById('btnText');
    const btnLoader = document.getElementById('btnLoader');

    if (depjuridicoForm) {
        depjuridicoForm.addEventListener('submit', function() {
            btnSubmit.disabled = true;
            btnSubmit.classList.add('opacity-70', 'cursor-not-allowed');
            btnText.textContent = 'PROCESSANDO...';
            btnLoader.classList.remove('hidden');
        });
    }
</script>
@endpush
