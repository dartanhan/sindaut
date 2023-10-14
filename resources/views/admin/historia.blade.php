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
                            @if(empty($historia))
                            <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#exampleModal">
                                Cadastrar História
                            </button>
                            @else
                            <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#editModal">
                                Editar História
                            </button>
                            @endif
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-lg modal-md" role="document">
                                    <form method="POST" action="{{route('historia.store')}}" name="uploadForm" id="uploadForm" enctype="multipart/form-data">
                                    @csrf
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="exampleModalLabel">História</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-row">
                                                    <textarea class="tinymce_editor" name="tinymce_editor" id="tinymce_editor"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                <button type="submit" class="btn btn-primary">Salvar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-lg modal-md" role="document">
                                    <form method="POST" action="{{route('historia.update',$historia->id)}}" name="uploadForm" id="uploadForm" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="exampleModalLabel">Editando História</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-row">
                                                    <textarea class="tinymce_editor" name="tinymce_editor" id="tinymce_editor">{!! $historia->conteudo !!}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                <button type="submit" class="btn btn-primary">Salvar</button>
                                            </div>
                                        </div>
                                    </form>
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
                    <div class="container mt-3">
                        <div class="card">
                            <div class="card-header text-center bg-primary text-white">
                              <b>HISTÓRIA</b>
                            </div>
                            <div class="card-body mt-3">
                                {!! $historia->conteudo !!}
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>


@endsection
@push("styles")
    <link rel="stylesheet" type="text/css" href="{{URL::asset('admin/assets/css/custom.css')}}">
@endpush
