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
    // Metodo del buscador para pedido
    public function searchRows($value)
    {
        $sql = 'SELECT a.id_pedido, a.estado_pedido, a.fecha_pedido, b.nombre_cliente
        FROM pedidos a
        INNER JOIN clientes b ON a.id_cliente = b.id_cliente
        WHERE b.nombre_cliente ILIKE ?
        ORDER BY a.id_pedido';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    // Metodo del buscador para el detalle del pedido
    public function searchRowsOrder($value)
    {
        $sql = 'SELECT a.id_detalle_pedido,a.cantidad,a.precio,a.id_pedido,b.nombre_producto
        FROM detalles_pedidos a INNER JOIN productos b ON a.id_producto = b.id_producto
        WHERE id_pedido = ? AND b.nombre_producto ILIKE ? OR a.precio::varchar ILIKE ? ';
        $params = array($this->id_pedido, "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    // metodo para mostrar el detalle
    public function showdetail()
    {
        $sql = 'SELECT a.id_detalle_pedido,a.cantidad,a.precio,b.nombre_producto
                FROM detalles_pedidos a INNER JOIN productos b ON a.id_producto = b.id_producto
                WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::getRows($sql, $params);
    }

    public function BorrarDetalle()
    {
        $sql = 'DELETE FROM detalles_pedidos
                WHERE id_detalle_pedido = ?';
        $params = array($this->id_detalle_pedido);
        return Database::executeRow($sql, $params);
    }

    // metodo para crear un registro

    public function createRow()
    {
        $sql = 'INSERT INTO pedidos(estado_pedido, fecha_pedido, id_cliente)
                VALUES(?,?,?)';
        $params = array($this->estado_pedido, $this->fecha_pedido, $this->id_cliente);
        return Database::executeRow($sql, $params);
    }
    // Metodo para leer todos los registros actuales creo
    public function readAll()
    {
        $sql = 'SELECT a.id_pedido, a.estado_pedido, a.fecha_pedido, b.nombre_cliente
                FROM pedidos a
                INNER JOIN clientes b ON a.id_cliente = b.id_cliente
                ORDER BY a.id_pedido';
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

    public function readDetalle()
    {
        $sql = 'SELECT id_detalle_pedido, cantidad, precio, id_pedido, id_producto
        FROM detalles_pedidos
        WHERE id_detalle_pedido = ?';
        $params = array($this->id_detalle_pedido);
        return Database::getRow($sql, $params);
    }

    // Metodo para actualizar un pedido
    public function updateRow()
    {
        $sql = 'UPDATE pedidos
                SET  estado_pedido = ?,fecha_pedido = ?,id_cliente = ?
                WHERE id_pedido = ?';
        $params = array($this->estado_pedido, $this->fecha_pedido, $this->id_cliente, $this->id_pedido);
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

    // Metodo para cambiar el estado de un pedido
    public function changeStatus()
    {
        $sql = 'UPDATE pedidos
                SET  estado_pedido = ?
                WHERE id_pedido = ?';
        $params = array($this->estado_pedido, $this->id_pedido);
        return Database::executeRow($sql, $params);
    }

     //Metodos para el carrito de compras

    // Metodos para el carrito de compras 
    // Método para verificar si existe un pedido en proceso para seguir comprando, de lo contrario se crea uno.
    public function startOrder()
    {
        $sql = 'SELECT id_pedido
                FROM pedidos
                WHERE estado_pedido = true AND id_cliente = ?';
        $params = array($_SESSION['id_cliente']);
        if ($data = Database::getRow($sql, $params)) {
            $this->id_pedido = $data['id_pedido'];
            return true;
        } else {
            $sql = 'INSERT INTO pedidos(direccion_pedido, id_cliente)
                    VALUES((SELECT direccion_cliente FROM clientes WHERE id_cliente = ?), ?)';
            $params = array($_SESSION['id_cliente'], $_SESSION['id_cliente']);
            // Se obtiene el ultimo valor insertado en la llave primaria de la tabla pedidos.
            if ($this->id_pedido = Database::getLastRow($sql, $params)) {
                return true;
            } else {
                return false;
            }
        }
    }


    // Método para agregar un producto al carrito de compras.
    public function createDetail()
    {
        // Se realiza una subconsulta para obtener el precio del producto.
        $sql = 'INSERT INTO detalles_pedidos(id_producto, precio, cantidad, id_pedido)
                VALUES(?, (SELECT precio_producto FROM productos WHERE id_producto = ?), ?, ?)';
        $params = array($this->producto, $this->producto, $this->cantidad, $this->id_pedido);
        return Database::executeRow($sql, $params);
    }

    // Método para obtener los productos que se encuentran en el carrito de compras.
    public function readOrderDetail()
    {
        $sql = 'SELECT id_detalle_pedido, nombre_producto,imagen_producto , detalles_pedidos.precio, detalles_pedidos.cantidad
        FROM pedidos INNER JOIN detalles_pedidos USING(id_pedido) INNER JOIN productos USING(id_producto)
        WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::getRows($sql, $params);
    }


    // Método para finalizar un pedido por parte del cliente.
    public function finishOrder()
    {
        // Se establece la zona horaria local para obtener la fecha del servidor.
        date_default_timezone_set('America/El_Salvador');
        $date = date('Y-m-d');
        $this->estado_pedido = 'false';
        $sql = 'UPDATE pedidos
                SET estado_pedido = ?, fecha_pedido = ?
                WHERE id_pedido = ?';
        $params = array($this->estado_pedido, $date, $_SESSION['id_pedido']);
        return Database::executeRow($sql, $params);
    }

    public function updateDetail()
    {
        $sql = 'UPDATE detalles_pedidos
                SET cantidad= ?
                WHERE id_detalle_pedido = ? AND id_pedido = ?';
        $params = array($this->cantidad, $this->id_detalle_pedido, $_SESSION['id_pedido']);
        return Database::executeRow($sql, $params);
    }

    // Método para eliminar un producto que se encuentra en el carrito de compras.
    public function deleteDetail()
    {
        $sql = 'DELETE FROM detalles_pedidos
                WHERE id_detalle_pedido = ? AND id_pedido = ?';
        $params = array($this->id_detalle_pedido, $_SESSION['id_pedido']);
        return Database::executeRow($sql, $params);
    }

    //Metodo para devolver el pedido que se a realizado Para el reporte 
    public function  readDetail()
    {
        $sql = 'SELECT  cantidad, precio, nombre_producto 
        FROM detalles_pedidos 
        INNER JOIN productos 
        USING (id_producto) 
        WHERE id_pedido = ?';
        $params = array ( $_SESSION['id_pedido']);
        return Database::getRows($sql, $params);
    }
}
