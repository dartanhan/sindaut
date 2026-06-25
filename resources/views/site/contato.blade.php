@extends('layouts.layout')

@section('menu')

    @include('site.menu')

@endsection

@section('content')

    <section id="contentSection">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <div class="left_content">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('danger'))
                        <div class="alert alert-danger">
                            {{ session('danger') }}
                        </div>
                    @endif
                    <div class="contact_area">
                        <h2>Contato</h2>
                        <span class="text-center"><p>Tel.: (21) 3077-2700 / 2242-1202 - E-mail: sindautrj@gmail.com</p></span>
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

