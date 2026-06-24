@extends('layouts.admin')

@section('title', 'Gerenciar Notícias')
@section('header_title', 'Notícias')
@section('header_subtitle', 'Gerencie as postagens e slider principal')

@section('header_actions')
<a href="{{ route('noticia.create') }}" class="bg-blue-600 hover:bg-slate-900 text-white font-black px-8 py-3 rounded-2xl transition flex items-center gap-2 text-sm shadow-xl shadow-blue-600/20">
    <i data-lucide="plus" class="w-5 h-5"></i>
    CRIAR NOTÍCIA
</a>
@endsection

@section('content')
<div class="space-y-8">
    <!-- News Table Card -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-black text-lg text-slate-900 uppercase tracking-tight">Lista de Notícias</h2>
            <span class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ count($noticias) }} registradas</span>
        </div>
        
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left min-w-[700px] lg:min-w-0">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-3 py-3 lg:px-6 lg:py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Notícia</th>
                        <th class="px-3 py-3 lg:px-6 lg:py-4 text-xs font-black text-slate-400 uppercase tracking-widest text-center w-36">Status</th>
                        <th class="px-3 py-3 lg:px-6 lg:py-4 text-xs font-black text-slate-400 uppercase tracking-widest w-32">Criado Em</th>
                        <th class="px-3 py-3 lg:px-6 lg:py-4 text-xs font-black text-slate-400 uppercase tracking-widest text-right w-28">Ações</th>
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
                            <td class="px-3 py-3 lg:px-6 lg:py-4">
                                <div class="flex items-center gap-6">
                                    <div class="@if($imgPath) cursor-pointer hover:scale-105 transition duration-300 @endif w-20 h-20 lg:w-24 lg:h-24 bg-slate-100 rounded-3xl overflow-hidden shadow-md flex-shrink-0 border-4 border-white"
                                         @if($imgPath) onclick="showImagePreview('{{ asset('storage/posts/files/'.$imgPath) }}')" @endif>
                                        @if($imgPath)
                                            <img src="{{ asset('storage/posts/files/'.$imgPath) }}" class="w-full h-full object-cover" title="Clique para ampliar">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <i data-lucide="image" class="w-8 h-8"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="space-y-1.5">
                                        <h5 class="text-sm font-black uppercase text-slate-900 leading-tight">{{ $noticia->titulo }}</h5>
                                        @if($noticia->subtitulo)
                                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest line-clamp-1 italic leading-none">{{ $noticia->subtitulo }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-3 lg:px-6 lg:py-4 text-center">
                                @if($noticia->status == 1)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                                        Publicado
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-slate-100 text-slate-800 uppercase tracking-wider">
                                        Rascunho
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-3 lg:px-6 lg:py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {{ $noticia->created_at ?: '-' }}
                            </td>
                            <td class="px-3 py-3 lg:px-6 lg:py-4">
                                <div class="flex items-center justify-end gap-2 lg:gap-3">
                                    <a href="{{ route('noticia.edit', $noticia->id) }}" 
                                       class="w-8 h-8 lg:w-10 lg:h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-blue-600 hover:text-white hover:border-blue-600 transition shadow-sm">
                                        <i data-lucide="edit-3" class="w-4 h-4 lg:w-5 lg:h-5"></i>
                                    </a>
                                    <form id="delete-form-{{ $noticia->id }}" action="{{ route('noticia.destroy', $noticia->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                onclick="confirmDelete('delete-form-{{ $noticia->id }}')"
                                                class="w-8 h-8 lg:w-10 lg:h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-rose-600 hover:text-white hover:border-rose-600 transition shadow-sm">
                                            <i data-lucide="trash-2" class="w-4 h-4 lg:w-5 lg:h-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-slate-400 font-bold uppercase tracking-wider text-sm">
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

@endsection

@push("scripts")
<script src="{{ asset('admin/assets/js/custom.js') }}"></script>
<script>
    function showImagePreview(url) {
        if (!url) return;
        Swal.fire({
            imageUrl: url,
            imageAlt: 'Visualização da Imagem',
            showConfirmButton: false,
            showCloseButton: true,
            background: 'transparent',
            customClass: {
                popup: 'bg-transparent shadow-none border-none',
                image: 'rounded-[2rem] max-h-[80vh] max-w-[90vw] object-contain shadow-2xl border-4 border-white'
            }
        });
    }
</script>
@endpush
