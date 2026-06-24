<!DOCTYPE html>
<html>
<head>
    <title>SINDAUT-RIO</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
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
    @stack("styles")
    <style>
        /* Colapso de conteudo longo */
        .article-content.collapsible-active {
            max-height: 500px;
            overflow: hidden;
            position: relative;
            transition: max-height 0.4s ease-in-out;
        }
        .article-content.collapsible-active.expanded {
            max-height: 20000px; /* Suficiente para qualquer texto longo */
        }
        .article-content.collapsible-active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 120px;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0), rgba(255, 255, 255, 1));
            pointer-events: none;
            transition: opacity 0.3s ease;
            opacity: 1;
        }
        .article-content.collapsible-active.expanded::after {
            opacity: 0;
            pointer-events: none;
        }

        /* Botao Veja Mais */
        .read-more-container {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 25px;
            position: relative;
            z-index: 10;
        }
        .btn-read-more-toggle {
            background-color: #0d6efd;
            color: #fff;
            border: none;
            padding: 8px 24px;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 4px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
            transition: all 0.2s ease-in-out;
        }
        .btn-read-more-toggle:hover {
            background-color: #0b5ed7;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .btn-read-more-toggle i {
            margin-left: 5px;
        }

        /* Sidebar Sticky */
        @media (min-width: 992px) {
            #contentSection > .row, #contentSction > .row {
                display: flex;
                flex-wrap: wrap;
            }
            .right-column, aside.right_content {
                position: -webkit-sticky;
                position: sticky;
                top: 20px;
                height: fit-content;
            }
        }
    </style>
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
                    <div>
                        <a href="{{route('site.home')}}" style="display: block; width: 100%;">
                            <img src="{{URL::asset('assets/images/banner.jpg')}}" alt="" style="width: 100%; height: auto;">
                        </a>
                    </div>
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
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var articles = document.querySelectorAll('.article-content');
            articles.forEach(function(article) {
                // Se a altura do conteudo for maior que 600px, adiciona o colapso
                if (article.scrollHeight > 600) {
                    article.classList.add('collapsible-active');
                    
                    var btnContainer = document.createElement('div');
                    btnContainer.className = 'read-more-container';
                    
                    var btn = document.createElement('button');
                    btn.className = 'btn-read-more-toggle';
                    btn.innerHTML = 'Veja mais <i class="fa fa-chevron-down"></i>';
                    
                    btnContainer.appendChild(btn);
                    article.parentNode.insertBefore(btnContainer, article.nextSibling);
                    
                    btn.addEventListener('click', function() {
                        if (article.classList.contains('expanded')) {
                            article.classList.remove('expanded');
                            btn.innerHTML = 'Veja mais <i class="fa fa-chevron-down"></i>';
                            // Rola suavemente de volta para o topo do artigo
                            article.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        } else {
                            article.classList.add('expanded');
                            btn.innerHTML = 'Veja menos <i class="fa fa-chevron-up"></i>';
                        }
                    });
                }
            });
        });
    </script>
    @stack("scripts")

</body>
</html>
