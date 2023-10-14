@extends('admin.layouts.layout')

@section('menu')

    @include('admin.menu')

@endsection

@section('content')

    <div class="pagetitle">

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item">Regsitro</li>
                <li class="breadcrumb-item active">Usuários </li>
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
                                Registro
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="POST" action="{{route('admin.store')}}" name="register" id="register" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="exampleModalLabel">Registro</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-row">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Nome</label>
                                                        <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus>
                                                        @error('name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">E-mail</label>
                                                        <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                                                        @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="password" class="form-label">Senha</label>
                                                        <input id="password" type="password" name="password" class="form-control" required>
                                                        @error('password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="password_confirmation" class="form-label">Confirme a Senha</label>
                                                        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
                                                    </div>
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
    <div class="card">
        <section class="product-list">
            <div class="col-lg-12">
                <div class="card">
                    <section>
                        <table class="table datatable text-center">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Email</th>
                                <th scope="col">Criado em:</th>
                                <th scope="col">Atualizado em:</th>
                                <th scope="col" colspan="2">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($usuarios as $usuario)
                                <tr>
                                    <th scope="row">{{$usuario->id}}</th>
                                    <td>{{$usuario->name}}</td>
                                    <td>{{$usuario->email}}</td>
                                    <td>{{$usuario->created_at}}</td>
                                    <td>{{$usuario->updated_at}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <i class="bi bi-trash custom-icon-size text-danger btn-excluir" style="cursor: pointer"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               title="Excluir Usuário"
                                               data-rota="">
                                            </i>
                                            <i class="bi bi-pencil-square custom-icon-size text-info btn-editar" style="cursor: pointer"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               title="Editar Usuário"
                                               data-rota=""
                                               data-rota-update="">
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
        </section>
    </div>
@endsection
@push("styles")
    <link rel="stylesheet" type="text/css" href="{{URL::asset('admin/assets/css/custom.css')}}">
@endpush
