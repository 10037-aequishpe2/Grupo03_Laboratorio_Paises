$(document).ready(function() {
  const preguntaContainer = $("#pregunta-container");
  const nombreContainer = $("#nombre-container");
  const resultadoContainer = $("#resultado-container");
  const puntajeElement = $("#puntaje");
  const totalPreguntasElement = $("#total-preguntas");
  const descargarJSONLink = $("#descargar-json");
  const enviarResultadosButton = $("#enviar-resultados");

  let nombreJugador = "";
  let index = 0;
  let puntaje = 0;
  let preguntas = [];
  let preguntasSeleccionadas = [];

  // Cargar las preguntas usando AJAX
  $.getJSON("preguntas/preguntas.json", function(data) {
    preguntas = data;
  });

  // Mostrar pregunta y opciones
  function mostrarPregunta(index) {
    const preguntaActual = preguntas[index];
    preguntasSeleccionadas.push(preguntaActual.respuesta);

    let opcionesHTML = "";

    preguntaActual.opciones.forEach((opcion, idx) => {
      opcionesHTML += `
        <div class="form-check">
          <input class="form-check-input" type="radio" name="opcion" id="opcion-${idx}" value="${idx}">
          <label class="form-check-label" for="opcion-${idx}">
            ${opcion}
          </label>
        </div>
      `;
    });

    const preguntaHTML = `
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">${preguntaActual.pregunta}</h5>
          <form id="formulario-pregunta">
            ${opcionesHTML}
            <button type="submit" class="btn btn-primary mt-3">Responder</button>
          </form>
          <div id="respuesta-mensaje" class="mt-3"></div>
        </div>
      </div>
    `;

    preguntaContainer.html(preguntaHTML);

    $("#formulario-pregunta").submit(function(event) {
      event.preventDefault();
      const respuestaSeleccionada = $("input[name=opcion]:checked").val();

      if (respuestaSeleccionada !== undefined) {
        if (parseInt(respuestaSeleccionada) === preguntaActual.respuesta) {
          puntaje++;
          $("#respuesta-mensaje").html("<p class='respuesta-correcta'>¡Respuesta correcta!</p>");
        } else {
          $("#respuesta-mensaje").html("<p class='respuesta-incorrecta'>Respuesta incorrecta.</p>");
        }

        index++;
        setTimeout(() => {
          if (index < preguntas.length) {
            mostrarPregunta(index);
          } else {
            mostrarPuntajeFinal();
          }
          $("#respuesta-mensaje").empty();
        }, 1500);
      }
    });
  }

  function mostrarPuntajeFinal() {
    puntajeElement.text(puntaje);
    totalPreguntasElement.text(preguntas.length);

    resultadoContainer.show();
  }

  // Agregar evento al formulario de nombre para comenzar el juego
  $("#form-nombre").submit(function(event) {
    event.preventDefault();
    nombreJugador = $("#nombre").val();
    nombreContainer.hide();
    mostrarPregunta(index);
  });

  // Enviar resultados al backend al finalizar el juego
  function enviarResultados() {
    const resultadoJSON = {
      jugador: nombreJugador,
      puntaje: puntaje,
      totalPreguntas: preguntas.length
    };

    $.ajax({
      url: "guardar_resultado.php",
      type: "POST",
      data: resultadoJSON,
      dataType: "json",
      success: function(response) {
        console.log(response);
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });
  }

  // Evento al finalizar el juego para enviar los resultados
  enviarResultadosButton.on("click", function() {
    enviarResultados();
  });
});
