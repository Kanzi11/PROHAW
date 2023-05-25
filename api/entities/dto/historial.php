<?php
require_once('../../helpers/Validator.php');
require_once('../../entities/dao/historial_queries.php');
/*
 * Clase para manejar la transferencia de datos de la entidad Clientes.
 *  
*/
class Historial extends HistorialQueries
{
    //Declarando los atributos de la tabla
    protected $id_detalle_pedido = null; 
    protected $id_pedido = null;
    protected $id_producto = null;
    protected $estado_pedido = null;
    protected $id_cliente = null;

    // Metodos para validar y asignar valores de los atributos
    //Set id_cliente

    public function setIdCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_cliente = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setEstadoPedido($value)
    {
        if (Validator::validateBoolean($value, 1, 100)) {
            $this->estado_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdDetallePedido($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_detalle_pedido = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setIdPedido($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_pedido = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setIdProducto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_producto = $value;
            return true;
        }else{
            return false;
        }
    }

    //Get 
    public function getIdDetallePedido()
    {
       return $this->id_detalle_pedido;
    }
    public function getIdCliente()
    {
       return $this->id_cliente;
    }
    public function getEstadoPedido()
    {
       return $this->estado_pedido;
    }
    public function getIdPedido()
    {
       return $this->id_pedido;
    }
    public function getIdProducto()
    {
       return $this->id_producto;
    }
}
