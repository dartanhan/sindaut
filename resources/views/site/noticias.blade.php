@extends('layouts.layout')

@section('menu')

    @include('site.menu')

@endsection

@section('content')

    <section id="contentSection">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <ol class="breadcrumb">
                    <li><a href="{{route('site.home')}}">Home</a></li>
                    <li><a href="#">Notícias</a></li>

                </ol>
                <div class="left_content">
                    <div class="contact_area">
                        <ul>
                            @foreach($noticias_site as $key => $noticiasite)
                            <li>
                                <div class="media-site" style=" margin-bottom: 20px;border-bottom: 1px dashed #ccc;">
                                    @php $imagemEncontrada = false; @endphp
                                        @foreach($noticiasite['imagens'] as $key => $imagem)
                                            @if(!empty($imagem) && strlen($imagem->path) > 0)
                                                <a href="{{ route('site.detalhe-noticia', $noticiasite->id) }}" class="media-left-site">
                                                    <img alt="" src="{{ URL::asset("storage/posts/files/".$imagem->path) }}">
                                                </a>
                                                @php $imagemEncontrada = true; @endphp
                                                @break
                                            @endif
                                        @endforeach

                                        @if(!$imagemEncontrada)
                                            <a href="{{ route('site.detalhe-noticia', $noticiasite->id) }}" class="media-left-site">
                                                <img alt="" src="{{ URL::asset("images/volume.png") }}">
                                            </a>
                                        @endif

                                        <div class="media-body-site">
                                            <a href="{{route('site.detalhe-noticia',$noticiasite->id)}}" class="catg_title_site ">
                                                <i class="fa fa-volume-up"></i> {{$noticiasite->titulo}} </a>
                                            <div>
                                                <span><i class="fa fa-calendar"></i> {{$noticiasite->created_at}}</span>
                                            </div>
                                            <div>
                                                <span>
                                                    {!! substr(strip_tags($noticiasite->conteudo), 0, 150) !!} <!-- Exibe os primeiros 100 caracteres do conteúdo -->
                                                    @if(strlen(strip_tags($noticiasite->conteudo)) > 150)
                                                        <a href="{{route('site.detalhe-noticia',$noticiasite->id)}}" class="catg_title_site link-info">
                                                            [...] <!-- Adicione reticências para indicar que o conteúdo foi truncado -->
                                                        </a>
                                                        <div>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Adicionando a paginação -->
                    <div class="pagination">
                        <ul class="pagination">
                            <!-- Links de páginação gerados pelo Laravel -->
                            {{ $noticias_site->links() }}
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <aside class="right_content">
                    @include('site/ultimas-noticias', ['variavel' => '$valor'])
                    @include('site/popular-post', ['variavel' => '$valor'])
                </aside>
            </div>
        </div>
    </section>
@endsection
@push("styles")
    <link rel="stylesheet" type="text/css" href="{{URL::asset('/assets/css/paginate.css')}}">
@endpush