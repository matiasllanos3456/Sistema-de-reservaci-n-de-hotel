<!-- Importamos la conexion a la BD -->
<?php
// Se guardará la sesion del usuario
session_start();
// require_once detiene la ejecucion del script si la conexion falla
require_once __DIR__ . '/../Complements/Connection.php';
// isset() verifica que una variable a sido declarada
if (isset($_POST['enviar'])) {
    // trim() elimina los espacios al inicio y al final
    // Aquí ya tengo el contenido de los inputs en variables
    $nombre = trim($_POST['nombre'] ?? "");
    $password = $_POST['password'] ?? "";

    if($nombre === "" || $password === ""){
        http_response_code(400);
        exit("Faltan datos");
    }
    if (!$conexion) {
        http_response_code(500);
        exit("Error de conexion");
    }

    // Verificar que el usuario esté en la BD
    // mysqli_query(conexion(ya importada), query)
    $query = "SELECT IdCliente, Nombre, password_hash 
              FROM cliente 
              WHERE nombre = ?";

    $stmt = $conexion->prepare($query);
    if (!$stmt) {
        http_response_code(500);
        exit("Error en la consulta");
    }
    $stmt->bind_param("s", $nombre);
    $stmt->execute();

    $result = $stmt->get_result();

    // Aqui se guarda el id, el nombre y la contraseña del usuario
    $user = $result->fetch_assoc(); 
    
    // Verificar la contraseña, solo si se utilizo password_hash() para el registro
    if (!$user || !password_verify($password, $user["password_hash"])) {
        // Recomendación: mensaje genérico para no revelar si existe el usuario
        http_response_code(401);
        exit("Credenciales inválidas");
    }

    // Si el usuario existe se guardaran sus datos en la variable superglobal $_SESSION
    session_regenerate_id(true);
    $_SESSION["user_id"] = (int)$user["IdCliente"];
    $_SESSION["user_name"] = $user["Nombre"];

    // Redirigir
    header("Location: ../Pages/Rooms.php");
    exit;
}

?>
