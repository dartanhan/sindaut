<div class="latest_post">
    <h2><span>Últimas Notícias</span></h2>
    <div class="latest_post_container">
        <div id="prev-button"><i class="fa fa-chevron-up"></i></div>
        <ul class="latest_postnav">
            @foreach($noticias as $key => $noticia)
            <li>
                <div class="media">
                    @foreach($noticia['imagens'] as $key => $imagem)
                        <a href="{{route('site.detalhe-noticia',$noticia->id)}}" class="media-left">
                            <img alt="" src="{{URL::asset("storage/posts/files/".$imagem->path)}}">
                        </a>
                    @endforeach
                    <div class="media-body">
                        <a href="{{route('site.detalhe-noticia',$noticia->id)}}" class="catg_title"><i class="fa fa-volume-up"></i> {{$noticia->titulo}} </a>
                        <div >
                            <span><i class="fa fa-calendar"></i> {{$noticia->created_at}}</span>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        <div id="next-button"><i class="fa  fa-chevron-down"></i></div>
    </div>
</div>
