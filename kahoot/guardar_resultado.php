<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $jugador = $_POST["jugador"];
    $puntaje = $_POST["puntaje"];

    $resultado = array(
        "jugador" => $jugador,
        "puntaje" => $puntaje,
        "fecha" => date("Ymd H:i:s")
    );

    $resultadoJSON = json_encode($resultado);

    $archivoResultado = "resultados/" . uniqid() . ".json";
    
    try {
        if (file_put_contents($archivoResultado, $resultadoJSON)) {
            echo json_encode(array("success" => true, "message" => "Resultado guardado con éxito"));
        } else {
            echo json_encode(array("success" => false, "message" => "Error al guardar el resultado"));
        }
    } catch (Exception $e) {
        echo json_encode(array("success" => false, "message" => "Excepción: " . $e->getMessage()));
    }    
} else {
    echo json_encode(array("success" => false, "message" => "Solicitud no válida"));
}
?>
