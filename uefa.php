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


    <link href="assets/img/favicon.png" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet" />
    <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet" />


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />
    <style>
        body {
            background-color: #232323;
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

    <header id="header" class="fixed-top d-flex align-items-center ">
        <div class="container-fluid">

            <div class="row justify-content-center align-items-center">
                <div class="col-xl-11 d-flex align-items-center justify-content-between">
                    <h1 class="logo"><a href="index.html">Europa</a></h1>
                    <!-- Uncomment below if you prefer to use an image logo -->
                    <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

                    <nav id="navbar" class="navbar">
                        <ul>
                            <li><a class="nav-link scrollto " href="index.html">Inicio</a></li>
                            <!-- <li><a class="nav-link  active" href="blog.html">Blog</a></li> -->
                        </ul>
                        <i class="bi bi-list mobile-nav-toggle"></i>
                    </nav><!-- .navbar -->
                </div>
            </div>

        </div>
    </header>
    <div class="container mt-5">
        <h1 class="text-center pt-5">UEFA</h1>
        <div class="container mt-5 text-center">
            <img src="./img/uefa.jpg" alt="linea" class="img-fluid linea" />
        </div>
    </div>
    <?php foreach ($countryNames as $countryName) { ?>
        <div class="container mt-5">

            <div class="country-card">


                <div class="row">
                    <div class="col-md-6">
                        <?php
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
    <?php } ?>

    <!-- Enlace a los scripts de Bootstrap (popper.js y el propio Bootstrap) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>