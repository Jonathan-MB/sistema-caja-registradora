document.addEventListener('DOMContentLoaded', (event) => {



    const input2 = document.getElementById("ccNit");

  


    // Permitir solo números
    input2.addEventListener("input", (e) => {
        const { value } = e.target;
        e.target.value = value.replace(/[^0-9]/g, '');
    });

    const form = document.getElementById('userForm');

    // Validar al enviar el formulario
    form.addEventListener('submit', (e) => {
        const value = input2.value;
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
        }
    });
});
