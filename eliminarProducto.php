<?php
require_once 'conexion.php';

if (isset($_POST['eliminar'])) {
    $id_producto = intval($_POST['id_producto']); // Convierte el valor a entero

    // Inicia la transacción
    $cnnPDO->beginTransaction();

    try {
        // Obtener el nombre de archivo de imagen antes de eliminar el producto
        $sql = "SELECT codigo_imagen FROM productos WHERE id_producto = :id_producto";
        $stmt = $cnnPDO->prepare($sql);
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Eliminar fila en la tabla inventario
        $sql1 = "DELETE FROM inventario WHERE id_producto = :id_producto";
        $stmt1 = $cnnPDO->prepare($sql1);
        $stmt1->bindParam(':id_producto', $id_producto);
        $stmt1->execute();

        // Eliminar fila en la tabla productos
        $sql2 = "DELETE FROM productos WHERE id_producto = :id_producto";
        $stmt2 = $cnnPDO->prepare($sql2);
        $stmt2->bindParam(':id_producto', $id_producto);
        $stmt2->execute();

        // Confirma la transacción si ambas consultas se completaron correctamente
        $cnnPDO->commit();

        // Eliminar el archivo de imagen de la carpeta
        $nombreArchivo = $resultado['codigo_imagen'];
        $rutaArchivo = 'imgProductos/' . $nombreArchivo;
        unlink($rutaArchivo);

        header('Location: eliProducto.php?mensaje2=Se elimino correctamente');
        exit(); // Salir del script después de enviar la redirección

    } catch (PDOException $e) {
        // Si ocurre un error, deshace la transacción y muestra el mensaje de error
        $cnnPDO->rollBack();
        echo 'Error al eliminar el producto: ' . $e->getMessage();
    }
}
?>