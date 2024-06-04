<header class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="d-flex align-items-center">
            <a class="navbar-brand" href="{{asset('/')}}">
                <img src="{{ asset('img/logoCaja.png') }}" class="d-inline-block align-text-top" id="logoCaja" alt="Logo">
            </a>
            <h1 class="tituloHeader">Sistema De Registro</h1>
        </a>
        <div class="justify-content-between">
            <a type="button" class="btn btn-light" href="{{asset('user/create')}} ">Registrar Usuario</a>
            <a type="button" class="btn btn-light" href="{{asset('sale/create')}} ">Facturar</a>
            <a type="button" class="btn btn-light" href="{{asset('product')}} ">Productos</a>
            <a type="button" class="btn btn-light" href="{{asset('user')}} ">Usuarios</a>
            <a type="button" class="btn btn-light" href="{{asset('sale')}} ">Facturas</a>

        </div>
    </div>
</header>

