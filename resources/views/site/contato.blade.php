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
                        <form method="post" action="{{route('site.enviaContato')}}" class="contact_form">
                            @csrf
                            <label id="nome-error" class="error" for="nome"></label>
                            <input class="form-control" type="text" name="nome" placeholder="Nome*">

                            <label id="email-error" class="error" for="email"></label>
                            <input class="form-control" type="email" name="email" placeholder="Email*">

                            <label id="mensagem-error" class="error" for="mensagem"></label>
                            <textarea class="form-control" cols="30" rows="10" name="mensagem" placeholder="Mensagem*"></textarea>

                            <label id="g-recaptcha-response-error" class="error" for="g-recaptcha-response"></label>
                            <div class="g-recaptcha" data-sitekey="{{ env('DATA_SITE_KEY') }}"></div>
                            <input type="submit" value="Enviar">
                        </form>
                    </div>
                    <div class="form-group col-lg-8 mx-auto d-flex align-items-center my-4">
                        @if($errors->all())
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <aside class="right_content">
                    @include('site/ultimas-noticias', ['variavel' => '$valor'])
                    @include('site/popular-post', ['variavel' => '$valor'])
                    <!--div class="single_sidebar">
                        <h2><span>Popular Post</span></h2>
                        <ul class="spost_nav">
                            <li>
                                <div class="media wow fadeInDown"> <a href="single_page.html" class="media-left"> <img alt="" src="../images/post_img1.jpg"> </a>
                                    <div class="media-body"> <a href="single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 1</a> </div>
                                </div>
                            </li>
                            <li>
                                <div class="media wow fadeInDown"> <a href="single_page.html" class="media-left"> <img alt="" src="../images/post_img2.jpg"> </a>
                                    <div class="media-body"> <a href="single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 2</a> </div>
                                </div>
                            </li>
                            <li>
                                <div class="media wow fadeInDown"> <a href="single_page.html" class="media-left"> <img alt="" src="../images/post_img1.jpg"> </a>
                                    <div class="media-body"> <a href="single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 3</a> </div>
                                </div>
                            </li>
                            <li>
                                <div class="media wow fadeInDown"> <a href="single_page.html" class="media-left"> <img alt="" src="../images/post_img2.jpg"> </a>
                                    <div class="media-body"> <a href="single_page.html" class="catg_title"> Aliquam malesuada diam eget turpis varius 4</a> </div>
                                </div>
                            </li>
                        </ul>
                    </div-->
                </aside>
            </div>
        </div>
    </section>
@endsection
@push("scripts")
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
     <script src="{{URL::asset('/js/site.js')}}"></script>
@endpush
