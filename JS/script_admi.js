// script_admi.js

function toggleTab(tabId) {
    // Ocultar todos los contenidos de pestañas
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });

    // Mostrar la pestaña seleccionada
    document.getElementById(tabId).classList.add('active');
}


document.addEventListener('DOMContentLoaded', () => {
    toggleTab('tab1');
});

function showUserDetails(userId) {
  
    alert('Mostrar detalles del usuario con ID: ' + userId);
};
// foto perfil


function editProfile() {
    // Lógica para editar información del perfil.
    alert('Función de edición de perfil aún no implementada.');
}

function editProfilePic() {
    // Lógica para cambiar la foto de perfil.
    alert('Función para cambiar la foto de perfil aún no implementada.');
}




