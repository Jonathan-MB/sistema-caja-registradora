$(document).ready(function () {
    function validateForm() {
        var productoCode = $('#productoCode').val();
        var nombreProducto = $('#nombreProducto').val();
        var cantidadProducto = $('#cantidadProducto').val();
        var isValid = productoCode.length > 0 && nombreProducto.length > 0 && cantidadProducto.length > 0 && cantidadProducto > 0;
        $('#Agregar').prop('disabled', !isValid);
    }

    function searchProduct(query, callback) {
        $.ajax({
            url: "/sistema-caja-registradora/public/product/search",
            type: "GET",
            data: { 'query': query },
            success: function (data) {
                callback(data);
            },
            error: function () {
                $('#productList').empty();
                $('#productList').append('<li class="list-group-item">Error al buscar productos</li>');
            }
        });
    }

    $('#nombreProducto').on('keyup', function () {
        var query = $(this).val();
        if (query.length > 0) {
            searchProduct(query, function (data) {
                $('#productList').empty();
                if (data.length > 0) {
                    data.forEach(function (product) {
                        $('#productList').append('<li class="list-group-item" data-code="' + product.product_code + '">' + product.product_name + '</li>');
                    });
                } else {
                    $('#productList').append('<li class="list-group-item">No se encontraron productos</li>');
                }
            });
        } else {
            $('#productList').empty();
        }
    });

    $('#productoCode').on('keyup', function () {
        var code = $(this).val();
        if (code.length > 0) {
            searchProduct(code, function (data) {
                if (data.length > 0) {
                    $('#nombreProducto').val(data[0].product_name);
                } else {
                    $('#nombreProducto').val('');
                }
                validateForm();
            });
        } else {
            $('#nombreProducto').val('');
            validateForm();
        }
    });

    $(document).on('click', '.list-group-item', function () {
        var productName = $(this).text();
        var productCode = $(this).data('code');
        $('#nombreProducto').val(productName);
        $('#productoCode').val(productCode);
        $('#productList').empty();
        validateForm();
    });

    $('#cantidadProducto').on('input', function () {
        validateForm();
        updatePrice();
    });

    $('#productoCode, #nombreProducto, #cantidadProducto').on('keyup change', function () {
        validateForm();
        updatePrice();
    });

    function updatePrice() {
        var cantidadProducto = parseFloat($('#cantidadProducto').val());
        var productoCode = $('#productoCode').val();
        var unidad = $('#precioProducto');
        var subtotal = $('#subtotalcantidad');

        $.ajax({
            url: "/sistema-caja-registradora/public/product/getPrice",
            type: "GET",
            data: { 'productoCode': productoCode },
            success: function (data) {
                if (data && data.product_price) {
                    var precioUnitario = parseFloat(data.product_price);
                    var precioTotal = cantidadProducto * precioUnitario;
                    unidad.text('$' + precioUnitario.toFixed(2));
                    subtotal.text('$' + precioTotal.toFixed(2));
                } else {
                    console.log(data);
                    subtotal.text('Precio no disponible');
                }
            },
            error: function () {
                subtotal.text('Error al obtener el precio');
            }
        });
    }

    $('#cantidadProducto').on('input', function () {
        var cantidadIngresada = $(this).val();
        var cantidadValidada = cantidadIngresada.replace(/[^\d]/g, '');
        $(this).val(cantidadValidada);
        validateForm();
        updatePrice();
    });

    validateForm();
});
