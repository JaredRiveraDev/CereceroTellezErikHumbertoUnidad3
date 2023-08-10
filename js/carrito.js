// Crea una alerta personalizada con estilo
function alerta(mensaje) {
  const alertaDiv = document.createElement("div");
  alertaDiv.classList.add("alerta");
  alertaDiv.textContent = mensaje;

  const cuerpo = document.querySelector("body");
  cuerpo.appendChild(alertaDiv);

  // Elimina la alerta después de unos segundos (ajusta el tiempo en milisegundos)
  setTimeout(() => {
    cuerpo.removeChild(alertaDiv);
  }, 3000); // 3000 ms = 3 segundos
}
//carrito
let carrito = [];
let total = 0;

function agregarAlCarrito(id_producto, nombre, precio, codigo_imagen) {
  // Verificar si hay información del carrito en la URL
  const urlParams = new URLSearchParams(window.location.search);
  const carritoBase64 = urlParams.get("carrito");
  if (carritoBase64) {
    try {
      // Decodificar el carrito desde base64 y convertirlo a un objeto JavaScript
      const carritoJSON = atob(carritoBase64);
      const carritoDesdeURL = JSON.parse(carritoJSON);

      // Combinar el carrito actual con el carrito obtenido desde la URL solo si el carrito actual está vacío
      if (carrito.length === 0) {
        carrito.push(...carritoDesdeURL);
      }
    } catch (error) {
      console.error(
        "Error al decodificar o parsear el carrito desde la URL:",
        error
      );
    }
  }

  const tallaSeleccionada = document.querySelector(
    'input[name="talla"]:checked'
  );
  if (!tallaSeleccionada) {
    alerta("Por favor, selecciona una talla antes de agregar al carrito.");
    return; // La función se detiene si no hay una talla seleccionada.
  }
  const talla = tallaSeleccionada.value; // Obtener el valor de la talla seleccionada o cadena vacía si no hay talla seleccionada
  // Buscar el producto en el carrito
  const productoEnCarrito = carrito.find(
    (item) => item.id_producto === id_producto && item.talla === talla
  );
  if (productoEnCarrito) {
    const cantidadAgregada = productoEnCarrito.cantidad + 1;
    if (cantidadAgregada > 10) {
      alerta("No se pueden agregar más de 10 unidades del mismo producto.");
      return;
    }
    // Si el producto ya está en el carrito y no se supera el límite de 10, aumentar la cantidad y actualizar el precio
    productoEnCarrito.cantidad = cantidadAgregada;
    productoEnCarrito.precioTotal += precio;
  } else {
    // Si el producto no está en el carrito, agregarlo con cantidad, precio, e incluir la talla, el código de la imagen y el ID del producto
    carrito.push({
      id_producto,
      nombre,
      precio,
      talla,
      codigo_imagen,
      cantidad: 1,
      precioTotal: precio,
    });
  }

  total += precio;

  // Actualizar la cantidad total de productos en el carrito
  const cantidadTotal = carrito.reduce(
    (total, item) => total + item.cantidad,
    0
  );
  document.getElementById("cantidad-carrito").innerText = cantidadTotal;

  mostrarCarrito();
  mostrarCarritoPorUnTiempo();

  // var cantidadActual = parseInt(document.getElementById("cantidad-carrito").innerText);
  // document.getElementById("cantidad-carrito").innerText = cantidadActual + 1;
}

function mostrarCarrito() {
  const listaCarrito = document.getElementById("lista-carrito");
  const totalCarrito = document.getElementById("total-carrito");
  const numProductos = carrito.length;

  listaCarrito.innerHTML = "";
  total = 0;
  // Utilizar un objeto para agrupar los productos por ID y talla
  const productosAgrupados = {};

  for (const item of carrito) {
    // Generar una clave única para agrupar por ID y talla
    const clave = `${item.id_producto}-${item.talla}`;

    // Si el producto ya está en el objeto productosAgrupados, aumentar la cantidad y actualizar el precio
    if (productosAgrupados[clave]) {
      productosAgrupados[clave].cantidad += item.cantidad;
      productosAgrupados[clave].precioTotal += item.precioTotal;
    } else {
      // Si el producto no está en el objeto productosAgrupados, agregarlo con las mismas propiedades
      productosAgrupados[clave] = { ...item };
    }
  }

  if (numProductos === 0) {
    listaCarrito.textContent = "El carrito está vacío.";
    totalCarrito.textContent = "$0";
  } else {
    let total = 0;
    for (const clave in productosAgrupados) {
      const productoAgrupado = productosAgrupados[clave];
      const li = document.createElement("li");
      li.textContent = `${productoAgrupado.nombre} - Talla: ${productoAgrupado.talla} - Cantidad: ${productoAgrupado.cantidad}`;
      listaCarrito.appendChild(li);
      total += productoAgrupado.precioTotal;
    }
    totalCarrito.textContent = `${total}`;
  }

  const carritoContainer = document.getElementById("carrito-container");
  // Remover la clase "nuevo-producto" para reiniciar la animación
  carritoContainer.classList.remove("nuevo-producto");
  // Agregar la clase "nuevo-producto" para iniciar la animación
  carritoContainer.classList.add("nuevo-producto");
  // Eliminar la clase "nuevo-producto" después de 1 segundo para que no se repita la animación
  setTimeout(() => {
    carritoContainer.classList.remove("nuevo-producto");
  }, 7000);
}

function mostrarCarritoPorUnTiempo() {
  const carritoContainer = document.getElementById("carrito-container");
  carritoContainer.style.display = "block"; // Mostrar el carrito

  setTimeout(() => {
    carritoContainer.style.display = "none"; // Ocultar el carrito después de 2 segundos (ajústalo según tus necesidades)
  }, 7000); // 7000 milisegundos = 7 segundos (ajústalo según tus necesidades)
}

function irAComprarProducto() {
  // Obtener el carrito en formato JSON
  const carritoJSON = JSON.stringify(carrito);

  // Codificar el carrito en base64 para que la URL no tenga problemas con caracteres especiales
  const carritoBase64 = btoa(carritoJSON);

  // Redireccionar a la página de comprar_producto.php con el carrito como parámetro en la URL
  window.location.href = "comprar_producto.php?carrito=" + carritoBase64;
}
