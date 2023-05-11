<?php
require_once('../../helpers/database.php');

/*
*	Clase para manejar el acceso a datos de la entidad MARCAS.
*/

class MarcasQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    // Metodo del buscador 
    public function searchRows($value)
    {
        $sql = 'SELECT id_marca, nombre_marca, logo_marca
                FROM marcas
                WHERE nombre_marca ILIKE  ?
                ORDER BY nombre_marca';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }
    // metodo para crear un registro

    public function createRow()
    {
        $sql = 'INSERT INTO marcas(nombre_marca, logo_marca)
                VALUES(?, ?)';
        $params = array($this->nombre_marca, $this->logo_marca );
        return Database::executeRow($sql, $params);
    }
    // Metodo para leer todos los registros actuales creo
    public function readAll()
    {
        $sql = 'SELECT id_marca, nombre_marca, logo_marca
                FROM marcas
                ORDER BY id_marca';
        return Database::getRows($sql);
    }
    // Metodo para leer un registro si no mal entiendo
    public function readOne()
    {
       $sql = 'SELECT id_marca, nombre_marca, logo_marca FROM marcas
       WHERE id_marca = ?';
        $params = array($this->id_marca);
        return Database::getRow($sql, $params);
    }

    // Metodo para actualizar un registro
    public function updateRow($current_image)
    {
        ($this ->logo_marca ) ? Validator::deleteFile($this->getRuta(), $current_image ) : $this->logo_marca = $current_image;
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        $sql = 'UPDATE marcas
                SET  nombre_marca  = ? , logo_marca = ?
                WHERE id_marca = ?';
        $params = array( $this->nombre_marca, $this->logo_marca,  $this->id_marca);
        return Database::executeRow($sql, $params);
    }
    // Metodo para eliminar un registro
    public function deleteRow()
    {
        $sql = 'DELETE FROM marcas
                WHERE id_marca = ?';
        $params = array($this->id_marca);
        return Database::executeRow($sql, $params);
    }
}