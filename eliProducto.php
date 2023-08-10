<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Productos</title>
    <link rel="stylesheet" href="css/eliproducto.css">
    <!-- Librerias de sweetalert 2-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/alertas.js"></script>
    <script>
        const eliminarProducto = (id_producto) => {
            let resultado = confirm("¿Estás seguro de eliminar el producto?");
            if (resultado) {
                return true; // Se envía el formulario y se ejecuta la acción de eliminación
            } else {
                return false; // No se envía el formulario
            }
        }
    </script>

</head>

<body>

    <?php require_once 'master_page.php'; ?>

    <div class="container">
        <?php
        require_once 'conexion.php';

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
            echo '<form method="POST" action="eliminarProducto.php">';
            echo '<div>';
            echo '<button class="delete-btn" name="eliminar" type="submit" onclick="return eliminarProducto(' . $id_producto . ')"><i class="fas fa-times"></i> </button>'; // Mantén el tipo de botón como "submit"
            echo '<input type="hidden" name="id_producto" value="' . $id_producto . '">';
            echo '</div>';
            echo '<center><img class="card-img-top" src="imgProductos/' . $codigo_imagen . '" alt="Imagen del producto" style="max-width: 200px; max-height: 200px;"></center>';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $nombre . '</h5>';
            echo '<p class="card-text">Precio: $' . $precio . '</p>';
            echo '<p class="card-text">Talla: ' . $talla . '</p>';
            echo '</div>';
            echo '</form>';
            echo '</div>';
            echo '</div>';



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