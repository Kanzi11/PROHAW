//constante para  completar la tuta de la api 
const PRODUCTO_API = 'business/public/producto.php';
// Contante tipo de objeto para obtener los parametros disponibles  en la URL 
const PARAMS = new URLSearchParams(location.search);
//Constante para establecer el contenido principal  de la pagina web
const TITULO = document.getElementById('title');
const PRODUCTOS = document.getElementById('productos');


//Metodo para menejador de  eventos  para cuando el documento  ha cargado 
document.addEventListener('DOMContentLoaded', async () => {
    //Se define un objeto  con los datos de la categoria  seleccionada 
    const FORM = new FormData();
    FORM.append('id_categoria', PARAMS.get('id_categoria'));
    //peticion para  solicitar los productos a la categoria seleccionada 
    const JSON = await dataFetch(PRODUCTO_API, 'readProductosCategoria', FORM);
    console.log(PARAMS.get('id_categoria'));
    //Se comprueba si la  respuesta es  correcta , de lo contrario se muestra el mensaje de error
    if (JSON.status) {
        // Se inicializa el contenedor de productos.
        PRODUCTOS.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las tarjetas con los datos de cada producto.
            PRODUCTOS.innerHTML += `
            <div tabindex="0" class="focus:outline-none mx-2 w-72 xl:mb-0 mb-8">
                <div>
            <img src="${SERVER_URL}img/productos/${row.imagen_producto}"
                tabindex="0" class="focus:outline-none w-full h-44" />
                </div>
                <div class="bg-white dark:bg-gray-800">
                // nombre del producto
                    <div class="p-4">
                        <div class="flex items-center">
                            <h2 tabindex="0" class="focus:outline-none text-lg dark:text-white font-semibold">
                            ${row.nombre_producto}
                            </h2>
                        </div>
                        
                        //  detalle del prducto
                        <p tabindex="0"
                            class="focus:outline-none text-xs text-gray-600 dark:text-gray-200 mt-2">${row.detalle_producto} </p>
                        <div class="flex mt-4">
                        </div>
                        // precio del producto 

                        <div class="flex items-center justify-between py-4">
                            <h3 tabindex="0" class="focus:outline-none text-indigo-700 text-xl font-semibold">
                            Precio(US$) ${row.precio_producto}</h3>

                            <a href="Vproducts.html?id=${row.id_producto}"class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-purple-400 dark:text-purple-400 dark:hover:text-white dark:hover:bg-purple-500 dark:focus:ring-purple-900">
                                <i class="fa-light fa-square-arrow-up-right"></i>    
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;
        });
        // Se asigna como título la categoría de los productos.
        TITULO.textContent = PARAMS.get('nombre');
    } else {
        // Se presenta un mensaje de error cuando no existen datos para mostrar.
        TITULO.textContent = JSON.exception;
    }
});