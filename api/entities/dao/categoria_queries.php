<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/

class CategoriaQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    // Metodo del buscador 
    public function searchRows($value)
    {
        $sql = 'SELECT id_categoria, nombre_categoria
                FROM categorias
                WHERE nombre_categoria ILIKE ?
                ORDER BY nombre_categoria';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }
    // metodo para crear un registro

    public function createRow()
    {
        $sql = 'INSERT INTO categorias(nombre_cateogria)
                VALUES(?)';
        $params = array($this->nombre_categoria);
        return Database::executeRow($sql, $params);
    }
    // Metodo para leer todos los registros actuales creo
    public function readAll()
    {
        $sql = 'SELECT id_categoria, nombre_categoria
                FROM categorias
                ORDER BY nombre_categoria';
        return Database::getRows($sql);
    }

    // Metodo para leer un registro si no mal entiendo
    public function readOne()
    {
        $sql = 'SELECT id_categoria, nombre_categoria
                FROM categorias
                WHERE id_categoria = ?';
        $params = array($this->id_categoria);
        return Database::getRow($sql, $params);
    }

    // Metodo para actualizar un registro
    public function updateRow()
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        $sql = 'UPDATE categorias
                SET  nombre_categoria = ?
                WHERE id_categoria = ?';
        $params = array( $this->nombre_categoria, $this->id_categoria);
        return Database::executeRow($sql, $params);
    }
    // Metodo para eliminar un registro
    public function deleteRow()
    {
        $sql = 'DELETE FROM categorias
                WHERE id_categoria = ?';
        $params = array($this->id_categoria);
        return Database::executeRow($sql, $params);
    }
}