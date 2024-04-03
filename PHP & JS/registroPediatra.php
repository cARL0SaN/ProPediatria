<?php
include_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identificacion = $_POST["ident"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $fechaNacimiento = $_POST["fecha_nacimiento"];
    $sexo = $_POST["sexo_usuario"];
    $lugarTrabajo = $_POST["Lugar_trabajo"];
    $contrasena = $_POST["cont"];


    if ($sexo == 'Masculino') {
        $sexo = 'M';
    } else {
        $sexo = 'F';
    }

    if (isset($_FILES['foto_pediatra'])) {
        $file_name = $_FILES['foto_pediatra']['name'];
        $file_tmp = $_FILES['foto_pediatra']['tmp_name'];

        $uploads_dir = 'uploads/';
        move_uploaded_file($file_tmp, $uploads_dir . $file_name);
        $urlImagen = $uploads_dir . $file_name;
    }

    $conexion = new Conexion();

    $conn = $conexion->conectar();

    $sqlPersona = "INSERT INTO persona (idPersona, nom_persona, ape_persona, fechaNaci_persona, TipoDocumento_persona, Rol_persona, estado_persona) 
        VALUES ('$identificacion','$nombre', '$apellido', '$fechaNacimiento', 1, 2, 1)";

    if ($conn->query($sqlPersona) === TRUE) {

        $sqlPediatra = "INSERT INTO pediatra (idPediatra_idPersona, sexo_pediatra, lugarLabora_pediatra, clave_pediatra, foto_pediatra) 
                VALUES ('$identificacion', '$sexo', '$lugarTrabajo', '$contrasena', '$urlImagen')";

        if ($conn->query($sqlPediatra) === TRUE) {
            echo "<script>alert('Registro exitoso. Nuevo pediatra añadido');</script>";
            header("refresh:1;url=../Reg_Pediatra.html");
        } else {
            echo "Error al registrar el pediatra: " . $conn->error;
        }
    } else {
        echo "Error al registrar la persona: " . $conn->error;
    }

    $identificacion = "";
    $nombre = "";
    $apellido = "";
    $fechaNacimiento = "";
    $sexo = "";
    $lugarTrabajo = "";
    $contrasena = "";
    $idPersona = "";
    $urlImagen = "";

    $conexion->cerrarConexion($conn);
} else {
    echo "Por favor, complete el formulario antes de enviar.";
}
