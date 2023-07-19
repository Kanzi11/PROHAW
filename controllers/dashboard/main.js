// Constante para completar la ruta de la API.
const PRODUCTO_API = 'business/dashboard/productos.php';

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Se define una constante tipo objeto con la fecha y hora actual.
    const TODAY = new Date();
    // Se define una variable con el número de horas transcurridas en el día.
    let hour = TODAY.getHours();
    // Se define una variable para guardar un saludo.
    let greeting = '';
    // Dependiendo del número de horas transcurridas en el día, se asigna un saludo para el usuario.
    if (hour < 12) {
        greeting = 'Buenos días';
    } else if (hour < 19) {
        greeting = 'Buenas tardes';
    } else if (hour <= 23) {
        greeting = 'Buenas noches';
    }
    // Se muestra un saludo en la página web.
    document.getElementById('greeting').textContent = greeting;
    // Se llaman a la funciones que generan los gráficos en la página web.
    graficoBarrasCategorias();
    graficoPastelCategorias();
    graficoLinealProductos();
});

/*
*   Función asíncrona para mostrar en un gráfico de barras la cantidad de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function graficoBarrasCategorias() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTO_API, 'cantidadProductosCategoria');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let categorias = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            categorias.push(row.nombre_categoria);
            cantidades.push(row.cantidad);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        barLineGraph('chart1', categorias, cantidades, 'Cantidad de productos', 'Cantidad de productos por categoría', 'bar');
    } else {
        document.getElementById('chart1').remove();
        console.log(DATA.exception);
    }
}

/*
*   Función asíncrona para mostrar en un gráfico de pastel el porcentaje de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function graficoPastelCategorias() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTO_API, 'porcentajeProductosCategoria');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        let categorias = [];
        let porcentajes = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            categorias.push(row.nombre_categoria);
            porcentajes.push(row.porcentaje);
        });
        // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
        pieGraph('chart2', categorias, porcentajes, 'Porcentaje de productos por categoría');
    } else {
        document.getElementById('chart2').remove();
        console.log(DATA.exception);
    }
}

/*
*   Función asíncrona para mostrar en un gráfico de linea los productos 5 productos mas comprados
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function graficoLinealProductos() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTO_API, 'lineaProductosMasComprados');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        let productos = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            productos.push(row.nombre_producto);
            cantidades.push(row.total_vendidos);
        });
        // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js productos eje x cantidades eje y unidades vendidas lo que va aparecer cuando seleccionen los puntos y el titulo del grafico lineal.
        barLineGraph('chart3', productos, cantidades, 'Unidades venidas', 'Top 5 productos mas vendidos', 'line');
    } else {
        document.getElementById('chart2').remove();
        console.log(DATA.exception);
    }
}