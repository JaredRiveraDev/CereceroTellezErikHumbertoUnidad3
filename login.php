<?php
session_start();
require_once 'conexion.php';

if (isset($_POST['enviar'])) {

  $correo_electronico = $_POST['correo_electronico'];
  $contrasena = $_POST['contrasena'];

  $sql = $cnnPDO->prepare('SELECT * from usuarios WHERE correo_electronico=:correo_electronico AND contrasena=:contrasena');
  $sql->bindParam(':correo_electronico', $correo_electronico);
  $sql->bindParam(':contrasena', $contrasena);
  $sql->execute();
  $count = $sql->rowCount();

  $valor = "-1";

  if ($count == intval($valor)) {
    $query = $cnnPDO->prepare('SELECT * from usuarios WHERE correo_electronico=:correo_electronico');
    $query->bindParam(':correo_electronico', $correo_electronico);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    $rol = $row['roles'];
    $id_usuario = $row['id_usuario'];

    if ($rol == "admin") {
      $_SESSION['id_usuario'] = $id_usuario;
      $_SESSION['rol'] = $rol;
      echo "<script>window.location='admin.php'</script>";
    } else if ($rol == "usaurio") {
      $_SESSION['id_usuario'] = $id_usuario;
      $_SESSION['rol'] = $rol;
      echo "<script>window.location='index.php'</script>";
    }
    exit;
  } else {
    header("location:login.html?mensaje=Correo o contraseña incorrectos");
  }
}
?>