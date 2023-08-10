<!DOCTYPE html>
<html>

<head>
    <title>Comprar Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/comprar_producto.css">
</head>

<body>
    <?php require_once 'master_page.php'; ?>

    <div class="container">
        <h1></h1>
        <div class="cart-items"></div>
        <div class="total-row-container">Total: <span id="totalCompra"></span></div>
        <a href="llenarDatos.php"><button class="checkout-btn">Realizar Compra</button></a>

    </div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const carritoBase64 = urlParams.get('carrito');
        const carritoJSON = atob(carritoBase64);
        const carrito = JSON.parse(carritoJSON);
        let totalCompra = 0;
        //document.write(carritoJSON);

        const cartItemsContainer = document.querySelector('.cart-items');


        // Función para aumentar la cantidad del producto
        function increaseQuantity(input, index) {
            const quantity = parseInt(input.value);
            if (quantity < 10) {
                input.value = quantity + 1;
                updateTotal();
                updateURL(index, input.value);
                location.reload(); // Recargar la página para guardar los cambios
            }
        }

        // Función para disminuir la cantidad del producto
        function decreaseQuantity(input, index) {
            const quantity = parseInt(input.value);
            if (quantity > 1) {
                input.value = quantity - 1;
                updateTotal();
                updateURL(index, input.value);
                location.reload(); // Recargar la página para guardar los cambios
            }
        }

        // Función para actualizar la URL con la cantidad de productos actualizada
        function updateURL(index, quantity) {
            carrito[index].cantidad = parseInt(quantity);
            const updatedCarritoJSON = JSON.stringify(carrito);
            const updatedCarritoBase64 = btoa(updatedCarritoJSON);
            const currentURL = new URL(window.location);
            currentURL.searchParams.set('carrito', updatedCarritoBase64);
            window.history.replaceState({}, '', currentURL);
        }


        // Función para actualizar el precio total del producto
        function updateTotal() {
            const quantityInputs = document.querySelectorAll('.qty-num');
            let newTotalCompra = 0;

            for (let i = 0; i < carrito.length; i++) {

                const producto = carrito[i];
                const quantity = parseInt(quantityInputs[i].value);

                // Asegurar que la cantidad no exceda el límite (10)
                const newQuantity = Math.min(Math.max(quantity, 1), 10);
                quantityInputs[i].value = newQuantity;

                const newPrecioTotal = newQuantity * producto.precio;

                newTotalCompra += newPrecioTotal;
                producto.precioTotal = newPrecioTotal;

                // Actualizar el precio total y el precio unitario para el producto actual
                const cartItemDiv = document.querySelectorAll('.cart-item')[i];
                const precioUnitarioElement = cartItemDiv.querySelector('.cart-item-details p:nth-child(3)');
                const precioTotalElement = cartItemDiv.querySelector('.cart-item-details p:nth-child(4)');
                precioUnitarioElement.innerHTML = `Precio Unitario: <b>$${producto.precio}</b>`;
                precioTotalElement.innerHTML = `Precio Total: <b>$${newPrecioTotal}</b>`;
            }

            totalCompra = newTotalCompra;
            const totalCompraSpan = document.getElementById('totalCompra');
            totalCompraSpan.textContent = `$${totalCompra}`;
        }
        for (let i = 0; i < carrito.length; i++) {
            carrito[i].index = i;
        }


        for (const producto of carrito) {
            const cartItemDiv = document.createElement('div');
            cartItemDiv.classList.add('cart-item');

            cartItemDiv.innerHTML = `
                <img src="imgProductos/${producto.codigo_imagen}" alt="${producto.codigo_imagen}" class="cart-item-image">
                <div class="cart-item-info-container">
                    <div class="cart-item-details">
                        <h3>${producto.nombre}</h3>
                        <div class="quantity-input">
                        <div class="quantity-btn" onclick="decreaseQuantity(this.nextElementSibling, ${producto.index})">&minus;</div>
                        <input class="qty-num" type="text" value="${producto.cantidad}" onchange="updateTotal()" onkeyup="this.value = this.value.replace(/[^0-9]/, '')">
                        <div class="quantity-btn" onclick="increaseQuantity(this.previousElementSibling, ${producto.index})">&#43;</div>
                        </div>
                        <p>Precio Unitario: <b>$${producto.precio}</b></p>
                        <p>Precio Total: <b>$${producto.precioTotal}</b></p>
                        <div class="color-talla" >Talla: ${producto.talla}</div>
                    </div>
                </div>`;

            cartItemsContainer.appendChild(cartItemDiv);
            totalCompra += producto.precioTotal;
        }

        const totalCompraSpan = document.getElementById('totalCompra');
        totalCompraSpan.textContent = `$${totalCompra}`;

    </script>
    <script src="js/funcionesCarrito.js"></script>
</body>


</html>