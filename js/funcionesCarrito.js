// function irAComprarProducto() {
//   // Verificar si ya hay información encriptada en la URL
//   const urlParams = new URLSearchParams(window.location.search);
//   const carritoEncriptado = urlParams.get("carrito");

//   if (carritoEncriptado) {
//     // Si ya hay información encriptada, simplemente redireccionar a comprar_producto.php
//     window.location.href = "comprar_producto.php?carrito=" + carritoEncriptado;
//   } else {
//     // Si no hay información encriptada, encriptar el carrito y redireccionar
//     // Obtener el carrito en formato JSON
//     const carritoJSON = JSON.stringify(carrito);

//     // Codificar el carrito en base64 para que la URL no tenga problemas con caracteres especiales
//     const carritoBase64 = btoa(carritoJSON);

//     // Redireccionar a la página de comprar_producto.php con el carrito como parámetro en la URL
//     window.location.href = "comprar_producto.php?carrito=" + carritoBase64;
//   }
// }

function seguirComprando() {
  // Obtener el carrito en formato JSON
  const carritoJSON = JSON.stringify(carrito);

  // Codificar el carrito en base64 para que la URL no tenga problemas con caracteres especiales
  const carritoBase64 = btoa(carritoJSON);

  // Redireccionar a la página de comprar_producto.php con el carrito como parámetro en la URL
  window.location.href =
    "index.php?categoria=<?php echo $categoria; ?>&carrito=" + carritoBase64;
}
