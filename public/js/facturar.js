$(document).ready(function () {

    var saleDetails = [];

    function verificarProducto() {
        var productoCode = $('#productoCode').val();
        var cantidadProducto = $('#cantidadProducto').val();

        $.ajax({
            url: "/sistema-caja-registradora/public/product/check",
            type: "GET",
            data: { 'productoCode': productoCode, 'cantidadProducto': cantidadProducto },
            success: function (data) {
                if (data.exists && data.enoughStock) {
                    var saleDetail = {
                        product_code: productoCode,
                        product_precio: data.productPrice,
                        quantity_product: cantidadProducto
                    };
                    saleDetails.push(saleDetail);
                    $('#userForm').submit();
                } else {
                    var message = data.exists ? "Stock insuficiente. Stock disponible: " + data.stockDisponible : "Código de producto incorrecto.";
                    var alertType = data.exists ? "warning" : "danger";
                    var alertHTML = '<div class="alert alert-' + alertType + ' alert-dismissible fade show" role="alert">' +
                        message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '</div>';
                    $('#alertContainer').html(alertHTML);
                }
            },
            error: function () {
                var errorMessage = "Error al verificar el producto. Por favor, inténtalo de nuevo.";
                var errorAlert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                    errorMessage +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>';
                $('#alertContainer').html(errorAlert);
            }
        });
    }

    $('#Agregar').on('click', function () {
        verificarProducto();
    });

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
        var subtotaliva = $('#totalcantidad');

        $.ajax({
            url: "/sistema-caja-registradora/public/product/getPrice",
            type: "GET",
            data: { 'productoCode': productoCode },
            success: function (data) {
                if (data && data.product_price) {
                    var precioUnitario = parseFloat(data.product_price);
                    var precioTotal = cantidadProducto * precioUnitario;
                    unidad.text('$ ' + precioUnitario.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    subtotal.text('$ ' + precioTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    subtotaliva.text('$ ' + (precioTotal.toFixed(2) * 1.19).toLocaleString('en-US', { maximumFractionDigits: 2 }));
                } else {

                    subtotal.text('Precio no disponible');
                }
            },
            error: function () {
                subtotal.text('Error al obtener el precio');
            }
        });

        $.ajax({
            url: "/sistema-caja-registradora/public/product/getPrice",
            type: "GET",
            data: { 'productoCode': productoCode },
            success: function (data) {
                if (data && data.product_price) {
                    var precioUnitario = parseFloat(data.product_price);
                    var precioTotal = cantidadProducto * precioUnitario;

                    // Actualizar los valores de los campos de entrada
                    $('#precioProductoHiden').val(precioUnitario.toFixed(2));
                    $('#subtotalcantidadHiden').val(precioTotal.toFixed(2));
                    $('#totalcantidadHiden').val((precioTotal.toFixed(2) * 1.19));
                } else {

                    $('#subtotalcantidad').val('Precio no disponible');
                }
            },
            error: function () {
                $('#subtotalcantidad').val('Error al obtener el precio');
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
