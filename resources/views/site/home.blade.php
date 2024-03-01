@extends('layouts.layout')

@section('menu')

    @include('site.menu')

@endsection

@section('content')

<section id="contentSection">
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-6 left-column">
            <div class="row">
                @include('site/sliders', ['variavel' => '$valor'])
            </div>
            <div class="row">
                @if(count($noticias) > 0)
                    <div class="col-lg-12 col-md-8 col-sm-8">
                        <div class="left_content">
                            <div class="single_page">

                                <h1>{{$noticias[0]->titulo}}</h1>
                                <div class="post_commentbox">
                                    <!--a href="#">
                                        <i class="fa fa-user"></i>Wpfreeware</a-->
                                    <span>
                                        <i class="fa fa-calendar"></i>{{$noticias[0]->created_at}}
                                    </span>
                                    <!-- a href="#"><i class="fa fa-tags"></i>Technology</a -->
                                </div>
                                <div class="single_page_content">
                                    {!! str_replace("../../", "", $noticias[0]->conteudo) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 right-column">
            @if(count($noticias) > 0)
                @include('site/ultimas-noticias', ['variavel' => '$valor'])
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
