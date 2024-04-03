<?php
include_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["Nombre_nino"];
    $apellido = $_POST["Apellido_nino"];
    $fechaNacimiento = $_POST["fecha_nacimiento_nino"];
    $sexo = $_POST["sexo_usuario"];
    $gs = $_POST["gs"];
    $rh = $_POST["rh"];
    $identificacion = $_POST["registro_civil_nino"];
    $nombreRes = $_POST["Nombre_responsable"];
    $apellidoRes = $_POST["Apellido_responsable"];
    $fechaNacimientoRes = $_POST["fecha_nacimiento_responsable"];
    $identificacionRes = $_POST["documento_responsable"];

    $edad_limite = 18; // Edad mínima para ser considerado mayor de edad
    
    $timestamp_nacimiento = strtotime($fechaNacimientoRes);
    $timestamp_limite = strtotime("-$edad_limite years");
    
    if ($timestamp_nacimiento > $timestamp_limite) {
        // La persona es menor de edad
        $edad = 2;
    } else {
        // La persona es mayor de edad
        $edad = 1;
    }

    if ($sexo == 'Masculino') {
        $sexo = 'M';
    } else {
        $sexo = 'F';
    }

    $conexion = new Conexion();

    $conn = $conexion->conectar();

    $sqlPersona = "INSERT INTO persona (idPersona, nom_persona, ape_persona, fechaNaci_persona, TipoDocumento_persona, Rol_persona, estado_persona) 
            VALUES ('$identificacionRes','$nombreRes', '$apellidoRes', '$fechaNacimientoRes', '$edad', 4, 1)";

    if ($conn->query($sqlPersona) === TRUE) {
        $sqlAcudiente = "INSERT INTO acudiente (idAcudiente, nom_acudiente, ape_acudiente) 
        VALUES ('$identificacionRes','$nombreRes', '$apellidoRes')";

        if ($conn->query($sqlAcudiente) === TRUE) {
            $sqlPersona2 = "INSERT INTO persona (idPersona, nom_persona, ape_persona, grupSang_persona, rh_persona, fechaNaci_persona, TipoDocumento_persona, Rol_persona, estado_persona) 
                VALUES ('$identificacion','$nombre', '$apellido', '$gs', '$rh', '$fechaNacimiento', 2, 3, 1)";

            if ($conn->query($sqlPersona2) === TRUE) {
                $sqlPaciente = "INSERT INTO paciente (idPaciente_idPersona, sexo_paciente, Pediatra_idPediatra_idPersona, Acudiente_idAcudiente) 
                VALUES ('$identificacion', '$sexo', 1, '$identificacionRes')";

                if ($conn->query($sqlPaciente) === TRUE) {
                    echo "<script>alert('Registro exitoso. Nuevo Paciente y acudiente añadido');</script>";
                    header("refresh:1;url=../Ventana_nino.html");
                } else {
                    echo "Error al registrar al Paciente: " . $conn->error;
                    header("refresh:1;url=../Reg_nino.html");
                }
            }
        } else {
            echo "Error al registrar al Acudiente: " . $conn->error;
            header("refresh:1;url=../Reg_nino.html");
        }
    }

    $nombre = "";
    $apellido = "";
    $fechaNacimiento = "";
    $sexo = "";
    $gs = "";
    $rh = "";
    $identificacion = "";
    $nombreRes = "";
    $apellidoRes = "";
    $fechaNacimientoRes = "";
    $identificacionRes = "";

    $conexion->cerrarConexion($conn);
} else {
    echo "Por favor, complete el formulario antes de enviar.";
}
