@extends('admin.layouts.layout')

@section('menu')

    @include('admin.menu')

@endsection

@section('content')

    <div class="pagetitle">

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Homologação</li>
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
                              <b>HOMOLOGAÇÃO</b>
                            </div>
                            <div class="card-body mt-3">
                                 <!-- Botão para abrir o modal -->
                                @if(empty($homologacao))
                                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#exampleModal">
                                        Cadastrar Homologação
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
                                    @if(!empty($homologacao))
                                        <tr>
                                            <td>
                                                {!! substr(strip_tags($homologacao->conteudo), 0, 50) !!} <!-- Exibe os primeiros 100 caracteres do conteúdo -->
                                                    @if(strlen(strip_tags($homologacao->conteudo)) > 20)
                                                        ... <!-- Adicione reticências para indicar que o conteúdo foi truncado -->
                                                @endif
                                            </td>
                                            <td>{{$homologacao->created_at}}</td>
                                            <td>{{$homologacao->updated_at}}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-check form-switch mt-2"  style="display: inline-block; vertical-align: middle;cursor: pointer">
                                                            <input class="form-check-input statusSwitch" style="text-align: center;cursor: pointer"
                                                                type="checkbox"
                                                                data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="{{$homologacao->status == 0 ? "Bloqueado, sem visualização no site." : "Liberado, para visualização no site."}}"
                                                                data-id="{{$homologacao->id}}"
                                                                data-rota="{{route('homologacao.status')}}"
                                                                {{$homologacao->status == 0 ? "" : "checked"}}>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div>
                                                            <a href="#" class="ler-mais"
                                                                data-toggle="modal"
                                                                data-target="#modalConteudo"
                                                                data-conteudo="{{ $homologacao->conteudo }}">

                                                                <i class="bi bi-eye-fill custom-icon-size text-success"
                                                                    data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="Visualizar a Homologação">
                                                                </i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div>
                                                            <span data-toggle="modal" data-target="#editModal">
                                                                <i class="bi bi-pencil-square custom-icon-size text-info" style="cursor: pointer"
                                                                    data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="Editar"
                                                                    data-rota="{{route('homologacao.edit',$homologacao->id,'/edit')}}"
                                                                    data-rota-update="{{route('homologacao.update',$homologacao->id)}}">
                                                                </i>
                                                            </span>
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
                <form method="POST" action="{{route('homologacao.store')}}" name="uploadForm" id="uploadForm" enctype="multipart/form-data">
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

    @if(!empty($homologacao))
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
                    {!!$homologacao->conteudo!!}
                </div>
            </div>
        </div>
    </div>

        <!-- Modal -->

            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-lg modal-md" role="document">
                    <form method="POST" action="{{route('homologacao.update',$homologacao->id)}}" name="uploadForm" id="uploadForm" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="exampleModalLabel">Editando Homologação</h5>
                            </div>
                            <div class="modal-body">
                                <div class="form-row">
                                    <textarea class="tinymce_editor" name="tinymce_editor" id="tinymce_editor">{!! $homologacao->conteudo !!}</textarea>
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
