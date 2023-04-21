<?php
require_once('../../helpers/Validator.php');
require_once('../../entities/dao/clientes_queries.php');
/*
 * Clase para manejar la transferencia de datos de la entidad Clientes.
 *  
*/
class Clientes extends ClientesQueris
{
    //Declarando los atributos de la tabla
    protected $id_cliente = null; 
    protected $nombre_cliente = null;
    protected $apellido_cliente = null;
    protected $dui_cliente = null;
    protected $correo_cliente = null;
    protected $telefono_cliente = null;
    protected $direccion_cliente = null;
    protected $estado_cliente = null;
    protected $usuario = null;
    protected $clave = null;

    // Metodos para validar y asignar valores de los atributos
    //Set id_cliente
    public function setIdCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_cliente = $value;
            return true;
        }else{
            return false;
        }
    }
    //set nombre del cliente
    public function setNombreCliente($value)
    {
        if (Validator::validateAlphanumeric($value,1,150)) {
            $this->nombre_cliente = $value;
            return true;
        }else{
            return false;
        }
    }
    //set Apellido del cliente
    public function setApellidoCliente($value)
    {
        if (Validator::validateAlphanumeric($value,1,150)) {
            $this->apellido_cliente = $value;
            return true;
        }else{
            return false;
        }
    }
    //Set Dui del cliente
    public function setDuiCliente($value)
    {
        if (Validator::validateAlphanumeric($value,1,10)) {
            $this->dui_cliente = $value;
            return true;
        }else{
            return false;
        }
    }
    //Set Correo Cliente
    public function setCorreoCliente($value)
    {
        if (Validator::validateAlphanumeric($value,1,100)) {
            $this->correo_cliente = $value;
            return true;
        }else{
            return false;
        }
    }
    //Set telefono cliente
    public function setTelefonoCliente($value)
    {
        if (Validator::validateAlphanumeric($value,1,9)) {
            $this->telefono_cliente = $value;
            return true;
        }else{
            return false;
        }
    }
    // set direccion cliente
    public function setDireccionCliente($value)
    {
        if (Validator::validateAlphanumeric($value,1,200)) {
            $this->direccion_cliente = $value;
            return true;
        }else{
            return false;
        }
    }
    //set estado cliente
    public function setEstadoCliente($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estado_cliente = $value;
            return true;
        }else{
            return false;
        }
    }
    //set usuario cliente
    public function setUsuarioCliente($value)
    {
        if (Validator::validateAlphanumeric($value,1,50)) {
            $this->usuario = $value;
            return true;
        }else{
            return false;
        }
    }
    // set clave cliente
    public function setClaveCliente($value) 
    {
        if (Validator::validateAlphanumeric($value,1,100)) {
            $this->clave = $value;
            return true;
        }else{
            return false;
        }
    }

    //Get 
    public function getIdCliente()
    {
       return $this->id_cliente;
    }
    public function getNombreCliente()
    {
       return $this->nombre_cliente;
    }
    public function getApellidoCliente()
    {
       return $this->apellido_cliente;
    }
    public function getDuiCliente()
    {
       return $this->dui_cliente;
    }
    public function getCorreoCliente()
    {
       return $this->correo_cliente;
    }
    public function getTelefonoCliente()
    {
       return $this->telefono_cliente;
    }
    public function getDireccionCliente()
    {
       return $this->direccion_cliente;
    }
    public function getEstadoCliente()
    {
       return $this->estado_cliente;
    }
    public function getUsuarioCliente()
    {
       return $this->usuario;
    }
    public function getClaveCliente()
    {
       return $this->clave;
    }
}
