// Constante para completar la ruta de la API.
const USUARIO_API = 'business/dashboard/usuarios.php';
// Constante para establecer el formulario de buscar.
const SEARCH_INPUT = document.getElementById('search-input');
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-form');
// Constante para establecer el título de la modal.
const MODAL_TITLE = document.getElementById('titulo-modal');
// Constantes para establecer el contenido de la tabla.
const TBODY_ROWS = document.getElementById('tbody-usuarios');
const RECORDS = document.getElementById('records');
//Constante para guardar el modal
const SAVE_MODAL = new Modal(document.getElementById('agregarusuario'));

//Evento al guardar el formulario
SAVE_FORM.addEventListener('submit',async (event) => {
  //se evita recargar la pagina
  event.preventDefault();
  //Se verifica la accion a realizar
  (document.getElementById('id').value) ? action = 'update':action = 'create';
  //Constante que contiene los datos del form
  const FORM = new FormData(SAVE_FORM);
  //peticion para guardar los datos del form
  const JSON = await dataFetch(USUARIO_API, action, FORM);
  //se comprueba si la respuesta es satisfactoria, si no se muestra un exception
  if (JSON.status) {
    SAVE_MODAL.hide();
    cargarTablaUsers();
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
  MODAL_TITLE.textContent = 'Crear usuario';
  fillSelect(USUARIO_API,'cargarTipoUsuario','tipousuario');
}

async function openUpdate(id_usuario){
  const FORM = new FormData();
  FORM.append('id',id_usuario);
  const JSON = await dataFetch(USUARIO_API, 'readOne', FORM);
  if (JSON.status) {
    SAVE_MODAL.show();
    MODAL_TITLE.textContent ='Actualizar Usuario';  
    document.getElementById('id').value = JSON.dataset.id_usuario;
    document.getElementById('nombre').value = JSON.dataset.nombre_usuario;
    document.getElementById('apellido').value = JSON.dataset.apellido_usuario;
    document.getElementById('Alias').value = JSON.dataset.alias_usuario;
    document.getElementById('clave').value = JSON.dataset.clave_usuario;
    fillSelect(USUARIO_API, 'cargarTipoUsuario','tipousuario',JSON.dataset.id_tipo_usuario);
  } else {
    sweetAlert(2, JSON.exception, false)
  }
}

//Metodo para buscar
SEARCH_INPUT.addEventListener('input',(event)=>{
  //Evitar que se recargue
  event.preventDefault();
  //Constante tipo objeto con los datos del form
  const FORM = new FormData();
  //Se lee el valor del input
  FORM.append('value',SEARCH_INPUT.value);
  //Carga la tabla con los valores
  cargarTablaUsers(FORM);   
})

document.addEventListener('DOMContentLoaded',()=>{
    cargarTablaUsers();
    })

async function cargarTablaUsers(form=null){
    TBODY_ROWS.innerHTML='';
    (form)? action='search':action='readAll';
    const JSON=await dataFetch(USUARIO_API, action, form);
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
            <td class="px-6 py-3">${row.id_usuario} </td>
            <td class="px-6 py-3">${row.nombre_usuario}</td> 
            <td class="px-6 py-3">${row.apellido_usuario}</td> 
            <td class="px-6 py-3">${row.alias_usuario}</td> 
            <td class="px-6 py-3">${row.tipo_usuario}</td>      
            <td class=" px-5  py-3">
              <a onclick="openUpdate(${row.id_usuario})"><i class="fa-sharp fa-solid fa-pen"></i></a>
              <a onclick="BorrarUsuario(${row.id_usuario})"><i class="fa-sharp fa-solid fa-trash"></i></a>
              <a><i class="fa-sharp fa-solid fa-clipboard-list"></i></a>
            </td>
          </tr>
          `;
        })
    }
}

async function BorrarUsuario(id_usuario) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar a el usuario de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_usuario', id_usuario);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(USUARIO_API, 'delete', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            cargarTablaUsers();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
  }

  function openReport() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/dashboard/usuarios.php`);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}