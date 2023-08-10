<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>inicio</title>
  <link rel="stylesheet" href="css/index.css">
</head>

<body>
  <?php require_once 'master_page.php'; ?>

  <div class="container">
    <div class="row">
      <?php
      require_once 'conexion.php';

      // Verificar si el parámetro 'carrito' está presente en la URL
      if (isset($_GET['carrito'])) {
        // Obtener el valor del parámetro 'carrito'
        $carritoBase64 = $_GET['carrito'];

        // Decodificar el carrito desde base64
        $carritoJSON = base64_decode($carritoBase64);

        // Convertir el JSON decodificado a un array de productos
        $carrito = json_decode($carritoJSON, true);
        //print_r($carrito);
      } else {
        // Si el parámetro 'carrito' no está presente en la URL, el carrito está vacío.
        $carrito = array();
      }

      // Obtener el carrito en formato JSON
      $carritoJSON = json_encode($carrito);

      // Codificar el carrito en base64 para que la URL no tenga problemas con caracteres especiales
      $carritoBase64 = base64_encode($carritoJSON);

      $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : 1;

      // Obtener los datos encriptados del carrito de compras si existen
      $carritoEncriptado = isset($_GET['carrito']) ? $_GET['carrito'] : '';


      // Realizar la consulta para obtener los datos de los productos
      $sql = $cnnPDO->prepare("SELECT * FROM productos WHERE id_categoria = :categoria");
      $sql->bindParam(':categoria', $categoria);
      $sql->execute();
      $productos = $sql->fetchAll(PDO::FETCH_ASSOC);

      // Generar las cards para cada producto
      foreach ($productos as $producto) {
        $nombre = $producto['nombre'];
        $precio = $producto['precio'];
        $talla = $producto['talla'];
        $color = $producto['color'];
        $codigo_imagen = $producto['codigo_imagen'];
        $id_producto = $producto['id_producto'];
        ?>

        <div class="col-md-3">
          <div class="card">
            <div class="card-image">
              <a href="detalle_producto.php?id_producto=<?php echo $id_producto; ?>&codigo_imagen=<?php echo $codigo_imagen; ?>&nombre=<?php echo $nombre; ?>&precio=<?php echo $precio; ?>&carrito=<?php echo empty($carrito) ? '' : $carritoBase64; ?>&categoria=<?php echo $categoria; ?>"
                style="text-decoration: none; color: inherit;">
                <img class="card-img-top" src="imgProductos/<?php echo $codigo_imagen; ?>" alt="Imagen del producto">
                <div class="card-overlay">
                  <div class="card-overlay-text">

                    Precio: $
                    <?php echo $precio; ?>
                    <br>
                    Descripción:
                    <?php echo $nombre; ?>

                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>



        <?php
      }
      ?>
    </div>
  </div>
  <script src="js/funcionesCarrito.js"></script>
</body>

</html>