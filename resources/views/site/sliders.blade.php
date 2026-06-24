<div class="slick_slider">
    @foreach($noticias as $key => $noticia)
        <div class="single_iteam">
            @php $hasImage = false; @endphp
            @foreach($noticia['imagens'] as $imagem)
                @if(!empty($imagem) && strlen($imagem->path) > 0)
                    <a href="{{route('site.detalhe-noticia',$noticia->id)}}">
                        <img alt="" src="{{URL::asset("storage/posts/files/".$imagem->path)}}">
                    </a>
                    @php $hasImage = true; @endphp
                    @break
                @endif
            @endforeach

            @if(!$hasImage)
                <a href="{{route('site.detalhe-noticia',$noticia->id)}}">
                    <img alt="" src="{{URL::asset("images/volume.png")}}">
                </a>
            @endif

            <div class="slider_article">
                <h2>
                    <a class="slider_tittle" href="{{route('site.detalhe-noticia',$noticia->id)}}">{{$noticia->titulo}}</a>
                </h2>
                <p>{{$noticia->subtitulo}}</p>
            </div>
        </div>
    @endforeach
</div>
