<?php
require_once 'conexion.php';
$token = $_GET["token"];
$idUsuario = $_GET["id"];

// Suponiendo que ya tienes la conexión a la base de datos establecida
$consulta = "SELECT caducidad, token FROM Usuarios WHERE id_usuario = :id_usuario";
$stmt = $cnnPDO->prepare($consulta);
$stmt->bindParam(':id_usuario', $idUsuario);
$stmt->execute();

$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

if ($resultado) {
    $fechaCaducidad = $resultado['caducidad'];
    $fechaActual = date("Y-m-d");
    
    if ($fechaCaducidad > $fechaActual) {
        // La fecha de caducidad es mayor que la fecha actual
        
        if($token == $resultado['token']){
            echo "<script>window.location = 'recuperar.html?id=$idUsuario'</script>";
        }else{
            echo "<script>window.location = 'login.html?mensaje=El token no es correcto. Intente de nuevo';</script>";    
        }
        
    } else {
        // La fecha de caducidad ha expirado
        echo "<script>window.location = 'login.html?mensaje=El token ha expirado. Intente de nuevo.';</script>";
    }
} else {
    echo "No se encontró el usuario.";
}


?>