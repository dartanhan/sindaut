@extends('layouts.layout')

@section('menu')

    @include('site.menu')

@endsection

@section('content')

<style>
    .news-square-box {
        display: block; 
        position: relative; 
        height: 219px; 
        overflow: hidden; 
        border-radius: 4px; 
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
    }
    .news-square-box:hover .square-img {
        transform: scale(1.05);
    }
    .square-img {
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
        object-position: center; 
        transition: transform 0.3s;
    }
    @media (max-width: 991px) {
        .news-square-box {
            height: 195px;
        }
    }
    @media (max-width: 767px) {
        .news-square-box {
            height: 180px;
        }
    }
</style>

<section id="contentSection">
    <!-- Top Row: Slider and 4 Squares Grid -->
    <div class="row" style="margin-bottom: 25px;">
        <div class="col-lg-7 col-md-7 col-sm-12">
            @include('site/sliders', ['noticias' => $noticias->slice(0, 5)])
        </div>
        <div class="col-lg-5 col-md-5 col-sm-12">
            <div class="row" style="margin-left: -5px; margin-right: -5px;">
                @foreach($noticias->slice(5, 4) as $key => $noticia)
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
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="padding-left: 5px; padding-right: 5px; margin-bottom: 10px;">
                        <a href="{{ route('site.detalhe-noticia', $noticia->id) }}" class="news-square-box">
                            @if($hasImage)
                                <img src="{{ URL::asset('storage/posts/files/'.$imagePath) }}" alt="{{ $noticia->titulo }}" class="square-img">
                            @else
                                <img src="{{ URL::asset('images/volume.png') }}" alt="{{ $noticia->titulo }}" class="square-img">
                            @endif
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.85)); padding: 12px 10px 8px; color: #fff;">
                                <h3 style="margin: 0 0 5px; font-size: 11px; font-weight: bold; line-height: 1.3; height: 28px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                    {{ $noticia->titulo }}
                                </h3>
                                <span style="font-size: 9px; opacity: 0.8; display: block;">
                                    <i class="fa fa-calendar" style="margin-right: 3px;"></i> {{ $noticia->created_at }}
                                </span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Bottom Row: Featured Post and Sidebar -->
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-6 left-column">
            <div class="row">
                @if(count($noticias) > 9)
                    @php $featuredNoticia = $noticias[9]; @endphp
                    <div class="col-lg-12 col-md-8 col-sm-8">
                        <div class="left_content">
                            <div class="single_page">
                                <h1>{{$featuredNoticia->titulo}}</h1>
                                <div class="post_commentbox">
                                    @php
                                        $criado = $featuredNoticia->getRawOriginal('created_at');
                                        $atualizado = $featuredNoticia->getRawOriginal('updated_at');
                                        $mostraAtualizado = $criado && $atualizado && (strtotime($atualizado) - strtotime($criado) > 60);
                                        
                                        $textoLimpo = strip_tags($featuredNoticia->conteudo);
                                        $palavras = count(explode(' ', preg_replace('/\s+/', ' ', trim($textoLimpo))));
                                        $tempoLeitura = max(1, ceil($palavras / 200));
                                    @endphp
                                    <span>
                                        <i class="fa fa-calendar"></i> Publicado em: {{$featuredNoticia->created_at}}
                                    </span>
                                    @if($mostraAtualizado)
                                        &nbsp;&nbsp;
                                        <span>
                                            <i class="fa fa-history"></i> Atualizado em: {{$featuredNoticia->updated_at}}
                                        </span>
                                    @endif
                                    &nbsp;&nbsp;
                                    <span>
                                        <i class="fa fa-clock-o"></i> {{$tempoLeitura}} min de leitura
                                    </span>
                                </div>
                                <div class="single_page_content">
                                    {!! str_replace("../../", "", $featuredNoticia->conteudo) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 right-column">
            @if(count($noticias) > 10)
                @include('site/ultimas-noticias', ['noticias' => $noticias->slice(10, 5)])
            @endif
            @include('site/popular-post', ['variavel' => '$valor'])
        </div>
    </div>
    </section>



                    <!--h2><span>Business</span></h2>
                    <div class="single_post_content_left">
                        <ul class="business_catgnav  wow fadeInDown">
                            <li>
                                <figure class="bsbig_fig"> <a href="pages/single_page.html" class="featured_img"> <img alt="" src="{{URL::asset('images/featured_img1.jpg')}}"> <span class="overlay"></span> </a>
                                    <figcaption> <a href="pages/single_page.html">Proin rhoncus consequat nisl eu ornare mauris</a> </figcaption>
                                    <p>Nunc tincidunt, elit non cursus euismod, lacus augue ornare metus, egestas imperdiet nulla nisl quis mauris. Suspendisse a phare...</p>
                                </figure>
                            </li>
                        </ul>
                    </div>
                    <div class="single_post_content_right">
                        <ul class="spost_nav">
                            <li>
                                <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images//post_img1.jpg')}}"> </a>
                                    <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 1</a> </div>
                                </div>
                            </li>
                            <li>
                                <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img2.jpg')}}"> </a>
                                    <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 2</a> </div>
                                </div>
                            </li>
                            <li>
                                <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img1.jpg')}}"> </a>
                                    <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 3</a> </div>
                                </div>
                            </li>
                            <li>
                                <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img2.jpg')}}"> </a>
                                    <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 4</a> </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="fashion_technology_area">
                    <div class="fashion">
                        <div class="single_post_content">
                            <h2><span>Fashion</span></h2>
                            <ul class="business_catgnav wow fadeInDown">
                                <li>
                                    <figure class="bsbig_fig"> <a href="pages/single_page.html" class="featured_img"> <img alt="" src="{{URL::asset('images/featured_img2.jpg')}}"> <span class="overlay"></span> </a>
                                        <figcaption> <a href="pages/single_page.html">Proin rhoncus consequat nisl eu ornare mauris</a> </figcaption>
                                        <p>Nunc tincidunt, elit non cursus euismod, lacus augue ornare metus, egestas imperdiet nulla nisl quis mauris. Suspendisse a phare...</p>
                                    </figure>
                                </li>
                            </ul>
                            <ul class="spost_nav">
                                <li>
                                    <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img1.jpg')}}"> </a>
                                        <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 1</a> </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img2.jpg')}}"> </a>
                                        <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 2</a> </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img1.jpg')}}"> </a>
                                        <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 3</a> </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img2.jpg')}}"> </a>
                                        <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 4</a> </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="technology">
                        <div class="single_post_content">
                            <h2><span>Technology</span></h2>
                            <ul class="business_catgnav">
                                <li>
                                    <figure class="bsbig_fig wow fadeInDown"> <a href="pages/single_page.html" class="featured_img"> <img alt="" src="{{URL::asset('images/featured_img3.jpg')}}"> <span class="overlay"></span> </a>
                                        <figcaption> <a href="pages/single_page.html">Proin rhoncus consequat nisl eu ornare mauris</a> </figcaption>
                                        <p>Nunc tincidunt, elit non cursus euismod, lacus augue ornare metus, egestas imperdiet nulla nisl quis mauris. Suspendisse a phare...</p>
                                    </figure>
                                </li>
                            </ul>
                            <ul class="spost_nav">
                                <li>
                                    <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img1.jpg')}}"> </a>
                                        <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 1</a> </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img2.jpg')}}"> </a>
                                        <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 2</a> </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img1.jpg')}}"> </a>
                                        <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 3</a> </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img2.jpg')}}"> </a>
                                        <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 4</a> </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="single_post_content">
                    <h2><span>Photography</span></h2>
                    <ul class="photograph_nav  wow fadeInDown">
                        <li>
                            <div class="photo_grid">
                                <figure class="effect-layla"> <a class="fancybox-buttons" data-fancybox-group="button" href="{{URL::asset('images/photograph_img2.jpg')}}" title="Photography Ttile 1"> <img src="{{URL::asset('images/photograph_img2.jpg')}}" alt=""/></a> </figure>
                            </div>
                        </li>
                        <li>
                            <div class="photo_grid">
                                <figure class="effect-layla"> <a class="fancybox-buttons" data-fancybox-group="button" href="{{URL::asset('images/photograph_img3.jpg')}}" title="Photography Ttile 2"> <img src="{{URL::asset('images/photograph_img3.jpg')}}" alt=""/> </a> </figure>
                            </div>
                        </li>
                        <li>
                            <div class="photo_grid">
                                <figure class="effect-layla"> <a class="fancybox-buttons" data-fancybox-group="button" href="{{URL::asset('images/photograph_img4.jpg')}}" title="Photography Ttile 3"> <img src="{{URL::asset('images/photograph_img4.jpg')}}" alt=""/> </a> </figure>
                            </div>
                        </li>
                        <li>
                            <div class="photo_grid">
                                <figure class="effect-layla"> <a class="fancybox-buttons" data-fancybox-group="button" href="{{URL::asset('images/photograph_img4.jpg')}}" title="Photography Ttile 4"> <img src="{{URL::asset('images/photograph_img4.jpg')}}" alt=""/> </a> </figure>
                            </div>
                        </li>
                        <li>
                            <div class="photo_grid">
                                <figure class="effect-layla"> <a class="fancybox-buttons" data-fancybox-group="button" href="{{URL::asset('images/photograph_img2.jpg')}}" title="Photography Ttile 5"> <img src="{{URL::asset('images/photograph_img2.jpg')}}" alt=""/> </a> </figure>
                            </div>
                        </li>
                        <li>
                            <div class="photo_grid">
                                <figure class="effect-layla"> <a class="fancybox-buttons" data-fancybox-group="button" href="{{URL::asset('images/photograph_img3.jpg')}}" title="Photography Ttile 6"> <img src="{{URL::asset('images/photograph_img3.jpg')}}" alt=""/> </a> </figure>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="single_post_content">
                    <h2><span>Games</span></h2>
                    <div class="single_post_content_left">
                        <ul class="business_catgnav">
                            <li>
                                <figure class="bsbig_fig  wow fadeInDown"> <a class="featured_img" href="pages/single_page.html"> <img src="{{URL::asset('images/featured_img1.jpg')}}" alt=""> <span class="overlay"></span> </a>
                                    <figcaption> <a href="pages/single_page.html">Proin rhoncus consequat nisl eu ornare mauris</a> </figcaption>
                                    <p>Nunc tincidunt, elit non cursus euismod, lacus augue ornare metus, egestas imperdiet nulla nisl quis mauris. Suspendisse a phare...</p>
                                </figure>
                            </li>
                        </ul>
                    </div>
                    <div class="single_post_content_right">
                        <ul class="spost_nav">
                            <li>
                                <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img1.jpg')}}"> </a>
                                    <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 1</a> </div>
                                </div>
                            </li>
                            <li>
                                <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img2.jpg')}}"> </a>
                                    <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 2</a> </div>
                                </div>
                            </li>
                            <li>
                                <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img1.jpg')}}"> </a>
                                    <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 3</a> </div>
                                </div>
                            </li>
                            <li>
                                <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img2.jpg')}}"> </a>
                                    <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 4</a> </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
            <aside class="right_content">
                <div class="single_sidebar">
                    <h2><span>Popular Post</span></h2>
                    <ul class="spost_nav">
                        <li>
                            <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img1.jpg')}}"> </a>
                                <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 1</a> </div>
                            </div>
                        </li>
                        <li>
                            <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img2.jpg')}}"> </a>
                                <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 2</a> </div>
                            </div>
                        </li>
                        <li>
                            <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img1.jpg')}}"> </a>
                                <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 3</a> </div>
                            </div>
                        </li>
                        <li>
                            <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img2.jpg')}}"> </a>
                                <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 4</a> </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="single_sidebar">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#category" aria-controls="home" role="tab" data-toggle="tab">Category</a></li>
                        <li role="presentation"><a href="#video" aria-controls="profile" role="tab" data-toggle="tab">Video</a></li>
                        <li role="presentation"><a href="#comments" aria-controls="messages" role="tab" data-toggle="tab">Comments</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="category">
                            <ul>
                                <li class="cat-item"><a href="#">Sports</a></li>
                                <li class="cat-item"><a href="#">Fashion</a></li>
                                <li class="cat-item"><a href="#">Business</a></li>
                                <li class="cat-item"><a href="#">Technology</a></li>
                                <li class="cat-item"><a href="#">Games</a></li>
                                <li class="cat-item"><a href="#">Life &amp; Style</a></li>
                                <li class="cat-item"><a href="#">Photography</a></li>
                            </ul>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="video">
                            <div class="vide_area">
                                <iframe width="100%" height="250" src="http://www.youtube.com/embed/h5QWbURNEpA?feature=player_detailpage" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="comments">
                            <ul class="spost_nav">
                                <li>
                                    <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img1.jpg')}}"> </a>
                                        <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 1</a> </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img2.jpg')}}"> </a>
                                        <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 2</a> </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img1.jpg')}}"> </a>
                                        <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 3</a> </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <img alt="" src="{{URL::asset('images/post_img2.jpg')}}"> </a>
                                        <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 4</a> </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="single_sidebar wow fadeInDown">
                    <h2><span>Sponsor</span></h2>
                    <a class="sideAdd" href="#"><img src="{{URL::asset('images/add_img.jpg')}}" alt=""></a> </div>
                <div class="single_sidebar wow fadeInDown">
                    <h2><span>Category Archive</span></h2>
                    <select class="catgArchive">
                        <option>Select Category</option>
                        <option>Life styles</option>
                        <option>Sports</option>
                        <option>Technology</option>
                        <option>Treads</option>
                    </select>
                </div>
                <div class="single_sidebar wow fadeInDown">
                    <h2><span>Links</span></h2>
                    <ul>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Rss Feed</a></li>
                        <li><a href="#">Login</a></li>
                        <li><a href="#">Life &amp; Style</a></li>
                    </ul>
                </div>
            </aside>
        </div>
    </div-->
@endsection