<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad MARCAS.
*/

class ProductoQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    // Metodo del buscador 
    public function searchRows($value)
    {
        $sql = 'SELECT id_producto, nombre_producto, detalle_producto, precio_producto, estado_producto, existencias, imagen_producto, id_marca, id_categoria, id_usuario
                FROM productos
                WHERE nombre_producto ILIKE  ?
                ORDER BY nombre_producto';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }
    // metodo para crear un registro

    public function createRow()
    {
        $sql = 'INSERT INTO productos(nombre_producto)
                VALUES(?)';
        $params = array($this->nombre_producto);
        return Database::executeRow($sql, $params);
    }
    // Metodo para leer todos los registros actuales creo
    public function readAll()
    {
        $sql = 'SELECT id_producto, nombre_producto, detalle_producto, precio_producto, estado_producto, existencias, imagen_producto, id_marca, id_categoria, id_usuario
                FROM productos
                ORDER BY id_producto';
        return Database::getRows($sql);
    }
    // Metodo para leer un registro si no mal entiendo
    public function readOne()
    {
        $sql = 'SELECT id_producto, nombre_producto, detalle_producto, precio_producto, estado_producto, existencias, imagen_producto, id_marca, id_categoria, id_usuario
                FROM productos
                WHERE id_productos = ?';
        $params = array($this->id_producto);
        return Database::getRow($sql, $params);
    }

    // Metodo para actualizar un registro
    public function updateRow()
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        $sql = 'UPDATE productos
                SET  nombre_producto = ?
                WHERE id_producto = ?';
        $params = array( $this->nombre_producto, $this->id_producto);
        return Database::executeRow($sql, $params);
    }
    // Metodo para eliminar un registro
    public function deleteRow()
    {
        $sql = 'DELETE FROM productos
                WHERE id_producto = ?';
        $params = array($this->id_producto);
        return Database::executeRow($sql, $params);
    }
}