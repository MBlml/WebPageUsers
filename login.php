<?php
include("con_db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos ingresados en el formulario de inicio de sesión
    $emailLog = $_POST["emailLog"];
    $passwordLog = $_POST["passwordLog"];

    // Realizar la consulta para buscar el usuario en la base de datos
    $consulta_usuario = "SELECT * FROM users WHERE email='$emailLog'";
    $resultado_usuario = mysqli_query($conex, $consulta_usuario);

    if (mysqli_num_rows($resultado_usuario) > 0) {
        // Si se encontró un registro con el email proporcionado, verificar la contraseña
        $row = mysqli_fetch_assoc($resultado_usuario);
        $hashed_password = $row['password'];

        if (password_verify($passwordLog, $hashed_password)) {
            // Contraseña válida, mostrar alerta exitosa
            echo '<script>alert("Inicio de sesión exitoso");</script>';
        } else {
            // Contraseña incorrecta, mostrar alerta de error
            echo '<script>alert("Contraseña incorrecta");</script>';
        }
    } else {
        // No se encontró el usuario, mostrar alerta de error
        echo '<script>alert("El usuario no existe");</script>';
    }
}
?>
