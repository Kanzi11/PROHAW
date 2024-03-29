<?php
require_once('../../entities/dto/pedido.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $pedido = new Pedido;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $pedido->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'showDetail':
                if (!$pedido->setIdPedido($_POST['id_pedido'])) {
                    $result['exception'] = 'Pedido incorrecto';
                } elseif (!$data = $pedido->readOne()) {
                    $result['exception'] = 'Pedido inexistente';
                } elseif ($result['dataset'] = $pedido->showdetail()) {
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
                //print_r($_POST);
                if ($_POST['value'] == '') {
                    $result['status'] = 1;
                    $result['dataset'] = $pedido->readAll();
                } elseif ($result['dataset'] =  $pedido->searchRows($_POST['value'])) {
         
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
               
                    $result['status'] = 1;
                    $result['dataset'] = $pedido->readAll();
                }
                break;
            case 'search-detail':
                    $_POST = Validator::validateForm($_POST);
                    //print_r($_POST);
                    if ($_POST['value'] == '') {
                        $result['status'] = 1;
                        $result['dataset'] = $pedido->readAll();
                    } elseif(!$pedido->setIdPedido($_POST['id_pedido'])) {
                        $result['exception'] = 'Pedido Incorrecto';
                    } elseif ($result['dataset'] =  $pedido->searchRowsOrder($_POST['value'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                   
                        $result['status'] = 1;
                        $result['dataset'] = $pedido->readAll();
                    }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$pedido->setEstadoPedido(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!$pedido->setFechaPedido($_POST['fecha'])) {
                    $result['exception'] = 'Fecha incorrecta';
                } elseif (!isset($_POST['cliente'])) {
                    $result['exception'] = 'Seleccione un cliente';
                } elseif (!$pedido->setIdCliente($_POST['cliente'])) {
                    $result['exception'] = 'Cliente incorrecto';
                } elseif ($pedido->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pedido creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // case 'ReadCliente':
                //     if ($result['dataset'] = $pedido->readCliente()) {
                //         $result['status'] = 1;
                //         $result['message'] = 'Existen registros ';
                //     } elseif (Database::getException()) {
                //         $result['exception'] = Database::getException();
                //     } else {
                //         $result['exception'] = 'No hay datos registrados';
                //     }
                //     break;
            case 'readOne':
                if (!$pedido->setIdPedido($_POST['id_pedido'])) {
                    $result['exception'] = 'Pedido incorrecto';
                } elseif ($result['dataset'] = $pedido->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Pedido inexistente';
                }
                break;
            case 'update':
                if (!$pedido->setIdPedido($_POST['id_pedido'])) {
                    $result['exception'] = 'Pedido incorrecto';
                } elseif (!$pedido->setEstadoPedido(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif ($pedido->changeStatus()) {
                    $result['status'] = 1;
                    $result['message'] = 'Estado del pedido actualizado';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$pedido->setIdPedido($_POST['id_pedido'])) {
                    $result['exception'] = 'Pedido incorrecto';
                } elseif (!$data = $pedido->readOne()) {
                    $result['exception'] = 'Pedido inexistente';
                } elseif ($pedido->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pedido eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'deleteDT':
                if (!$pedido->setIdDetalle($_POST['id_detalle_pedido'])) {
                    $result['exception'] = 'Detalle incorrecto';
                } elseif (!$data = $pedido->readDetalle()) {
                    $result['exception'] = 'Detalle inexistente';
                } elseif ($pedido->BorrarDetalle()) {
                    $result['status'] = 1;
                    $result['message'] = 'Detalle eliminado correctamente';
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
