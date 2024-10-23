// Selección de elementos
const formulario = document.getElementById('formulario');
const inputs = document.querySelectorAll('#formulario input');

// Expresiones regulares para validación
const expresiones = {
    nick: /^[a-zA-ZÀ-ÿ\s]{4,20}$/, // Letras y espacios, pueden llevar acentos.
    password: /^.{6,20}$/, // 6 a 20 caracteres.
    correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
    documento: /^\d{10,15}$/ // 10 a 15 dígitos.
};

// Estado de validación de los campos
const campos = {
    nick: false,
    password: false,
    correo: false,
    documento: false
};

// Función para validar los campos
const validaCampo = (expresion, input, campo) => {
    const grupo = document.getElementById(`grupo_${campo}`);
    const error = grupo.querySelector('.formulario_input-error');
    const icono = grupo.querySelector('i');

    if (expresion.test(input.value)) {
        grupo.classList.remove('formulario_grupo-incorrecto');
        grupo.classList.add('formulario_grupo-correcto');
        icono.classList.add('fa-check-circle');
        icono.classList.remove('fa-times-circle');
        error.classList.remove('formulario_input-error-activo');
        campos[campo] = true;
    } else {
        grupo.classList.add('formulario_grupo-incorrecto');
        grupo.classList.remove('formulario_grupo-correcto');
        icono.classList.add('fa-times-circle');
        icono.classList.remove('fa-check-circle');
        error.classList.add('formulario_input-error-activo');
        campos[campo] = false;
    }
};

// Validación en tiempo real
inputs.forEach((input) => {
    input.addEventListener('keyup', validaFormularios);
    input.addEventListener('blur', validaFormularios);
});

// Función para validar el formulario
const validaFormularios = (e) => {
    switch (e.target.name) {
        case "nick":
            validaCampo(expresiones.nick, e.target, 'nick');
            break;
        case "password":
            validaCampo(expresiones.password, e.target, 'password');
            break;
        case "correo":
            validaCampo(expresiones.correo, e.target, 'correo');
            break;
        case "documento":
            validaCampo(expresiones.documento, e.target, 'documento');
            break;
    }
};

// Envío del formulario
formulario.addEventListener('submit', (e) => {
    e.preventDefault();

    if (Object.values(campos).every(value => value === true)) {
        formulario.reset();
        document.getElementById('formulario_mensaje-exito').classList.add('formulario_mensaje-exito-activo');
        setTimeout(() => {
            document.getElementById('formulario_mensaje-exito').classList.remove('formulario_mensaje-exito-activo');
        }, 5000);
        window.location.href = "inicio_sesion.html";
    } else {
        document.getElementById('formulario_mensaje').classList.add('formulario_mensaje-activo');
        setTimeout(() => {
            document.getElementById('formulario_mensaje').classList.remove('formulario_mensaje-activo');
        }, 3000);
    }
});

