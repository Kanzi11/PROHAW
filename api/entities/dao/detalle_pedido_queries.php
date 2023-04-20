<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/

class  DetallePedidoQuery {
    ///metodo para que que se cargue la tabla y se vean todos los datos 
    public function readAll()
    {
        $sql = 'SELECT id_detalle_pedido, cantidad, precio,, id_pedido ,id_producto
                FROM detalle_pedido
                ORDER BY id_pedido';
        return Database::getRows($sql);
    }
}