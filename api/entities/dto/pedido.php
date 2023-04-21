<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/pedido_queries.php');

class Pedido extends PedidoQueries
{
     // Declaracion de los atributos propiedades de la tabla
    protected $id_pedido = null;
    protected $estado_pedido = null;
    protected $fecha_pedido = null;
    protected $id_cliente = null;

    
    // Metodos para validar y asignar valores de los atributos.
    // set
    public function setIdPedido($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstadoPedido($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estado_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFechaPedido($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    // GET 
    public function getIdPedido()
    {
        return $this->id_pedido;
    }

    public function getEstadoPedido()
    {
        return $this->estado_pedido;
    }

    public function getFechaPedido()
    {
        return $this->fecha_pedido;
    }
    
    public function getIdCliente()
    {
        return $this->id_cliente;
    }
}