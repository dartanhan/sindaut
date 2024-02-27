@extends('layouts.layout')

@section('menu')

    <nav class="navbar navbar-inverse" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav main_nav">
                <li class="active">
                    <a href="{{route('site.home')}}">
                        <span class="fa fa-home desktop-home"></span>
                        <span class="mobile-show">Home</span></a>
                </li>
                <li><a href="{{route('site.historia.index')}}">História</a></li>
                <li><a href="#">Homologação</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Benefícios</a>
                    <!--ul class="dropdown-menu" role="menu">
                        <li><a href="#">Como Obter</a></li>
                        <li><a href="#">Convênios</a></li>
                    </ul-->
                </li>
                <li><a href="{{route('site.convencao.index')}}">Convenções</a></li>
                <li><a href="#">Departamento Jurídico</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Outros</a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Balcão de Empregos</a></li>
                        <li><a href="#">Contribuições</a></li>
                        <li><a href="#">Enquadramento Sindical</a></li>
                        <li><a href="#">Empresas</a></li>
                    </ul>
                </li>
                <li><a href="#">Notícias</a></li>
            </ul>
        </div>
    </nav>

@endsection

