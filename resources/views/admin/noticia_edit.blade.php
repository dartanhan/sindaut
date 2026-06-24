@extends('layouts.admin')

@section('title', 'Editar Notícia')
@section('header_title', 'Editar Notícia')
@section('header_subtitle', 'Atualize o conteúdo selecionado')

@section('header_actions')
<div class="flex gap-4">
    <a href="{{ route('noticia.index') }}" class="text-slate-400 hover:text-slate-900 font-bold px-6 py-3 transition text-sm flex items-center">CANCELAR</a>
    <button form="noticiaForm" type="submit" id="btnSubmit" class="bg-blue-600 hover:bg-slate-900 text-white font-black px-8 py-3 rounded-2xl transition shadow-xl shadow-blue-600/20 text-sm flex items-center gap-2">
        <span id="btnText">SALVAR ALTERAÇÕES</span>
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

    <form id="noticiaForm" action="{{ route('noticia.update', $noticia->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8 pb-20">
        @csrf
        @method('PUT')
        <input type="hidden" name="idImagemDestaque" id="idImagemDestaque" value="{{ old('idImagemDestaque', $noticia->imagem_id) }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Column: News Data -->
            <div class="space-y-6">
                <!-- Title -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Título da Notícia (Máximo 80 Caracteres)</label>
                    <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $noticia->titulo) }}" required maxlength="80" placeholder="Ex: Novo benefício disponível para associados" class="w-full bg-white border border-slate-200 rounded-2xl p-4 font-bold text-slate-900 focus:border-blue-600 focus:ring-0 transition">
                </div>
                
                <!-- Subtitle -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Subtítulo (Resumo - Máximo 250 Caracteres)</label>
                    <textarea id="subtitulo" name="subtitulo" rows="3" maxlength="250" placeholder="Breve resumo da notícia..." class="w-full bg-white border border-slate-200 rounded-2xl p-4 font-bold text-slate-900 focus:border-blue-600 focus:ring-0 transition">{{ old('subtitulo', $noticia->subtitulo) }}</textarea>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <!-- Status -->
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Status</label>
                        <select name="status" class="w-full bg-white border border-slate-200 rounded-2xl p-4 text-xs font-bold uppercase tracking-widest focus:border-blue-600 focus:ring-0 transition">
                            <option value="1" {{ old('status', $noticia->status) == '1' ? 'selected' : '' }}>Ativo / Publicado</option>
                            <option value="0" {{ old('status', $noticia->status) == '0' ? 'selected' : '' }}>Inativo / Rascunho</option>
                        </select>
                    </div>

                    <!-- Date -->
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Data de Cadastro</label>
                        @php
                            $rawCreated = $noticia->getRawOriginal('created_at');
                            $formattedDate = $rawCreated ? date('Y-m-d\TH:i', strtotime($rawCreated)) : '';
                        @endphp
                        <input type="datetime-local" name="data_cadastro" value="{{ old('data_cadastro', $formattedDate) }}" class="w-full bg-white border border-slate-200 rounded-2xl p-4 font-bold text-slate-900 focus:border-blue-600 focus:ring-0 transition">
                    </div>
                </div>


            </div>

            <!-- Right Column: Highlight Image Selector -->
            <div class="space-y-2 flex flex-col">
                <div class="flex justify-between items-center mb-1">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Imagem de Destaque</label>
                    <button type="button" id="btnOpenGallery" class="bg-amber-400 hover:bg-amber-500 text-slate-900 font-black text-[10px] uppercase tracking-widest px-4 py-2 rounded-xl transition flex items-center gap-1.5 shadow-sm">
                        <i data-lucide="image" class="w-3.5 h-3.5"></i>
                        Selecionar da Galeria
                    </button>
                </div>
                
                @php
                    $selectedImage = null;
                    $idDestaque = old('idImagemDestaque', $noticia->imagem_id);
                    if ($idDestaque) {
                        $selectedImage = $images->firstWhere('id', $idDestaque);
                    }
                @endphp
                
                <div id="imagePreviewContainer" 
                     class="relative h-full min-h-[300px] bg-white border-2 border-solid border-slate-200 rounded-[2.5rem] flex flex-col items-center justify-center p-8 text-center hover:border-blue-600 transition group cursor-pointer overflow-hidden bg-cover bg-center"
                     style="@if($selectedImage) background-image: url('{{ asset('storage/posts/files/'.$selectedImage->path) }}') @endif">
                    
                    <input type="file" name="image" id="imageInput" class="absolute inset-0 opacity-0 cursor-pointer z-20 w-full h-full" onchange="previewImage(event)">
                    
                    <div id="previewPlaceholder" class="space-y-3 group-hover:scale-110 transition relative z-10 @if($selectedImage) bg-white/80 p-6 rounded-2xl backdrop-blur-sm shadow-xl @endif">
                        <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-3xl flex items-center justify-center mx-auto shadow-sm">
                            <i data-lucide="upload-cloud" class="w-10 h-10"></i>
                        </div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Clique para selecionar do computador</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Conteúdo da Notícia</label>
            </div>
            <div class="bg-white rounded-[2.5rem] overflow-hidden border border-slate-200 shadow-sm">
                <textarea class="tinymce_editor" name="tinymce_editor" id="tinymce_editor">{{ old('tinymce_editor', $noticia->conteudo) }}</textarea>
            </div>
        </div>
    </form>
</div>

<!-- ================= MODALS ================= -->

<!-- Modal Selecionar Imagem Destaque -->
<div id="imagemModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-[2rem] shadow-2xl border border-slate-100 max-w-xl w-full max-h-[80vh] flex flex-col overflow-hidden">
        <div class="bg-blue-600 text-white px-8 py-6 flex justify-between items-center">
            <h5 class="font-black text-lg uppercase tracking-tight">Selecione a Imagem de Destaque</h5>
            <button type="button" class="text-blue-100 hover:text-white transition" onclick="$('#imagemModal').modal('hide')">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <div class="p-8 overflow-y-auto flex-1 bg-slate-50">
            <div class="grid grid-cols-3 gap-4 product-list-gallery">
                @foreach($images as $image)
                    <div class="group relative bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md hover:border-blue-600 transition cursor-pointer product-card-gallery">
                        <img src="{{ asset('storage/posts/files/'.$image->path) }}" data-id="{{ $image->id }}" class="w-full h-24 object-cover imagem-selecao" title="Selecionar para Capa">
                        <div class="absolute inset-0 bg-blue-600/10 opacity-0 group-hover:opacity-100 transition flex items-center justify-center pointer-events-none">
                            <span class="bg-blue-600 text-white text-[9px] font-black uppercase px-2 py-1 rounded">Selecionar</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-slate-100 border-t border-slate-200 px-8 py-4 flex justify-end">
            <button type="button" class="bg-slate-800 hover:bg-slate-900 text-white font-black text-xs uppercase tracking-widest px-6 py-3 rounded-xl transition" onclick="$('#imagemModal').modal('hide')">
                Fechar
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Adjust modal library shim
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
<script src="{{ asset('admin/assets/js/custom.js') }}"></script>
<script>
    // Form Submitting loader
    const noticiaForm = document.getElementById('noticiaForm');
    const btnSubmit = document.getElementById('btnSubmit');
    const btnText = document.getElementById('btnText');
    const btnLoader = document.getElementById('btnLoader');

    if (noticiaForm) {
        noticiaForm.addEventListener('submit', function() {
            btnSubmit.disabled = true;
            btnSubmit.classList.add('opacity-70', 'cursor-not-allowed');
            btnText.textContent = 'SALVANDO...';
            btnLoader.classList.remove('hidden');
        });
    }

    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            // Limpa o ID da galeria já que estamos subindo um arquivo local
            const idInput = document.getElementById('idImagemDestaque');
            if (idInput) {
                idInput.value = '';
            }
            
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('imagePreviewContainer');
                if (output) {
                    output.style.backgroundImage = `url('${reader.result}')`;
                    output.classList.remove('border-dashed');
                    const placeholder = document.getElementById('previewPlaceholder');
                    if (placeholder) {
                        placeholder.classList.add('bg-white/80', 'p-6', 'rounded-2xl', 'backdrop-blur-sm', 'shadow-xl');
                    }
                }
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
