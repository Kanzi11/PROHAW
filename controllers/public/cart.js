

// Constante para completar la ruta de la API.
const PEDIDO_API = 'business/public/pedido.php';
// Constante para establecer el formulario de cambiar producto.
const ITEM_FORM = document.getElementById('item-form');
//Constante para establecer el cuerpo donde van aparecer los productos
const ITEM_SHOW = document.getElementById('item-show');

// Metodo que maneja el evenbto cuando el documento se ha cargado
document.addEventListener('DOMContentLoaded', ()=>{
    // mandas a llamar la funcion para mostrar los productos del carrito de compras 
    readOrderDetail();
});

// ME FALTA UN METODO QUE NO HE HECHO 
ITEM_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    //constante de tipo objeto con los datos del formulario
    const FORM = new FormData(ITEM_FORM);
    //peticion para actualizar la cantidad de producto 
    const JSON = await dataFetch(PEDIDO_API, 'updateDetail',FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if(JSON.status) {
      // Se actualiza la tabla para visualizar los cambios.
        readOrderDetail();  
        sweetAlert(1, JSON.message, true);
    }else {
        sweetAlert(2, JSON.exception, false);
    }
});

async function readOrderDetail() {
    // Petición para obtener los datos del pedido en proceso.
    const JSON = await dataFetch(PEDIDO_API, 'readOrderDetail');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializa el cuerpo de la tabla.
        ITEM_SHOW.innerHTML = '';
        // Se declara e inicializa una variable para calcular el importe por cada producto.
        let subtotal = 0;
        // Se declara e inicializa una variable para sumar cada subtotal y obtener el monto final a pagar.
        let total = 0;
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            subtotal = row.precio * row.cantidad;
            total += subtotal;
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            ITEM_SHOW.innerHTML += `
            <div class="justify-between mb-6 rounded-lg bg-white p-6 shadow-md sm:flex sm:justify-start">
            <img src="${SERVER_URL.concat('img/productos/', row.imagen_producto)}"
                alt="product-image" class="w-full rounded-lg sm:w-40" />
            <div class="sm:ml-4 sm:flex sm:w-full sm:justify-between">
                <div class="mt-5 sm:mt-0">
                    <h2 class="text-lg font-bold text-gray-900">${row.nombre_producto}</h2>
                </div>
                <div class="mt-4 flex justify-between sm:space-y-6 sm:mt-0 sm:block sm:space-x-6">
                    <div class="flex items-center border-gray-100">
                        <button onclick="openUpdate(${row.id_detalle_pedido}, ${row.cantidad})" type="submit"
                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Cantidad</button>
            
                            <div class="flex items-center border-gray-100">
                            <input class="h-8 w-8 border bg-white text-center text-xs outline-none" disabled="true"
                                type="number" min="1" /> ${row.cantidad}
                        </div>
                    </div>
                    <div class="flex items-center space-x-4" onclick="openDelete(${row.id_detalle_pedido})">
                        <p class="text-sm">${row.precio}</p>
                        <svg  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                            stroke-width="1.5" stroke="currentColor"
                            class="h-5 w-5 cursor-pointer duration-150 hover:text-red-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
            `;
        });
         // Se muestra el total a pagar con dos decimales.
        document.getElementById('sub-total').textContent = subtotal.toFixed(2);
        // Se muestra el total a pagar con dos decimales.
        document.getElementById('pago').textContent = total.toFixed(2);
    } 
    // else {
    //     sweetAlert(4, JSON.exception, false, 'index.html');
    // }   
}

/*
*   Función para abrir la caja de diálogo con el formulario de cambiar cantidad de producto.
*/

function openUpdate(id_detalle_pedido, quantity) {
    const $targetEl = document.getElementById('popup-modal');
    const modal=new Modal($targetEl);
    modal.show();
    document.getElementById('id_detalle_pedido').value = id_detalle_pedido;
    document.getElementById('cantidad').value = quantity;
}

/*
*   Función asíncrona para mostrar un mensaje de confirmación al momento de finalizar el pedido.
*/
async function finishOrder() {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Está seguro de finalizar el pedido?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Petición para finalizar el pedido en proceso.
        const JSON = await dataFetch(PEDIDO_API, 'finishOrder');
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            window.open(`${SERVER_URL}reports/public/detalle_pedido.php`)
            sweetAlert(1, JSON.message, false, 'index.html');
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}

/*
*   Función asíncrona para mostrar un mensaje de confirmación al momento de eliminar un producto del carrito.
*   Parámetros: id (identificador del producto).
*   Retorno: ninguno.
*/
async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Está seguro de remover el producto?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define un objeto con los datos del producto seleccionado.
        const FORM = new FormData();
        FORM.append('id_detalle_pedido', id);
        // Petición para eliminar un producto del carrito de compras.
        const JSON = await dataFetch(PEDIDO_API, 'deleteDetail', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            readOrderDetail();
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}
