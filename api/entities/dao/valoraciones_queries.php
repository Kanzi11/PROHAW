<?php
require_once('../../helpers/database.php');

/*
*	Clase para manejar el acceso a datos de la entidad MARCAS.
*/

class ValoracionesQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    // Metodo del buscador 
    public function searchRows($value)
    {
        $sql = 'SELECT id_valoraciones, valoracion_producto, comentario_prodcuto, fecha_comentario, estado_comentario, id_detalle_pedido
                FROM valoraciones
                WHERE valoracion_producto ILIKE  ?
                ORDER BY valoracion_producto';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }
    // metodo para crear un registro

    // public function createRow()
    // {
    //     $sql = 'INSERT INTO valoraciones(nombre_marca, logo_marca)
    //             VALUES(?, ?)';
    //     $params = array($this->nombre_marca, $this->logo_marca );
    //     return Database::executeRow($sql, $params);
    // }

    
    // // Metodo para leer todos los registros actuales creo
    public function readAll()
    {
        $sql = 'SELECT id_valoracion, valoracion_producto, comentario_prodcuto, fecha_comentario, estado_comentario, id_detalle_pedido
                FROM valoraciones
                ORDER BY id_valoracion';
        return Database::getRows($sql);
    }


    // Metodo para leer un registro si no mal entiendo
    public function readOne()
    {
       $sql = 'SELECT id_valoracion, valoracion_producto, comentario_prodcuto, fecha_comentario, estado_comentario, id_detalle_pedido
       FROM valoraciones
       WHERE id_valoraciones = ?';
        $params = array($this->id_valoracion);
        return Database::getRow($sql, $params);
    }

    // Metodo para actualizar un registro
    public function updateRow()
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        $sql = 'UPDATE valoraciones
                SET  estado_comentario  = ? 
                WHERE id_valoracion = ?';
        $params = array( $this->estado_comentario,  $this->id_valoracion);
        return Database::executeRow($sql, $params);
    }
    // Metodo para eliminar un registro
    public function deleteRow()
    {
        $sql = 'DELETE FROM valoraciones
                WHERE id_valoracion = ?';
        $params = array($this->id_valoracion);
        return Database::executeRow($sql, $params);
    }
}