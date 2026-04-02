


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Assets/css/stylesRegistro.css">
    <title>Registro</title>
</head>
<body>
    <div class="login-container">
        <form action="../Process/ProcesarRegistro.php" method="post" class="form-registro">
            <h1>Registrarse</h1>
            <div class="input-container">
                <label for="nombre">Name <input type="text" id="nombre" name="nombre" required></label>
                <label for="apelldo">Surname <input type="text" id="apellido" name="apellido" required></label>
                <!-- El correo debe tener como maximo 50 caracteres -->
                <label for="correo">Email <input type="text" id="correo" name="correo" placeholder="junitope123@gmail.com" required></label>
                <label for="password">Password <input type="password" id="password" name="password" placeholder="Minimo 8 caracteres" required></label>
    
                <button type="submit" class="enter-button" name="enviar">Enter</button>
            </div>
            <div class="create-container">
                <h4>Ya tienes una cuenta? <a href="LogIn.php">Iniciar sesion</a></h4>
            </div>
        </form>
    </div>
</body>
</html>