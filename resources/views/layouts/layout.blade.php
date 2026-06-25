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
        /* Ajustar imagens dentro do conteudo para nao estourarem a largura */
        .article-content img {
            max-width: 100% !important;
            height: auto !important;
        }

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
                            <li><a href="{{route('site.quemsomos.index')}}">Quem Somos</a></li>
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
    <footer id="footer" style="background:#111827; color:#e5e7eb; margin-top:0; padding:0;">
        @php
            $footerConfig = \App\Models\FooterConfig::config();
            $redesSociais = $footerConfig->redes_sociais ?? [];
            $faleConosco  = $footerConfig->fale_conosco  ?? [];
            $temSede      = $footerConfig->sede_telefone || $footerConfig->sede_email || $footerConfig->sede_endereco;
            $temSubsede   = $footerConfig->subsede_telefone || $footerConfig->subsede_endereco;
            $temFale      = !empty(array_filter($faleConosco, fn($r) => !empty($r['setor']) || !empty($r['telefone'])));
        @endphp

        {{-- Footer Body --}}
        <div style="padding: 36px 0 24px;">
            <div class="row" style="margin:0 15px; align-items:flex-start;">

                {{-- Logo --}}
                <div class="col-lg-2 col-md-3 col-sm-12" style="margin-bottom:20px; padding-right:20px;">
                    @if($footerConfig->logo_path)
                        <img src="{{ asset('storage/footer/' . $footerConfig->logo_path) }}"
                             alt="{{ $footerConfig->copyright ?? 'Logo' }}"
                             style="max-width:100px; max-height:70px; object-fit:contain;">
                    @else
                        <span style="font-size:14px; font-weight:800; letter-spacing:.5px; color:#9ca3af;">
                            {{ $footerConfig->copyright ?? 'SINDAUT-RIO' }}
                        </span>
                    @endif

                    {{-- Redes Sociais --}}
                    @php $redesAtivas = array_filter($redesSociais); @endphp
                    @if(!empty($redesAtivas))
                    <div style="display:flex; gap:10px; margin-top:14px; flex-wrap:wrap;">
                        @if(!empty($redesSociais['facebook']))
                            <a href="{{ $redesSociais['facebook'] }}" target="_blank" rel="noopener" style="color:#4b5563; font-size:16px; transition:color .2s;" onmouseover="this.style.color='#9ca3af'" onmouseout="this.style.color='#4b5563'">
                                <i class="fa fa-facebook-square"></i>
                            </a>
                        @endif
                        @if(!empty($redesSociais['instagram']))
                            <a href="{{ $redesSociais['instagram'] }}" target="_blank" rel="noopener" style="color:#4b5563; font-size:16px; transition:color .2s;" onmouseover="this.style.color='#9ca3af'" onmouseout="this.style.color='#4b5563'">
                                <i class="fa fa-instagram"></i>
                            </a>
                        @endif
                        @if(!empty($redesSociais['youtube']))
                            <a href="{{ $redesSociais['youtube'] }}" target="_blank" rel="noopener" style="color:#4b5563; font-size:16px; transition:color .2s;" onmouseover="this.style.color='#9ca3af'" onmouseout="this.style.color='#4b5563'">
                                <i class="fa fa-youtube-square"></i>
                            </a>
                        @endif
                    </div>
                    @endif
                </div>

                {{-- Fale Conosco --}}
                @if($temFale)
                <div class="col-lg-3 col-md-3 col-sm-12" style="margin-bottom:20px; padding-right:20px; border-right:1px solid #1f2937;">
                    <p style="font-size:9px; font-weight:800; letter-spacing:.18em; text-transform:uppercase; color:#4b5563; margin-bottom:12px;">FALE CONOSCO</p>
                    @foreach($faleConosco as $setor)
                        @if(!empty($setor['setor']) || !empty($setor['telefone']))
                        <div style="display:flex; align-items:baseline; gap:5px; margin-bottom:6px; flex-wrap:wrap;">
                            @if(!empty($setor['setor']))
                                <span style="font-size:10px; font-weight:700; letter-spacing:.04em; text-transform:uppercase; color:#6b7280; white-space:nowrap;">{{ $setor['setor'] }}:</span>
                            @endif
                            @if(!empty($setor['telefone']))
                                <span style="font-size:11px; font-weight:500; color:#9ca3af;">{{ $setor['telefone'] }}</span>
                            @endif
                        </div>
                        @endif
                    @endforeach
                </div>
                @endif

                {{-- Sede --}}
                @if($temSede)
                <div class="col-lg-3 col-md-3 col-sm-12" style="margin-bottom:20px; padding-right:20px; {{ $temSubsede ? 'border-right:1px solid #1f2937;' : '' }}">
                    <p style="font-size:9px; font-weight:800; letter-spacing:.18em; text-transform:uppercase; color:#4b5563; margin-bottom:12px;">ATENDIMENTO</p>
                    @if($footerConfig->sede_telefone)
                        <div style="display:flex; align-items:flex-start; gap:8px; margin-bottom:8px;">
                            <i class="fa fa-phone" style="color:#4b5563; font-size:10px; margin-top:2px; flex-shrink:0;"></i>
                            <span style="font-size:11px; font-weight:500; color:#9ca3af; text-transform:uppercase; line-height:1.5;">{{ $footerConfig->sede_telefone }}</span>
                        </div>
                    @endif
                    @if($footerConfig->sede_email)
                        <div style="display:flex; align-items:flex-start; gap:8px; margin-bottom:8px;">
                            <i class="fa fa-envelope" style="color:#4b5563; font-size:10px; margin-top:2px; flex-shrink:0;"></i>
                            <span style="font-size:11px; font-weight:500; color:#9ca3af; text-transform:uppercase; line-height:1.5;">{{ $footerConfig->sede_email }}</span>
                        </div>
                    @endif
                    @if($footerConfig->sede_endereco)
                        <div style="display:flex; align-items:flex-start; gap:8px; margin-bottom:8px;">
                            <i class="fa fa-map-marker" style="color:#4b5563; font-size:11px; margin-top:2px; flex-shrink:0;"></i>
                            <span style="font-size:11px; font-weight:500; color:#9ca3af; text-transform:uppercase; line-height:1.6;">{!! nl2br(e($footerConfig->sede_endereco)) !!}</span>
                        </div>
                    @endif
                </div>
                @endif

                {{-- Subsede --}}
                @if($temSubsede)
                <div class="col-lg-3 col-md-3 col-sm-12" style="margin-bottom:20px;">
                    <p style="font-size:9px; font-weight:800; letter-spacing:.18em; text-transform:uppercase; color:#4b5563; margin-bottom:12px;">SUBSEDE</p>
                    @if($footerConfig->subsede_telefone)
                        <div style="display:flex; align-items:flex-start; gap:8px; margin-bottom:8px;">
                            <i class="fa fa-phone" style="color:#4b5563; font-size:10px; margin-top:2px; flex-shrink:0;"></i>
                            <span style="font-size:11px; font-weight:500; color:#9ca3af; text-transform:uppercase; line-height:1.5;">{{ $footerConfig->subsede_telefone }}</span>
                        </div>
                    @endif
                    @if($footerConfig->subsede_endereco)
                        <div style="display:flex; align-items:flex-start; gap:8px; margin-bottom:8px;">
                            <i class="fa fa-map-marker" style="color:#4b5563; font-size:11px; margin-top:2px; flex-shrink:0;"></i>
                            <span style="font-size:11px; font-weight:500; color:#9ca3af; text-transform:uppercase; line-height:1.6;">{!! nl2br(e($footerConfig->subsede_endereco)) !!}</span>
                        </div>
                    @endif
                </div>
                @endif

                {{-- Fallback --}}
                @if(!$footerConfig->logo_path && !$temFale && !$temSede && !$temSubsede)
                <div class="col-12" style="text-align:center; color:#4b5563; font-size:11px; padding:20px 0;">
                    Configure as informações do rodapé no painel administrativo.
                </div>
                @endif

            </div>
        </div>

        {{-- Copyright bar --}}
        <div style="border-top:1px solid #1f2937; padding:12px 30px; text-align:center;">
            <p style="font-size:10px; font-weight:600; letter-spacing:.12em; color:#374151; margin:0; text-transform:uppercase;">
                &copy; <?php echo Carbon\Carbon::now()->locale('pt_BR')->isoFormat('YYYY'); ?>
                {{ $footerConfig->copyright ?? 'SINDAUT-RIO' }}. TODOS OS DIREITOS RESERVADOS.
            </p>
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
