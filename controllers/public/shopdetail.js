//Constantes para completar la ruta de la API
const HISTORIAL_API = 'business/public/historialcompra.php';
//const PEDIDO_API = 'business/public/pedido.php';
//Contante tipo objeto para obtener los paramentros disponibles en la URL.
const PARAMS = new URLSearchParams(location.search);
//Constante para establer el formulario  de agregar un producto al carrito de compras 
const ITEM_FORM = document.getElementById('cargar');


// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar los productos del carrito de compras.
    readTable();
});

async function readTable(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(HISTORIAL_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
                <tr>
                    <td class="d-none">${row.id_detalle_pedido}</td>
                    <td>${row.fecha_pedido}</td>
                    <td>${row.Total}</td>
                </tr>
            `;
        });

    } else {
        sweetAlert(4, JSON.exception, true);
    }
}