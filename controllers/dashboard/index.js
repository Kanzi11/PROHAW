// Constante para establecer el formulario de inicio de sesión.
const LOGIN_FORM = document.getElementById('login-form');


// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para consultar los usuarios registrados.
    const JSON = await dataFetch(USER_API, 'readUsers');
    // Se comprueba si existe una sesión, de lo contrario se sigue con el flujo normal.
    if (JSON.session) {
        // Se direcciona a la página web de bienvenida.
        location.href = 'main.html';
    } else if (JSON.status) {
        // Se muestra el formulario para iniciar sesión.
        sweetAlert(4, JSON.message, true);
    } else {
        // Se muestra el formulario para registrar el primer usuario.
        //document.getElementById('container-login').style.display='none';
        //document.getElementById('container-signup').style.display='block'
        sweetAlert(4, JSON.exception, true);
    }
});

//Método manejador de eventos para cuando se envía el formulario de inicio de sesión.
LOGIN_FORM.addEventListener('submit', async (event) => { 
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(LOGIN_FORM);
    // Petición para iniciar sesión.
    const JSON = await dataFetch(USER_API, 'login', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        sweetAlert(1, JSON.message, true, 'main.html');
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});