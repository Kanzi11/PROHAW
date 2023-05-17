// Constante para establecer el formulario de registrar cliente.
const SIGNUP_FORM = document.getElementById('signup-form');



// Método manejador de eventos para cuando se envía el formulario de registrar cliente.
SIGNUP_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SIGNUP_FORM);
    // Petición para registrar un cliente.
    const JSON = await dataFetch(USER_API, 'singup', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        sweetAlert(1, JSON.message, true, 'login.html');
    } else if (JSON.recaptcha) {
        sweetAlert(2, JSON.exception, false, 'index.html');
    } else {
        sweetAlert(2, JSON.exception, false);
        // Se genera un nuevo token cuando ocurre un problema.
        // reCAPTCHA();
    }
});