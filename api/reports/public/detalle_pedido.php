<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/reportp.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/pedido.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('PROHAW');
// Se instancia el módelo Categoría para obtener los datos.
$detallePedido = new Pedido;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataDetalle = $detallePedido->readDetail()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(255, 255, 255);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(98, 10, 'Producto', 1, 0, 'C',1);
    $pdf->cell(22, 10, 'Precio (US$)', 1, 0, 'C',1);
    $pdf->cell(20, 10, 'Cantidad', 1, 0, 'C',1);
    $pdf->cell(46, 10, 'Sub Total', 1, 1, 'C',1);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', 'I', 12);
 $total = 0;
    // Se recorren los registros fila por fila.
    foreach ($dataDetalle as $rowDetalle) {
        $subtotal = $rowDetalle['cantidad']*$rowDetalle['precio'];
        $total+=$subtotal;
        // Se imprimen las celdas con los datos de los productos.
        $pdf->cell(98, 10, $pdf->encodeString($rowDetalle['nombre_producto']), 1, 0,'C');
        $pdf->cell(22, 10, $rowDetalle['precio'], 1, 0,'C');
        $pdf->cell(20, 10, $rowDetalle['cantidad'], 1, 0,'C');
        $pdf->cell(46, 10, $subtotal, 1, 1,'C');
    }
    $pdf->cell(0, 10, 'Total (US$)'.$total, 1, 1,'R');
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay productos'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'factura.pdf');
