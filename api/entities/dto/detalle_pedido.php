<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/cliente_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CLIENTE.
*/
class Detalle_Producto extends DetallesProductosQuery
{
    protected $id_detalle_pedido = null;
    protected $cantidad = null;
    protected $precio = null;
    protected $id_pedido = null;
    protected $id_producto = null;
        /*
    *   Métodos para validar y asignar valores de los atributos.
    */
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
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->cantidad = $value;
            return true;
        } else {
            return false;
        }
    }

}
