!--><?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/detalle_pedido_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CLIENTE.
*/
class Detalle_Pedido extends DetallePedidoQuery
{
    protected $id_detalle_pedido = null;
    protected $cantidad = null;
    protected $precio = null;
    protected $id_pedido = null;
    protected $id_producto = null;
    //set

    public function setIdDetallePedido($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_detalle_pedido = $value;
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
    public function setPrecio($value)
    {
        if (Validator::validateMoney($value)) {
            $this->precio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdPedido($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_pedido = $value;
            return true;
        } else {
            return false;
        }
    }
        public function setIdProducto($value)
        {
            if (Validator::validateNaturalNumber($value)) {
                $this->id_producto = $value;
                return true;
            } else {
                return false;
            }
    }


        //gett
        public function getIdDetallePedido()
        {
            return $this->id_detalle_pedido;
        }

        public function getCantidad()
        {
            return $this->cantidad;
        }

        public function getPrecio()
        {
            return $this->precio;
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
