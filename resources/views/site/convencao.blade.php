@extends('layouts.layout')

@section('menu')

    @include('site.menu')

@endsection

@section('content')

    <section id="contentSction">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <ol class="breadcrumb">
                    <li><a href="{{route('site.home')}}">Home</a></li>
                    <li><a href="#">Convenções Coletiva de Trabalho</a></li>

                </ol>
                <div class="left_content">
                    <div class="contact_area">
                        @if(!empty($convencoes))
                            <div>
                                {!!$convencao_descricao->descricao!!}
                            </div>
                            <table class="table text-center table-striped table-bordered" id="dataTableConvencao">
                                <thead class="bg-primary">
                                    <tr>
                                        <th width="350px">Convenção</th>
                                        <th width="100px">Período</th>
                                        <th width="50px">Data</th>
                                        <th width="50px">Arquivo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($convencoes as $key => $convencao)
                                        <tr>
                                            <td>{{$convencao->titulo_cct}}</td>
                                            <td>{{$convencao->data_cct}}</td>
                                            <td>{{$convencao->created_at}}</td>
                                            <td>

                                                <a href="../public/storage/posts/files/{{$convencoes[$key]->files[0]->path}}" target="_blank"
                                                   data-toggle="tooltip"
                                                   data-placement="top" title="Visualizar">
                                                    <img border="0" alt="" src="../public/images/pdf.png" width="35">
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <aside class="right_content">
                    @include('site/ultimas-noticias', ['variavel' => '$valor'])
                    @include('site/popular-post', ['variavel' => '$valor'])
                </aside>
            </div>
        </div>
    </section>
@endsection
@push("styles")
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css" />
@endpush
@push("scripts")
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
    <script src="{{URL::asset('admin/assets/js/convencao.js')}}"></script>
@endpush
