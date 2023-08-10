<?php
ob_start();
require_once 'conexion.php';

if (isset($_POST['actualizar'])) {

    $id_producto = 3;


    // Obtener los valores actualizados del formulario
    $nombre_actualizado = $_POST['nombre_producto'];
    $precio_actualizado = $_POST['precio'];
    $cantidad_actualizada = $_POST['cantidad'];
    $id_categoria_actualizada = $_POST['id_categoria'];
    $color_actualizado = $_POST['color'];
    $talla_actualizada = $_POST['talla'];

    // Verificar si se ha enviado una nueva imagen
    if (isset($_FILES['imagen_producto']) && $_FILES['imagen_producto']['error'] === UPLOAD_ERR_OK) {
        // Obtener información de la nueva imagen
        $nombre_archivo_nuevo = $_FILES['imagen_producto']['name'];
        $ruta_destino_nueva = 'imgProductos/' . $nombre_archivo_nuevo;

        // Mover la nueva imagen al directorio de destino
        move_uploaded_file($_FILES['imagen_producto']['tmp_name'], $ruta_destino_nueva);

        // Actualizar el nombre de la imagen en la base de datos y en la variable $codigo_imagen
        $codigo_imagen = $nombre_archivo_nuevo;
    }

    // Realizar la consulta para actualizar los datos del producto en la base de datos
    $sql = $cnnPDO->prepare("UPDATE productos
        SET nombre = :nombre, precio = :precio, id_categoria = :id_categoria,
            color = :color, talla = :talla
        WHERE id_producto = :id_producto
    ");

    $sql->bindParam(':nombre', $nombre_actualizado);
    $sql->bindParam(':precio', $precio_actualizado);
    $sql->bindParam(':id_categoria', $id_categoria_actualizada);
    $sql->bindParam(':color', $color_actualizado);
    $sql->bindParam(':talla', $talla_actualizada);
    $sql->bindParam(':id_producto', $id_producto);
    $sql->execute();

    $sql2 = $cnnPDO->prepare("UPDATE inventario
        SET cantidad = :cantidad
        WHERE id_producto = :id_producto
    ");

    $sql2->bindParam(':cantidad', $cantidad_actualizada);
    $sql2->bindParam(':id_producto', $id_producto);
    $sql2->execute();

    $resultado = $sql;
    if ($resultado) {
        // Redireccionar a actProducto.php
        header('Location: actProducto.php?mensaje2=Se actualizó el producto correctamente');
        exit();
    } else {
        echo "Error al actualizar el producto";
    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


</head>

<body>
    <?php
    ob_start();
    // traemos el nav de la master_page
    require_once 'master_page.php';
    // validamos si es admin si no lo sacamos por rata
    if (isset($_SESSION['rol']) != "admin") {
        header("Location:login.html");
    }

    ?>
    <?php
    // Verificar si se envió una ID de producto o si las variables están definidas
    if (isset($_GET['id_producto'])) {
        // Obtener la ID del producto si está definida
        $id_producto = isset($_GET['id_producto']) ? $_GET['id_producto'] : '';

        // Realizar la consulta para obtener los datos del producto y del inventario según la ID
        $sql = $cnnPDO->prepare("SELECT p.* , p.nombre AS nombre_producto, i.*, c.* FROM productos p JOIN inventario i ON p.id_producto = i.id_producto JOIN categorias c ON p.id_categoria = c.id_categoria WHERE p.id_producto = :id");
        $sql->bindParam(':id', $id_producto);
        $sql->execute();
        $producto = $sql->fetch(PDO::FETCH_ASSOC);

        // Asignar los valores a las variables correspondientes
        $nombre = isset($producto['nombre_producto']) ? $producto['nombre_producto'] : '';
        $precio = isset($producto['precio']) ? $producto['precio'] : '';
        $cantidad = isset($producto['cantidad']) ? $producto['cantidad'] : '';
        $id_categoria = isset($producto['id_categoria']) ? $producto['id_categoria'] : '';
        $color = isset($producto['color']) ? $producto['color'] : '';
        $talla = isset($producto['talla']) ? $producto['talla'] : '';

        // Obtener el valor de la imagen del producto
        if (isset($_FILES['imagen_producto']['name'])) {
            $nombre_archivo = $_FILES['imagen_producto']['name'];
            $ruta_destino = 'imgProductos/' . $nombre_archivo;

            // Mover la imagen al directorio de destino
            move_uploaded_file($_FILES['imagen_producto']['tmp_name'], $ruta_destino);

            // Asignar el nombre de la imagen al campo codigo_imagen
            $codigo_imagen = $nombre_archivo;
        } else {
            $codigo_imagen = isset($producto['codigo_imagen']) ? $producto['codigo_imagen'] : '';
        }
    } else {

        header('Location: actProducto.php'); // Redireccionar a actProducto.php
        exit; // Detener la ejecución del resto del código
    }


    ?>

    <div class="container">
        <div class="add-product-container">
            <h2 class="text-center">Agregar Producto:</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Nombre del producto:</label>
                    <input type="text" class="form-control" id="nombre_producto" name="nombre_producto"
                        placeholder="Ingrese el nombre del producto" required
                        value="<?php echo isset($nombre) ? $nombre : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="price">Precio del producto:</label>
                    <input type="number" class="form-control" id="price" name="precio"
                        placeholder="Ingrese el precio del producto" required
                        value="<?php echo isset($precio) ? $precio : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="price">Piezas en el inventario:</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad"
                        placeholder="Ingrese la cantidad del producto en el inventario" required
                        value="<?php echo isset($cantidad) ? $cantidad : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="categoria">Categoría del producto:</label>
                    <select class="custom-select" id="id_categoria" name="id_categoria" required>
                        <!-- <option value="">Seleccionar categoría</option> -->
                        <?php
                        // Realizar la consulta para obtener los datos de las categorías
                        $sql = $cnnPDO->prepare("SELECT * FROM categorias");
                        $sql->execute();
                        $categorias = $sql->fetchAll(PDO::FETCH_ASSOC);

                        // Generar las opciones del select con los datos de las categorías
                        foreach ($categorias as $categoria) {
                            $id_categoria = $categoria['id_categoria'];
                            $nombre_categoria = $categoria['nombre'];
                            $selected = ($id_categoria == $id_categoria_producto) ? 'selected' : '';
                            echo '<option value="' . $id_categoria . '" ' . $selected . '>' . $nombre_categoria . '</option>';
                        }
                        ?>
                    </select>

                </div>

                <div class="form-group">
                    <label for="image">Imagen del producto:</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="imagen_producto" name="imagen_producto">
                        <label class="custom-file-label" for="imagen_producto">Seleccionar archivo</label>
                    </div>
                    <?php
                    // Mostrar el nombre de la imagen actual si está definido
                    if (isset($codigo_imagen)) {
                        echo '<p>Imagen actual: ' . $codigo_imagen . '</p>';
                    }
                    ?>
                    <p>Seleccionar una nueva imagen:</p>
                    <input type="file" name="nueva_imagen">
                </div>


                <div class="form-group">
                    <label for="color">Color:</label>
                    <div class="input-group colorpicker">
                        <input type="color" id="color" name="color" class="form-control form-control-color" required
                            value="<?php echo isset($color) ? $color : ''; ?>">
                        <div class="input-group-append">
                            <span class="input-group-text color-preview"></span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="size">Talla del producto:</label><br>
                    <div class="form-check-inline">
                        <input type="radio" class="form-check-input" id="sizeXG" name="talla" value="XG" <?php echo isset($talla) && $talla == 'XG' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="sizeXG">XG</label>
                    </div>
                    <div class="form-check-inline">
                        <input type="radio" class="form-check-input" id="sizeG" name="talla" value="G" <?php echo isset($talla) && $talla == 'G' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="sizeG">G</label>
                    </div>
                    <div class="form-check-inline">
                        <input type="radio" class="form-check-input" id="sizeM" name="talla" value="M" <?php echo isset($talla) && $talla == 'M' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="sizeM">M</label>
                    </div>
                    <div class="form-check-inline">
                        <input type="radio" class="form-check-input" id="sizeCH" name="talla" value="CH" <?php echo isset($talla) && $talla == 'CH' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="sizeCH">CH</label>
                    </div>
                </div>

                <button type="submit" name="actualizar" class="btn btn-primary btn-block"
                    onclick="return confirm('!Seguro que quiere actualizar el producto¡')">Actualizar Producto</button>


            </form>
        </div><br><br>

    </div>
</body>

</html>