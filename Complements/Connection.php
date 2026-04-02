<?php
    // Conexion a la base de datos
    // servidor, nombre de usuario, contraseña(ninguna por default), nombre de la BD, puerto
    $conexion = mysqli_connect("localhost", "root", "", "reservacioneshotel", 3307);
    // Este script debe ser incluido en cada pagina/proceso que necesite
    // realizar una consulta a la base de datos
?>