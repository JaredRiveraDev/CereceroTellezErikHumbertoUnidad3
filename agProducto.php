<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar Producto</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/agg_producto.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <!-- Librerias de sweetalert 2-->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="js/alertas.js"></script>
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
  <div class="container">
    <div class="add-product-container">
      <h2 class="text-center">Agregar Producto:</h2>
      <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="name">Nombre del producto:</label>
          <input type="text" class="form-control" id="name" name="nombre" placeholder="Ingrese el nombre del producto"
            required>
        </div>

        <div class="form-group">
          <label for="price">Precio del producto:</label>
          <input type="number" class="form-control" id="price" name="precio"
            placeholder="Ingrese el precio del producto" required>
        </div>
        <div class="form-group">
          <label for="price">Piesas en el inventario:</label>
          <input type="number" class="form-control" id="cantidad" name="cantidad"
            placeholder="Ingrese la cantidad del producto en el inventario" required>
        </div>
        <div class="form-group">
          <label for="categoria">Categoría del producto:</label>
          <select class="custom-select" id="id_categoria" name="id_categoria" required>
            <option value="">Seleccionar categoría</option>

            <?php

            // Realizar la consulta para obtener los datos de las categorías
            $sql = $cnnPDO->prepare("SELECT * FROM categorias");
            $sql->execute();
            $categorias = $sql->fetchAll(PDO::FETCH_ASSOC);

            // Generar las opciones del select con los datos de las categorías
            foreach ($categorias as $categoria) {
              $id_categoria = $categoria['id_categoria'];
              $nombre_categoria = $categoria['nombre'];
              echo '<option value="' . $id_categoria . '">' . $nombre_categoria . '</option>';
            }
            ?>

          </select>
        </div>
        <div class="form-group">
          <label for="image">Imagen del producto:</label>
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="imagen_producto" name="imagen_producto" required>
            <label class="custom-file-label" for="imagen_producto">Seleccionar archivo</label>
          </div>
        </div>
        <div class="form-group">
          <label for="color">Color:</label>
          <div class="input-group colorpicker">
            <input type="color" id="color" name="color" class="form-control form-control-color" required>
            <div class="input-group-append">
              <span class="input-group-text color-preview"></span>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="size">Talla del producto:</label><br>
          <div class="form-check-inline">
            <input type="radio" class="form-check-input" id="sizeXG" name="talla" value="XG">
            <label class="form-check-label" for="sizeXG">XG</label>
          </div>
          <div class="form-check-inline">
            <input type="radio" class="form-check-input" id="sizeG" name="talla" value="G">
            <label class="form-check-label" for="sizeG">G</label>
          </div>
          <div class="form-check-inline">
            <input type="radio" class="form-check-input" id="sizeM" name="talla" value="M">
            <label class="form-check-label" for="sizeM">M</label>
          </div>
          <div class="form-check-inline">
            <input type="radio" class="form-check-input" id="sizeM" name="talla" value="M">
            <label class="form-check-label" for="sizeM">CH</label>
          </div>
        </div>

        <button type="submit" name="subir_producto" class="btn btn-primary btn-block">Agregar Producto</button>
      </form>
    </div>
  </div>
</body>

</html>

<?php
require_once 'conexion.php';

if (isset($_POST['subir_producto'])) {
  // Obtener los valores de los campos del formulario
  $nombre = $_POST['nombre'];
  $precio = $_POST['precio'];
  $talla = $_POST['talla'];
  $color = $_POST['color'];
  $cantidad = $_POST['cantidad'];
  $imagen_producto = $_FILES['imagen_producto'];
  $id_categoria = $_POST['id_categoria']; // Obtener el valor de id_categorias

  // Ruta de la carpeta donde se guardarán las imágenes
  $directorio_imagenes = 'D:\xampp\htdocs\StyleSpectrum\imgProductos\\';

  // Verificar si los campos no están vacíos
  if (!empty($nombre) && !empty($precio) && !empty($talla) && !empty($color) && !empty($imagen_producto) && !empty($cantidad) && !empty($id_categoria)) {
    // Obtener el nombre y la extensión del archivo
    $nombre_archivo = $imagen_producto['name'];
    $extension_archivo = pathinfo($nombre_archivo, PATHINFO_EXTENSION);

    // Generar un nombre único para el archivo combinando uniqid() y la extensión del archivo original
    $nombre_unico = uniqid() . '.' . $extension_archivo;

    // Ruta completa del archivo en la carpeta de imágenes
    $ruta_imagen = $directorio_imagenes . $nombre_unico;

    // Guardar el nombre único como código de imagen
    $codigo_imagen = $nombre_unico;

    // Mover el archivo a la carpeta de imágenes
    move_uploaded_file($imagen_producto['tmp_name'], $ruta_imagen);

    // Realizar las operaciones de registro en la base de datos
    $sql = $cnnPDO->prepare("INSERT INTO productos (nombre, precio, talla, color, codigo_imagen, id_categoria) VALUES (:nombre, :precio, :talla, :color, :codigo_imagen, :id_categoria); 
                            DECLARE @id_producto INT; SET @id_producto = SCOPE_IDENTITY();  
                            INSERT INTO inventario (id_producto, cantidad) VALUES (@id_producto, :cantidad);");

    $sql->bindParam(':nombre', $nombre);
    $sql->bindParam(':precio', $precio);
    $sql->bindParam(':talla', $talla);
    $sql->bindParam(':color', $color);
    $sql->bindParam(':cantidad', $cantidad);
    $sql->bindParam(':codigo_imagen', $codigo_imagen);
    $sql->bindParam(':id_categoria', $id_categoria);

    $sql->execute();
    unset($sql);

    // Redireccionar a otra página después del registro exitoso
    header("location:agProducto.php?mensaje2=Se registró el producto exitosamente");

    exit();
  } else {
    echo "Por favor, completa todos los campos.";
  }
}
ob_end_flush();
?>