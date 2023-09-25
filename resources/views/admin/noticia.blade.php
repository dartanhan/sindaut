@extends('admin.layouts.layout')

@section('menu')

    @include('admin.menu')

@endsection

@section('content')

    <div class="pagetitle">

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item">Notícias</li>
                <li class="breadcrumb-item active">Criar Notícia</li>
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
                                <h5 class="card-title">Criar Notícia</h5>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"></label>
                                    <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Título">
                                </div>
                                <hr/>
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

    <script>
       /* tinymce.init({ selector:'textarea#descricao' ,
            language: 'pt_BR',
            plugins: 'advlist link image lists',
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | image | link',
            images_upload_url: '../admin/upload-imagem'});*/
    </script>
@endsection
