document.addEventListener('DOMContentLoaded', function () {
    // Obtener el elemento select
    const tipoClienteSelect = document.getElementById('tipoClienteSelect');
    const ccNitInput = document.getElementById('ccNit');
    const nombreInput = document.getElementById('nombre');
    const registrarButton = document.getElementById('registrar');
    const ccNitLabel = document.getElementById('ccNitLabel');
    const nombreLabel = document.getElementById('nombreLabel');
    const razonSocialLabel = document.getElementById('razonSocialLabel');


    // Obtener el campo de entrada de la razón social
    const razonSocialInput = document.getElementById('razonSocial');


    // Agregar un evento de cambio al elemento select
    tipoClienteSelect.addEventListener('change', activarCampos);

    activarCampos();

    function activarCampos() {


        // Desabilirta campos si no hay tipo de suario
        if (tipoClienteSelect.value !== '') {
            ccNitInput.disabled = false;
            nombreInput.disabled = false;
            razonSocialInput.disabled = false;
            registrarButton.disabled = false;
        } else {
            // Habilita los campos
            ccNitInput.disabled = true;
            nombreInput.disabled = true;
            razonSocialInput.disabled = true;
            registrarButton.disabled = true;
        }

        // Cambia Texts y Campos Segun el tipo
        if (tipoClienteSelect.value == '1') {
            razonSocialLabel.style.display = 'none';
            razonSocialInput.style.display = 'none';
            razonSocialInput.removeAttribute('required');
            ccNitLabel.textContent = 'Ingrese Cédula';
            nombreLabel.textContent = 'Nombre y Apellido';


        } else {
            ccNitLabel.textContent = 'Ingrese NIT';
            razonSocialLabel.style.display = 'block';
            razonSocialInput.style.display = 'block';
            razonSocialInput.required = true;
            nombreLabel.textContent = 'Nombre de la Empresa';
        }


    } 



    ccNitInput.addEventListener('input', (e) => {
        e.target.value = e.target.value.replace(/[^0-9]/g, '');
        registrarButton.disabled = !registrarteForm();
    });

});
