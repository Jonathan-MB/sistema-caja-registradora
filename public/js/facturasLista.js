// facturas.js
$(document).ready(function(){
    $.ajax({
        url: '/sistema-caja-registradora/public/sale/info', 
        type: 'GET',
        dataType: 'json',
        success: function(data){
            generarListaFacturas(data);
        }
    });

    function generarListaFacturas(data) {
        var facturasHTML = '';
        data.forEach(function(factura) {
            facturasHTML += `
                <div class="card mb-3">
                    <div class="card-header">Factura #${factura.id}</div>
                    <div class="card-body">
                        <p><strong>Subtotal:</strong> $${factura.sales_subtotal}</p>
                        <p><strong>Total:</strong> $${factura.sales_total}</p>
                        <p><strong>Cliente:</strong> ${factura.user_name} (Nit/CC: ${factura.user_cc_nit}), Tipo: ${factura.user_type}</p>
                        <h5>Detalles:</h5>
                        <ul class="list-group">
            `;
            factura.details.forEach(function(detalle) {
                facturasHTML += `
                    <li class="list-group-item">Producto: ${detalle.product_name} (ID: ${detalle.product_id}), Cantidad: ${detalle.quantity_product}</li>
                `;
            });
            facturasHTML += `
                        </ul>
                    </div>
                </div>
            `;
        });
        $('#facturas').html(facturasHTML);
    }
});
