<?php
require_once('../../helpers/database.php');
/*
* Clase para manejar el acceso a los datos de la entidad Clientes.
*/

class HistorialQueries
{
    // Metodo para leer todos los registros actuales 
    public function readAll()
    {
        $sql = 'SELECT id_detalle_pedido , fecha_pedido , cantidad * precio AS Total
                FROM detalles_pedidos INNER JOIN pedidos(id_pedido)
                WHERE estado_pedido = true AND id_cliente = ?
                ORDER BY id_detalle_pedido';
                $params = array($this->estado_pedido,$_SESSION['id_cliente']);
        return Database::getRows($sql);
    }
}
