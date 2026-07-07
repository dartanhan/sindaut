@extends('layouts.layout')

@section('menu')

    @include('site.menu')

@endsection

@section('content')

<style>
    .home-card-hover {
        display: flex; 
        align-items: center;
        justify-content: center;
        position: relative; 
        overflow: hidden; 
        border-radius: 4px; 
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        transition: transform 0.3s, box-shadow 0.3s;
        height: 200px; /* fixed height for cards alignment */
        background-color: #fff;
    }
    .home-card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.25) !important;
    }
    .home-card-img {
        width: 100%; 
        height: 100%; 
        object-fit: contain; /* displays full image without cropping */
        background-color: #fff;
    }
</style>

<section id="contentSection">
    <!-- Top and Main Row -->
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12 left-column">
            <!-- Banner Slider -->
            <div style="margin-bottom: 25px;">
                @include('site/sliders', ['noticias' => $noticias->slice(0, 5)])
            </div>
            
            <!-- 3 Custom Cards Row -->
            <div class="row" style="margin-bottom: 25px; margin-left: -5px; margin-right: -5px;">
                @foreach($cards as $card)
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="padding-left: 5px; padding-right: 5px;">
                        <a href="{{ route('site.detalhe-card', $card->id) }}" class="home-card-hover">
                            @if($card->imagens && count($card->imagens) > 0 && !empty($card->imagens[0]->path))
                                <img src="{{ URL::asset('storage/posts/files/'.$card->imagens[0]->path) }}" alt="{{ $card->titulo }}" class="home-card-img">
                            @else
                                <img src="{{ URL::asset('images/volume.png') }}" alt="{{ $card->titulo }}" class="home-card-img">
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Sidebar Column -->
        <div class="col-lg-4 col-md-4 col-sm-12 right-column">
            @include('site/ultimas-noticias')
            @include('site/popular-post', ['variavel' => '$valor'])
        </div>
    </div>
</section>

@endsection
