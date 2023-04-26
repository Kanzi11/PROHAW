<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class PedidoQueries 
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    // Metodo del buscador 
    public function searchRows($value)
    {
        $sql = 'SELECT id_pedido, estado_pedido, fecha_pedido, id_cliente
                FROM pedidos
                WHERE id_cliente ILIKE ?
                ORDER BY id_cliente';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }
    // metodo para crear un registro

    public function createRow()
    {
        $sql = 'INSERT INTO pedidos(estado_pedido, fecha_pedido, id_cliente)
                VALUES(?,?,?)';
        $params = array($this->estado_pedido,$this->fecha_pedido,$this->id_cliente);
        return Database::executeRow($sql, $params);
    }
    // Metodo para leer todos los registros actuales creo
    public function readAll()
    {
        $sql = 'SELECT id_pedido, estado_pedido, fecha_pedido, id_cliente
                FROM pedidos
                ORDER BY id_pedido';
        return Database::getRows($sql);
    }
    // Metodo para leer un registro si no mal entiendo
    public function readOne()
    {
        $sql = 'SELECT id_pedido, estado_pedido, fecha_pedido, id_cliente
                FROM pedidos
                WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::getRow($sql, $params);
    }

     // metodo para leer cliente mandar a llamar a los clientes por medio de un 
     // de un cmb
    // public function readCliente(){
    //     $sql='SELECT id cliente, nombre_cliente FROM clientes';
    //     return Database::getRow($sql);
    // }


    // Metodo para actualizar un pedido
    public function updateRow()
    {
        $sql = 'UPDATE pedidos
                SET  estado_pedido = ?,fecha_pedido = ?,id_cliente = ?
                WHERE id_pedido = ?';
        $params = array($this->estado_pedido, $this->fecha_pedido, $this->id_cliente, $this->id_pedido
    );
    return Database::executeRow($sql, $params);
    }
    // Metodo para eliminar un registro
    public function deleteRow()
    {
        $sql = 'DELETE FROM pedidos
                WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::executeRow($sql, $params);
    }
}