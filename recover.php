<?php
require_once 'conexion.php';
//Token
$token = bin2hex(random_bytes((20 - (20 % 2)) / 2));
$fechaActual = date("Y-m-d");
//Añadir caducidad de 1 dia
$caducidad = date("Y-m-d",strtotime($fechaActual."+ ". 2 ." days"));
echo $token . " caduca ".$caducidad;

//Traer id del usuario
$correoElectronico = $_POST["correo_electronico"];
// Consulta SQL para obtener el id_usuario según el correo_electronico
$sql = "SELECT id_usuario FROM Usuarios WHERE correo_electronico = :correo";
$stmt = $cnnPDO->prepare($sql);
$stmt->bindParam(':correo', $correoElectronico);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $idUsuario = $result['id_usuario'];
    
} else {
    echo "<script>window.location = 'login.html?mensaje=No se encontró ningún registro para el correo $correoElectronico';</script>";
}

$correoEmisor = "coronasr.hikod@gmail.com";
$nombreEmisor = "Style Spectrum";
$destinatario = $_POST["correo_electronico"];
$nombreDestinatario = "Usuario";
$asunto = "Recuperación de contraseña";
$cuerpo = '

<html>
    <head>
        <title>Correo de Recuperación</title>
    </head>
    <body>
        <h1>Correo para recuperar contraseña</h1>
        <p>Hola, recibiste un correo para recuperar tu contraseña.</p>
        <p>Ingresa <a href="http://localhost/ingenieria/desarrollowebp/unidad3/StyleSpectrum/validarCaducidad.php?token='.$token.'&id='.$idUsuario.'">aquí</a>
    </body>
</html>';
$aviso = "Gracias, Correo enviado";

include('./vendor/_mail.php');

// Consulta SQL para actualizar el token y la caducidad
$sql = "UPDATE Usuarios SET token = :token, caducidad = :caducidad WHERE id_usuario = :id";
$stmt = $cnnPDO->prepare($sql);
$stmt->bindParam(':token', $token);
$stmt->bindParam(':caducidad', $caducidad);
$stmt->bindParam(':id', $idUsuario);
$stmt->execute();

echo "<script>window.location = 'login.html?mensaje2=Revise su correo, por favor';</script>"
?>
