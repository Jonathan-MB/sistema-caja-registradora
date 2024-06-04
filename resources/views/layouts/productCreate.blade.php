@extends('partials.principal')

@section('titulo')
    Registro Productos
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/productCreate.css')}}">
@endsection

@section('contenido')
    <div class="d-flex justify-content-center align-items-center contenedorCardInicio" style="min-height: 100vh;">
        <div class="card text-dark cardInicio">
            <div class="card-header d-flex justify-content-center align-items-center bg-secondary">
                <p class="tituloCard">Registro de Productos</p>
            </div>
            <div class="card-body">
                <div id="alertContainer"></div>

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <form id="userForm" class="d-flex flex-column align-items-center" action="{{ route('product.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 w-100">
                        <label for="productName" class="form-label labelRegister">Nombre Producto</label>
                        <input type="text" class="form-control no-spinner" id="productName" maxlength="45" name="productName" value="{{ old('productName') }}" required placeholder="Nombre Producto">
                        @error('productName')
                            <p>{{ $errors->first('productName') }}</p>
                        @enderror

                        <label for="productCode" class="form-label labelRegister">Codigo Producto</label>
                        <input type="text" class="form-control no-spinner" id="productCode" maxlength="40" name="productCode" value="{{ old('productCode') }}" required placeholder="Máximo 40 caracteres">
                        @error('productCode')
                            <p>{{ $errors->first('productCode') }}</p>
                        @enderror
                    
                        <label for="productPrice" class="form-label labelRegister">Precio Unidad</label>
                        <input type="number" class="form-control no-spinner" step="0.01" min="0.00" max="9999999.99" pattern="\d+(\.\d{2})?" id="productPrice" name="productPrice" value="{{ old('productPrice') }}" required>
                        @error('productPrice')
                            <p>{{ $errors->first('productPrice') }}</p>
                        @enderror
                    
                        <label for="productStock" class="form-label labelRegister">Stock</label>
                        <input type="number" class="form-control no-spinner" id="productStock" step="1" min="0" maxlength="45" name="productStock" value="{{ old('productStock') }}" required>
                        @error('productStock')
                            <p>{{ $errors->first('productStock') }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-warning btnCard" id="registrar">Registrar</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/productCreate.js') }}"></script>
@endsection
