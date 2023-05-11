<?php
require_once('../../entities/dto/usuarios.php');


if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();

    // Se instancia la clase correspondiente.
    $usuario = new Usuarios;

    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'getUser':
                if (isset($_SESSION['alias_usuario'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['alias_usuario'];
                } else {
                    $result['exception'] = 'Alias de usuario indefinido';
                }
                break;
            case 'logOut':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminada correctamente';
                } else {
                    $result['exception'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen' . count($result['dataset']) . ' registros';
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
                    $result['dataset'] = $usuario->readAll();
                } elseif ($result['dataset'] =  $usuario->searchRows($_POST['value'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['status'] = 1;
                    $result['dataset'] = $usuario->readAll();
                }
                break;
            case 'readOne':
                if (!$usuario->setId_Usuario($_POST['id'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($result['dataset'] = $usuario->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrectos';
                } elseif (!$usuario->setApellidos($_POST['apellido'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setAlias_Usuario($_POST['Alias'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif (!$usuario->setIdTipoUsuario($_POST['tipousuario'])) {
                    $result['exception'] = 'Tipo de usuario incorrecto';
                } elseif (!$usuario->setClave_Usuario($_POST['clave'])) {
                    $result['exception'] = 'Clave incorrecto';
                } elseif ($usuario->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario agregado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setId_Usuario($_POST['id'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$data = $usuario->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif (!$usuario->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setApellidos($_POST['apellido'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setAlias_Usuario($_POST['Alias'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif (!$usuario->setIdTipoUsuario($_POST['tipousuario'])) {
                    $result['exception'] = 'Tipo de usuario incorrecto';
                } elseif (!$usuario->setClave_Usuario($_POST['clave'])) {
                    $result['exception'] = 'Clave incorrecto';
                } elseif ($usuario->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'cargarTipoUsuario':
                if ($result['dataset'] = $usuario->CargarCmbTipoUsuario()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'delete':
                if (!$usuario->setId_Usuario($_POST['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$data = $usuario->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif ($usuario->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        switch ($_GET['action']) {
            case 'readUsers':
                if ($usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Debe autenticarse para ingresar';
                } else {
                    $result['exception'] = 'Debe crear un usuario para comenzar';
                }
                break;
            case 'signup':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setNombre($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setId_Usuario($_POST['usuario'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif ($_POST['codigo'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$usuario->setClave_Usuario($_POST['codigo'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($usuario->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario registrado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

            case 'login':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->checkUser($_POST['user'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif ($usuario->checkPassword($_POST['password'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                    $_SESSION['id_usuario'] = $usuario->getId();
                    $_SESSION['alias_usuario'] = $usuario->getAlias();
                } else {
                    $result['exception'] = 'Clave incorrecta';
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible fuera de la sesión';
        }
    }

    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
