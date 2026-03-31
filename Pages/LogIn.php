

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Assets/css/stylesLogIn.css">
    <title>LogIn</title>
</head>
<body>
    <div class="login-container">
        <form action="../Process/ProcesarLogIn.php" method="post" class="form-login">
            <h1>Iniciar sesion</h1>
            <div class="input-container">
                <label for="nombre">Name <input type="text" id="nombre" name="nombre" required></label>
    
                <label for="password">Password <input type="password" id="password" name="password" required></label>
                <!-- Se debe validar la informacion ingresada en la BD -->
                <button type="button" class="enter-button" onclick="location.href='Rooms.php'">Enter</button>
            </div>
            <div class="create-container">
                <h4>No tienes una cuenta? <a href="Registro.php">Crear cuenta</a></h4>
            </div>
        </form>
    </div>
</body>
</html>