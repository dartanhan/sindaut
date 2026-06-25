<div class="slick_slider">
    @foreach($noticias as $key => $noticia)
        @php 
            $hasImage = false;
            $imagePath = '';
            foreach($noticia['imagens'] as $imagem) {
                if(!empty($imagem) && strlen($imagem->path) > 0) {
                    $hasImage = true;
                    $imagePath = $imagem->path;
                    break;
                }
            }
        @endphp

        @if($hasImage)
            <div class="single_iteam">
                <a href="{{route('site.detalhe-noticia',$noticia->id)}}">
                    <img alt="" src="{{URL::asset("storage/posts/files/".$imagePath)}}" style="object-fit: cover; object-position: center; width: 100%; height: 100%;">
                </a>

                <div class="slider_article">
                    <h2>
                        <a class="slider_tittle" href="{{route('site.detalhe-noticia',$noticia->id)}}">{{$noticia->titulo}}</a>
                    </h2>
                    <p>{{$noticia->subtitulo}}</p>
                </div>
            </div>
        @endif
    @endforeach
</div>
