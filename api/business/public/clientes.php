<?php
require_once('../../entities/dto/clientes.php');

//se comprueba  que si existe una accion a realizar , de lo contrario se finaliza  el script con el mensaje de error 
if (isset($_GET['action'])) {
    //se crea una session o se reanuda la actual para poder utilizar variables de session  en el script
    session_start();
    //se instancia la clase correspondiente 
    $cliente  = new Clientes;
    // se declara  e inicializa  un arreglo para guardar el resultado de retorno de la API 
    $result = array('status' => 0, 'session' => 0, 'recaptcha' => 0, 'message' => null, 'exception' => null, 'username' => null);
    // se verifica que sin existe una session inciiada  como cliente para poder realizar las acciones correspondientes 
    if (isset($_SESSION['id_cliente'])) {
        $result['session'] = 1;

        // se  compara la accion a   realizar cuando un cliente  ha iniciado session 

        switch ($_GET['action']) {
            case 'getUser':
                if (isset($_SESSION['usuario'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['usuario'];
                } else {
                    $result['exception'] = 'Usuario no indefinido';
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
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // se compara la accion a  realizar cuando el cliente no ha iniciado la session 
        switch ($_GET['action']) {
            case 'singup':
                // $_POST = Validator::validateForm($_POST);
                // $secretKey = '6LdBzLQUAAAAAL6oP4xpgMao-SmEkmRCpoLBLri-';
                // $ip = $_SERVER['REMOTE_ADDR'];

                // $data = array('secret' => $secretKey, 'response' => $_POST['g-recaptcha-response'], 'remoteip' => $ip);

                // $options = array(
                //     'http' => array('header'  => "Content-type: application/x-www-form-urlencoded\r\n", 'method' => 'POST', 'content' => http_build_query($data)),
                //     'ssl' => array('verify_peer' => false, 'verify_peer_name' => false)
                // );

                // $url = 'https://www.google.com/recaptcha/api/siteverify';
                // $context  = stream_context_create($options);
                // $response = file_get_contents($url, false, $context);
                // $captcha = json_decode($response, true);

                // Se le da nombres a los objetos apra poder mandar a llamarlos en html
                if (!$cliente->setNombreCliente($_POST['nombre'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$cliente->setApellidoCliente($_POST['apellido'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$cliente->setDuiCliente($_POST['dui'])) {
                    $result['exception'] = 'DUI incorrectos';
                } elseif (!$cliente->setCorreoCliente($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$cliente->setTelefonoCliente($_POST['telefono'])) {
                    $result['exception'] = 'Telefono incorrecto';
                } elseif (!$cliente->setDireccionCliente($_POST['direccion'])) {
                    $result['exception'] = 'direccion incorrecta';
                } elseif (!$cliente->setUsuarioCliente($_POST['usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($_POST['clave'] != $_POST['confirmar_clave']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$cliente->setClaveCliente($_POST['clave'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($cliente->createRow()) {
                    
                    $result['status'] = 1;
                    $result['message'] = 'Cuenta registrada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'login':
                $_POST = Validator::validateForm($_POST);
                if (!$cliente->checkUser($_POST['usuario'])) {
                    $result['exception'] = 'Usario incorrecto';
                } elseif (!$cliente->getEstadoCliente()) {
                    $result['exception'] = 'La cuenta ha sido desactivada';
                } elseif ($cliente->checkPassword($_POST['clave'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                    $_SESSION['id_cliente'] = $cliente->getIdCliente();
                    $_SESSION['usuario'] = $cliente->getUsuarioCliente();
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
