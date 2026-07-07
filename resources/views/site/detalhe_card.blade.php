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
                    <li><a href="#">Destaque</a></li>
                    <li class="active">{{$card->titulo}}</li>
                </ol>
                <h1>{{$card->titulo}}</h1>
                
                <div class="post_commentbox">
                    @php
                        $criado = $card->getRawOriginal('created_at');
                        $atualizado = $card->getRawOriginal('updated_at');
                        $mostraAtualizado = $criado && $atualizado && (strtotime($atualizado) - strtotime($criado) > 60);
                        
                        $textoLimpo = strip_tags($card->conteudo);
                        $palavras = count(explode(' ', preg_replace('/\s+/', ' ', trim($textoLimpo))));
                        $tempoLeitura = max(1, ceil($palavras / 200));
                    @endphp
                    <span>
                        <i class="fa fa-calendar"></i> Publicado em: {{$card->created_at}}
                    </span>
                    @if($mostraAtualizado)
                        &nbsp;&nbsp;
                        <span>
                            <i class="fa fa-history"></i> Atualizado em: {{$card->updated_at}}
                        </span>
                    @endif
                    &nbsp;&nbsp;
                    <span>
                        <i class="fa fa-clock-o"></i> {{$tempoLeitura}} min de leitura
                    </span>
                </div>

                @if($card->imagens && count($card->imagens) > 0 && !empty($card->imagens[0]->path))
                    <div style="margin-top: 25px; margin-bottom: 25px; text-align: center;">
                        <img src="{{ asset('storage/posts/files/'.$card->imagens[0]->path) }}" alt="{{ $card->titulo }}" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                    </div>
                @endif

                <div class="single_page_content article-content">
                    {!! str_replace("../", "../../", $card->conteudo) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 right-column">
        @include('site/ultimas-noticias')
        @include('site/popular-post')
    </div>
</div>
@endsection
