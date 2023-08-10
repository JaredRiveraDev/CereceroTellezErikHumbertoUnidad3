<?php
session_start();
require_once 'conexion.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <!-- Agrega los enlaces a los archivos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <!-- estilos de la master page -->
    <link rel="stylesheet" href="css/master_page.css">
</head>

<body>
    <?php
    // validamos si es admin si no lo sacamos por rata
    if ($_SESSION['rol'] === "admin") {
        ?>
        <!-- Navbar admin -->
        <nav class="navbar navbar-expand-md navbar-custom">
            <div class="container">
                <!-- Logo de la empresa -->
                <a class="navbar-brand" href="admin.php">
                    <img src="img/logo.jpeg" width="150" />
                </a>
                <!-- Botón para colapsar el navbar en pantallas pequeñas -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Contenido del navbar -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">Inicio</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Productos
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="agProducto.php">Agregar productos</a>
                                <a class="dropdown-item" href="eliProducto.php">Eliminar productos</a>
                                <a class="dropdown-item" href="actProducto.php">Actualizar productos</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="inventario.php">Inventario</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pedidos.php">Pedidos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="usuarios.php">Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="configuracion.php">Configuración</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-shopping-cart cart-icon"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-user-circle profile-logo"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <br>
        <br>
        <br>
    <?php } else { ?>


        <!-- Navbar usuario -->
        <nav class="navbar navbar-expand-md navbar-custom">
            <div class="container">
                <!-- Logo de la empresa -->
                <a class="navbar-brand" onclick="seguirComprando()">
                    <img src=" img/logo.jpeg" width="150" />
                </a>
                <!-- Botón para colapsar el navbar en pantallas pequeñas -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Contenido del navbar -->
                <?php
                // Obtener el nombre de la página actual
                $currentPage = basename($_SERVER['PHP_SELF']);
                ?>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <?php if ($currentPage !== 'llenarDatos.php' && $currentPage !== 'comprar_producto.php'): ?>

                            <!-- <li class="nav-item">
                        <a class="nav-link" href="#">Inicio</a>
                    </li> -->
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="index.php?categoria=1<?= isset($_GET['carrito']) ? '&carrito=' . $_GET['carrito'] : '' ?>">Hombre</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="index.php?categoria=2<?= isset($_GET['carrito']) ? '&carrito=' . $_GET['carrito'] : '' ?>">Mujer</a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link" href="#">Ofertas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Contacto</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="tallas.php?categoria=2<?= isset($_GET['carrito']) ? '&carrito=' . $_GET['carrito'] : '' ?>">Tallas</a>
                            </li>
                            <li class=" nav-item">
                                <a class="nav-link" onclick="irAComprarProducto()">
                                    <i class="fas fa-shopping-cart cart-icon"></i>
                                    <span id="cantidad-carrito">

                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <img src="img/perfil.png" class="profile-logo" />
                                </a>
                            </li>
                        </ul>
                    <?php endif; ?>

                    <?php if ($currentPage === 'comprar_producto.php'): ?>
                        <li class="nav-item">
                            <a class="nav-link" onclick="seguirComprando()">Seguir comprando</a>
                        </li>
                    <?php endif; ?>

                </div>
            </div>
        </nav>

        <script>

            // Función para obtener la cantidad del carrito desde la URL
            function obtenerCantidadCarritoDesdeURL() {
                // Obtener el valor del parámetro 'carrito' de la URL
                const urlParams = new URLSearchParams(window.location.search);
                const carritoBase64 = urlParams.get('carrito');
                if (carritoBase64) {
                    try {
                        // Decodificar el carrito desde base64 y convertirlo a un objeto JavaScript
                        const carritoJSON = atob(carritoBase64);
                        const carrito = JSON.parse(carritoJSON);

                        // Calcular la cantidad total de productos en el carrito
                        let cantidadTotal = 0;
                        for (const item of carrito) {
                            cantidadTotal += item.cantidad;
                        }

                        return cantidadTotal;
                    } catch (error) {
                        console.error("Error al decodificar o parsear el carrito desde la URL:", error);
                    }
                }
                return 0;
            }

            // Función para actualizar la cantidad del carrito en el elemento span
            function actualizarCantidadCarrito() {
                const cantidadCarrito = obtenerCantidadCarritoDesdeURL();
                document.getElementById("cantidad-carrito").innerText = cantidadCarrito;
            }

            // Llamar a la función para actualizar la cantidad del carrito al cargar la página
            actualizarCantidadCarrito();

        </script>

    <?php } ?>
    <br>

    <!-- Agrega los enlaces a los archivos JS de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- Agrega los enlaces a los archivos JavaScript de Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <!-- Agrega los enlaces a los archivos JavaScript de Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <!-- <script src="js/carrito.js"></script> -->

</body>

</html>