<!DOCTYPE html>
<html>

<head>
    <title>Formulario de la Tienda de Ropa Elegante</title>
    <style>
        body {
            background-color: white;
            color: black;
            font-family: Arial, sans-serif;
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 10px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
            max-width: 800px;
            /* Ajustamos el ancho máximo del div */
            margin: 0 auto;
        }

        form {
            width: 100%;
        }

        label,
        input {
            display: block;
            margin-bottom: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="text"],
        select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .input-group {
            display: flex;
            gap: 10px;
        }

        .input-group label {
            flex: 1;
        }

        .input-group input {
            flex: 2;
        }

        input[type="submit"] {
            background-color: black;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #333;
        }
    </style>
</head>

<body>
    <?php require_once 'master_page.php'; ?>
    <div class="cart-item">
        <form>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required placeholder="Nombre">

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required placeholder="Apellido">

            <label for="telefono">Número de Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required placeholder="Número de Teléfono">

            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" required
                placeholder="Direccion-Calle y Numero (ejemplo: calle6 numero 230#)">

            <label for="referencias">Referencias:</label>
            <input type="text" id="referencias" name="referencias"
                placeholder="Referencias-Negocio en la esquina, porton negro, casa color verde">

            <div class="input-group">
                <div style="flex: 1;">
                    <label for="codigo-postal">Código Postal:</label>
                    <input type="text" id="codigo-postal" name="codigo-postal" required
                        placeholder="Codigo Postal- Ejemplo 25015">
                </div>
                <div style="flex: 1;">
                    <label for="estado">Estado:</label>
                    <input type="text" id="estado" name="estado" required placeholder="Estado">
                </div>
            </div>

            <label for="ciudad">Ciudad:</label>
            <input type="text" id="ciudad" name="ciudad" required placeholder="Ciudad"><br>

            <input type="submit" value="Enviar">
        </form>
    </div>
</body>

</html>