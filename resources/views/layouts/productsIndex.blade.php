@extends('partials.principal')

@section('titulo')
    Listado de Productos
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/productIndex.css') }}">
@endsection

@section('contenido')
    <div class="d-flex justify-content-center align-items-center contenedorCardInicio" style="min-height: 100vh;">
        <div class="card text-dark cardInicio w-75 m-1">
            <div class="card-header d-flex justify-content-between align-items-center bg-secondary">
                <p class="tituloCard">Listado de Productos</p>
                <form class="d-flex" action="{{ route('product.index') }}" method="GET">
                    @csrf
                    <input class="form-control me-2" type="search" name="search" placeholder="Nombre o Codigo"
                        aria-label="Search" value="{{ request('search') }}">
                        
                    <button class="btn btn-warning btnCard" type="submit">Buscar</button>
                </form>
                
                <form class="d-flex m-1" action="{{ route('product.index') }}" method="GET">
                    @csrf
                    <input class="form-control me-2" type="hidden" name="search2" placeholder="Nombre o Codigo"
                        aria-label="Search" value="{{ request('search') }}">
                    <button class="btn btn-warning btnCard2" type="submit">Todos</button>
                </form>
            </div>

            
            <div class="card-body">
                @if ($products->isEmpty())
                    <div class="alert alert-warning" role="alert">
                        No se encontraron productos.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Código</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr  onclick="window.location='{{ route('product.show', $product->id) }}'">
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->product_code }}</td>
                                        <td>{{ $product->product_price }}</td>
                                        <td>
                                            @if ($product->product_stock > 0)
                                                {{ $product->product_stock }}
                                            @else
                                                <span class="stock-agotado">Agotado</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $products->links('pagination::bootstrap-4') }}
                @endif
            </div>
        </div>
    </div>
@endsection
