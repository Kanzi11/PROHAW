<?php
require_once('../../helpers/database.php');
/*
* Clase para manejar el acceso a los datos de la entidad Clientes.
*/

class ClientesQueris
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    // Metodo del buscador 
    public function searchRows($value)
    {
        $sql = 'SELECT nombre_cliente,apellido_cliente,telefono_cliente,dui_cliente
                FROM clientes
                WHERE nombre_cliente ILIKE ? , apellido_cliente ILIKE ? , telefono_cliente ILIKE ? , dui_cliente ILIKE ?
                ORDER BY nombre_cliente, apellido_cliente, telefono_cliente, dui_cliente';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }
    // metodo para crear un registro

    public function createRow()
    {
        $sql = 'INSERT INTO clientes(nombre_cliente,apellido_cliente,dui_cliente,correo_cliente,telefono_cliente,direccion_cliente,estado_cliente,usuario,clave)
                VALUES(?,?,?,?,?,?,?,?,?)';
        $params = array($this->nombre_cliente, $this->apellido_cliente, $this->dui_cliente, $this->correo_cliente, $this->telefono_cliente, $this->direccion_cliente, $this->estado_cliente, $this->usuario, $this->clave);
        return Database::executeRow($sql, $params);
    }
    // Metodo para leer todos los registros actuales 
    public function readAll()
    {
        $sql = 'SELECT id_cliente,nombre_cliente,apellido_cliente,dui_cliente,correo_cliente,telefono_cliente,direccion_cliente,estado_cliente,usuario,clave
                FROM clientes
                ORDER BY id_cliente';
        return Database::getRows($sql);
    }
    // Metodo para leer un registro
    public function readOne()
    {
        $sql = 'SELECT id_cliente,nombre_cliente,apellido_cliente,dui_cliente,correo_cliente,telefono_cliente,direccion_cliente,estado_cliente,usuario,clave
                FROM clientes
                WHERE id_cliente = ?';
        $params = array($this->id_cliente);
        return Database::getRow($sql, $params);
    }

    // Metodo para actualizar un registro
    public function updateRow()
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        $sql = 'UPDATE clientes
                SET  nombre_cliente = ?,apellido_cliente = ?,dui_cliente = ?,correo_cliente = ?,telefono_cliente = ?,direccion_cliente = ?,estado_cliente = ?,usuario = ?,clave = ?
                WHERE id_cliente = ?';
        $params = array($this->nombre_cliente, $this->apellido_cliente, $this->dui_cliente, $this->correo_cliente, $this->telefono_cliente, $this->direccion_cliente, $this->estado_cliente, $this->usuario, $this->clave
    );
        return Database::executeRow($sql, $params);
    }
    // Metodo para eliminar un registro
    public function deleteRow()
    {
        $sql = 'DELETE FROM clientes
                WHERE id_cliente = ?';
        $params = array($this->id_cliente);
        return Database::executeRow($sql, $params);
    }
}