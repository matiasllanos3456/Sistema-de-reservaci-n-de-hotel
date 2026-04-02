<?php
session_start();
require_once __DIR__ . '/../Complements/Connection.php';

// Si fue presionado el boton de enviar....
if(isset($_POST["enviar"])){
    // Verificacion del correo y contraseña
    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $email = trim($_POST["correo"] ?? "");
    $password = $_POST["password"] ?? "";

    // Validaciones de entrada
    if ($nombre === "" || $apellido === "") {
        exit("Nombre y apellido son obligatorios");
    }
    if(50 < strlen($email) || strlen($email) < 8){
        exit("El correo debe tener entre 8 y 50 caracteres");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit("El correo no es valido");
    }
    if(strlen($password) < 8 || strlen($password) > 250){
        exit("La contraseña debe tener entre 8 y 250 caracteres");
    }
    // Asegurar la contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    if (!$conexion) {
        http_response_code(500);
        exit("Error de conexion");
    }
    
    // Insertar en la BD
    $query = "INSERT INTO cliente (Nombre, Apellido, Correo, password_hash)
              VALUES (?, ?, ?, ?)";

    $stmt = $conexion->prepare($query);
    if (!$stmt) {
        http_response_code(500);
        exit("Error en la consulta");
    }
    $stmt->bind_param("ssss", $nombre, $apellido, $email, $passwordHash);
    $stmt->execute();
    // Redirigir
    header("Location: ../Pages/LogIn.php");
    exit;
}
?>