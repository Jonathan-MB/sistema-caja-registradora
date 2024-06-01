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
});
