@extends('partials.principal')

@section('contenido')
    <div class="container fondoListaFactura">
        <h2>Detalle de la Factura</h2>

        <div class="card mb-3 cartafactura m-3">
            <div class="card-header cabezaFactura">Factura #{{ $factura->id }}</div>
            <div class="card-body">
                <p><strong>Subtotal :</strong> $ {{ number_format($factura->sales_subtotal, 2, '.', ',') }}</p>
                <p><strong>Iva :</strong> $ {{ number_format($factura->sales_subtotal * 0.19, 2, '.', ',') }}</p>
                <p><strong>Total a pagar : </strong> $ {{ number_format($factura->sales_total, 2, '.', ',') }}</p>
                <p><strong>Cliente:</strong> {{ $factura->user_name }} (Nit/CC: {{ $factura->user_cc_nit }}),
                    <strong>Tipo : </strong>{{ $factura->user_type == 1 ?'Persona Natural' : 'Persoana Juridica' }}</p>
                <h5>Detalles:</h5>
                <div class="row">
                    <div class="col">
                        <ul class="list-group">
                            @foreach ($factura->details as $detalle)
                                <li class="list-group-item">Nombre: {{ $detalle->product_name }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col">
                        <ul class="list-group">
                            @foreach ($factura->details as $detalle)
                                <li class="list-group-item">Codigo: {{ $detalle->product_code }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col">
                        <ul class="list-group">
                            @foreach ($factura->details as $detalle)
                                <li class="list-group-item">Cantidad: {{ $detalle->quantity_product }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col">
                        <ul class="list-group">
                            @foreach ($factura->details as $detalle)
                                <li class="list-group-item">Total: {{ number_format($detalle->sale_detail_total, 2, '.', ',') }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        "></a>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/facturasLista.js') }}"></script>
@endsection
