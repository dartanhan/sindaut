@extends('layouts.layout')

@section('menu')

    @include('site.menu')

@endsection

@section('content')
    <div>
    <button wire:click="openModal">Adicionar Produto</button>

    @if($showModal)
        <div>
            <input wire:model="productName" type="text" placeholder="Nome do Produto">
            <button wire:click="addProduct">Adicionar</button>
            <button wire:click="closeModal">Fechar</button>
        </div>
    @endif

    <table>
        <thead>
        <tr>
            <th>Nome do Produto</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
