<?php
require_once 'conexion.php';

if (isset($_POST['registrar'])) {
    // Obtener los valores de los campos del formulario
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $correo_electronico = $_POST['correo_electronico'];
    $contrasena = $_POST['contrasena'];


    // Verificar si los campos no están vacíos
    if (!empty($nombre) && !empty($direccion) && !empty($correo_electronico) && !empty($contrasena)) {
        // Realizar las operaciones de registro en la base de datos
        $roles = "usaurio";
        // Ejemplo de inserción en una tabla llamada 'usuarios'
        $sql = $cnnPDO->prepare("INSERT INTO usuarios (nombre, direccion, correo_electronico, contrasena,roles) VALUES (:nombre, :direccion, :correo_electronico, :contrasena,:roles)");

        $sql->bindParam(':nombre', $nombre);
        $sql->bindParam(':direccion', $direccion);
        $sql->bindParam(':correo_electronico', $correo_electronico);
        $sql->bindParam(':contrasena', $contrasena);
        $sql->bindParam(':roles', $roles);

        $sql->execute();
        unset($sql);

        // Redireccionar a otra página después del registro exitoso
        header("location:login.html?mensaje2=Se registro exitosamente");
        exit();
    } else {
        echo "Por favor, completa todos los campos.";
    }
}
?>