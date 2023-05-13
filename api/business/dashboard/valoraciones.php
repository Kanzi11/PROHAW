<?php
require_once('../../entities/dto/valoraciones.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $valoracion = new Valoraciones;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $valoracion->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
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
                    $result['dataset'] = $valoracion->readAll();
                } elseif ($result['dataset'] =  $valoracion->searchRows($_POST['value'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                    $result['status'] = 1;
                    $result['dataset'] = $valoracion->readAll();
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$valoracion->setNombreMarca($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrectos';
                } elseif(!is_uploaded_file($_FILES['archivo']['tmp_name'])){
                    $result['exception'] = 'Seleccione una  imagen';
                } elseif (!$valoracion->setLogoMarca($_FILES['archivo'])){
                    $result['exception'] = Validator::getFileError();
                }elseif ($valoracion->createRow()) {
                    $result['status'] = 1;
                 if(Validator::saveFile($_FILES['archivo'], $valoracion->getRuta(), $valoracion->getLogoMarca())){
                    $result['message'] = 'Marca creada correctamente';
                 } else{
                    $result['message'] = 'Marca creada correctamente pero no se guardo imagen';
                 }
            }else{
                $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$valoracion->setIdValoracion($_POST['id'])) {
                    $result['exception'] = 'incorrecto';
                } elseif ($result['dataset'] = $valoracion->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$valoracion->setIdValoracion($_POST['id'])) {
                    $result['exception'] = 'estado incorrecto';
                } elseif (!$data=$valoracion->readOne()) {
                    $result['exception'] = 'estado inexistente';
                }elseif (!$valoracion->setValoracionProducto($_POST['nombre'])) {
                    $result['exception'] = 'algo incorrecto';
                }elseif (!$valoracion->setComentarioProducto($_POST['comentario'])) {
                    $result['exception'] = 'algo incorrecto';
                } elseif (!$valoracion->setFechaComentario($_POST['fecha'])) {
                    $result['exception'] = 'algo incorrecto';
                }elseif (!$valoracion->setEstadoComentario(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'algo incorrecto';
                }elseif (!$valoracion->setIdDetallePedido($_POST['detalle'])) {
                    $result['exception'] = 'algo incorrecto';
                } if($valoracion->updateRow()){
                        $result['status'] = 1;
                        $result['message'] = 'Estado actualizado correctamente';
                }
            
                break;
                case 'delete':
                    if (!$valoracion->setIdMarca($_POST['id_marca'])) {
                        $result['exception'] = 'Marca incorrecta';
                    } elseif (!$data = $valoracion->readOne()) {
                        $result['exception'] = 'Marca inexistente';
                    } elseif ($valoracion->deleteRow()) {
                        $result['status'] = 1;
                        if(Validator::deleteFile($valoracion->getRuta(), $data['logo_marca'])){
                            $result['message'] = 'Marca eliminada';
                        }else{
                            $result['message'] = 'Marca eliminada pero no se borro la imagen';
                        }
                    } else{
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