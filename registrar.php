<?php
include("con_db.php");

if (isset($_POST['sign_in'])) {
    if (strlen($_POST['name']) >= 1 && strlen($_POST['lastName']) >= 1 && strlen($_POST['email']) >= 1 && strlen($_POST['password']) >= 1) {
        $name = trim($_POST['name']);
        $lastName = trim($_POST['lastName']);
        $email = trim($_POST['email']);
        $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT); // Hash de la contraseña
        $fechareg = date("d/m/y");
        $consulta = "INSERT INTO users(name, lastName, email, password, fecha_reg) VALUES ('$name', '$lastName','$email','$password','$fechareg')";
        $resultado = mysqli_query($conex,$consulta);
        if ($resultado) {
            echo '<h3 class="ok">¡Registrado correctamente!</h3>';
        } else {
            echo '<h3 class="bad">¡Error!</h3>';
        }
    } else {
        echo '<h3 class="bad">¡Completa todos los campos!</h3>';
    }
}
?>
