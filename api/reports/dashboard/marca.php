<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/marcas.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Marcas');
// Se instancia el módelo Categoría para obtener los datos.
$marcas = new Marcas;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataMarca = $marcas->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(175);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(30, 10, 'Marca', 1, 1, 'C');
    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(225);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', 'I', 12);

    // Se recorren los registros fila por fila.
    foreach ($dataMarca as $rowMarcas) {
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($marcas->setIdMarca($rowMarcas['id_marca'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataMarca = $marcas->ReportMarcas()) {
                // Se recorren los registros fila por fila.
                foreach($dataMarca as $rowMarcas) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(60, 10, $pdf->encodeString($rowMarcas['nombre_marca']), 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay marcas que mostrar'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Marca incorrecta o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay categorías para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'marcas.pdf');
