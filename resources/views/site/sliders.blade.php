<div class="slick_slider">
    @foreach($noticias as $key => $noticia)
        @if($noticia->destaque)
            <div class="single_iteam">
                @foreach($noticia['imagens'] as $key => $imagem)
                    <a href="{{route('site.detalhe-noticia',$noticia->id)}}">
                        <img alt="" src="{{URL::asset("storage/posts/files/".$imagem->path)}}">
                    </a>
                    <div class="slider_article">
                        <h2>
                            <a class="slider_tittle" href="{{route('site.detalhe-noticia',$noticia->id)}}">{{$noticia->titulo}}</a>
                        </h2>
                        <p>{{$noticia->subtitulo}}</p>
                    </div>
                @endforeach
            </div>
        @endif
    @endforeach
</div>
