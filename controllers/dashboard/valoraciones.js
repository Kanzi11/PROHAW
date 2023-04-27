// Constante para completar la ruta de la API.
const VALORACIONES_API = 'business/dashboard/valoraciones.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-form');
//constrante para establecerle el titulo de el modal al momento de cambiarlo
const MODAL_TITLE = document.getElementById('titulo-modal');
// constante para darle un id para todos los metodos insert update delete guardar el modal
const options = {
    placement: 'bottom-right',
    backdrop: 'dynamic',
    backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
    closable: true,
    onHide: () => {
        console.log('modal is hidden');
    },
    onShow: () => {
        console.log('modal is shown');
    },
    onToggle: () => {
        console.log('modal has been toggled');
    }
};
const SAVE_MODAL = new Modal(document.getElementById('agregarvaloracion'),options);
// Constantes para establecer el contenido de la tabla.
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');




// Método manejador de eventos para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(VALORACIONES_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se muestra un mensaje de éxito.
        SAVE_MODAL.hide();
        // Se carga nuevamente la tabla para visualizar los cambios.
        cargarTabla();
        // Se cierra la caja de diálogo.
        
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

/*
*   Función para preparar el formulario al momento de insertar un registro.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
function openCreate() {
    SAVE_MODAL.show();
    // Se restauran los elementos del formulario.
    SAVE_FORM.reset();
    // Se asigna título a la caja de diálogo.
    MODAL_TITLE.textContent = 'Crear Valoracion';
}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openUpdate(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(VALORACIONES_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se abre la caja de diálogo que contiene el formulario.
        
        SAVE_MODAL.show();
        // Se asigna título para la caja de diálogo.
        MODAL_TITLE.textContent = 'Actualizar marca';
        // Se inicializan los campos del formulario.
        document.getElementById('archivo').required = false;
        document.getElementById('id').value = JSON.dataset.id_marca;
        document.getElementById('nombre').value = JSON.dataset.nombre_marca;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}


/*
*   Función asíncrona para eliminar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar la marca de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_marca', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(VALORACIONES_API, 'delete', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            cargarTabla();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}

document.addEventListener('DOMContentLoaded',()=>{
    cargarTabla();
})

async function cargarTabla (form=null){
    TBODY_ROWS.innerHTML='';
    (form)? action='search':action='readAll';
    const JSON=await dataFetch(VALORACIONES_API, action, form);
    if(JSON.status){
        JSON.dataset.forEach(row=> {
            TBODY_ROWS.innerHTML+=`
            <tr>
                <td class="w-4 p-4">
                    <div class="flex items-center">
                        <input id="checkbox-table-search-1" type="checkbox"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                    </div>
                    <td>${row.id_valoracion} </td>
                    <td>${row.valoracion_producto} </td>
                    <td>${row.comentario_prodcuto} </td>
                    <td>${row.fecha_comentario} </td>
                    <td>${row.estado_comentario} </td>
                    <td>${row.id_detalle_pedido}</td>
                <td class="px-10 py-3">
                    <a onclick="openUpdate(${row.id_valoracion})"><i class="fa-sharp fa-solid fa-edit"></i></a>
                    <a onclick="openDelete(${row.id_valoracion})"><i class="fa-sharp fa-solid fa-trash"></i></a>
                </td>
            </tr>
        `;    
        }) 
    }else{
        sweetAlert(4,JSON.exception,true)
    }
}

