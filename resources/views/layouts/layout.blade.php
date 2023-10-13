<!DOCTYPE html>
<html>
<head>
    <title>Sindaut</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/font.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/li-scroller.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/slick.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/jquery.fancybox.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/theme.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/style.css')}}">
    <!--[if lt IE 9]>
    <script src="{{URL::asset('assets/js/html5shiv.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/respond.min.js')}}"></script>
    <![endif]-->

</head>
<body>
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>
<a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
<div class="container">
    <header id="header">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="header_top">
                    <div class="header_top_left">
                        <ul class="top_nav">
                            <li><a href="{{route('site.home')}}">Home</a></li>
                            <li><a href="#">Quem Somos</a></li>
                            <li><a href="{{route('site.contato')}}">Contato</a></li>
                        </ul>
                    </div>
                    <div class="header_top_right text-capitalize">
                        <p><?php echo Carbon\Carbon::now()->locale('pt_BR')->isoFormat('dddd, DD MMMM YYYY');?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="header_bottom">
                    <!--div class="logo_area"><a href="{{route('site.home')}}" class="logo"><img src="{{URL::asset('assets/images/banner.jpg')}}" alt=""></a></div-->
                    <div class="add_banner"><img src="{{URL::asset('assets/images/banner.jpg')}}" alt=""></div>
                </div>
            </div>
        </div>
    </header>
    <section id="navArea">
        @yield('menu')
    </section>
    <section id="newsSection">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                @include('site/newsarea', ['variavel' => '$valor'])
            </div>
        </div>
    </section>

    <section id="contentSection">
        @yield('content')
    </section>
    <footer id="footer">
        <div class="footer_top">
            <div class="row">
                <!--div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="footer_widget wow fadeInLeftBig">
                        <h2>Flickr Images</h2>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="footer_widget wow fadeInDown">
                        <h2>Tag</h2>
                        <ul class="tag_nav">
                            <li><a href="#">Notícias</a></li>
                            <li><a href="#">Homologação</a></li>
                            <li><a href="#">Fashion</a></li>
                            <li><a href="#">Business</a></li>
                            <li><a href="#">Life &amp; Style</a></li>
                            <li><a href="#">Technology</a></li>
                            <li><a href="#">Photo</a></li>
                            <li><a href="#">Slider</a></li>
                        </ul>
                    </div>
                </div-->
                <div class="col-lg-6 col-md-4 col-sm-4">
                    <div class="footer_widget wow fadeInRightBig">
                        <h2>Contato</h2>
                        <p>Tel.: (21) 3077-2700 / 2242-1202  - E-mail: sindautrj@gmail.com</p>
                        <address>
                            Rua Andre Cavalcante 128  - CEP: 20231-050 -  Rio de Janeiro - RJ
                        </address>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer_bottom">
            <p class="copyright">Copyright &copy; <?php echo Carbon\Carbon::now()->locale('pt_BR')->isoFormat('YYYY');?></p>
        </div>
    </footer>
</div>
<script src="{{URL::asset('assets/js/jquery.min.js')}}"></script>
<script src="{{URL::asset('assets/js/wow.min.js')}}"></script>
<script src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/js/slick.min.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.li-scroller.1.0.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.newsTicker.min.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.fancybox.pack.js')}}"></script>
<script src="{{URL::asset('assets/js/custom.js')}}"></script>

@stack("scripts")

</body>
</html>
