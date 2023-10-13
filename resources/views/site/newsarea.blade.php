<div class="latest_newsarea">
    <span>Últimas Notícias</span>
    <ul id="ticker01" class="news_sticker">

        @foreach($noticias as $key => $noticia)
            @foreach($noticia['imagens'] as $key => $imagem)
                <li>
                    <a href="{{route('site.detalhe-noticia',$noticia->id)}}">
                        <img alt="" src="{{URL::asset("storage/posts/files/".$imagem->path)}}">{{$noticia->titulo}}
                    </a>
                </li>
            @endforeach
        @endforeach
    </ul>
    <div class="social_area">
        <ul class="social_nav">
            <li class="facebook"><a href="#"></a></li>
            <!--li class="twitter"><a href="#"></a></li>
            <li class="flickr"><a href="#"></a></li>
            <li class="pinterest"><a href="#"></a></li>
            <li class="googleplus"><a href="#"></a></li>
            <li class="vimeo"><a href="#"></a></li-->
            <li class="youtube"><a href="#"></a></li>
            <li class="mail"><a href="#"></a></li>
        </ul>
    </div>
</div>
