<div class="latest_post">
    <h2><span>Últimas Notícias</span></h2>
    <div class="latest_post_container" style="max-height: auto;overflow-y: hidden;">
        <div id="prev-button"><i class="fa fa-chevron-up"></i></div>
        <ul class="latest_postnav">
            @foreach($noticias as $key => $noticia)
            <li>
                <div class="media">
                    @php $imagemEncontrada = false; @endphp
                    @foreach($noticia['imagens'] as $key => $imagem)
                        @if(!empty($imagem) && strlen($imagem->path) > 0)
                            <a href="{{ route('site.detalhe-noticia', $noticia->id) }}" class="media-left">
                                <img alt="" src="{{ URL::asset("storage/posts/files/".$imagem->path) }}">
                            </a>
                            @php $imagemEncontrada = true; @endphp
                            @break
                        @endif
                    @endforeach

                    @if(!$imagemEncontrada)
                        <a href="{{ route('site.detalhe-noticia', $noticia->id) }}" class="media-left">
                            <img alt="" src="{{ URL::asset("images/volume.png") }}">
                        </a>
                    @endif

                    <div class="media-body">
                        <a href="{{route('site.detalhe-noticia',$noticia->id)}}" class="catg_title">
                            <i class="fa fa-volume-up"></i> {{$noticia->titulo}} </a>
                        <div>
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
