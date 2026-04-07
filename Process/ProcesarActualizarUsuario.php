<?php
session_start();
require_once __DIR__ . '/../Complements/Connection.php';

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit("Sesion no valida");
}

if (!$conexion) {
    http_response_code(500);
    exit("Error de conexion");
}

if (isset($_POST["actualizar"])) {
    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $email = trim($_POST["correo"] ?? "");
    $password = $_POST["password"] ?? "";

    // Validaciones (mismas que en ProcesarRegistro.php)
    if ($nombre === "" || $apellido === "") {
        exit("Nombre y apellido son obligatorios");
    }
    if (50 < strlen($email) || strlen($email) < 8) {
        exit("El correo debe tener entre 8 y 50 caracteres");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit("El correo no es valido");
    }
    if ($password !== "" && (strlen($password) < 8 || strlen($password) > 250)) {
        exit("La contraseña debe tener entre 8 y 250 caracteres");
    }

    $userId = (int)$_SESSION["user_id"];

    if ($password !== "") {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE cliente SET Nombre = ?, Apellido = ?, Correo = ?, password_hash = ? WHERE IdCliente = ?";
        $stmt = $conexion->prepare($query);
        if (!$stmt) {
            http_response_code(500);
            exit("Error en la consulta");
        }
        $stmt->bind_param("ssssi", $nombre, $apellido, $email, $passwordHash, $userId);
    } else {
        // Si el usuario no ingresa una nueva contraseña, esta quedará igual
        $query = "UPDATE cliente SET Nombre = ?, Apellido = ?, Correo = ? WHERE IdCliente = ?";
        $stmt = $conexion->prepare($query);
        if (!$stmt) {
            http_response_code(500);
            exit("Error en la consulta");
        }
        $stmt->bind_param("sssi", $nombre, $apellido, $email, $userId);
    }

    $stmt->execute();

    $_SESSION["user_name"] = $nombre;

    header("Location: ../Pages/Rooms.php");
    exit;
}

http_response_code(400);
exit("Solicitud invalida");
?>