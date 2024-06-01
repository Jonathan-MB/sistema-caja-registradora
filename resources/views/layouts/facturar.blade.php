@extends('partials.principal')






@section('titulo')
    Facturacion
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/facturacion.css') }}">
@endsection


@section('contenido')
    <div class="contenedorFinalizarCompra">
        <form class="">
            
            <p id="usuarioRegistadoName"></p>
            <button type="button" class="btn btn-danger btnCard finalizaCompra" id="finalizaCompra" >FINALIZAR COMPRA</button>
        </form>
    </div>
    <div id="alertContainer" class="mt-3"></div>
    <div class="d-flex justify-content-center align-items-center contenedorCardInicio" style="min-height: 100vh;">
        <div class="card text-white bg-secondary mb-3 cardInicio">
            <div class="card-header d-flex justify-content-center align-items-center">
                <p class="tituloCard">Facturacion</p>
            </div>
            <div class="card-body">
                <div id="alertContainer"></div>
                <form id="userForm" class="d-flex flex-column align-items-center" @csrf <div class="mb-1 w-100">
                    <label for="ccNit" id="productoCodeLabel" class="form-label labelRegister">Codigo
                        Producto</label>
                    <input type="text" class="form-control no-spinner " id="productoCode" maxlength="10"
                        name="productoCode" placeholder="XXXXXXXXX" required>

                    <label for="nombreLabel" class="form-label labelRegister">Nombre Producto</label>
                    <input type="text" class="form-control no-spinner " id="nombreProducto" maxlength="45"
                        name="nombreProducto" placeholder="Nombre" required>
                    <ul id="productList" class="list-group"></ul>

                    <label for="nombreLabel" class="form-label labelRegister">Cantidad</label>
                    <input type="number" class="form-control no-spinner " id="cantidadProducto" min="1"
                        max="100" name="cantidadProducto" placeholder="Cantidad" required>

                    <label for="nombreLabel" class="form-label labelRegister">Precio Unitario</label>
                    <p id="precioProducto"></p>
                    <label for="nombreLabel" class="form-label labelRegister">subtotal</label>
                    <p id="subtotalcantidad"></p>
                    <p class="textCard mt-3">Terminar venta y generar factura.</p>

                    <div class="d-flex flex-column align-items-center">
                        <button type="button" class="btn btn-warning btnCard" id="Agregar" disabled>Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection



@section('scrips')
    <script src="{{ asset('js/factAutoCompl.js') }}"></script>
    <script src="{{ asset('js/btnRegistrar.js') }}"></script>
@endsection
