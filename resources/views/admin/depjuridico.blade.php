@extends('admin.layouts.layout')

@section('menu')

    @include('admin.menu')

@endsection

@section('content')

    <div class="pagetitle">

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Documentos Necessários</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
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
                <section>
                    <div class="container mt-3">
                        <div class="card">
                            <div class="card-header text-center bg-primary text-white">
                              <b>DEP JURIDICO - DOCUMENTOS NECESSÁRIOS</b>
                            </div>
                            <div class="card-body mt-3">
                                 <!-- Botão para abrir o modal -->
                                @if(empty($depjuridico))
                                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#exampleModal">
                                        Cadastrar
                                    </button>
                                @endif
                                <table class="table datatable text-center ">
                                    <thead>
                                        <tr>
                                            <th scope="col">Conteúdo:</th>
                                            <th scope="col">Criado em:</th>
                                            <th scope="col">Atualizado em:</th>
                                            <th scope="col" colspan="2" width="250px">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($depjuridico))
                                        <tr>
                                            <td>
                                                {!! substr(strip_tags($depjuridico->conteudo), 0, 50) !!} <!-- Exibe os primeiros 100 caracteres do conteúdo -->
                                                    @if(strlen(strip_tags($depjuridico->conteudo)) > 20)
                                                        ... <!-- Adicione reticências para indicar que o conteúdo foi truncado -->
                                                @endif
                                            </td>
                                            <td>{{$depjuridico->created_at}}</td>
                                            <td>{{$depjuridico->updated_at}}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-check form-switch mt-2"  style="display: inline-block; vertical-align: middle;cursor: pointer">
                                                            <input class="form-check-input statusSwitch" style="text-align: center;cursor: pointer"
                                                                type="checkbox"
                                                                data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="{{$depjuridico->status == 0 ? "Bloqueado, sem visualização no site." : "Liberado, para visualização no site."}}"
                                                                data-id="{{$depjuridico->id}}"
                                                                data-rota="{{route('depjuridico.status')}}"
                                                                {{$depjuridico->status == 0 ? "" : "checked"}}>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div>
                                                            <a href="#" class="ler-mais"
                                                                data-toggle="modal"
                                                                data-target="#modalConteudo"
                                                                data-conteudo="{{ $depjuridico->conteudo }}">

                                                                <i class="bi bi-eye-fill custom-icon-size text-success"
                                                                    data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="Visualizar">
                                                                </i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div>
                                                            <i class="bi bi-pencil-square custom-icon-size text-info" style="cursor: pointer"
                                                                data-toggle="modal"
                                                                data-target="#editModal"
                                                                data-placement="top"
                                                                title="Editar"
                                                                data-rota="{{route('depjuridico.edit',$depjuridico->id,'/edit')}}"
                                                                data-rota-update="{{route('depjuridico.update',$depjuridico->id)}}">
                                                            </i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
     <!-- Modal -->
     <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-lg modal-md" role="document">
                <form method="POST" action="{{route('depjuridico.store')}}" name="uploadForm" id="uploadForm" enctype="multipart/form-data">
                @csrf
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="exampleModalLabel">Homologação</h5>
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

    @if(!empty($depjuridico))
    <div class="modal fade" id="modalConteudo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Conteúdo Completo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-conteudo">
                    <!-- O conteúdo será carregado aqui via JavaScript -->
                    {!!$depjuridico->conteudo!!}
                </div>
            </div>
        </div>
    </div>

        <!-- Modal -->

            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-lg modal-md" role="document">
                    <form method="POST" action="{{route('depjuridico.update',$depjuridico->id)}}" name="uploadForm" id="uploadForm" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="exampleModalLabel">Editando</h5>
                            </div>
                            <div class="modal-body">
                                <div class="form-row">
                                    <textarea class="tinymce_editor" name="tinymce_editor" id="tinymce_editor">{!! $depjuridico->conteudo !!}</textarea>
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
        @endif
    </div>
@endsection
@push("styles")
    <link rel="stylesheet" type="text/css" href="{{URL::asset('admin/assets/css/custom.css')}}">
@endpush
@push("scripts")
    <script src="{{URL::asset('admin/assets/js/custom.js')}}"></script>
@endpush
