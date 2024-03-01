@extends('layouts.layout')

@section('menu')

    @include('site.menu')

@endsection

@section('content')

    <section id="contentSection">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <ol class="breadcrumb">
                    <li><a href="{{route('site.home')}}" >Home</a></li>
                    <li><a>Documentos Necessários</a></li>
                </ol>
                <div class="left_content">
                    <div class="contact_area">
                        @if(!empty($depjuridico))
                            {!! $depjuridico->conteudo !!}
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
