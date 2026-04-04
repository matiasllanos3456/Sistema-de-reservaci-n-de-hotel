<?php
session_start();
require_once __DIR__ . '/../Complements/Connection.php';

if (!$conexion) {
    http_response_code(500);
    exit("Error de conexion");
}
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Metodo no permitido");
}

$inicioRaw = $_POST["inicio"] ?? "";
$terminoRaw = $_POST["termino"] ?? "";
$rooms = $_SESSION["rooms"] ?? [];

if (!is_array($rooms) || count($rooms) === 0) {
    http_response_code(400);
    exit("No hay habitaciones seleccionadas");
}

try {
    $inicio = new DateTime($inicioRaw);
    $termino = new DateTime($terminoRaw);
} catch (Exception $e) {
    http_response_code(400);
    exit("Fechas invalidas");
}

if ($termino <= $inicio) {
    http_response_code(400);
    exit("La fecha de termino debe ser posterior a la de inicio");
}

$diffSeconds = $termino->getTimestamp() - $inicio->getTimestamp();
$nights = (int) ceil($diffSeconds / 86400);
if ($nights < 1) {
    $nights = 1;
}

$placeholders = implode(",", array_fill(0, count($rooms), "?"));
// Tomar el precio de cada noche
$query = "SELECT SUM(PrecioNoche) AS total_noche FROM habitacion WHERE Nombre IN ($placeholders)";
$stmt = $conexion->prepare($query);
if (!$stmt) {
    http_response_code(500);
    exit("Error en la consulta");
}

$types = str_repeat("s", count($rooms));
$stmt->bind_param($types, ...$rooms);
$stmt->execute();
$result = $stmt->get_result();
$row = $result ? $result->fetch_assoc() : null;
$totalPorNoche = $row ? (float) $row["total_noche"] : 0.0;

if ($totalPorNoche <= 0) {
    http_response_code(400);
    exit("No se pudieron obtener los precios de las habitaciones");
}

$totalReserva = $totalPorNoche * $nights;
$totalReservaFormatted = number_format($totalReserva, 2, ".", "");


// Insertar datos: Reservacion -> HabitacionReservada -> Pago
// Necesito el id del cliente para la reservacion
// Necesito el id de la habitacion y el de la reservacion para la tabla HabitacionReservada
// Necesito el id de la reservacion para la tabla de Pago

// ------- Inserta la reservacion.
$insert = $conexion->prepare("INSERT INTO reservacion (FechaInicio, FechaTermino, IdCliente) 
                              VALUES (?, ?, ?)");
if (!$insert) {
    http_response_code(500);
    exit("Error al preparar la reservacion");
}
$inicioStr = $inicio->format("Y-m-d H:i:s");
$terminoStr = $termino->format("Y-m-d H:i:s");

// Para guardar fechas se deben pasar a string
$insert->bind_param("ssi", $inicioStr, $terminoStr, $_SESSION["user_id"]);
$insert->execute();

// ------- Id de la reservacion -------------
$idReservacion = $conexion->insert_id;
$_SESSION["id_reservacion"] = $idReservacion;

// ------- Insertar la HabitacionReservada(varias instancias)

$insert2 = $conexion->prepare(
    "INSERT INTO HabitacionReservada (IdReservacion, IdHabitacion, PrecioFinal) 
    VALUES (?, ?, ?)"
);
if (!$insert2) {
    http_response_code(500);
    exit("Error al registrar la habitacion");
}

$roomLookup = $conexion->prepare(
    "SELECT IdHabitacion, PrecioNoche FROM habitacion WHERE Nombre = ?"
);
if (!$roomLookup) {
    http_response_code(500);
    exit("Error al buscar la habitacion");
}
// $roomId guarda el nombre de la habitacion, no el id que es el que se necesita
foreach ($rooms as $roomId) {
    // Se ejecutará la query para buscar el id y el precio de la habitacion
    $roomLookup->bind_param("s", $roomId);
    $roomLookup->execute();
    $roomResult = $roomLookup->get_result();
    $roomData = $roomResult ? $roomResult->fetch_assoc() : null;
    if (!$roomData) {
        http_response_code(400);
        exit("No se encontro la habitacion seleccionada");
    }
    // $roomData = {"IdHabitacion": 1, "PrecioNoche": 5000}
    $id_room = (int) $roomData["IdHabitacion"];
    $precioFinal = (float) $roomData["PrecioNoche"] * $nights;
    // La query se ejecutará la cantidad de veces deacuerdo al numero de habitaciones
    $insert2->bind_param("iid", $idReservacion, $id_room, $precioFinal);
    $insert2->execute();
}

// ------- Insertar el pago

$insert3 = $conexion->prepare("INSERT INTO pago (Cantidad, Cuotas, IdReservacion, MetodoDePago)
                               VALUES (?, ?, ?, ?)");
if (!$insert3) {
    http_response_code(500);
    exit("Error al agregar el pago");
}

$metodo_pago = $_POST["opciones"] ?? "";
$cantidad = (float) $totalReservaFormatted;
$cuotas = (int) $_POST["cuotas"] ?? 1;

$insert3->bind_param("diis", $cantidad, $cuotas, $idReservacion, $metodo_pago);
$insert3->execute();

$_SESSION["total_reserva"] = $totalReservaFormatted;

header("Location: ../Pages/ConfirmacionReserva.php");
exit;
// Al finalizar el proceso de reserva. Aquí se verificará la 
// disponibilidad de las habitaciones en el horario establecido
// Si no están disponibles manda un mensaje de error
// de lo contrario redirige los datos a la pagina de ConfirmacionReserva.php

// Aquí se creará una instancias en las siguientes tablas:
// Reserva - HabitacionReservada(varias instancias), Pago
?>