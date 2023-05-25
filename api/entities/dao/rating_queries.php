<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class rating_queries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function readAll()
    {
        $sql = 'SELECT valoracion_producto, comentario_prodcuto, fecha_comentario, usuario FROM valoraciones 
        INNER JOIN detalles_pedidos  USING (id_detalle_pedido)
        INNER JOIN pedidos  USING (id_pedido)
        INNER JOIN clientes  USING(id_cliente)
        INNER JOIN productos  USING (id_producto)
        WHERE estado_comentario = true';
        return Database::getRows($sql);
    }
}
