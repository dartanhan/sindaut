@extends('layouts.layout')

@section('menu')
    @include('site.menu')
@endsection

@section('content')
    <section id="contentSection">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <ol class="breadcrumb">
                    <li><a href="{{route('site.home')}}">Home</a></li>
                    <li><a>Enquadramento Sindical</a></li>
                </ol>
                <div class="left_content">
                    <div class="contact_area article-content">
                        @if(!empty($enquadramento))
                            {!! $enquadramento->conteudo !!}
                        @else
                            <div class="alert alert-info" style="margin-top: 20px;">
                                Nenhum conteúdo cadastrado para Enquadramento Sindical no momento.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <aside class="right_content">
                    @include('site/ultimas-noticias', ['variavel' => '$valor'])
                    @include('site/popular-post', ['variavel' => '$valor'])
                </aside>
            </div>
        </div>
    </section>
@endsection