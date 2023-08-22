<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/estilos.css">
  <title>Juego Kahoot</title>
</head>
<body>
  <div class="container">
    <h1 class="text-center my-4">Juego Kahoot</h1>
    <div id="nombre-container">
      <form id="form-nombre">
        <div class="mb-3">
          <label for="nombre" class="form-label">Ingresa tu nombre:</label>
          <input type="text" class="form-control" id="nombre" required>
        </div>
        <button type="submit" class="btn btn-primary">Comenzar el juego</button>
      </form>
    </div>
    <div id="pregunta-container" class="my-4">
      <!-- Aquí se mostrarán las preguntas y opciones -->
    </div>
    <div id="resultado-container" class="mt-4">
      <h3>¡Fin del juego!</h3>
      <p>Puntaje: <span id="puntaje"></span> / <span id="total-preguntas"></span></p>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/scripts.js"></script>
</body>
</html>

