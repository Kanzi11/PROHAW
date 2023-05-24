<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/pedido_queries.php');

class Pedido extends PedidoQueries
{
     // Declaracion de los atributos propiedades de la tabla
    protected $id_pedido = null;
    protected $id_detalle_pedido = null;
    protected $id_cliente = null;
    protected $estado_pedido = null;
    protected $fecha_pedido = null; 
    protected $direccion_pedido = null;
    protected $producto = null;
    protected $cantidad = null;
    protected $precio = null;
    

    
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

    public function setCantidad($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidad = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDireccionPedido($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 200)) {
            $this->direccion_pedido = $value;
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

    public function setProducto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdDetalle($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_detalle_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    
    public function setPrecio($value)
    {
        if (Validator::validateMoney($value)) {
            $this->precio = $value;
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

    public function getDireccionPedido()
    {
        return $this->direccion_pedido;
    }
    
    

    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    public function getIdDetallePedido()
    {
        return $this->id_detalle_pedido;
    }
}