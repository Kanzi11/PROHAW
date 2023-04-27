<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/valoraciones_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad USUARIO.
*/

class Valoraciones extends ValoracionesQueries
{
    protected  $id_valoracion  = null;
    protected  $valoracion_producto  = null;
    protected  $comentario_producto  = null;
    protected  $fecha_comentario  = null;
    protected  $estado_comentario  = null;
    protected  $id_detalle_pedido  = null;

    // SET de valoraciones
    public function setIdValoracion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_valoracion = $value;
            return true;
        } else {
            return false;
        }
    } 

    public function setValoracionProducto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->valoracion_producto = $value;
            return true;
        } else {
            return false;
        }
    }  

    public function setComentarioProducto($value)
    {
        if (Validator::validateAlphabetic($value, 1, 1000)) {
            $this->comentario_producto = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setFechaComentario($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha_comentario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstadoComentario($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estado_comentario = $value;
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
        } else {
            return false;
        }
    }

    // get de valoraciones
    public function getIdValoracion()
    {
        return $this->id_valoracion;
    }

    public function getValoracionProducto()
    {
        return $this->valoracion_producto;
    }

    public function getComentarioProducto()
    {
        return $this->comentario_producto;
    }

    public function getFechaComentario()
    {
        return $this->fecha_comentario;
    }
    
    public function getEstadoComentario()
    {
        return $this->estado_comentario;
    }

    public function getIdDetallePedido()
    {
        return $this->id_detalle_pedido;
    }

}