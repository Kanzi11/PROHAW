<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class UsuarioQueries
{

    public function checkUser($alias_usuario)
    {
        $sql = 'SELECT id_usuario FROM usuarios WHERE alias_usuario = ?';
        $params = array($alias_usuario);
        if ($data = Database::getRow($sql, $params)) {
            $this->id_usuario = $data['id_usuario'];
            $this->alias_usuario = $alias_usuario;
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT clave_usuario FROM usuarios WHERE id_usuario = ?';
        $params = array($this->id_usuario);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contraseña coincide con el hash almacenado en la base de datos.
        if ($password == $data['clave_usuario']) {
            return true;
        } else {
            return false;
        }
    }
    public function searchRows($value)
    {
        $sql = 'SELECT nombre_usuario, alias_usuario, id_tipo_usuario
                FROM usuarios
                WHERE nombre_usuario  ILIKE ?, alias_usuario  ILIKE ?, id_tipo_usuario  ILIKE ?
                 ORDER BY id_usuario';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }
    public function createRow()
    {
        $sql = 'INSERT INTO usuarios(nombres_usuario, apellidos_usuario,  alias_usuario, clave_usuario,id_tipo_usuario)
                VALUES(?, ?, ?, ?, ?)';
        $params = array($this->nombre_usuario, $this->apellido_usuario,  $this->alias_usuario, $this->clave_usuario, $this->id_tipo_usuario);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT a.id_usuario, a.nombre_usuario, a.apellido_usuario, a.alias_usuario, a.clave_usuario, b.tipo_usuario
                FROM usuarios a INNER JOIN tipos_usuarios b ON a.id_tipo_usuario = b.id_tipo_usuario
                ORDER BY id_usuario;';
        return Database::getRows($sql);
    }
    public function readOne()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, alias_usuario, clave_usuario, id_tipo_usuario
                FROM usuarios
                WHERE id_usuario = ?';
        $params = array($this->id_usuario);
        return Database::getRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM usuarios
                WHERE id_usuario = ?';
        $params = array($this->id_usuario);
        return Database::executeRow($sql, $params);
    }
}
