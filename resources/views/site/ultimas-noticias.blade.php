<style>
    .scrollable-news::-webkit-scrollbar {
        display: none;
    }
    .scrollable-news {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .btn-veja-mais-standard {
        display: inline-block;
        background-color: #0d6efd;
        color: #fff;
        border: none;
        font-weight: bold;
        padding: 10px 24px;
        font-size: 12px;
        text-transform: uppercase;
        border-radius: 5px;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: all 0.2s ease-in-out;
    }
    .btn-veja-mais-standard:hover {
        background-color: #0b5ed7 !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15) !important;
        transform: translateY(-1px);
        color: #fff !important;
        text-decoration: none !important;
    }
</style>

<div class="latest_post">
    <h2><span>Últimas Notícias</span></h2>
    <div class="latest_post_container scrollable-news" style="display: block !important; height: 600px !important; overflow-y: auto !important; overflow-x: hidden !important; padding-right: 5px; float: none; width: 100%;">
        <ul class="latest_postnav" style="height: auto !important; float: none; width: 100%;">
            @foreach($noticias as $key => $noticia)
            <li class="noticia-item" style="display: {{ $key < 8 ? 'block' : 'none' }}; width: 100%; float: none; clear: both;">
                <div class="media" style="margin-bottom: 10px;">
                    @php $imagemEncontrada = false; @endphp
                    @foreach($noticia['imagens'] as $imagem)
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
    </div>
    @if(count($noticias) > 8)
        <div style="text-align: center; margin-top: 15px; margin-bottom: 15px;">
            <button id="btn-ver-mais-noticias" class="btn-veja-mais-standard">
                VEJA MAIS <i class="fa fa-chevron-down" style="margin-left: 8px;"></i>
            </button>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var visibleCount = 8;
        var totalItems = $('.noticia-item').length;
        
        $('#btn-ver-mais-noticias').click(function(e) {
            e.preventDefault();
            var $container = $('.scrollable-news');
            
            $('.noticia-item').slice(visibleCount, visibleCount + 8).slideDown(400, function() {
                // Scroll down slightly to make the expansion apparent inside the container
                $container.animate({
                    scrollTop: $container.scrollTop() + 100
                }, 300);
            });
            
            visibleCount += 8;
            if (visibleCount >= totalItems) {
                $('#btn-ver-mais-noticias').fadeOut();
            }
        });
    });
</script>
@endpush
