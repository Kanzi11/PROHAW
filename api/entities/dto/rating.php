<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/rating_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class Ratings extends rating_queries
{
    // Declaración de atributos (propiedades).
    protected $valoracion_producto = null;
    protected $comentario_prodcuto = null;
    protected $fecha_comentario = null;
    protected $usuario = null;
    protected $estado_comentario = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setValoracion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->valoracion_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setComentario($value)
    {
        if (Validator::validateString($value, 1, 150)) {
            $this->comentario_prodcuto = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setFecha($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha_comentario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCliente($value)
    {
        if (Validator::validateString($value, 1, 150)) {
            $this->usuario = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setEstado($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estado_comentario = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getValoracion()
    {
        return $this->valoracion_producto;
    }

    public function getComentario()
    {
        return $this->comentario_prodcuto;
    }
    public function getFecha()
    {
        return $this->fecha_comentario;
    }

    public function getCliente()
    {
        return $this->usuario;
    }
    public function getEstado()
    {
        return $this->estado_comentario;
    }
}
