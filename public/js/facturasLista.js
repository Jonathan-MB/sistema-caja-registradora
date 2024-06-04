$(document).ready(function () {
    // Función para generar la lista de facturas
    function generarListaFacturas(data, filtro = '') {
        var facturasHTML = '';
        data.forEach(function (factura) {
            // Agregar filtrado por nombre o CC
            if ((factura.user_name && factura.user_name.toLowerCase().includes(filtro.toLowerCase())) ||
                (factura.user_cc_nit && factura.user_cc_nit.includes(filtro))) {
                facturasHTML += `
                    <a class="card mb-3 cartafactura" href="/sistema-caja-registradora/public/sale/${factura.id}">
                        <div class="card-header cabezaFactura">Factura #${factura.id}</div>
                        <div class="card-body">
                            <p><strong>Subtotal :</strong> $${parseFloat(factura.sales_subtotal).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</p>
                            <p><strong>Iva :</strong> $${(factura.sales_subtotal * 0.19).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</p>
                            <p><strong>Total a pagar : </strong> $${parseFloat(factura.sales_total).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</p>
                            <p><strong>Cliente:</strong> ${factura.user_name} (Nit/CC: ${factura.user_cc_nit}), <strong>Tipo :</strong> ${factura.user_type}</p>
                            <h5>Detalles:</h5>
                            <div class="row">
                                <div class="col">
                                    <ul class="list-group">
                `;
                factura.details.forEach(function (detalle) {
                    facturasHTML += `<li class="list-group-item">Nombre: ${detalle.product_name}</li>`;
                });
                facturasHTML += `
                                    </ul>
                                </div>
                                <div class="col">
                                    <ul class="list-group">
                `;
                factura.details.forEach(function (detalle) {
                    facturasHTML += `<li class="list-group-item">Codigo: ${detalle.code_product}</li>`;
                });
                facturasHTML += `
                                    </ul>
                                </div>
                                <div class="col">
                                    <ul class="list-group">
                `;
                factura.details.forEach(function (detalle) {
                    facturasHTML += `<li class="list-group-item">Cantidad: ${detalle.quantity_product}</li>`;
                });
                facturasHTML += `
                                    </ul>
                                </div>
                                <div class="col">
                                    <ul class="list-group">
                `;
                factura.details.forEach(function (detalle) {
                    facturasHTML += `<li class="list-group-item">Total: ${detalle.total_product.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</li>`;
                });
                facturasHTML += `
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </a>
                `;
            }
        });

        if (facturasHTML === '') {
            facturasHTML = '<p>No hay facturas relacionadas con este cliente. Revise si el cliente existe.</p>';
        }

        $('#facturas').html(facturasHTML);
    }

    // Cargar las facturas al inicio
    $.ajax({
        url: '/sistema-caja-registradora/public/sale/info',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            generarListaFacturas(data);
        }
    });

    // Escuchar el evento de entrada en el buscador
    $('#buscarFactura').on('input', function () {
        var filtro = $(this).val();
        $.ajax({
            url: '/sistema-caja-registradora/public/sale/info',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                generarListaFacturas(data, filtro);
            }
        });
    });
});
