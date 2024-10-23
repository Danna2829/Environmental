document.addEventListener('DOMContentLoaded', () => {
    const modalLogros = document.getElementById('modal-logros');
    const closeButton = document.querySelector('.close');
    const volverAtrasButton = document.getElementById('volver-atras');
    const juegosSection = document.getElementById('juegos');
    const verLogrosButton = document.getElementById('ver-logros');

    // Datos de ejemplo de logros
    const logros = [
        { fecha: '2024-08-01', descripcion: 'Completar la primera actividad', estado: 'Completado' },
        { fecha: '2024-08-02', descripcion: 'Realizar 5 tareas', estado: 'Completado' },
        { fecha: '2024-08-03', descripcion: 'Obtener una calificación alta', estado: 'En progreso' }
    ];

    // Mostrar el modal con los logros
    verLogrosButton.addEventListener('click', () => {
        juegosSection.style.opacity = '0.3'; // Desvanece la sección de juegos
        modalLogros.style.display = 'block';
        
        const listaLogros = document.getElementById('lista-logros');
        listaLogros.innerHTML = ''; // Limpiar la lista actual
        logros.forEach(logro => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${logro.fecha}</td>
                <td>${logro.descripcion}</td>
                <td>${logro.estado}</td>
            `;
            listaLogros.appendChild(tr);
        });
    });

    // Cerrar el modal
    closeButton.addEventListener('click', () => {
        modalLogros.style.display = 'none';
        juegosSection.style.opacity = '1'; // Restaura la opacidad de la sección de juegos
    });

    // Volver a la sección de actividades
    volverAtrasButton.addEventListener('click', () => {
        modalLogros.style.display = 'none';
        juegosSection.style.opacity = '1'; // Restaura la opacidad de la sección de juegos
    });

    // Cerrar el modal si se hace clic fuera de él
    window.addEventListener('click', (event) => {
        if (event.target === modalLogros) {
            modalLogros.style.display = 'none';
            juegosSection.style.opacity = '1'; // Restaura la opacidad de la sección de juegos
        }
    });
});