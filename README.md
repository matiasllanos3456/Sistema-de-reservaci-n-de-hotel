# Sistema-de-reservacion-de-hotel
El  sistema consistirá en una pagina que le permitirá a un usuario iniciar sesión, elegir entre varias opciones de habitaciones para reservar y proceder a realizar un pago de forma segura.

Requerimientos funcionales: - Se debe poder iniciar sesión o crear una cuenta en caso de que el cliente no tenga una
- El usuario podrá interactuar con un catalogo de habitaciones
- Al reservar se debe verificar la disponibilidad, el horario de llegada y de salida.
- Luego de la reservación se procederá al pago, el cliente debe seleccionar el tipo de pago y el numero de cuotas.
- Se emitirá una boleta al finalizar la reservación.

Requerimientos no funcionales: - La pagina debe adaptarse a distintos dispositivos
- Debe desplegarse rapidamente.
- Se utilizaran colores agradables a la vista.
- Los datos de los usuarios deberán almacenarse de forma segura

Restricciones/Validaciones de los datos: Estas se manejaran en la base de datos(MySQL) y antes de la query, en php. Estas son:
 Ningún atributos debe ser nulo.
- Los distintos IDs de las entidades deben ser únicos y NOTNULL.
- Se verificará el tipo de dato de cada campo antes de la query y también en la misma tabla.
- Se evitarán las inyecciones de sql utilizando consultas preparadas, separando el código sql de los datos ingresados por el usuario.

