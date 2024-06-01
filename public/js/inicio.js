document.addEventListener('DOMContentLoaded', (event) => {
    const inputCcNit = document.getElementById("ccNitInicio");

    // Permitir solo números
    inputCcNit.addEventListener("input", (e) => {
        const { value } = e.target;
        e.target.value = value.replace(/[^0-9]/g, '');
    });

    const form = document.getElementById('userInicioForm');

    // Validar al enviar el formulario
    form.addEventListener('submit', (e) => {
        const value = inputCcNit.value;
        const alertContainer = document.getElementById('alertContainer');
        
        // Limpiar alertas anteriores
        alertContainer.innerHTML = '';

        if (value.length < 9 || value.length > 10) {
            e.preventDefault();
            
            // Crea alerta 
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger';
            alertDiv.role = 'alert';
            alertDiv.innerText = 'La Cédula o NIT debe tener entre 9 y 10 dígitos.';

            // Insertar alerta 
            alertContainer.appendChild(alertDiv);
        }});


    // Formulario  verificacion Bd----------------------------------------------------------------------------------------------------------

    const userInicioForm = document.getElementById('userInicioForm');
    userInicioForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = $(userInicioForm).serialize();

        $.ajax({
            url: '/sistema-caja-registradora/public/user/validateUser',
            type: 'POST',
            data: formData,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.status === true) {
                    $('#datosUser input[name="userName"]').val(response.user.user_name);
                    $('#datosUser input[name="userId"]').val(response.user.id);
                    $('#datosUser input[name="typeId"]').val(response.user.type_id);
                    $('#datosUser').show();
                    $('#registrarUser').hide();
                } else {
                    $('#registrarUser').show();
                }
            },
            error: function (response) {

                console.log("Error:", response);
            }
        });
    });

});
