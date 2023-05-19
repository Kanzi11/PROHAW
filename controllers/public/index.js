// Constante para completar la ruta de la API.
const CATEGORIA_API = 'business/public/categoria.php';

const CATEGORIAS = document.getElementById('categoria');
// Constante tipo objeto para establecer las opciones del componente Slider.

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener las categorías disponibles.
    const JSON = await dataFetch(CATEGORIA_API, 'readAll');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializa el contenedor de categorías.
        CATEGORIAS.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se establece la página web de destino con los parámetros.
            url = `Fproduct.html?id=${row.id_categoria}&nombre=${row.nombre_categoria}`;
            // Se se crean las cosas en el index
            CATEGORIAS.innerHTML += `
                <li>
                   <a  href="${url}" class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                <div class="font-semibold">${row.nombre_categoria}</div>
                  </a>
                </li>
            `;
        });
    } else {
        // Se asigna al título del contenido de la excepción cuando no existen datos para mostrar.
        document.getElementById('title').textContent = JSON.exception;
    }
});