<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/productos_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad Marcas.
*/
class Producto extends ProductoQueries
{
    // Declaracion de los atributos propiedades de la tabla
    protected $id_producto = null;
    protected $nombre_producto = null;
    protected $detalle_producto = null;
    protected $precio_producto = null;
    protected $estado_producto= null;
    protected $existencias = null;
    protected $imagen_producto = null;
    protected $id_marca = null;
    protected $id_categoria = null;
    protected $id_usuario = null;
    protected $ruta = '../../img/productos/';


    // Metodos para validar y asignar valores de los atributos.
    // set
    public function setIdProducto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    
    public function setNombreProducto($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 100)) {
            $this->nombre_producto = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setDetalleProducto($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 1000)) {
            $this->detalle_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPrecioProducto($value)
    {
        if (Validator::validateMoney($value)) {
            $this->precio_producto = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setEstadoProducto($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estado_producto = $value;
            return true;
        } else {
            return false;
        }
    }
    //preguntarle  al profe
    public function setExistenciasProducto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->existencias = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setImagenProducto($value)
    {
        if (Validator::validateImageFile($value, 800, 800)) {
            $this->imagen_producto = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }

    public function setIdmarca($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_marca = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setIdcategoria($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_categoria = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setIdusuario($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_usuario = $value;
            return true;
        } else {
            return false;
        }
    }
    // Metodo para obtener los valores de los atributos.
    // Get
    public function getIdProducto()
    {
        return $this->id_producto;
    }

    public function getNombreProducto()
    {
        return $this->nombre_producto;
    }
    public function getDetalleProducto()
    {
        return $this->detalle_producto;
    }
    public function getPrecioProducto()
    {
        return $this->precio_producto;
    }
    public function getEstadoProducto()
    {
        return $this->estado_producto;
    }
    public function getExistenciasProductos()
    {
        return $this->existencias;
    }
    
    public function getImagenProducto()
    {
        return $this->imagen_producto;
    }
    public function getIdmarca()
    {
        return $this->id_marca;
    }
    public function getIdusuario()
    {
        return $this->id_usuario;
    }
    public function getIdcategoria()
    {
        return $this->id_categoria;
    }

    public function getRuta()
    {
        return $this->ruta;
    }

}