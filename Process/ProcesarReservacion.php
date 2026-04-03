<?php
session_start();
require_once __DIR__ . '/../Complements/Connection.php';

if (!$conexion) {
    http_response_code(500);
    exit("Error de conexion");
}
// Al finalizar el proceso de reserva. Aquí se verificará la 
// disponibilidad de las habitaciones en el horario establecido
// Si no están disponibles manda un mensaje de error
// de lo contrario redirige los datos a la pagina de ConfirmacionReserva.php

// Aquí se creará una instancias en las siguientes tablas:
// Reserva - HabitacionReservada(varias instancias), Pago
?>