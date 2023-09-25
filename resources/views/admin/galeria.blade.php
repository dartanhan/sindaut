@extends('admin.layouts.layout')

@section('menu')

    @include('admin.menu')

@endsection

@section('content')

    <div class="pagetitle">

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item">Noticas</li>
                <li class="breadcrumb-item active">Galeria de Imagens </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div>
                <div class="card">
                    <div class="card-body">

                        <form method="POST" action="{{route('uploadImagem')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">

                                <div class="form-group">
                                    <textarea class="tinymce-editor" name="tinymce-editor" id="tinymce-editor"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
