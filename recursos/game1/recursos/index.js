// Variables de configuración
let preguntas_aleatorias = true;
let mostrar_pantalla_juego_terminado = true;
let reiniciar_puntos_al_reiniciar_el_juego = true;

// JSON integrado directamente con preguntas ambientales
let interprete_bp = [
    {
        "categoria": "Ambiente",
        "pregunta": "¿Cuál es la principal causa de la deforestación en la Amazonía?",
        "respuesta": "La expansión agrícola",
        "incorrectas": [
            "El cambio climático",
            "El turismo",
            "La urbanización"
        ]
    },
    {
        "categoria": "Ambiente",
        "pregunta": "¿Qué gas es responsable del efecto invernadero?",
        "respuesta": "Dióxido de carbono (CO2)",
        "incorrectas": [
            "Oxígeno (O2)",
            "Nitrógeno (N2)",
            "Hidrógeno (H2)"
        ]
    },
    {
        "categoria": "Fauna",
        "pregunta": "¿Qué animal está en peligro de extinción debido a la caza furtiva por su marfil?",
        "respuesta": "Elefante",
        "incorrectas": [
            "Tigre",
            "Oso polar",
            "Ballena azul"
        ]
    },
    {
        "categoria": "Ambiente",
        "pregunta": "¿Cuál es una de las principales consecuencias de la contaminación plástica en los océanos?",
        "respuesta": "Muerte de especies marinas",
        "incorrectas": [
            "Aumento de la salinidad",
            "Reducción del oxígeno",
            "Acidificación de los océanos"
        ]
    },
    {
        "categoria": "Fauna",
        "pregunta": "¿Cuál es la función de los polinizadores como las abejas en el ecosistema?",
        "respuesta": "Ayudan a la reproducción de plantas",
        "incorrectas": [
            "Son depredadores naturales",
            "Regulan la temperatura del suelo",
            "Mantienen el equilibrio del CO2"
        ]
    },
    {
        "categoria": "Ambiente",
        "pregunta": "¿Qué puedes hacer para reducir tu huella de carbono?",
        "respuesta": "Usar transporte público o bicicleta",
        "incorrectas": [
            "Aumentar el uso de energía eléctrica",
            "Comprar productos de plástico",
            "Consumir más carne roja"
        ]
    },
    {
        "categoria": "Fauna",
        "pregunta": "¿Cuál de estos animales es clave para mantener el equilibrio en el ecosistema marino?",
        "respuesta": "Tiburón",
        "incorrectas": [
            "Tortuga",
            "Pez payaso",
            "Cangrejo"
        ]
    },
    {
        "categoria": "Ambiente",
        "pregunta": "¿Qué acción contribuye al calentamiento global?",
        "respuesta": "La quema de combustibles fósiles",
        "incorrectas": [
            "La reforestación",
            "El reciclaje",
            "El uso de energía solar"
        ]
    },
    {
        "categoria": "Ambiente",
        "pregunta": "¿Qué tipo de energía es más limpia y renovable?",
        "respuesta": "Energía solar",
        "incorrectas": [
            "Energía nuclear",
            "Energía de carbón",
            "Energía de gas natural"
        ]
    }
];

let pregunta;
let posibles_respuestas;

const btn_correspondiente = [
    select_id("btn1"),
    select_id("btn2"),
    select_id("btn3"),
    select_id("btn4")
];

let npreguntas = [];
let preguntas_hechas = 0;
let preguntas_correctas = 0;

// Iniciar el juego cuando la ventana se cargue
window.onload = function () {
    escogerPreguntaAleatoria();
};

// Escoger una pregunta aleatoria
function escogerPreguntaAleatoria() {
    let n;
    if (preguntas_aleatorias) {
        n = Math.floor(Math.random() * interprete_bp.length);
    } else {
        n = 0;
    }

    while (npreguntas.includes(n)) {
        n++;
        if (n >= interprete_bp.length) {
            n = 0;
        }
        if (npreguntas.length === interprete_bp.length) {
            // Reiniciar el juego
            if (mostrar_pantalla_juego_terminado) {
                swal.fire({
                    title: "Juego finalizado",
                    text: "Puntuación: " + preguntas_correctas + "/" + preguntas_hechas,
                    icon: "success"
                });
            }
            if (reiniciar_puntos_al_reiniciar_el_juego) {
                preguntas_correctas = 0;
                preguntas_hechas = 0;
            }
            npreguntas = [];
        }
    }
    npreguntas.push(n);
    preguntas_hechas++;
    escogerPregunta(n);
}

// Mostrar la pregunta y opciones
function escogerPregunta(n) {
    pregunta = interprete_bp[n];
    select_id("categoria").innerHTML = pregunta.categoria;
    select_id("pregunta").innerHTML = pregunta.pregunta;
    select_id("numero").innerHTML = n + 1; // Para mostrar el número de pregunta de forma más amigable
    let pc = preguntas_correctas;
    select_id("puntaje").innerHTML = pc + "/" + preguntas_hechas;

    desordenarRespuestas(pregunta);
}

// Desordenar respuestas
function desordenarRespuestas(pregunta) {
    posibles_respuestas = [
        pregunta.respuesta,
        ...pregunta.incorrectas // Usamos el array de incorrectas directamente
    ];
    posibles_respuestas.sort(() => Math.random() - 0.5);

    btn_correspondiente.forEach((btn, index) => {
        btn.innerHTML = posibles_respuestas[index];
        btn.style.background = "white"; // Reiniciar el fondo
    });
}

let suspender_botones = false;

// Manejar clic en los botones
function oprimir_btn(i) {
    if (suspender_botones) {
        return;
    }
    suspender_botones = true;
    if (posibles_respuestas[i] === pregunta.respuesta) {
        preguntas_correctas++;
        btn_correspondiente[i].style.background = "lightgreen";
    } else {
        btn_correspondiente[i].style.background = "pink";
    }
    btn_correspondiente.forEach((btn, j) => {
        if (posibles_respuestas[j] === pregunta.respuesta) {
            btn.style.background = "lightgreen";
        }
    });

    setTimeout(() => {
        reiniciar();
        suspender_botones = false;
    }, 3000);
}

// Reiniciar el juego
function reiniciar() {
    btn_correspondiente.forEach(btn => {
        btn.style.background = "white";
    });
    escogerPreguntaAleatoria();
}

function guardarResultado(usuario) {
  const preguntasIncorrectas = preguntas_hechas - preguntas_correctas;

  fetch('guardar_resultado.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: new URLSearchParams({
          'id_actividad': 1, 
          'id_user': 1, 
          'codigo_actividad': 'codigo_123', 
          'nombre': usuario, 
          'preguntas_correctas': preguntas_correctas,
          'preguntas_incorrectas': preguntasIncorrectas,
          'puntuacion': preguntas_correctas 
      })
  })
  .then(response => response.text())
  .then(data => {
      console.log(data); 
  })
  .catch(error => {
      console.error('Error:', error);
  });
}


// Seleccionar un elemento por ID
function select_id(id) {
    return document.getElementById(id);
}
