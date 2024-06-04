@extends('partials.principal')

@section('titulo')
    Detalle del Producto
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/productDetalle.css') }}">
    

@endsection

@section('contenido')
    <div class="contenedorCardInicio">
        <div class="card text-white mb-3 cardInicio">
            <div class="card-header d-flex justify-content-center align-items-center">
                <p class="tituloCard">Detalle del Producto</p>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <p><strong>Nombre del Producto :  </strong> {{ $product->product_name }}</p>
                <p><strong>Código del Producto :  </strong> {{ $product->product_code }}</p>
                <p><strong>Precio del Producto : $ </strong> {{ $product->product_price }}</p>
                <p><strong>Stock del Producto :  </strong> {{ $product->product_stock }}</p>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('product.edit', ['product' => $product->id]) }}" class="btn btn-primary">Editar</a>
                    <a href="{{ route('product.index') }}" class="btn btn-secondary">Lista Productos</a>
                </div>
            </div>
        </div>
    </div>
@endsection

