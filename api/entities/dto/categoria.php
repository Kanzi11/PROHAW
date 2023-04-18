<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/categoria_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class Categoria extends CategoriaQueries
{
    // Declaracion de los atributos propiedades de la tabla
    protected $id_categoria = null;
    protected $nombre_categoria = null;


    // Metodos para validar y asignar valores de los atributos.
    // set
    public function setIdCategoria($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_categoria = $value;
            return true;
        } else {
            return false;
        }
    }

    
    public function setNombreCategoria($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->nombre_categoria = $value;
            return true;
        } else {
            return false;
        }
    }

    // Metodo para obtener los valores de los atributos.
    // Get
    public function getIdCategoria()
    {
        return $this->id_categoria;
    }

    public function getNombreCategoria()
    {
        return $this->nombre_categoria;
    }

}