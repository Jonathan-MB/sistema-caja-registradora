document.addEventListener('DOMContentLoaded', function () {
    // Obtener los elementos
    const productCode = document.getElementById('productCode');
    const productStock = document.getElementById('productStock');
    const productPrice = document.getElementById('productPrice');

    productCode.addEventListener('input', soloNum);
    productStock.addEventListener('input', soloNum);


    
    function soloNum(e) {
        e.target.value = e.target.value.replace(/[^0-9]/g, '');
    }
});
