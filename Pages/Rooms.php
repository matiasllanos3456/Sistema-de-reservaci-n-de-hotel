

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Assets/css/stylesRooms.css">
    <title>Habitaciones</title>
</head>
<body>
    <div class="header">
        <a class="back-button" href="LogIn.php">Volver</a>
        <h1>Habitaciones</h1>
        <i class="fa-solid fa-gear fa-2xl" style="color: #1e3a8a;" class="settings-button"></i>
    </div>
    <!-- Las habitaciones seleccionadas serán validadas en la pagina de Reserva.php -->
    <form action="../Pages/Reserva.php" method="post" id="rooms-form">
        <div class="catalogo-container">
            <div class="room-container">
                <div class="img-container">
                    <img src="../Assets/img/Habitacion1plaza.jpg" alt="">
                </div>
                <div class="description-container">
                    <h3>Habitacion matrimonial</h3>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eligendi distinctio nihil inventore autem dicta doloribus unde.</p>
                    <div class="icons-container">
                        <div class="icon-block">
                            <i class="fa-solid fa-bed" style="color: #1e3a8a;"></i>
                            <span>1</span>
                        </div>
                        <div class="icon-block">
                            <i class="fa-solid fa-dollar-sign" style="color: #1e3a8a;"></i>
                            <span>$6000</span>
                        </div>
                        <!-- El valor del input debe coincidir con el nombre de la habitacion en la BD -->
                        <input type="checkbox" class="check" name="rooms[]" value="H_Matrimonial">
                    </div>
                </div>
            </div>
            <div class="room-container">
                <div class="img-container">
                    <img src="../Assets/img/Habitacion2camas.jpg" alt="">
                </div>
                <div class="description-container">
                    <h3>Habitacion deluxe</h3>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eligendi distinctio nihil inventore autem dicta doloribus unde.</p>
                    <div class="icons-container">
                        <div class="icon-block">
                            <i class="fa-solid fa-bed" style="color: #1e3a8a;"></i>
                            <span>2</span>
                        </div>
                        <div class="icon-block">
                            <i class="fa-solid fa-dollar-sign" style="color: #1e3a8a;"></i>
                            <span>$12000</span>
                        </div>
                        <input type="checkbox" class="check" name="rooms[]" value="H_Deluxe">
                    </div>
                </div>

            </div>
            <div class="room-container">
                <div class="img-container">
                    <img src="../Assets/img/habitacion-triple-3-camas.jpg" alt="">
                </div>
                <div class="description-container">
                    <h3>Habitacion triple</h3>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eligendi distinctio nihil inventore autem dicta doloribus unde.</p>
                    <div class="icons-container">
                        <div class="icon-block">
                            <i class="fa-solid fa-bed" style="color: #1e3a8a;"></i>
                            <span>3</span>
                        </div>
                        <div class="icon-block">
                            <i class="fa-solid fa-dollar-sign" style="color: #1e3a8a;"></i>
                            <span>$8500</span>
                        </div>
                        <input type="checkbox" class="check" name="rooms[]" value="H_Triple">
                    </div>
                </div>
            </div>
            <div class="room-container">
                <div class="img-container">
                    <img src="../Assets/img/Habitacion4camas.png" alt="">
                </div>
                <div class="description-container">
                    <h3>Habitacion familiar</h3>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eligendi distinctio nihil inventore autem dicta doloribus unde.</p>
                    <div class="icons-container">
                        <div class="icon-block">
                            <i class="fa-solid fa-bed" style="color: #1e3a8a;"></i>
                            <span>4</span>
                        </div>
                        <div class="icon-block">
                            <i class="fa-solid fa-dollar-sign" style="color: #1e3a8a;"></i>
                            <span>$10000</span>
                        </div>
                        <input type="checkbox" class="check" name="rooms[]" value="H_Familiar">
                    </div>
                </div>
            </div>
        </div>
        <!-- Si no se han seleccionado habitaciones no funcionará el boton -->
        <button class="boton-reservar" name="reserva" type="submit" disabled>Reservar</button>
    </form>
    <footer>
        CopyRight 302094932. Todos los derechos reservados
        Servicio al cliente: - Telefono: 3043992922030
                             - Correo: Juanin234@gmail.com
                             - Chillan, Chile
    </footer>
    <!-- Fuente de iconos -->
     <script src="https://kit.fontawesome.com/b9285facdc.js" crossorigin="anonymous"></script>
     <script>
        const form = document.getElementById("rooms-form");
        const checks = Array.from(form.querySelectorAll(".check"));
        const submitBtn = form.querySelector(".boton-reservar");

        // Verificar que almenos una habitacion haya sido seleccionada
        function syncButtonState() {
            const anyChecked = checks.some((check) => check.checked);
            submitBtn.disabled = !anyChecked;
        }

        checks.forEach((check) => check.addEventListener("change", syncButtonState));
        syncButtonState();
     </script>
</body>
</html>