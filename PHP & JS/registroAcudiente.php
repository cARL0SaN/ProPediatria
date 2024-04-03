<?php
include_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identificacion = $_POST["ident"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    $contrasena = $_POST["cont"];

    $conexion = new Conexion();

    $conn = $conexion->conectar();

    $sqlAcudiente = "UPDATE acudiente SET telefono_acudiente = '$telefono', correo_acudiente = '$correo', clave_acudiente = '$contrasena' WHERE idAcudiente = $identificacion";
    $sqlPersona = "UPDATE persona SET correo_persona = '$correo', telefono_persona = '$telefono' WHERE idPersona = $identificacion";

    if ($conn->query($sqlAcudiente) === TRUE) {
        if ($conn->query($sqlPersona) === TRUE) {
            echo "Registro actualizado correctamente";
            header("refresh:2;url=../Ventana_nino.html");
        }
    } else {
        echo "Error al actualizar el registro: " . $conn->error;
        header("refresh:2;url=../Reg_Acudiente.html");
    }
    /*$sqlPersona = "INSERT INTO persona (idPersona, nom_persona, ape_persona, fechaNaci_persona, correo_persona, telefono_persona, TipoDocumento_persona, Rol_persona, estado_persona) 
        VALUES ('$identificacion','$nombre', '$apellido', '$fecha_nacimiento', '$correo', '$telefono', '$edad', 3, 1)";

    if ($conn->query($sqlPersona) === TRUE) {

        $sqlPediatra = "INSERT INTO acudiente (idAcudiente, nom_acudiente, ape_acudiente, telefono_acudiente, correo_acudiente, clave_acudiente) 
                VALUES ('$identificacion', '$nombre', '$apellido', '$correo', '$telefono', '$contrasena')";

        if ($conn->query($sqlPediatra) === TRUE) {
            echo "<script>alert('Registro exitoso. Nuevo pediatra añadido');</script>";
        } else {
            echo "Error al registrar el pediatra: " . $conn->error;
        }
    } else {
        echo "Error al registrar la persona: " . $conn->error;
    }*/

    $identificacion = "";
    $nombre = "";
    $apellido = "";
    $correo = "";
    $telefono = "";
    $contrasena = "";
    $fecha_nacimiento = "";

    $conexion->cerrarConexion($conn);
} else {
    echo "Por favor, complete el formulario antes de enviar.";
}
