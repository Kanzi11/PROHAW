<?php
require_once('../../entities/dto/productos.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $producto = new Producto;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $producto->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['value'] == '') {
                    $result['status'] = 1;
                    $result['dataset'] = $producto->readAll();
                } elseif ($result['dataset'] =  $producto->searchRows($_POST['value'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                    $result['status'] = 1;
                    $result['dataset'] = $producto->readAll();
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$producto->setNombreProducto($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrectos';
                } elseif (!$producto->setDetalleProducto($_POST['detalle'])) {
                    $result['exception'] = 'Descripcion incorrecta';
                } elseif (!$producto->setPrecioProducto($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$producto->setEstadoProducto(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!$producto->setExistenciasProducto($_POST['existencias'])) {
                    $result['exception'] = 'existencias incorrectas';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una  imagen';
                } elseif (!$producto->setImagenProducto($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif (!$producto->setIdmarca($_POST['marca'])) {
                    $result['exception'] = 'Marca incorrecta';
                } elseif (!$producto->setIdcategoria($_POST['categoria'])) {
                    $result['exception'] = 'Categoria incorrecta';
                } elseif ($producto->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $producto->getRuta(), $producto->getImagenProducto())) {
                        $result['message'] = 'Producto creado correctamente';
                    } else {
                        $result['message'] = 'Producto  creado correctamente pero no se guardo imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$producto->setIdProducto($_POST['id_producto'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif ($result['dataset'] = $producto->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = ' inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$producto->setIdProducto($_POST['id_producto'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$data = $producto->readOne()) {
                    $result['exception'] = 'Producto inexistente';
                } elseif (!$producto->setNombreProducto($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$producto->setDetalleProducto($_POST['detalle'])) {
                    $result['exception'] = 'Detalle incorrecto';
                } elseif (!$producto->setPrecioProducto($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$producto->setEstadoProducto(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!$producto->setExistenciasProducto($_POST['existencias'])) {
                    $result['exception'] = 'existencias incorrecto';
                } elseif (!$producto->setIdmarca($_POST['marca'])) {
                    $result['exception'] = ' Marca incorrecto';
                } elseif (!$producto->setIdcategoria($_POST['categoria'])) {
                    $result['exception'] = ' Categoria incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($producto->updateRow($data['imagen_producto'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Marca actualizada correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$producto->setImagenProducto($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($producto->updateRow($data['imagen_producto'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $producto->getRuta(), $producto->getImagenProducto())) {
                        $result['message'] = 'Producto  actualizado correctamente';
                    } else {
                        $result['message'] = 'Producto actualizada correctamente pero no se guardo la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'cargarCmbMarca':
                if ($result['dataset'] = $producto->cargarCmbMarca()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'cargarCategoria':
                if ($result['dataset'] = $producto->cargarCmbCategoria()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'cantidadProductosCategoria':
                if ($result['dataset'] = $producto->cantidadProductosCategoria()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
            case 'porcentajeProductosCategoria':
                if ($result['dataset'] = $producto->porcentajeProductosCategoria()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
            case 'lineaProductosMasComprados':
                if ($result['dataset'] = $producto->productosMasComprados()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
            case 'lineaProductosMejorValorados':
                if ($result['dataset'] = $producto->productosMejorValorados()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
            case 'cantidadProductosMarcas':
                if ($result['dataset'] = $producto->cantidadProductosMarcas()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
            case 'delete':
                if (!$producto->setIdProducto($_POST['id_producto'])) {
                    $result['exception'] = 'incorrecta';
                } elseif (!$data = $producto->readOne()) {
                    $result['exception'] = 'Producto  inexistente';
                } elseif ($producto->deleteRow()) {
                    $result['status'] = 1;
                    if (Validator::deleteFile($producto->getRuta(), $data['imagen_producto'])) {
                        $result['message'] = 'Producto eliminado';
                    } else {
                        $result['message'] = 'Producto eliminado pero no se borro la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}
