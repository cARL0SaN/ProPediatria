<?php
include_once "conexion.php";

// Verifica si se han enviado datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Iniciar sesión
    session_start();

    $db = mysqli_connect('localhost', 'root', '', 'propediatria');

    $errors1 = "<div style='background-color: #4CAF50; color: white; padding: 10px; text-align: center; margin-top: 20px;'>Acceso denegado a pediatra.</div>";
    $errors2 = "<div style='background-color: #4CAF50; color: white; padding: 10px; text-align: center; margin-top: 20px;'>Acceso denegado a acudiente.</div>";
    $errors3 = "<div style='background-color: #4CAF50; color: white; padding: 10px; text-align: center; margin-top: 20px;'>Acceso denegado.</div>";

    if (isset($_POST['validar'])) {
        $id = mysqli_real_escape_string($db, $_POST['ident']);
        $cont = mysqli_real_escape_string($db, $_POST['contrasena']);

        // Comprobar si el nombre de usuario es válido
        $query = "SELECT idPediatra_idPersona, clave_pediatra FROM pediatra WHERE idPediatra_idPersona='$id'";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) == 1) {
            // Nombre de usuario válido, verificar contraseña
            $row = mysqli_fetch_assoc($results);
            if ($cont == $row['clave_pediatra']) {
                // Inicio de sesión válido
                $_SESSION['idPediatra_idPersona'] = $id;
                header("refresh:2;url=../Ven_Pediatra.html");
                exit();
            } else {
                // Contraseña inválida
                echo $errors1;
            }
        } else {
            $query = "SELECT idAcudiente, clave_acudiente FROM acudiente WHERE idAcudiente='$id'";
            $results = mysqli_query($db, $query);

            if (mysqli_num_rows($results) == 1) {
                // Nombre de usuario válido, verificar contraseña
                $row = mysqli_fetch_assoc($results);
                if ($cont == $row['clave_acudiente']) {
                    // Inicio de sesión válido
                    $_SESSION['idAcudiente'] = $id;
                    header("refresh:0;url=../Ventana_nino.html");
                    exit();
                } else {
                    // Contraseña inválida
                    echo $errors2;
                }
            } else {
                echo $errors3;
            }
        }
    }

    header("refresh:2;url=../inicio_sesion.html");
    exit();

    /*    // Captura los datos del formulario
    $identificacion = $_POST["ident"];
    $contrasena = $_POST["contrasena"];

    $conexion = new Conexion();
    $conn = $conexion->conectar();

    // Consulta para verificar si el identificador y la contraseña coinciden en la tabla de acudientes
    $sqlAcudiente = "SELECT * FROM acudiente WHERE identificacion = '$identificacion' AND contrasena = '$contrasena'";
    $resultadoAcudiente = $conn->query($sqlAcudiente);

    // Consulta para verificar si el identificador y la contraseña coinciden en la tabla de pediatras
    $sqlPediatra = "SELECT * FROM pediatra WHERE idPediatra_idPersona = '$identificacion' AND clave_pediatra = '$contrasena'";
    $resultadoPediatra = $conn->query($sqlPediatra);

    // Verifica si se encontró algún acudiente con las credenciales proporcionadas
    if ($resultadoAcudiente->num_rows > 0) {
        // Acceso como acudiente
        echo "<div style='background-color: #4CAF50; color: white; padding: 10px; text-align: center; margin-top: 20px;'>Acceso permitido como acudiente.</div>";
    }
    // Verifica si se encontró algún pediatra con las credenciales proporcionadas
    elseif ($resultadoPediatra->num_rows > 0) {
        // Acceso como pediatra
        echo "<div style='background-color: #4CAF50; color: white; padding: 10px; text-align: center; margin-top: 20px;'>Acceso permitido como pediatra.</div>";
    } else {
        // No se encontró ningún acudiente ni pediatra con las credenciales proporcionadas
        echo "<div style='background-color: #f44336; color: white; padding: 10px; text-align: center; margin-top: 20px;'>Credenciales incorrectas.</div>";
    }

    $conexion->cerrarConexion($conn);*/
} else {
    // Si no se han enviado datos por POST, redirige a la página de inicio de sesión
    header("Location: Index.html");
    exit();
}
