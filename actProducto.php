<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Productos</title>
    <link rel="stylesheet" href="css/actproducto.css">
    <!-- Librerias de sweetalert 2-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/alertas.js"></script>

</head>

<body>

    <?php require_once 'master_page.php'; ?>
    <div class="container">
        <?php
        require_once 'conexion.php';

        // Verificar si se ha enviado el formulario con la ID del producto
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
            $id_producto = $_POST['id_producto'];
            // Realizar las operaciones necesarias con la ID del producto
            // ...
        }

        // Realizar la consulta para obtener los datos de los productos
        $sql = $cnnPDO->prepare("SELECT * FROM productos");
        $sql->execute();
        $productos = $sql->fetchAll(PDO::FETCH_ASSOC);

        // Inicializar un contador
        $contador = 0;

        // Generar las cards para cada producto
        foreach ($productos as $producto) {
            $nombre = $producto['nombre'];
            $precio = $producto['precio'];
            $talla = $producto['talla'];
            $color = $producto['color'];
            $codigo_imagen = $producto['codigo_imagen'];
            $id_producto = $producto['id_producto'];

            // Si el contador es divisible por 4, comenzar una nueva fila
            if ($contador % 4 === 0) {
                echo '<div class="row">';
            }

            // Generar la estructura de la card con los datos del producto
            echo '<div class="col-md-3">';
            echo '<div class="card card-product">';
            echo '<div>';
            echo '<input type="hidden" name="id_producto" value="' . $id_producto . '">';
            echo '<a href="actualizarProducto.php?id_producto=' . $id_producto . '"><button class="update-btn" type="submit"><i class="fas fa-sync-alt"></i></button></a> ';
            echo '</div>';
            echo '<center><img class="card-img-top" src="imgProductos/' . $codigo_imagen . '" alt="Imagen del producto" style="max-width: 200px; max-height: 200px;"></center>';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $nombre . '</h5>';
            echo '<p class="card-text">Precio: $' . $precio . '</p>';
            echo '<p class="card-text">Talla: ' . $talla . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            // echo '<a href="actualizarProducto.php?id=' . $id_producto . '"><button class="update-btn" type="submit"><i class="fas fa-sync-alt"></i></button></a> ';
        
            // Incrementar el contador
            $contador++;

            // Si el contador es divisible por 4 o se han generado todas las cards, cerrar la fila
            if ($contador % 4 === 0 || $contador === count($productos)) {
                echo '</div>';
            }
        }
        ?>
    </div>

</body>

</html>