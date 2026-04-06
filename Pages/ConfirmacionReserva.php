<?php
session_start();

$roomsValue = $_SESSION["rooms"] ?? [];
$roomsText = is_array($roomsValue) ? implode(", ", $roomsValue) : (string) $roomsValue;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Assets/css/stylesConfirmation.css">
    <title>ConfirmarReservacion</title>
</head>
<body>
    <div class="confirm-container">
        <h1>Reservacion confirmada</h1>
        <label for="">Nombre: <?php echo htmlspecialchars($_SESSION["user_name"] ?? "", ENT_QUOTES, "UTF-8"); ?></label>
        <label for="">Habitaciones: <?php echo htmlspecialchars($roomsText, ENT_QUOTES, "UTF-8"); ?></label>
        <label for="">Fecha inicio: <?php echo htmlspecialchars($_SESSION["inicio"] ?? "", ENT_QUOTES, "UTF-8"); ?></label>
        <label for="">Fecha termino: <?php echo htmlspecialchars($_SESSION["fin"] ?? "", ENT_QUOTES, "UTF-8"); ?></label>
        <label for="">Monto total: <?php echo htmlspecialchars($_SESSION["monto_total"] ?? "", ENT_QUOTES, "UTF-8"); ?></label>
        <a href="Rooms.php" class="back-button">Volver al inicio</a>
        
    </div>
</body>
</html>