@extends('partials.principal')

@section('titulo')
    Facturas
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/facturasLista.css') }}">
@endsection


@section('contenido')
    <div class="container  fondoListaFactura">
        <h2>Lista de Facturas</h2>
        <input class="form-control me-2 m-3" type="search" id="buscarFactura" placeholder="Buscar factura  por nombre o CC del cliente">
        <div id="facturas" class="row">

            <!-- lista de facturas -->
            
        </div>
    </div>

    @endsection



    @section('scrips')
        <script src="{{ asset('js/facturasLista.js') }}"></script>
    @endsection
