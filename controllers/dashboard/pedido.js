// Constante para completar la ruta de la API.
const PEDIDO_API = 'business/dashboard/pedido.php';
const CLIENTE_API ='business/dashboard/clientes.php';
// Constante para establecer el formulario de buscar.
//const SEARCH_FORM = document.getElementById('search-form');
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-form');
// constante para darle un id para todos los metodos insert update delete guardar el modal
const SAVE_MODAL = new Modal(document.getElementById('agregarpedido'));
//constrante para establecerle el titulo de el modal al momento de cambiarlo
const MODAL_TITLE = document.getElementById('titulo-modal');
// Constantes para establecer el contenido de la tabla.
const TBODY_ROWS = document.getElementById('tbody-rows');



function openCreate() {
    SAVE_MODAL.show();
    // Se restauran los elementos del formulario.
    SAVE_FORM.reset();
    // Se asigna título a la caja de diálogo.
    MODAL_TITLE.textContent = 'Crear pedido';

    fillSelect(CLIENTE_API, 'readAll', 'cliente');

}

// Método manejador de eventos para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id_cliente').value) ? action = 'update' : action = 'create';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(PEDIDO_API, action, FORM);
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

document.addEventListener('DOMContentLoaded',()=>{
    cargarTabla();
})

async function cargarTabla (form=null){
    TBODY_ROWS.innerHTML='';
    (form)? action='search':action='readAll';
    const JSON=await dataFetch(PEDIDO_API, action, form);
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
                <td>${row.id_pedido}</td>
                <td>${row.estado_pedido}</td>
                <td>${row.fecha_pedido}</td>
                <td>${row.id_cliente}</td>
                <td class="px-10 py-3">
                    <a onclick="openUpdate(${row.id_categoria})"><i class="fa-sharp fa-solid fa-edit"></i></a>
                    <a onclick="eliminarPedido(${row.id_pedido})"><i class="fa-sharp fa-solid fa-trash"></i></a>
                </td>
            </tr>
        `;    
        }) 
    }else{
        sweetAlert(4,JSON.exception,true)
    }
}



async function eliminarPedido (id_pedido){
    const RESPONSE= await confirmAction('Desea eliminar este pedido?');
    if(RESPONSE){
        const FORM= new FormData();
        FORM.append('id_pedido',id_pedido);
        const JSON = await dataFetch(PEDIDO_API, 'delete', FORM);
        if(JSON.status) {
            cargarTabla();
            sweetAlert(1,JSON.message,true);
        }else{
            sweetAlert(2,JSON.message,false);
        }
    }
}
