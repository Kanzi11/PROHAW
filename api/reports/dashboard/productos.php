<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/productos.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Reporte de los productos activos');
// Se instancia el módelo Categoría para obtener los datos.
$estado = new Producto;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataEstado = $estado->reportEstadoProducto()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(204, 229, 255);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(46, 10, 'Categoria', 1, 0, 'C',1);
    $pdf->cell(60, 10, 'Marca', 1, 0, 'C',1);
    $pdf->cell(85, 10, 'Producto', 1, 1, 'C',1);

    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', 'I', 12);

    // Se recorren los registros fila por fila.
    foreach ($dataEstado as $rowEstado) {

        // Se imprimen las celdas con los datos de los productos.
        $pdf->cell(46, 10, $pdf->encodeString($rowEstado['nombre_categoria']), 1, 0,'C');
        $pdf->cell(60, 10, $pdf->encodeString($rowEstado['nombre_marca']), 1, 0,'C');
        $pdf->cell(85, 10, $pdf->encodeString($rowEstado['nombre_producto']), 1, 1,'C');
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay productos para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'estado_producto.pdf');
