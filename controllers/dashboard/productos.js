// Constante para completar la ruta de la API.
const PRODUCTOS_API = 'business/dashboard/productos.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-form');
// Constante para establecer el título de la modal No lo vamos  utilizar.
const MODAL_TITLE = document.getElementById('modal-title');
// Constantes para establecer el contenido de la tabla.
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');
// Constante tipo objeto para establecer las opciones del componente Modal.
const OPTIONS = {
    dismissible: false
}

document.addEventListener('DOMContentLoaded',()=>{
    cargarTabla();
})

async function cargarTabla (form=null){
    TBODY_ROWS.innerHTML='';
    (form)? action='search':action='readAll';
    const JSON=await dataFetch(PRODUCTOS_API, action, form);
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
            <td>${row.id_producto} </td>
            <td>${row.nombre_producto}</td>
            <td>${row.detalle_producto} </td>
            <td>${row.precio_producto} </td>
            <td>${row.estado_producto} </td>
            <td>${row.existencias} </td>
            <td>${row.imagen_producto} </td>
            <td>${row.id_marca} </td>
            <td>${row.id_categoria} </td>
            <td>${row.id_usuario} </td>
                <td class="px-10 py-3">
                                <a><i class="fa-sharp fa-solid fa-clipboard-list"></i></a>
                                <a><i class="fa-sharp fa-solid fa-trash"></i></a>
                </td>
            </tr>
        `;    
        }) 
    }else{
        sweetAlert(4,JSON.exception,true)
    }
} 