// Constante para completar la ruta de la API.
const PRODUCTOS_API = 'business/dashboard/productos.php';
const MARCA_API = 'business/dashboard/marcas.php';
const CATEGORIA_API = 'business/dashboard/categoria.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-form');
// Constante para establecer el título de la modal No lo vamos  utilizar.
const MODAL_TITLE = document.getElementById('modal-title');
// Constantes para establecer el contenido de la tabla.
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');
const SAVE_MODAL = new Modal(document.getElementById('agregarproducto'));
// Constante tipo objeto para establecer las opciones del componente Modal.
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
    MODAL_TITLE.textContent = 'Crear producto';
    document.getElementById('archivo').required = true;
    fillSelect(MARCA_API, 'readAll', 'marca');
    fillSelect(CATEGORIA_API, 'readAll', 'categoria');
}


//   metodo para encontrar los casos de create an update   
//Evento al guardar el formulario
SAVE_FORM.addEventListener('submit', async (event) => {
    //se evita recargar la pagina
    event.preventDefault();
    //Se verifica la accion a realizar
    (document.getElementById('id_producto').value) ? action = 'update' : action = 'create';
    //Constante que contiene los datos del form
    const FORM = new FormData(SAVE_FORM);
    //peticion para guardar los datos del form
    const JSON = await dataFetch(PRODUCTOS_API, action, FORM);
    //se comprueba si la respuesta es satisfactoria, si no se muestra un exception
    if (JSON.status) {
        SAVE_MODAL.hide();
        cargarTabla();
        sweetAlert(1, JSON.message, true);
    } else {

        sweetAlert(2, JSON.exception, false);
    }
});





/*
*   Función asíncrona para eliminar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openDelete(id_producto) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el producto de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_producto', id_producto);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(PRODUCTOS_API, 'delete', FORM);
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

async function openUpdate(id_producto) {
    const FORM = new FormData();
    FORM.append('id_producto', id_producto);
    const JSON = await dataFetch(PRODUCTOS_API, 'readOne', FORM);
    if (JSON.status) {
        SAVE_MODAL.show();
        MODAL_TITLE.textContent = 'Actualizar producto';
        document.getElementById('archivo').required = false;
        document.getElementById('id_producto').value = JSON.dataset.id_usuario;
        document.getElementById('nombre').value = JSON.dataset.nombre_producto;
        document.getElementById('detalle').value = JSON.dataset.detalle_producto;
        document.getElementById('precio').value = JSON.dataset.precio_producto;
        if (JSON.dataset.estado_producto) {
            document.getElementById('estado').checked = true;
        } else {
            document.getElementById('estado').checked = false;
        }
        document.getElementById('existencias').value = JSON.dataset.existencias;

        fillSelect(MARCA_API, 'readAll', 'marca', JSON.dataset.
            id_marca);
        fillSelect(CATEGORIA_API, 'readAll', 'categoria', JSON.dataset.
            id_categoria);
    } else {
        sweetAlert(2, JSON.exception, false)
    }
}

document.addEventListener('DOMContentLoaded', () => {
    cargarTabla();
})

async function cargarTabla(form = null) {
    TBODY_ROWS.innerHTML = '';
    (form) ? action = 'search' : action = 'readAll';
    const JSON = await dataFetch(PRODUCTOS_API, action, form);
    if (JSON.status) {
        JSON.dataset.forEach(row => {
            TBODY_ROWS.innerHTML += `
            <tr>
            <td class="w-4 p-4">
                <div class="flex items-center">
                    <input id="checkbox-table-search-1" type="checkbox"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                </div>
            <td class="px-6 py-3" >${row.id_producto} </td>
            <td class="px-6 py-3">${row.nombre_producto}</td>
            <td>${row.detalle_producto} </td>
            <td class="px-6 py-3">${row.precio_producto} </td>
            <td class="px-6 py-3">${row.estado_producto} </td>
            <td class="px-6 py-3">${row.existencias} </td>
            <td><img src="${SERVER_URL}img/productos/${row.imagen_producto}" class="materialboxed" height="100"> </td> 
            <td class="px-6 py-3">${row.id_marca} </td>
            <td class="px-6 py-3">${row.id_categoria} </td>
            <td class="px-6 py-3">${row.id_usuario} </td>
                <td class="px-5 py-3">
                    <a onclick="openUpdate(${row.id_producto})"><i class="fa-sharp fa-solid fa-pen"></i></a>
                    <a onclick="openDelete(${row.id_producto})"<i class="fa-sharp fa-solid fa-trash"></i></a>
                </td>
            </tr>
        `;
        })
    } else {
        sweetAlert(4, JSON.exception, true)
    }
}

