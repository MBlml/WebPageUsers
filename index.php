<!DOCTYPE html>
<html lang="en">
<head>
    <title>WebPageUsers</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="styles-dark.css" id="themeLink">
    <link rel="shortcut icon" href="images/iconPage.ico" />
</head>
<body>
    <script>
        // Función para cambiar el tema
        function toggleTheme() {
            var themeLink = document.getElementById("themeLink");
            var themeToggleBtn = document.getElementById("themeToggleBtn");
            var currentTheme = themeLink.getAttribute("href");
            var darkThemePath = "styles-dark.css";
            var lightThemePath = "styles-light.css";

            // Cambia el tema en función de la hoja de estilos actual
            if (currentTheme === darkThemePath) {
                themeLink.setAttribute("href", lightThemePath);
            } else {
                themeLink.setAttribute("href", darkThemePath);
            }
        }
    </script>

    <nav class="navTop">
        <div class="flex-container">
            <ul>
                <img src="images/iconPage.png" alt="imageError" class="iconPage">
            </ul>
            <ul>
                <h1>WebPageUsers</h1>
            </ul>
            <ul>
                <h1>Inicio</h1>
            </ul>
            <ul>
                <h1>Registro</h1>
            </ul>
            <ul>
                <h1>Usuarios</h1>
            </ul>
            <ul>
                <h1>Informacion</h1>
            </ul>
            <ul>
                <button id="themeToggleBtn" class = "themeToggleBtn" onclick="toggleTheme()"></button>
            </ul>
        </div>
    </nav>

    <div class="backCenter">
        <!-- Left to Sign In -->
        <div class="signAccount">
            <h1>Sign in</h1>
            <form method="post">
                <div class="form-sign">
                    <label for="name">Name:</label>
                    <input type="text" name="name">
                </div>
                <div class="form-sign">
                    <label for="lastName">Last name:</label>
                    <input type="text" name="lastName">
                </div>
                <div class="form-sign">
                    <label for="email">E-mail address:</label>
                    <input type="text" name="email">
                </div>
                <div class="form-sign">
                    <label for="password">Password:</label>
                    <input type="password" name="password">
                </div>
                <div class="form-sign">
                    <label for="confirmPassword">Confirm password:</label>
                    <input type="password" name="confirmPassword">
                </div>
                <input type="submit" name="sign_in" value="Sign in">
            </form>
            
            <?php
            include("con_db.php");

            if (isset($_POST['sign_in'])) {
                if (strlen($_POST['name']) >= 1 && strlen($_POST['lastName']) >= 1 && strlen($_POST['email']) >= 1 && strlen($_POST['password']) >= 1) {
                    $name = trim($_POST['name']);
                    $lastName = trim($_POST['lastName']);
                    $email = trim($_POST['email']);
                    $password = trim($_POST['password']);
                    $fechareg = date("d/m/y");
                    $consulta = "INSERT INTO users(name, lastName, email, password, fecha_reg) VALUES ('$name', '$lastName','$email','$password','$fechareg')";
                    $resultado = mysqli_query($conex,$consulta);
                    if ($resultado) {
                        echo '<h3 class="signOk">¡Registrado correctamente!</h3>';
                    } else {
                        echo '<h3 class="signBad">¡Error!</h3>';
                    }
                } else {
                    echo '<h3 class="signBad">¡Completa todos los campos!</h3>';
                }
            }
            ?>
        </div>

        <div class="or">
            <h3>Or</h3>
        </div>

        <!-- Right to Log In -->
        <div class="logAccount">
            <h1>Log in</h1>
            <form method="post">
                <div class="form-log">
                    <label for="email">E-mail address:</label>
                    <input type="text" id="email" name="emailLog" style="width: 250px;">
                </div>
                <div class="form-log">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="passwordLog" style="width: 250px;">
                </div>
                <a href="./forgotPassword.php">Forgot password?</a><br>

                <input type="submit" value="Log in">
            </form>

            <?php
                include("con_db.php");

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Obtener los datos ingresados en el formulario de inicio de sesión
                    $emailLog = $_POST["emailLog"];
                    $passwordLog = $_POST["passwordLog"];

                    // Realizar la consulta para buscar el usuario en la base de datos
                    $consulta_email = "SELECT * FROM users WHERE email='$emailLog'";
                    $resultado_email = mysqli_query($conex, $consulta_email);

                    if (mysqli_num_rows($resultado_email) > 0) {                        
                        // Si se encontró un registro con el email proporcionado, verificar la contraseña
                        $row = mysqli_fetch_assoc($resultado_email);
                        $hashed_password = $row['password'];

                        /* if (password_verify($passwordLog, $hashed_password)) { */
                        if ($passwordLog == $hashed_password) {
                            // Contraseña válida, mostrar alerta exitosa
                            echo '<h3 class="sesionOk">¡Inicio de sesión exitoso!</h3>';    
                            echo '<script>window.location.href = "./home.php";</script>';
                        } else {
                            // Contraseña incorrecta, mostrar alerta de error
                            echo '<h3 class="sesionBad">¡Contraseña incorrecta!</h3>';
                            
                        }
                    } else {
                        // No se encontró el usuario, mostrar alerta de error
                        echo '<h3 class="sesionBad">¡No se encontraron usuarios!</h3>';
                    }
                }
            ?>

        </div>
    </div>

    <?php
    // Consulta para obtener los usuarios de la tabla
    $consulta_usuarios = "SELECT * FROM users";
    $resultado_usuarios = mysqli_query($conex, $consulta_usuarios);
    ?>

    <!-- Tabla de usuarios registrados -->
    <hr>
    <div class = "infoUserTable">
        <h2>Usuarios registrados</h2>
        <button id="toggleTableBtn" class = "buttonTable" onclick="toggleTable()">Mostrar tabla</button>
        <form method="post" action="limpiar_tabla.php" onsubmit="return confirm('¿Estás seguro de que deseas limpiar la tabla?');">
            <button type="submit" name="clearTableBtn" class = "buttonTable" >Limpiar tabla</button>
        </form>      
    </div>

    <div class = "tableUsers">   
        <table class="table-container" id="tableContainer">
            <tr>
                <th>Icon</th>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Fecha de registro</th>
            </tr>
            <?php while ($row = mysqli_fetch_array($resultado_usuarios)) { ?>
                <tr>
                    <td><img src="images/iconPage.png" alt="?" class = "iconUser"></td>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['lastName']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['fecha_reg']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    

    <script>
        function toggleTable() {
            var tableContainer = document.getElementById("tableContainer");
            if (tableContainer.style.display === "none") {
                tableContainer.style.display = "block";
                tableContainer.style.margin = "auto";
            } else {
                tableContainer.style.display = "none";
            }
        }
    </script>

</body>
</html>
