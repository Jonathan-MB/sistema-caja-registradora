@extends('partials.principal')






@section('titulo')
    Facturacion
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/facturacion.css') }}">
@endsection


@section('contenido')
    {{-- Verificacion de si hay usuaroo registrado a quien hacer factura  --}}




    <div id="alertContainer" class="mt-3 m-3"></div>
    <div class="d-flex justify-content-center align-items-center contenedorCardInicio contenedorCardInicio"
        style="min-height: 100vh;">
        <div class="card text-white bg-secondary mb-3 cardInicio m-2">
            <div class="card-header d-flex justify-content-center align-items-center">
                <p class="tituloCard">Facturacion</p>
            </div>
            <div class="card-body">
                <div id="alertContainer"></div>
                <div class="mb-1 w-100">
                    <form method="POST" action="{{ route('sale.store') }}" id="userForm"
                        class="d-flex flex-column align-items-center">
                        @csrf
                        <label for="productoCode" id="productoCodeLabel" name="productoCodeLabel"
                            class="form-label labelRegister">Codigo
                            @if (isset($user))
                                <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}">
                            @else
                                <meta http-equiv="refresh" content="0; url=../">
                            @endif


                            Producto
                        </label>
                        <input type="text" class="form-control no-spinner " id="productoCode" maxlength="10"
                            name="productoCode" placeholder="XXXXXXXXX" required>

                        <label for="nombreLabel" class="form-label labelRegister">Nombre Producto</label>
                        <input type="text" class="form-control no-spinner " id="nombreProducto" maxlength="45"
                            name="nombreProducto" placeholder="Nombre" required>
                        <ul id="productList" class="list-group"></ul>

                        <label for="nombreLabel" class="form-label labelRegister">Cantidad</label>
                        <input type="number" class="form-control no-spinner " id="cantidadProducto" name="cantidadProducto"
                            min="1" max="100" name="cantidadProducto" placeholder="Cantidad" required>

                        <input type = "hidden" id="precioProductoHiden" name="precioProductoHiden"></input>

                        <input type = "hidden" id="subtotalcantidadHiden" name="subtotalcantidadHiden"></input>

                        <input type = "hidden" id="totalcantidadHiden" name="totalcantidadHiden"></input>


                        <label for="nombreLabel" class="form-label labelRegister">Precio Unitario</label>
                        <p id="precioProducto" name="precioProducto"></p>
                        <label for="nombreLabel" class="form-label labelRegister">Subtotal</label>
                        <p id="subtotalcantidad" name="subtotalcantidad"></p>
                        <label for="nombreLabel" class="form-label labelRegister">Total + 19 % iva</label>
                        <p id="totalcantidad" name="totalcantidad"></p>
                        <p class="textCard mt-3">Terminar venta y generar factura.</p>

                        <div class="d-flex flex-column align-items-center">
                            <button type="button" class="btn btn-warning btnCard" id="Agregar" disabled>Comprar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('scrips')
    <script src="{{ asset('js/facturar.js') }}"></script>
@endsection
