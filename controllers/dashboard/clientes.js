// Constante para completar la ruta de la API.
const CLIENTE_API = 'business/dashboard/clientes.php';
//Constante para establecer el formulario de busqueda
const SEARCH_FROM = document.getElementById('search_form');
//Constante para guardar el formulario
const SAVE_FORM = document.getElementById('save-form');
// Constante para establecer el contenido de la tabla.
const TBODY_ROWS = document.getElementById('tbody-clientes');
//Constante para guardar el modal
const SAVE_MODAL = new Modal(document.getElementById('agregarcliente'));
//Constante para establecer el titulo del modal
const MODAL_TITLE = document.getElementById('titulo-modal');

//Evento al guardar el formulario
SAVE_FORM.addEventListener('submit',async (event) => {
  //se evita recargar la pagina
  event.preventDefault();
  //Se verifica la accion a realizar
  (document.getElementById('id').value) ? action= 'update':action = 'create';
  //Constante que contiene los datos del form
  const FORM = new FormData(SAVE_FORM);
  //peticion para guardar los datos del form
  const JSON = await dataFetch(CLIENTE_API, action, FORM);
  //se comprueba si la respuesta es satisfactoria, si no se muestra un exception
  if (JSON.status) {
    SAVE_MODAL.hide();
    cargarTabla();
    sweetAlert(1, JSON.message, true);
  }else{
    
    sweetAlert(2, JSON.exception, false);
  }
});

function openCreate(){
  SAVE_MODAL.show();
  //Se restaura los elementos del modal
  SAVE_FORM.reset();
  //Se asigna un titulo al modal
  MODAL_TITLE.textContent = 'Crear cliente';
}

document.addEventListener('DOMContentLoaded',()=>{
cargarTabla();
})

async function cargarTabla (form=null){
    TBODY_ROWS.innerHTML='';
    (form)? action='search':action='readAll';
    const JSON=await dataFetch(CLIENTE_API, action, form);
    if (JSON.status) {
        JSON.dataset.forEach(row=> {
            TBODY_ROWS.innerHTML+=`
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="w-4 ">
              <div class="px-6 py-3">
                <input id="checkbox-table-search-1" type="checkbox"
                  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
              </div>
            </td>
            <td class="px-6 py-3">${row.id_cliente} </td>
            <td class="px-6 py-3">${row.nombre_cliente}</td> 
            <td class="px-6 py-3">${row.apellido_cliente}</td> 
            <td class="px-6 py-3">${row.dui_cliente}</td> 
            <td class="px-6 py-3">${row.correo_cliente}</td> 
            <td class="px-6 py-3">${row.telefono_cliente}</td> 
            <td class="px-6 py-3">${row.direccion_cliente}</td>  
            <td class="px-6 py-3">${row.estado_cliente}</td>  
            <td class="px-6 py-3">${row.usuario}</td>      
            <td class=" px-5  py-3">
              <a><i class="fa-sharp fa-solid fa-pen"></i></a>
              <a onclick="BorrarCliente(${row.id_cliente})" "><i class="fa-sharp fa-solid fa-trash"></i></a>
              <a><i class="fa-sharp fa-solid fa-clipboard-list"></i></a>
            </td>
          </tr>
          `;
        })
    }
}

async function BorrarCliente(id_cliente) {
  // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
  const RESPONSE = await confirmAction('¿Desea eliminar a el/la cliente de forma permanente?');
  // Se verifica la respuesta del mensaje.
  if (RESPONSE) {
      // Se define una constante tipo objeto con los datos del registro seleccionado.
      const FORM = new FormData();
      FORM.append('id_cliente', id_cliente);
      // Petición para eliminar el registro seleccionado.
      const JSON = await dataFetch(CLIENTE_API, 'delete', FORM);
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

