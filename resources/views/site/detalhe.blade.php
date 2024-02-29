@extends('layouts.layout')

@section('menu')

    @include('site.menu')

@endsection

@section('content')

        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <div class="left_content">
                    <div class="single_page">
                        <ol class="breadcrumb">
                            <li><a href="{{route('site.home')}}">Home</a></li>
                            <li><a href="#">Noticia</a></li>
                            <li class="active">{{$noticiaDetalhe->titulo}}</li>
                        </ol>
                        <h1>{{$noticiaDetalhe->titulo}}</h1>
                        <div class="post_commentbox">
                            <!--a href="#">
                                <i class="fa fa-user"></i>Wpfreeware</a-->
                            <span>
                                <i class="fa fa-calendar"></i>{{$noticiaDetalhe->created_at}}
                            </span>
                            <!-- a href="#"><i class="fa fa-tags"></i>Technology</a -->
                        </div>
                        <div class="single_page_content">
                            {!! str_replace("../", "../../", $noticiaDetalhe->conteudo) !!}
                        </div>
                        <div class="social_link">
                            <ul class="sociallink_nav">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                            </ul>
                        </div>
                        <!--div class="related_post">
                            <h2>Related Post <i class="fa fa-thumbs-o-up"></i></h2>
                            <ul class="spost_nav wow fadeInDown animated animated" style="visibility: visible; animation-name: fadeInDown;">
                                <li>
                                    <div class="media"> <a class="media-left" href="single_page.html"> <img src="../images/post_img1.jpg" alt=""> </a>
                                        <div class="media-body"> <a class="catg_title" href="single_page.html"> Aliquam malesuada diam eget turpis varius</a> </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media"> <a class="media-left" href="single_page.html"> <img src="../images/post_img2.jpg" alt=""> </a>
                                        <div class="media-body"> <a class="catg_title" href="single_page.html"> Aliquam malesuada diam eget turpis varius</a> </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media"> <a class="media-left" href="single_page.html"> <img src="../images/post_img1.jpg" alt=""> </a>
                                        <div class="media-body"> <a class="catg_title" href="single_page.html"> Aliquam malesuada diam eget turpis varius</a> </div>
                                    </div>
                                </li>
                            </ul>
                        </div-->
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 right-column">
                @include('site/ultimas-noticias', ['variavel' => '$valor'])
                @include('site/popular-post', ['variavel' => '$valor'])
            </div>
        </div>

@endsection
