document.addEventListener('DOMContentLoaded', function() {
    // Funciones comunes pueden ir aquí
    
    // Ejemplo: Confirmación antes de eliminar
    const deleteButtons = document.querySelectorAll('.btn-danger');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('¿Estás seguro de que deseas eliminar este registro?')) {
                e.preventDefault();
            }
        });
    });
});