<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/usuarios_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad USUARIO.
*/
class Usuarios extends UsuarioQueries
{
    protected $id_usuario = null;
    protected $nombre_usuario = null;
    protected $apellido_usuario = null;
    protected $alias_usuario = null;
    protected $clave_usuario = null;
    protected $id_tipo_usuario = null;

    //Sett
    public function setId_Usuario($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_usuario = $value;
            return true;
        } else {
            return false;
        }
    }   

    public function setNombre($value)
    {
        if (Validator::validateAlphabetic($value, 1, 150)) {
            $this->nombre_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setApellidos($value)
    {
        if (Validator::validateAlphabetic($value, 1, 150)) {
            $this->apellido_usuario = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setAlias_Usuario($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->alias_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    
    public function setClave_Usuario($value)
    {
        if (Validator::validatePassword($value)) {
            $this->clave_usuario = password_hash($value, PASSWORD_DEFAULT);
            return true;
        } else {
            return false;
        }
    }

    public function setIdTipoUsuario($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_tipo_usuario = $value;
            return true;
        } else {
            return false;
        }
    }


    //gett
    public function getId()
    {
        return $this->id_usuario;
    }

    public function getNombre_usuario()
    {
        return $this->nombre_usuario;
    }
    
    public function getApellidos()
    {
        return $this->nombre_usuario;
    }

    public function getAlias()
    {
        return $this->alias_usuario;
    }

    public function getClave()
    {
        return $this->clave_usuario;
    }

    public function getTipoUsuario()
    {
        return $this->id_tipo_usuario;
    }
}