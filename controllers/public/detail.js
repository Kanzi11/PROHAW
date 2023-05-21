//Constantes para completar la ruta de la API
const PRODUCTO_API = 'business/public/producto.php';
//const PEDIDO_API = 'business/public/pedido.php';
//Contante tipo objeto para obtener los paramentros disponibles en la URL.
const PARAMS = new URLSearchParams(location.search);
//Constante para establer el formulario  de agregar un producto al carrito de compras 
const SHOPPING_FORM = document.getElementById('shopping-form');


//Metodo manejador de eventos para cuando el documento ya  ha cargado 
document.addEventListener('DOMContentLoaded', async ()=>{
    // Constante tipo objeto con los datos del producto seleccionado.
    const FORM = new FormData();
    FORM.append('id_producto', PARAMS.get('id'));
    // Petición para solicitar los datos del producto seleccionado.
    const JSON = await dataFetch(PRODUCTO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if(JSON.status){
         // Se colocan los datos en la página web de acuerdo con el producto seleccionado previamente.
        document.getElementById('imagen').src = SERVER_URL.concat('img/productos/', JSON.dataset.imagen_producto);
        document.getElementById('nombre').textContent = JSON.dataset.nombre_producto;
        document.getElementById('descripcion').textContent = JSON.dataset.detalle_producto;
        document.getElementById('precio').textContent = JSON.dataset.precio_producto;
        document.getElementById('id_producto').value = JSON.dataset.id_producto;
    }else{
        // Se presenta un mensaje de error cuando no existen datos para mostrar.
        document.getElementById('title').textContent = JSON.exception;
        // Se limpia el contenido cuando no hay datos para mostrar.
        document.getElementById('detalle').innerHTML = ''; 
    }
});