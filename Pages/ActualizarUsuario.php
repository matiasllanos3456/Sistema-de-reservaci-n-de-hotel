<?php
session_start();
require_once __DIR__ . '/../Complements/Connection.php';

if (!$conexion) {
    http_response_code(500);
    exit("Error de conexion");
}

if (!isset($_SESSION["user_id"])) {
    header("Location: LogIn.php");
    exit;
}
// Se intenta encontrar al usuario en la base de datos
$userId = (int)$_SESSION["user_id"];
$query = "SELECT Nombre, Apellido, Correo FROM cliente WHERE IdCliente = ?";
$stmt = $conexion->prepare($query);
if (!$stmt) {
    http_response_code(500);
    exit("Error en la consulta");
}
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    http_response_code(404);
    exit("Usuario no encontrado");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Assets/css/stylesRegistro.css">
    <title>Actualizar usuario</title>
</head>
<body>
    <div class="login-container">
        <form action="../Process/ProcesarActualizarUsuario.php" method="post" class="form-registro">
            <h1>Actualizar datos</h1>
            <div class="input-container">
                <label for="nombre">Name <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($user["Nombre"], ENT_QUOTES, "UTF-8"); ?>" required></label>
                <label for="apellido">Surname <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($user["Apellido"], ENT_QUOTES, "UTF-8"); ?>" required></label>
                <label for="correo">Email <input type="text" id="correo" name="correo" value="<?php echo htmlspecialchars($user["Correo"], ENT_QUOTES, "UTF-8"); ?>" required></label>
                <label for="password">New password <input type="password" id="password" name="password" placeholder="Minimo 8 caracteres"></label>

                <button type="submit" class="enter-button" name="actualizar">Guardar cambios</button>
            </div>
            <div class="create-container">
                <h4><a href="Rooms.php">Volver a habitaciones</a></h4>
            </div>
        </form>
    </div>
</body>
</html>