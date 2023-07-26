<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad MARCAS.
*/

class ProductoQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    // Metodo del buscador 
    public function searchRows($value)
    {
        $sql = 'SELECT a.id_producto, a.nombre_producto, a.detalle_producto, a.precio_producto, a.estado_producto, a.existencias, a.imagen_producto, c.nombre_marca, b.nombre_categoria, d.nombre_usuario
        FROM productos a 
        INNER JOIN categorias b ON a.id_categoria = b.id_categoria 
        INNER JOIN marcas c ON a.id_marca = c.id_marca 
        INNER JOIN usuarios d ON a.id_usuario = d.id_usuario
        WHERE a.nombre_producto ILIKE ? OR c.nombre_marca ILIKE ? OR b.nombre_categoria ILIKE ? or a.precio_producto::varchar ILIKE ? OR a.estado_producto::varchar ILIKE ? 
        ORDER BY id_producto'; 
        $params = array("%$value%","%$value%","%$value%","%$value%","%$value%");
        return Database::getRows($sql, $params);
    }
    // metodo para crear un registro

    public function createRow()
    {
        $sql = 'INSERT INTO productos(nombre_producto, detalle_producto, precio_producto, estado_producto, existencias, imagen_producto, id_marca, id_categoria, id_usuario)
                VALUES(?,?,?,?,?,?,?,?,?)';
        $params = array($this->nombre_producto, $this->detalle_producto, $this->precio_producto, $this->estado_producto, $this->existencias, $this->imagen_producto, $this->id_marca, $this->id_categoria, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }
    // Metodo para leer todos los registros actuales creo
    public function readAll()
    {
        $sql = 'SELECT a.id_producto, a.nombre_producto, a.detalle_producto, a.precio_producto, a.estado_producto, a.existencias, a.imagen_producto, c.nombre_marca, b.nombre_categoria, d.nombre_usuario
        FROM productos a 
        INNER JOIN categorias b ON a.id_categoria = b.id_categoria 
        INNER JOIN marcas c ON a.id_marca = c.id_marca 
        INNER JOIN usuarios d ON a.id_usuario = d.id_usuario
        ORDER BY id_producto';
        return Database::getRows($sql);
    }
    // Metodo para leer un registro si no mal entiendo
    public function readOne()
    {
        $sql = 'SELECT id_producto, nombre_producto, detalle_producto, precio_producto, estado_producto, existencias, imagen_producto, id_marca, id_categoria, id_usuario
                FROM productos
                WHERE id_producto = ?';
        $params = array($this->id_producto);
        return Database::getRow($sql, $params);
    }

    // Metodo para actualizar un registro
    public function updateRow($current_image)
    {
        ($this->imagen_producto) ? Validator::deleteFile($this->getRuta(), $current_image) : $this->imagen_producto = $current_image;
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        $sql = 'UPDATE productos
                SET  nombre_producto = ? , detalle_producto = ? , precio_producto = ? , estado_producto = ? , existencias = ? , imagen_producto = ? , id_marca = ? , id_categoria = ?
                WHERE id_producto = ?';
        $params = array($this->nombre_producto, $this->detalle_producto, $this->precio_producto, $this->estado_producto, $this->existencias, $this->imagen_producto, $this->id_marca, $this->id_categoria, $this->id_producto);
        return Database::executeRow($sql, $params);
    }

    // Metodo para cambiar el estado de un producto
    public function changeStatusP()
    {
        $sql = 'UPDATE productos
                SET  estado_producto = ?
                WHERE id_producto = ?';
        $params = array($this->estado_producto, $this->id_producto);
        return Database::executeRow($sql, $params);
    }
    // Metodo para cargar el cmb de marcas
    public function cargarCmbMarca()
    {
        $sql = 'SELECT id_marca, nombre_marca 
        FROM marcas';
        return Database::getRows($sql);
    }
    // Metodo para cargar el cmb de categoria
    public function cargarCmbCategoria()
    {
        $sql = 'SELECT id_categoria, nombre_categoria 
        FROM categorias';
        return Database::getRows($sql);
    }
    // Metodo para eliminar un registro
    public function deleteRow()
    {
        $sql = 'DELETE FROM productos
                WHERE id_producto = ?';
        $params = array($this->id_producto);
        return Database::executeRow($sql, $params);
    }

    public function readProductosCategoria()
    {
        $sql = 'SELECT id_producto, imagen_producto, nombre_producto, detalle_producto, precio_producto
        FROM productos INNER JOIN categorias USING (id_categoria)
        WHERE id_categoria = ? AND estado_producto = true
        ORDER BY nombre_producto';
        $params = array($this->id_categoria);
        return Database::getRows($sql, $params);
    }

     /*
    *   Métodos para generar gráficas.
    */
    public function cantidadProductosCategoria()
    {
        $sql = 'SELECT nombre_categoria, COUNT(id_producto) cantidad
                FROM productos
                INNER JOIN categorias USING(id_categoria)
                GROUP BY nombre_categoria ORDER BY cantidad DESC';
        return Database::getRows($sql);
    }

    public function porcentajeProductosCategoria()
    {
        $sql = 'SELECT nombre_categoria, ROUND((COUNT(id_producto) * 100.0 / (SELECT COUNT(id_producto) FROM productos)), 2) porcentaje
                FROM productos
                INNER JOIN categorias USING(id_categoria)
                GROUP BY nombre_categoria ORDER BY porcentaje DESC';
        return Database::getRows($sql);
    }

    public function productosMasComprados(){
        $sql = 'SELECT b.nombre_producto, SUM(a.cantidad) AS total_vendidos
        FROM detalles_pedidos a INNER JOIN productos b USING (id_producto)
        GROUP BY b.nombre_producto ORDER BY total_vendidos ASC
        LIMIT 5';
        return Database::getRows($sql);
    }

    
    public function productosMejorValorados(){
        $sql = 'SELECT p.nombre_producto, ROUND(AVG (v.valoracion_producto),2) AS promedio
                FROM productos p
                INNER JOIN detalles_pedidos dp ON p.id_producto = dp.id_producto
                INNER JOIN valoraciones v ON dp.id_detalle_pedido = v.id_detalle_pedido
                GROUP BY p.nombre_producto
                ORDER BY promedio DESC LIMIT 5';
        return Database::getRows($sql);
    }

    public function cantidadProductosMarcas()
    {
        $sql = 'SELECT nombre_marca, COUNT(id_producto) AS total
            FROM productos
            INNER JOIN marcas USING(id_marca)
            GROUP BY nombre_marca ORDER BY total DESC';
        return Database::getRows($sql);
    }

    // Metodo para traer el nombre de los productos
    public function reportNombresProductos()
    {
        $sql = 'SELECT id_producto,nombre_producto FROM productos INNER JOIN detalles_pedidos USING (id_producto)';
        return Database::getRows($sql);
    }

    public function reportEstadoProducto()
    {
        $sql = 'SELECT p.nombre_producto , p.estado_producto, c.nombre_categoria, m.nombre_marca FROM productos p
		INNER JOIN categorias c USING (id_categoria) INNER JOIN marcas m USING (id_marca) ORDER BY p.estado_producto
        ';
        return Database::getRows($sql);
    }
}
