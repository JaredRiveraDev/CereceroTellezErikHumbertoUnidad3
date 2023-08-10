<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    // traemos el nav de la master_page
    require_once 'master_page.php';

    ?>
    <?php
    // Verificar si el usuario ha iniciado sesión y tiene el rol de administrador
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
        header('Location: login.html'); // Redirigir al inicio de sesión si no es un administrador
        exit;
    }
    ?>
</body>

</html>