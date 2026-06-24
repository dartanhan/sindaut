@extends('layouts.admin')

@section('title', 'Galeria de Imagens')
@section('header_title', 'Galeria')
@section('header_subtitle', 'Gerencie arquivos, imagens e documentos do portal')

@section('header_actions')
<button type="button" class="bg-blue-600 hover:bg-slate-900 text-white font-black px-8 py-3 rounded-2xl transition flex items-center gap-2 text-sm shadow-xl shadow-blue-600/20"
        data-toggle="modal" data-target="#exampleModal">
    <i data-lucide="upload-cloud" class="w-5 h-5"></i>
    FAZER UPLOAD
</button>
@endsection

@section('content')
<div class="space-y-8">
    <!-- Grid of Files -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8 space-y-8">
        <div class="flex items-center justify-between border-b border-slate-100 pb-6">
            <h2 class="font-black text-lg text-slate-900 uppercase tracking-tight">Arquivos Cadastrados</h2>
            <span class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ $images->total() }} no total</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse($images as $image)
                @php
                    $extension = pathinfo($image->path, PATHINFO_EXTENSION);
                    $fileTypes = [
                        'doc' => 'doc',
                        'docx' => 'docx',
                        'xls' => 'xls',
                        'xlsx' => 'xlsx',
                    ];
                    $fileUrl = asset('storage/posts/files/' . $image->path);
                @endphp

                <div class="group bg-slate-50 border border-slate-100 hover:border-blue-600 hover:bg-white rounded-[2rem] p-4 flex flex-col justify-between shadow-sm hover:shadow-md transition duration-300 relative overflow-hidden">
                    
                    <!-- Preview Container -->
                    <div class="w-full h-44 rounded-2xl bg-white border border-slate-100 overflow-hidden flex items-center justify-center relative shadow-inner">
                        @if($extension === 'pdf')
                            <div class="w-full h-full flex flex-col items-center justify-center p-4 text-center">
                                <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mb-2">
                                    <i data-lucide="file-text" class="w-6 h-6"></i>
                                </div>
                                <span class="text-xs font-black uppercase text-slate-700 tracking-wider">Documento PDF</span>
                                <span class="text-[10px] text-slate-400 font-bold truncate max-w-full px-4 mt-1">{{ $image->path }}</span>
                            </div>
                        @elseif(isset($fileTypes[$extension]))
                            <div class="w-full h-full flex flex-col items-center justify-center p-4 text-center">
                                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-2">
                                    <i data-lucide="file" class="w-6 h-6"></i>
                                </div>
                                <span class="text-xs font-black uppercase text-slate-700 tracking-wider">{{ strtoupper($extension) }} File</span>
                                <span class="text-[10px] text-slate-400 font-bold truncate max-w-full px-4 mt-1">{{ $image->path }}</span>
                            </div>
                        @else
                            <img src="{{ asset('storage/posts/files/'.$image->path) }}" class="w-full h-full object-cover transition duration-300 group-hover:scale-105">
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4 pt-4 border-t border-slate-100 flex flex-col gap-2">
                        @if($extension === 'pdf')
                            <a href="{{ asset('storage/posts/files/' . $image->path) }}" target="_blank" 
                               class="w-full bg-slate-900 hover:bg-blue-600 text-white font-black text-center py-2.5 rounded-xl transition text-[11px] uppercase tracking-wider flex items-center justify-center gap-1.5 shadow-sm">
                                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                Abrir PDF
                            </a>
                        @endif
                        
                        <div class="flex gap-2">
                            <button class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 font-black py-2.5 rounded-xl transition text-[11px] uppercase tracking-wider copy-link" 
                                    data-link="{{ $fileUrl }}">
                                Copiar Link
                            </button>
                            <button class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-black p-2.5 rounded-xl transition delete-button" 
                                    data-rota="{{ route('upload.destroy', $image->id) }}"
                                    title="Deletar Arquivo">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center text-slate-400 font-bold uppercase tracking-wider text-sm">
                    Nenhum arquivo ou imagem na galeria.
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($images->hasPages())
            <div class="pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                    Exibindo {{ $images->firstItem() }} até {{ $images->lastItem() }} de {{ $images->total() }} mídias
                </div>
                <div class="flex items-center gap-2 flex-wrap justify-center">
                    {{-- Previous Page Link --}}
                    @if($images->onFirstPage())
                        <span class="px-4 py-2 bg-slate-100 text-slate-400 rounded-xl text-xs font-black cursor-not-allowed uppercase tracking-widest border border-slate-200/50">
                            Anterior
                        </span>
                    @else
                        <a href="{{ $images->previousPageUrl() }}" class="px-4 py-2 bg-white hover:bg-blue-600 hover:text-white text-slate-700 rounded-xl text-xs font-black transition shadow-sm border border-slate-200 uppercase tracking-widest">
                            Anterior
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    @php
                        $start = max($images->currentPage() - 2, 1);
                        $end = min($start + 4, $images->lastPage());
                        if ($end - $start < 4) {
                            $start = max($end - 4, 1);
                        }
                    @endphp

                    @if($start > 1)
                        <a href="{{ $images->url(1) }}" class="w-10 h-10 bg-white hover:bg-slate-100 text-slate-700 rounded-xl flex items-center justify-center text-xs font-black transition border border-slate-200">1</a>
                        @if($start > 2)
                            <span class="text-slate-400 text-xs px-1 font-bold">...</span>
                        @endif
                    @endif

                    @foreach(range($start, $end) as $page)
                        @if($page == $images->currentPage())
                            <span class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center text-xs font-black shadow-lg shadow-blue-600/20">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $images->url($page) }}" class="w-10 h-10 bg-white hover:bg-slate-100 text-slate-700 rounded-xl flex items-center justify-center text-xs font-black transition border border-slate-200">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    @if($end < $images->lastPage())
                        @if($end < $images->lastPage() - 1)
                            <span class="text-slate-400 text-xs px-1 font-bold">...</span>
                        @endif
                        <a href="{{ $images->url($images->lastPage()) }}" class="w-10 h-10 bg-white hover:bg-slate-100 text-slate-700 rounded-xl flex items-center justify-center text-xs font-black transition border border-slate-200">{{ $images->lastPage() }}</a>
                    @endif

                    {{-- Next Page Link --}}
                    @if($images->hasMorePages())
                        <a href="{{ $images->nextPageUrl() }}" class="px-4 py-2 bg-white hover:bg-blue-600 hover:text-white text-slate-700 rounded-xl text-xs font-black transition shadow-sm border border-slate-200 uppercase tracking-widest">
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

<!-- Upload Modal -->
<div id="exampleModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-[2rem] shadow-2xl border border-slate-100 max-w-lg w-full max-h-[85vh] flex flex-col overflow-hidden">
        <form method="POST" action="{{ route('uploadImagem') }}" name="uploadForm" id="uploadForm" enctype="multipart/form-data">
            @csrf
            <!-- Header -->
            <div class="bg-slate-900 text-white px-8 py-6 flex justify-between items-center">
                <h5 class="font-black text-lg uppercase tracking-tight">Fazer Upload de Arquivo</h5>
                <button type="button" class="text-slate-400 hover:text-white transition" onclick="$('#exampleModal').modal('hide')">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <!-- Body -->
            <div class="p-8 space-y-6">
                <div class="border-2 border-dashed border-slate-200 rounded-3xl p-6 bg-slate-50">
                    <input type="file" name="image" id="image" class="filepond"/>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="bg-slate-50 border-t border-slate-100 px-8 py-6 flex justify-end gap-3">
                <button type="button" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-black text-xs uppercase tracking-widest px-6 py-4 rounded-2xl transition" 
                        onclick="$('#exampleModal').modal('hide')">
                    Fechar
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-black text-xs uppercase tracking-widest px-8 py-4 rounded-2xl transition shadow-lg shadow-blue-600/20">
                    Salvar Arquivo
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
                    $el.removeClass('hidden').addClass('flex');
                    jQuery('body').addClass('overflow-hidden');
                } else if (action === 'hide') {
                    $el.addClass('hidden').removeClass('flex');
                    jQuery('body').removeClass('overflow-hidden');
                }
            });
        };
    }
</script>
<script src="{{URL::asset('admin/assets/js/file-pond.js')}}"></script>
<script src="{{URL::asset('admin/assets/js/custom.js')}}"></script>
@endpush
