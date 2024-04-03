<?php
include_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valor = $_POST["ident"];

    $conexion = new Conexion();
    $conn = $conexion->conectar();

    // Realizar la consulta SQL para buscar el dato en la tabla especificada
    $sql = "SELECT nom_persona, ape_persona, correo_persona, telefono_persona, fechaNaci_persona FROM persona WHERE idPersona = '$valor'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data = array('nom_persona' => $row['nom_persona'], 'ape_persona' => $row['ape_persona'], 'correo_persona' => $row['correo_persona'], 'telefono_persona' => $row['telefono_persona'], 'fechaNaci_persona' => $row['fechaNaci_persona']);
        echo json_encode($data);
    } else {
        echo json_encode(array('error' => 'No se encontraron resultados'));
    }

    $conexion->cerrarConexion($conn);
}
?>

