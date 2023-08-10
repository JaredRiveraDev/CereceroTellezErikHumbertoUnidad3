// Obtener el mensaje de la URL
const urlParams = new URLSearchParams(window.location.search);
const mensaje = urlParams.get("mensaje");
const mensaje2 = urlParams.get("mensaje2");

// Mostrar una alerta si hay un mensaje definido
if (mensaje) {
  document.write("<p style='color: white';>.</p>");
  Swal.fire({
    icon: "error",
    title: "Datos Incorrectos",
    text: mensaje,
  });
} else if (mensaje2) {
  document.write("<p style='color: white';>.</p>");
  Swal.fire({
    icon: "success",
    title: mensaje2,
    showConfirmButton: false,
    timer: 2000,
  });
}
