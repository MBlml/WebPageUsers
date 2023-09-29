<?php
include("con_db.php");

if (isset($_POST['clearTableBtn'])) {
    // Limpiar la tabla
    $consulta_limpiar = "DELETE FROM users";
    $resultado_limpiar = mysqli_query($conex, $consulta_limpiar);
    if ($resultado_limpiar) {
        echo "<script>alert('Tabla limpiada exitosamente.');</script>";
    } else {
        echo "<script>alert('Error al limpiar la tabla.');</script>";
    }
}
header("Location: index.php");
exit();
?>
