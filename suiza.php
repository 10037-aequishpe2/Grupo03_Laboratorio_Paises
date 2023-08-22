<?php
require_once "./php/LectorXML.php";
require_once "./php/Pais.php";
require_once "./php/Provincia.php";
require_once "./php/Ciudad.php";

$reader = new LectorXML("./data/paises.xml");
$countryNames = $reader->getCountryNames();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de País</title>
    <!-- Enlace a los estilos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #737373;
            color: #ffffff;
            font-family: Arial, sans-serif;
        }

        .country-card {
            border-radius: 10px;
            -webkit-backdrop-filter: blur(10px);
            background-color: #00000079;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
        }

        .country-flag {
            max-width: 100%;
            height: auto;
        }

        .province-info {
            margin-top: 20px;
        }

        .custom-btn {
            background-color: #ff5a5f;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            color: #ffffff;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .custom-btn:hover {
            background-color: #e04146;
        }

        #video-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        #video-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="country-card">
            <h1 class="mb-4">Información del País</h1>

            <div class="row">
                <div class="col-md-6">
                    <?php
                    $countryName = 'Suiza';
                    $country = $reader->getCountry($countryName);
                    $platoTipico = array();
                    foreach ($country->plato_tipico as $plato) {
                        $platoTipico[] = (string) $plato;
                    }
                    $moneda = (string) $country->moneda;
                    $imagen = (string) $country->bandera;
                    $provincias = array();
                    foreach ($country->provincias->children() as $province) {
                        $provincias[] = (string) $province->nombre;
                    }
                    ?>
                    <h2 class="mb-5 mt-3"><?php echo $countryName; ?></h2>
                    <p><strong>Plato Típico:</strong> <?php echo implode(", ", $platoTipico); ?></p>
                    <p><strong>Moneda:</strong> <?php echo $moneda; ?></p>
                    <p><strong>Provincias:</strong> <?php echo implode(", ", $provincias); ?></p>
                </div>
                <div class="col-md-6 text-center">
                    <img src="<?php echo $imagen; ?>" alt="<?php echo $countryName; ?>" class="country-flag img-fluid">
                </div>
            </div>

            <form method="post" class="province-info mt-4">
                <label for="provincia" class="form-label">Selecciona una provincia:</label>
                <select id="provincia" name="provincia" class="form-select">
                    <?php
                    foreach ($provincias as $provincia) {
                        echo "<option value='$provincia'>$provincia</option>";
                    }
                    ?>
                </select>
                <button type="submit" name="submit" class="custom-btn mt-3">Más info provincia</button>
            </form>

            <?php
            if (isset($_POST["submit"])) {
                $provinciaSeleccionada = $_POST["provincia"];
                $provinciaEncontrada = false;
                foreach ($country->provincias->children() as $province) {
                    if ((string) $province->nombre === $provinciaSeleccionada) {
                        $provinciaEncontrada = true;
                        $ciudades = array();
                        foreach ($province->ciudades->children() as $city) {
                            $ciudadNombre = (string) $city->nombre;
                            $codigoPostal = (string) $city->CodigoPostal;
                            $ciudades[] = array('nombre' => $ciudadNombre, 'codigoPostal' => $codigoPostal);
                        }
                        $numCiudades = (int) $province->numCiudades;
            ?>
                        <div class="province-info mt-4">
                            <h2><?php echo $provinciaSeleccionada; ?></h2>
                            <p><strong>Número de ciudades:</strong> <?php echo $numCiudades; ?></p>
                            <ul>
                                <?php
                                foreach ($ciudades as $ciudad) {
                                    echo "<li>{$ciudad['nombre']} - Código Postal: {$ciudad['codigoPostal']}</li>";
                                }
                                ?>
                            </ul>
                        </div>
            <?php
                        break;
                    }
                }
                if (!$provinciaEncontrada) {
                    echo "<p class='mt-4'>No se encontró información para la provincia seleccionada.</p>";
                }
            }
            ?>
        </div>
    </div>

    <!-- Enlace a los scripts de Bootstrap (popper.js y el propio Bootstrap) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>