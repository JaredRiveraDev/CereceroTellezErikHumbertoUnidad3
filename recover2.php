<?php
require_once 'conexion.php';

if (isset($_POST['enviar'])) {
    // Obtener los valores de los campos del formulario
    $contrasena = $_POST['new_contraseña'];
    $idUsuario = $_POST['idUsuario']; // Suponiendo que el campo hidden se llama id_usuario

    // Actualizar la contraseña, eliminar el token y la fecha de caducidad
    try {
        echo $idUsuario;
        $sql = "UPDATE Usuarios SET contrasena = :contrasena, token = NULL, caducidad = NULL WHERE id_usuario = :id";
        $stmt = $cnnPDO->prepare($sql);
        $stmt->bindParam(':contrasena', $contrasena);
        $stmt->bindParam(':id', $idUsuario);
        $stmt->execute();
        header("location:login.html?mensaje2=Contraseña cambiada exitosamente");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
