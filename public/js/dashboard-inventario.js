document.addEventListener('DOMContentLoaded', function () {
    // Obtenemos todos los elementos con el atributo 'data-toggle="collapse"'
    const collapseTriggers = document.querySelectorAll('[data-toggle="collapse"]');

    // Función para cerrar todos los colapsables
    function closeAllCollapses() {
        const allCollapses = document.querySelectorAll('.collapse');
        allCollapses.forEach(function (collapse) {
            // Si el colapsable está abierto, lo cerramos
            if (collapse.classList.contains('show')) {
                collapse.classList.remove('show');
            }
        });
    }

    // Escuchamos el clic en el documento
    document.addEventListener('click', function (event) {
        // Si el clic no está dentro del colapsable ni en el botón que lo activa
        const isClickInsideCollapse = event.target.closest('.collapse');
        const isClickInsideToggle = event.target.closest('[data-toggle="collapse"]');

        if (!isClickInsideCollapse && !isClickInsideToggle) {
            closeAllCollapses(); // Cerramos todos los colapsables
        }
    });

    // Evitar que el clic en el botón colapsable cierre el colapsable
    collapseTriggers.forEach(function (trigger) {
        trigger.addEventListener('click', function (event) {
            event.stopPropagation(); // Previene el cierre al hacer clic en el botón
        });
    });
});