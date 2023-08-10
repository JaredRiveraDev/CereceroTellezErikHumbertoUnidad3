const urlParams = new URLSearchParams(window.location.search);
const id_usuario = urlParams.get("id");
console.log("Valor de id_usuario:", id_usuario);
// Asignar los valores a los campos
document.getElementById("idUsuario").value = id_usuario;