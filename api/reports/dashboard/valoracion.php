<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/valoraciones.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Comentarios de los productos');
// Se instancia el módelo Categoría para obtener los datos.
$producto = new Producto;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataProductos = $producto->reportNombresProductos()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(175);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(126, 10, 'Producto', 1, 0, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(225);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', 'B', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataProductos as $rowProducto) {
        // Se imprime una celda con el nombre de la categoría.
        $pdf->cell(0, 10, $pdf->encodeString('Producto: ' . $rowProducto['nombre_producto']), 1, 1, 'C', 1);
        // Se instancia el módelo Producto para procesar los datos.
        $valoraciones = new Valoraciones;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($producto->setCategoria($rowCategoria['id_categoria'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $producto->productosCategoria()) {
                // Se recorren los registros fila por fila.
                foreach ($dataProductos as $rowProducto) {
                    ($rowProducto['estado_producto']) ? $estado = 'Activo' : $estado = 'Inactivo';
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(126, 10, $pdf->encodeString($rowProducto['nombre_producto']), 1, 0);
                    $pdf->cell(30, 10, $rowProducto['precio_producto'], 1, 0);
                    $pdf->cell(30, 10, $estado, 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para la categoría'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Categoría incorrecta o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay categorías para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Comentarios.pdf');
