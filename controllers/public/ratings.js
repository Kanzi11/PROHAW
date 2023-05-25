// Constantes para completar las rutas de la API.
const RATINGS_API = 'business/public/ratings.php';
// Constantes para establecer el contenido de la tabla.
const TBODY_ROWS = document.getElementById('ratings');
// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    fillTable();
});
/*
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/
async function fillTable(form = null) {
    TBODY_ROWS.innerHTML = '';
    (form) ? action = 'readAll' : action = 'readAll';
    const JSON = await dataFetch(RATINGS_API, action, form);
    if (JSON.status) {
        JSON.dataset.forEach(row => {
            TBODY_ROWS.innerHTML += `
            <article class="p-6 mb-6 text-base bg-white rounded-lg dark:bg-gray-900">
                <footer class="flex justify-between items-center mb-2">
                    <div class="flex items-center">
                        <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">${row.usuario}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">${row.fecha_comentario}
                        </p>
                    </div>
                </footer>
                <p class="text-gray-500 dark:text-gray-400"> ${row.comentario_prodcuto}</p>
                <div class="flex items-center mt-4 space-x-4">
                    <button type="button"
                        class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400">
                        <svg aria-hidden="true" class="mr-1 w-4 h-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        Reply
                    </button>
                </div>
            </article>
        `;
        })
    } else {
        sweetAlert(4, JSON.exception, true)
    }
}
/*
*   Función para abrir el reporte de RATINGS de una categoría.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
// function openReport(id) {
//     // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
//     const PATH = new URL(`${SERVER_URL}reports/dashboard/RATINGS_categoria.php`);
//     // Se agrega un parámetro a la ruta con el valor del registro seleccionado.
//     PATH.searchParams.append('id_categoria', id);
//     // Se abre el reporte en una nueva pestaña del navegador web.
//     window.open(PATH.href);
// }