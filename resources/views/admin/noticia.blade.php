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
                    <div class="card-body mt-3">
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
                        <div class="container text-center ">
                            <!-- Botão para abrir o modal -->
                            <button type="button" class="btn btn-primary mt-3 btnModal" data-toggle="modal"
                                    data-target="#modalNoticia" data-rota="{{route('noticia.store')}}">
                               Criar Notícia
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="modalNoticia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <form method="POST" action="{{route('noticia.store')}}" name="noticiaForm" id="noticiaForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="exampleModalLabel">Criar Notícia</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-row">
                                                    <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Título da Notícia">
                                                </div>
                                                <div class="form-group  mt-3">
                                                    <input type="text" name="subtitulo" id="subtitulo" class="form-control" placeholder="SubTítulo da Notícia">
                                                </div>

                                                <div class="form-group  mt-3">
                                                    <textarea class="tinymce_editor" name="tinymce_editor" id="tinymce_editor"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-warning text-left text-white" data-toggle="modal" data-target="#exampleModalImage" style="margin-right: auto;">Abrir Galeria de Imagens </button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                <button type="submit" class="btn btn-primary">Salvar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal fade" id="exampleModalImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning  text-white">
                                            <h5 class="modal-title" id="exampleModalLabel">Galeria</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-row">
                                                <div class="card" style="height: 420px;overflow-y: auto;">
                                                    <section class="product-list-gallery">
                                                        @foreach($images as $image)
                                                            <div class="product-card-gallery">
                                                                <img src="{{URL::asset('storage/posts/files/'.$image->path)}}" class="resize-image-gallery" title="Inserir Image">
                                                            </div>
                                                        @endforeach
                                                    </section>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="modalConteudoNoticia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="exampleModalLabel">Conteúdo Completo da Notícia</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" id="modal-conteudo">
                                            <!-- O conteúdo será carregado aqui via JavaScript -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <section>
                    <table class="table datatable text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Titulo</th>
                                <th scope="col">SubTitulo</th>
                                <th scope="col">Conteudo</th>
                                <th scope="col">Status</th>
                                <th scope="col">Criado em:</th>
                                <th scope="col">Atualizado em:</th>
                                <th scope="col" colspan="2">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($noticias as $noticia)
                                <tr>
                                    <th scope="row">{{$noticia->id}}</th>
                                    <td>{{$noticia->titulo}}</td>
                                    <td>{{$noticia->subtitulo == "" ? "-" : $noticia->subtitulo}}</td>
                                    <td>
                                        <a href="#" class="ler-mais"
                                            data-toggle="modal"
                                            data-target="#modalConteudoNoticia"
                                            data-conteudo="{{ $noticia->conteudo }}">
                                            <i class="bi bi-eye-fill custom-icon-size text-success"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               title="Visualizar a Notícia">
                                            </i>
                                        </a>
                                    </td>
                                    <td class="align-middle">
                                        <div class="form-check form-switch mt-2">
                                            <input class="form-check-input statusSwitch"
                                                   type="checkbox"
                                                   data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="{{$noticia->status == 0 ? "Bloqueado, sem visualização no site." : "Liberado, para visualização no site."}}"
                                                   data-id="{{$noticia->id}}"
                                                   data-rota="{{route('atualizar-status')}}"
                                                   {{$noticia->status == 0 ? "" : "checked"}}>
                                        </div>
                                    </td>
                                    <td>{{$noticia->created_at}}</td>
                                    <td>{{$noticia->updated_at}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <i class="bi bi-trash custom-icon-size text-danger btn-excluir" style="cursor: pointer"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               title="Excluir Noticia"
                                               data-rota="{{route('noticia.destroy',$noticia->id)}}">
                                            </i>
                                            <i class="bi bi-pencil-square custom-icon-size text-info btn-editar" style="cursor: pointer"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               title="Editar Noticia"
                                               data-rota="{{route('noticia.edit',$noticia->id,'/edit')}}"
                                               data-rota-update="{{route('noticia.update',$noticia->id)}}">
                                            </i>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>
@endsection
@push("styles")
    <link rel="stylesheet" type="text/css" href="{{URL::asset('admin/assets/css/custom.css')}}">
@endpush
@push("scripts")
    <script src="{{URL::asset('admin/assets/js/custom.js')}}"></script>

@endpush
