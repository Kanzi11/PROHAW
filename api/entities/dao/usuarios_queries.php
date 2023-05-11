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
    // Metodo del buscador 
    public function searchRows($value)
    {
        $sql = 'SELECT a.id_usuario, a.nombre_usuario, a.apellido_usuario, a.alias_usuario, a.clave_usuario, b.tipo_usuario
        FROM usuarios a INNER JOIN tipos_usuarios b ON a.id_tipo_usuario = b.id_tipo_usuario
        WHERE a.nombre_usuario ILIKE ? OR a.apellido_usuario ILIKE ? OR a.alias_usuario ILIKE ? OR b.tipo_usuario ILIKE ? 
        ORDER BY a.nombre_usuario;';
        $params = array("%$value%","%$value%","%$value%","%$value%");
        return Database::getRows($sql, $params);
    }
    public function createRow()
    {
        $sql = 'INSERT INTO usuarios(nombre_usuario, apellido_usuario,  alias_usuario, clave_usuario, id_tipo_usuario)
                VALUES(?, ?, ?, ?, ?)';
        $params = array($this->nombre_usuario, $this->apellido_usuario,  $this->alias_usuario, $this->clave_usuario, $this->id_tipo_usuario);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        $sql = 'UPDATE usuarios 
                SET  nombre_usuario = ?, apellido_usuario = ?, alias_usuario = ?, clave_usuario = ?, id_tipo_usuario = ?
                WHERE id_usuario = ?';
        $params = array($this->nombre_usuario, $this->apellido_usuario,  $this->alias_usuario, $this->clave_usuario, $this->id_tipo_usuario, $this->id_usuario);
        return Database::executeRow($sql, $params);
    }

    public function CargarCmbTipoUsuario()
    {
        $sql = 'SELECT id_tipo_usuario, tipo_usuario 
        FROM tipos_usuarios';
        return Database::getRows($sql);
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
