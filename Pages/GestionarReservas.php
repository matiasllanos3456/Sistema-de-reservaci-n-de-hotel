<?php
session_start();
require_once __DIR__ . '/../Complements/Connection.php';

$notice = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";

    if ($action === "delete_user") {
        $userId = (int) ($_SESSION["user_id"] ?? 0);
        $reservacionId = (int) ($_SESSION["id_reservacion"] ?? 0);

        // Validaciones por si el usuario aun no tiene reservaciones
        if ($userId <= 0) {
            $notice = "No se encontro el usuario en la sesion.";
        } elseif ($reservacionId <= 0) {
            $notice = "No se encontro una reservacion activa para borrar.";
        } elseif (!$conexion) {
            $notice = "Error de conexion.";
        } else {
            // Para borrar la ultima reservacion que realizo el cliente en sesion, primero se debe borrar las instancias en donde
            // el IdReservacion aparezca en la tabla de HabitacionReservada, luego hay que borrar la instancia en
            // la tabla del pago en donde aparesca el IdReservacion y por ultimo se borra la reservacion.
            // $borrar1 = DELETE FROM habitacionreservada WHERE IdReservacion = $reservacionId;
            // Borrar las filas en HabitacionReservada: 
            $borrar1 = $conexion->prepare("DELETE FROM habitacionreservada WHERE IdReservacion = ?");
            // $borrar2 = DELETE FROM pago WHERE IdReservacion = $reservacionId;
            $borrar2 = $conexion->prepare("DELETE FROM pago WHERE IdReservacion = ?");
            // $borrar3 = DELETE FROM reservacion WHERE IdReservacion = $reservacionId;
            $borrar3 = $conexion->prepare("DELETE FROM reservacion WHERE IdReservacion = ?");

            if (!$borrar1 || !$borrar2 || !$borrar3) {
                $notice = "Error en la consulta.";
            } else {
                // Ejecución
                $borrar1->bind_param("i", $reservacionId);
                $borrar1->execute();

                $borrar2->bind_param("i", $reservacionId);
                $borrar2->execute();

                $borrar3->bind_param("i", $reservacionId);
                $borrar3->execute();

                // Limpiar por completo la sesion
                $_SESSION = [];
                if (ini_get("session.use_cookies")) {
                    $params = session_get_cookie_params();
                    setcookie(
                        session_name(),
                        "",
                        time() - 42000,
                        $params["path"],
                        $params["domain"],
                        $params["secure"],
                        $params["httponly"]
                    );
                }
                session_destroy();

                header("Location: Rooms.php");
                exit;
            }
        }
    }
}
// Se reiniciaran las variables que guardan la sesion del usuario
$roomsValue = $_SESSION["rooms"] ?? [];
$roomsText = is_array($roomsValue) ? implode(", ", $roomsValue) : (string) $roomsValue;
$inicioValue = $_SESSION["inicio"] ?? "";
$finValue = $_SESSION["fin"] ?? "";
$montoValue = $_SESSION["monto_total"] ?? "";
$usuarioValue = $_SESSION["user_name"] ?? "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Assets/css/stylesGestionarReservas.css">
    <title>Gestionar Reservas</title>
</head>
<body>
    <div class="page">
        <header class="page-header">
            <div>
                <h1>Gestionar Reservas</h1>
            </div>
            <a class="back-button" href="Rooms.php">Volver a habitaciones</a>
        </header>

        <?php if ($notice !== ""): ?>
            <div class="notice">
                <?php echo htmlspecialchars($notice, ENT_QUOTES, "UTF-8"); ?>
            </div>
        <?php endif; ?>

        <section class="card">
            <h2>Datos actuales</h2>
            <div class="summary">
                <div>
                    <span class="label">Usuario</span>
                    <span><?php echo htmlspecialchars($usuarioValue, ENT_QUOTES, "UTF-8"); ?></span>
                </div>
                <div>
                    <span class="label">Habitaciones</span>
                    <span><?php echo htmlspecialchars($roomsText, ENT_QUOTES, "UTF-8"); ?></span>
                </div>
                <div>
                    <span class="label">Inicio</span>
                    <span><?php echo htmlspecialchars($inicioValue, ENT_QUOTES, "UTF-8"); ?></span>
                </div>
                <div>
                    <span class="label">Termino</span>
                    <span><?php echo htmlspecialchars($finValue, ENT_QUOTES, "UTF-8"); ?></span>
                </div>
                <div>
                    <span class="label">Monto total</span>
                    <span><?php echo htmlspecialchars($montoValue, ENT_QUOTES, "UTF-8"); ?></span>
                </div>
            </div>
        </section>

        <section class="card">
            <h2>Eliminar reservacion activa</h2>
            <form method="post" class="form-grid">
                <input type="hidden" name="action" value="delete_user">
                <button type="submit" class="danger">Eliminar</button>
            </form>
        </section>
    </div>
</body>
</html>
