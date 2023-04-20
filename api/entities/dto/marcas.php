<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/marca_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad Marcas.
*/
class Marcas extends MarcasQueries
{
    // Declaracion de los atributos propiedades de la tabla
    protected $id_marca = null;
    protected $nombre_marca = null;
    protected $logo_marca = null;


    // Metodos para validar y asignar valores de los atributos.
    // set
    public function setIdMarca($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_marca = $value;
            return true;
        } else {
            return false;
        }
    }

    
    public function setNombreMarca($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 100)) {
            $this->nombre_marca = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setLogoMarca($value)
    {
        if (Validator::validateImageFile($value, 1, 50)) {
            $this->logo_marca = $value;
            return true;
        } else {
            return false;
        }
    }
    // Metodo para obtener los valores de los atributos.
    // Get
    public function getIdMarca()
    {
        return $this->id_marca;
    }

    public function getNombreMarca()
    {
        return $this->nombre_marca;
    }

    public function getLogoMarca()
    {
        return $this->logo_marca;
    }

}