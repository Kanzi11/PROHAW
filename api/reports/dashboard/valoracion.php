<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/valoraciones.php');
require_once('../../entities/dto/productos.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Comentarios de los productos');
// Se instancia el módelo Producto para obtener los datos.
$producto = new Producto;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataProductos = $producto->reportNombresProductos()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(175);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se establece un color de relleno para mostrar el nombre de los productos
    $pdf->setFillColor(225);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', 'B', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataProductos as $rowProducto) {
        // Se imprime una celda con los comentarios
        $pdf->cell(0, 10, $pdf->encodeString($rowProducto['nombre_producto']), 1, 1, 'C', 1);
        // Se instancia el módelo Valoraciones para procesar los datos.
        $valoraciones = new Valoraciones;
        // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
        if ($dataValoraciones = $valoraciones->reportComentario($rowProducto['id_producto'])) {
            // Se recorren los registros fila por fila.
            foreach ($dataValoraciones as $rowValoraciones) {
                // Se imprimen las celdas con los datos de los comentarios.
                $pdf->cell(0, 10, $pdf->encodeString($rowValoraciones['comentario_prodcuto']), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('No hay valoraciones para el producto'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay productos para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Comentarios.pdf');
