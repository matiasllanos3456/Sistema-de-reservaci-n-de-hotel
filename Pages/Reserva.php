<?php
session_start();
require_once __DIR__ . '/../Complements/Connection.php';

$rooms = $_POST["rooms"] ?? [];
if (!is_array($rooms) || count($rooms) === 0) {
	$rooms = $_SESSION["rooms"] ?? [];
}
if (!is_array($rooms) || count($rooms) === 0) {
	http_response_code(400);
	exit("Debe seleccionar al menos una habitacion");
}
if (!$conexion) {
    http_response_code(500);
    exit("Error de conexion");
}

$_SESSION["rooms"] = $rooms;
?>
<!-- Variables de sesion:
    $_SESSION["user_id"]
    $_SESSION["user_name"] 
    $_SESSION["rooms"]
-->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Assets/css/stylesReserva.css">
	<title>Reserva</title>
</head>
<body>
	<h1>Reserva</h1>
	<h3>Habitaciones seleccionadas</h3>
	<ul>
		<?php foreach ($rooms as $room): ?>
            <!-- Por cada habitacion se creará un div con la informacion de la habitacion -->
			<li><?php echo htmlspecialchars($room, ENT_QUOTES, "UTF-8"); ?></li>
		<?php endforeach; ?>
	</ul>
    <!-- Debe ser un formulario que envíe la informacion a ProcesarReserva.php -->
    <!-- Apartado de ajustes: fecha_inicio, fecha_termino, metodo de pago y cuotas -->
    <form action="ProcesarReserva.php" method="post" class="form-reserva">
        <div class="settings-container">
            <label>
              Inicio
              <input type="datetime-local" name="inicio" required>
            </label>

            <label>
              Termino
              <input type="datetime-local" name="termino" required>
            </label>
            <label for="opciones">Metodo de pago:</label>
            <select id="opciones" name="opciones">
              <option value="opcion1">Debito</option>
              <option value="opcion2">Credito</option>
              <option value="opcion3">Transferencia</option>
            </select>

            <label for="opciones">Cuotas</label>
            <input type="text" class="cuotas" name="cuotas" placeholder="1" required>
        </div>
    </form>
    <!-- Boton para finalizar reservacion -->
      <!-- Si todo sale bien, los datos serán enviados a la pagina de ConfirmacionReserva.php -->
</body>
</html>