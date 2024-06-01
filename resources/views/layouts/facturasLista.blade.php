@extends('partials.principal')

@section('titulo')
    Facturas
@endsection

@section('css')

@endsection


@section('contenido')
    
<div class="container">
    <h2>Lista de Facturas</h2>
    <div id="facturas" class="row">
        <!-- Aquí se generará la lista de facturas -->
    </div>
@endsection



@section('scrips')

<script src="{{asset('js/facturasLista.js')}}"></script>

@endsection
