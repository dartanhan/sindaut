@extends('layouts.admin')

@section('title', 'Gerenciar Notícias')
@section('header_title', 'Notícias')
@section('header_subtitle', 'Gerencie as postagens e slider principal')

@section('header_actions')
<button type="button" class="bg-blue-600 hover:bg-slate-900 text-white font-black px-8 py-3 rounded-2xl transition flex items-center gap-2 text-sm shadow-xl shadow-blue-600/20 btnModal"
        data-toggle="modal" data-target="#modalNoticia" data-rota="{{route('noticia.store')}}">
    <i data-lucide="plus" class="w-5 h-5"></i>
    CRIAR NOTÍCIA
</button>
@endsection

@section('content')
<div class="space-y-8">
    <!-- News Table Card -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-black text-lg text-slate-900 uppercase tracking-tight">Lista de Notícias</h2>
            <span class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ count($noticias) }} registradas</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest text-center w-16">#</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Notícia</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest text-center w-24">Conteúdo</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest text-center w-28">Status</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest text-center w-28">Destaque</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest w-40">Criado Em</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest text-right w-36">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($noticias as $noticia)
                        @php
                            $imgPath = null;
                            if (isset($noticia->imagens) && count($noticia->imagens) > 0) {
                                $imgPath = $noticia->imagens[0]->path;
                            }
                        @endphp
                        <tr class="odd:bg-white even:bg-slate-50/40 hover:bg-slate-100/50 transition">
                            <td class="px-6 py-4 text-center text-sm font-bold text-slate-500">{{ $noticia->id }}</td>
                            <td class="px-6 py-4">
                                <div class="font-black text-slate-900 text-sm max-w-xs sm:max-w-md truncate uppercase leading-tight" title="{{ $noticia->titulo }}">
                                    {{ $noticia->titulo }}
                                </div>
                                @if($noticia->subtitulo)
                                    <div class="text-[10px] font-bold text-slate-400 mt-1 max-w-xs sm:max-w-md truncate italic" title="{{ $noticia->subtitulo }}">
                                        {{ $noticia->subtitulo }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="#" class="ler-mais inline-flex items-center justify-center w-9 h-9 bg-slate-50 hover:bg-blue-50 text-slate-400 hover:text-blue-600 rounded-xl transition"
                                   data-toggle="modal"
                                   data-target="#modalConteudoNoticia"
                                   data-conteudo="{{ $noticia->conteudo }}"
                                   data-img-destaque="{{ $imgPath ? asset('storage/posts/files/'.$imgPath) : '' }}">
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </a>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input class="sr-only peer statusSwitch" 
                                           type="checkbox"
                                           data-id="{{ $noticia->id }}"
                                           data-rota="{{ route('atualizar-status') }}"
                                           {{ $noticia->status == 0 ? '' : 'checked' }}>
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input class="sr-only peer destaqueSwitch" 
                                           type="checkbox"
                                           data-id="{{ $noticia->id }}"
                                           data-rota="{{ route('atualizar-destaque') }}"
                                           {{ $noticia->destaque == 0 ? '' : 'checked' }}>
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                                </label>
                            </td>
                            <td class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {{ $noticia->created_at ?: '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-3">
                                    <button type="button" 
                                            class="w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-blue-600 hover:text-white hover:border-blue-600 transition shadow-sm btn-editar"
                                            data-rota="{{ route('noticia.edit', $noticia->id) }}"
                                            data-rota-update="{{ route('noticia.update', $noticia->id) }}">
                                        <i data-lucide="edit-3" class="w-5 h-5"></i>
                                    </button>
                                    <button type="button" 
                                            class="w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-rose-600 hover:text-white hover:border-rose-600 transition shadow-sm btn-excluir"
                                            data-rota="{{ route('noticia.destroy', $noticia->id) }}">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-slate-400 font-bold uppercase tracking-wider text-sm">
                                Nenhuma notícia cadastrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($noticias->hasPages())
            <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                    Exibindo {{ $noticias->firstItem() }} até {{ $noticias->lastItem() }} de {{ $noticias->total() }} notícias
                </div>
                <div class="flex items-center gap-2 flex-wrap justify-center">
                    {{-- Previous Page Link --}}
                    @if($noticias->onFirstPage())
                        <span class="px-4 py-2 bg-slate-100 text-slate-400 rounded-xl text-xs font-black cursor-not-allowed uppercase tracking-widest border border-slate-200/50">
                            Anterior
                        </span>
                    @else
                        <a href="{{ $noticias->previousPageUrl() }}" class="px-4 py-2 bg-white hover:bg-blue-600 hover:text-white text-slate-700 rounded-xl text-xs font-black transition shadow-sm border border-slate-200 uppercase tracking-widest">
                            Anterior
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    @php
                        $start = max($noticias->currentPage() - 2, 1);
                        $end = min($start + 4, $noticias->lastPage());
                        if ($end - $start < 4) {
                            $start = max($end - 4, 1);
                        }
                    @endphp

                    @if($start > 1)
                        <a href="{{ $noticias->url(1) }}" class="w-10 h-10 bg-white hover:bg-slate-100 text-slate-700 rounded-xl flex items-center justify-center text-xs font-black transition border border-slate-200">1</a>
                        @if($start > 2)
                            <span class="text-slate-400 text-xs px-1 font-bold">...</span>
                        @endif
                    @endif

                    @foreach(range($start, $end) as $page)
                        @if($page == $noticias->currentPage())
                            <span class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center text-xs font-black shadow-lg shadow-blue-600/20">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $noticias->url($page) }}" class="w-10 h-10 bg-white hover:bg-slate-100 text-slate-700 rounded-xl flex items-center justify-center text-xs font-black transition border border-slate-200">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    @if($end < $noticias->lastPage())
                        @if($end < $noticias->lastPage() - 1)
                            <span class="text-slate-400 text-xs px-1 font-bold">...</span>
                        @endif
                        <a href="{{ $noticias->url($noticias->lastPage()) }}" class="w-10 h-10 bg-white hover:bg-slate-100 text-slate-700 rounded-xl flex items-center justify-center text-xs font-black transition border border-slate-200">{{ $noticias->lastPage() }}</a>
                    @endif

                    {{-- Next Page Link --}}
                    @if($noticias->hasMorePages())
                        <a href="{{ $noticias->nextPageUrl() }}" class="px-4 py-2 bg-white hover:bg-blue-600 hover:text-white text-slate-700 rounded-xl text-xs font-black transition shadow-sm border border-slate-200 uppercase tracking-widest">
                            Próximo
                        </a>
                    @else
                        <span class="px-4 py-2 bg-slate-100 text-slate-400 rounded-xl text-xs font-black cursor-not-allowed uppercase tracking-widest border border-slate-200/50">
                            Próximo
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

<!-- ================= MODALS ================= -->

<!-- Modal Notícia (Criar / Editar) -->
<div id="modalNoticia" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4 overflow-y-auto">
    <div class="bg-white rounded-[2rem] shadow-2xl border border-slate-100 max-w-4xl w-full max-h-[90vh] flex flex-col overflow-hidden transition-all duration-300">
        <form method="POST" action="{{ route('noticia.store') }}" name="noticiaForm" id="noticiaForm" enctype="multipart/form-data" class="flex flex-col h-full overflow-hidden">
            @csrf
            <input type="hidden" name="idImagemDestaque" id="idImagemDestaque">
            
            <!-- Header -->
            <div class="bg-slate-900 text-white px-8 py-6 flex justify-between items-center">
                <h5 class="font-black text-lg uppercase tracking-tight" id="modalTitle">Criar Notícia</h5>
                <button type="button" class="text-slate-400 hover:text-white transition" onclick="$('#modalNoticia').modal('hide')">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <!-- Body -->
            <div class="p-8 overflow-y-auto space-y-6 flex-1 text-slate-700">
                <!-- Title Field -->
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase text-slate-400 tracking-wider">Título da Notícia (Máximo 80 Caracteres)</label>
                    <input type="text" name="titulo" id="titulo" maxlength="80" required
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 outline-none focus:border-blue-600 focus:bg-white transition"
                           placeholder="Ex: Novo benefício disponível para associados">
                </div>

                <!-- Subtitle Field -->
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase text-slate-400 tracking-wider">Subtítulo (Máximo 250 Caracteres)</label>
                    <textarea name="subtitulo" id="subtitulo" maxlength="250" rows="3"
                              class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 outline-none focus:border-blue-600 focus:bg-white transition"
                              placeholder="Resumo curto que será exibido no slider principal da página inicial..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Date Field -->
                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase text-slate-400 tracking-wider">Data de Cadastro (Opcional)</label>
                        <input type="datetime-local" name="data_cadastro" id="data_cadastro"
                               class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 outline-none focus:border-blue-600 focus:bg-white transition">
                    </div>

                    <!-- Highlight Option -->
                    <div class="flex items-center space-x-4 h-full pt-6">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input class="sr-only peer" type="checkbox" id="destaque" name="destaque">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                        <span class="text-xs font-black uppercase tracking-widest text-slate-500">Colocar no Slider Principal?</span>
                    </div>
                </div>

                <!-- Image Selector Preview Container -->
                <div id="editorContainer" class="hidden border-2 border-dashed border-slate-200 rounded-3xl p-6 bg-slate-50 space-y-4 text-center">
                    <button type="button" class="bg-blue-600 hover:bg-slate-900 text-white font-black text-xs uppercase tracking-widest px-6 py-3 rounded-xl transition shadow-md" id="modalImage">
                        Selecionar Imagem de Destaque
                    </button>
                    <div class="max-w-xs mx-auto">
                        <img src="" alt="Preview da Imagem" id="previewImagem" class="img-thumbnail-none rounded-2xl border-4 border-white shadow-md w-full object-cover">
                    </div>
                </div>

                <!-- Content Area -->
                <div class="space-y-3">
                    <label class="text-xs font-black uppercase text-slate-400 tracking-wider">Corpo da Notícia</label>
                    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                        <textarea class="tinymce_editor" name="tinymce_editor" id="tinymce_editor"></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="bg-slate-50 border-t border-slate-100 px-8 py-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                <button type="button" class="bg-amber-500 hover:bg-amber-600 text-white font-black text-xs uppercase tracking-widest px-6 py-4 rounded-2xl transition shadow-md w-full sm:w-auto"
                        onclick="$('#exampleModalImage').modal('show')">
                    Inserir Imagem no Texto
                </button>
                <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                    <button type="button" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-black text-xs uppercase tracking-widest px-6 py-4 rounded-2xl transition w-full sm:w-auto"
                            onclick="$('#modalNoticia').modal('hide')">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-black text-xs uppercase tracking-widest px-8 py-4 rounded-2xl transition shadow-lg shadow-blue-600/20 w-full sm:w-auto">
                        Salvar Notícia
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Galeria para TinyMCE -->
<div id="exampleModalImage" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-[2rem] shadow-2xl border border-slate-100 max-w-xl w-full max-h-[80vh] flex flex-col overflow-hidden">
        <div class="bg-amber-500 text-white px-8 py-6 flex justify-between items-center">
            <h5 class="font-black text-lg uppercase tracking-tight">Galeria de Mídia</h5>
            <button type="button" class="text-amber-100 hover:text-white transition" onclick="$('#exampleModalImage').modal('hide')">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <div class="p-8 overflow-y-auto flex-1 bg-slate-50">
            <div class="grid grid-cols-3 gap-4 product-list-gallery">
                @foreach($images as $image)
                    <div class="group relative bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md hover:border-amber-500 transition cursor-pointer product-card-gallery">
                        <img src="{{ asset('storage/posts/files/'.$image->path) }}" class="w-full h-24 object-cover resize-image-gallery" title="Inserir na Notícia">
                        <div class="absolute inset-0 bg-amber-500/10 opacity-0 group-hover:opacity-100 transition flex items-center justify-center pointer-events-none">
                            <span class="bg-amber-500 text-white text-[9px] font-black uppercase px-2 py-1 rounded">Inserir</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-slate-100 border-t border-slate-200 px-8 py-4 flex justify-end">
            <button type="button" class="bg-slate-800 hover:bg-slate-900 text-white font-black text-xs uppercase tracking-widest px-6 py-3 rounded-xl transition" onclick="$('#exampleModalImage').modal('hide')">
                Fechar
            </button>
        </div>
    </div>
</div>

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

<!-- Modal Conteúdo Completo (Visualizar) -->
<div id="modalConteudoNoticia" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-[2rem] shadow-2xl border border-slate-100 max-w-3xl w-full max-h-[85vh] flex flex-col overflow-hidden">
        <div class="bg-slate-900 text-white px-8 py-6 flex justify-between items-center">
            <h5 class="font-black text-lg uppercase tracking-tight">Conteúdo Completo</h5>
            <button type="button" class="text-slate-400 hover:text-white transition" onclick="$('#modalConteudoNoticia').modal('hide')">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <div class="p-8 overflow-y-auto flex-1 bg-white text-slate-800 leading-relaxed space-y-6 modal-conteudo" id="modal-conteudo">
            <!-- Loaded dynamically via custom.js -->
        </div>
        <div class="bg-slate-50 border-t border-slate-100 px-8 py-4 flex justify-end">
            <button type="button" class="bg-slate-800 hover:bg-slate-900 text-white font-black text-xs uppercase tracking-widest px-6 py-3 rounded-xl transition" onclick="$('#modalConteudoNoticia').modal('hide')">
                Fechar
            </button>
        </div>
    </div>
</div>

@endsection

@push("styles")
<link href="{{URL::asset('/admin/assets/filepond/dist/filepond.css')}}" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>
<style>
    /* Compatibility styles for FilePond & Gallery elements */
    .img-thumbnail-none {
        display: none;
    }
    #previewImagem:not(.img-thumbnail-none) {
        display: block;
    }
</style>
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
                    // Hide other open modals to avoid overlap
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

    // Set page specific details
    document.addEventListener('DOMContentLoaded', function() {
        // Intercept modal actions to update titles
        $('.btnModal').on('click', function() {
            $('#modalTitle').text('Criar Notícia');
        });
        $(document).on('click', '.btn-editar', function() {
            $('#modalTitle').text('Editar Notícia');
        });
    });
</script>
<script src="{{ asset('admin/assets/js/file-pond.js') }}"></script>
<script src="{{ asset('admin/assets/js/custom.js') }}"></script>
@endpush
