@extends('admin.layouts.layout')

@section('menu')

    @include('admin.menu')

@endsection

@section('content')

    <div class="pagetitle">

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Convenção Coletiva de Trabalho</li>
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
                            <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#exampleModal">
                                Cadastrar Convenção
                            </button>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-lg modal-md" role="document">
                                    <form method="POST" action="{{route('convencao.store')}}" name="uploadForm" id="uploadForm" enctype="multipart/form-data">
                                    @csrf
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="exampleModalLabel">Cadastro de Convenção Coletiva de Trabalho - CCT</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group" style="text-align: left;">
                                                    <label for="titulo"><strong>Título da CCT</strong></label>
                                                    <input type="text" name="titulo" id="titulo"
                                                           class="form-control"
                                                           placeholder="Título da CCT que irá aparecer no SITE"
                                                           data-toggle="tooltip"
                                                           data-placement="top"
                                                           title="Título da CCT">
                                                </div>
                                                <div class="form-group" style="text-align: left;">
                                                    <label><strong>Data da CCT:</strong></label>
                                                    <input type="text" name="data_cct" id="data_cct"
                                                           class="form-control"
                                                           placeholder="Exemplo: 2023/2024" maxlength="9"
                                                           data-toggle="tooltip"
                                                           data-placement="top"
                                                           title="Data da CCT">
                                                </div>
                                                <div class="form-group  mt-3"  style="text-align: left;">
                                                    <label><strong>Descrição da CCT</strong></label>
                                                    <textarea type="text" name="descricao_cct" id="descricao_cct"
                                                              class="form-control"
                                                              placeholder="Opcional! Descrição da CCT caso queira informar algo aos usuários." 
                                                              data-toggle="tooltip"
                                                              data-placement="top"
                                                              title="Descrição da CCT"></textarea>
                                                </div>
                                                <div class="form-group mt-3">
                                                        <input type="file" name="image" id="image" class="filepond"/>
                                                </div>
                                               <!-- div class="form-group  mt-3">
                                                    <textarea class="tinymce_editor" name="tinymce_editor" id="tinymce_editor"></textarea>
                                                </div-->
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
                    <div class="card-header text-center bg-primary text-white">
                        <b>CONVENÇÕES COLETIVAS</b>
                    </div>
                    <div class="card-body mt-3">
                        <table class="table datatable text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Descrição:</th>
                                    <th scope="col">Titulo:</th>
                                    <th scope="col">Data CCT:</th>
                                    <th scope="col">Arquivo:</th>
                                    <th scope="col">Criado em:</th>
                                    <th scope="col">Atualizado em:</th>
                                    <th scope="col" colspan="2">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">

                                @foreach($convencoes as $convencao)
                                    @foreach($convencao['files'] as $key => $file)
                                        @php
                                            /** @var TYPE_NAME $imagem */
                                            $filePath = $file->path;
                                        @endphp
                                    @endforeach
                                <tr>
                                    <td>{{$convencao->descricao_cct}}</td>
                                    <td>{{$convencao->titulo_cct}}</td>
                                    <td>{{$convencao->data_cct}}</td>
                                    <td>
                                        <a href="../public/storage/posts/files/{{$filePath}}" target="_blank"  
                                            data-toggle="tooltip"
                                            data-placement="top" title="Visualizar arquivo">
                                            <img border="0" alt="" src="../public/images/jornal.png" width="100" height="100">
                                        </a>
                                    </td>
                                    <td>{{$convencao->created_at}}</td>
                                    <td>{{$convencao->updated_at}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <i class="bi bi-trash custom-icon-size text-danger btn-excluir" style="cursor: pointer"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Excluir Convenção"
                                                data-rota="{{route('convencao.destroy',$convencao->id)}}">
                                            </i>
                                            <i class="bi bi-pencil-square custom-icon-size text-info btn-editar" style="cursor: pointer"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Editar Convenção"
                                                data-rota="{{route('convencao.edit',$convencao->id,'/edit')}}"
                                                data-rota-update="{{route('convencao.update',$convencao->id)}}">
                                            </i>
                                        </div>
                                    </td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
@push("styles")
    <link rel="stylesheet" type="text/css" href="{{URL::asset('admin/assets/css/custom.css')}}">
@endpush
@push("scripts")
    <script src="{{URL::asset('admin/assets/js/file-pond.js')}}"></script>
@endpush
