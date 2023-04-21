<?php
require_once('../../entities/dto/clientes.php');

if(isset($_GET['action'])){
    //Se crea o reanuda la sesion actual para poder utilizar las variables de la sesion en el script.
    session_start();
    //Instancia de la clase
    $cliente = new Clientes;
    //Se declara e inicializa un arreglo para guardar el resultado de la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesion iniciada como administrador o se finaliza el script con un error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $cliente->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen'.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] =  $cliente->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$cliente->setNombreCliente($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrectos';
                }elseif(!$cliente->setApellidoCliente($_POST['apellido'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                }elseif(!$cliente->setDuiCliente($_POST['dui'])) {
                    $result['exception'] = 'DUI incorrecto';
                }elseif(!$cliente->setCorreoCliente($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                }elseif(!$cliente->setDireccionCliente($_POST['direccion'])) {
                    $result['exception'] = 'Direccion incorrecta';
                }elseif(!$cliente->setTelefonoCliente($_POST['telefono'])) {
                    $result['exception'] = 'Telefono incorrecto';
                }elseif(!$cliente->setUsuarioCliente($_POST['usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                }elseif(!$cliente->setClaveCliente($_POST['clave'])) {
                    $result['exception'] = 'Clave incorrecta';
                }elseif(!$cliente->setEstadoCliente(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif ($cliente->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cliente agregado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$cliente->setIdCliente($_POST['id_cliente'])) {
                    $result['exception'] = 'Cliente incorrecto';
                } elseif ($result['dataset'] = $cliente->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Cliente inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$cliente->setIdCliente($_POST['id'])) {
                    $result['exception'] = 'Cliente incorrecto';
                } elseif (!$cliente->readOne()) {
                    $result['exception'] = 'Cliente inexistente';
                } elseif (!$cliente->setNombreCliente($_POST['nombre'])) {
                    $result['exception'] = 'Cliente incorrectos';
                } elseif ($cliente->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Marca modificada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                case 'delete':
                    if (!$cliente->setIdCliente($_POST['id_cliente'])) {
                        $result['exception'] = 'Cliente incorrecto';
                    } elseif (!$data = $cliente->readOne()) {
                        $result['exception'] = 'Cliente inexistente';
                    } elseif ($cliente->deleteRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Cliente eliminado correctamente';
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
