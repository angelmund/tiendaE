
//seccion-menu
if ($('.seccion-menu').length > 0) {
    //btn por año
    document.addEventListener('DOMContentLoaded', function () {
        const anioElement = document.getElementById('anio');
        //Obtenemos el año actual
        const currentYear = new Date().getFullYear();
        //Asignamos el año en el texto
        anioElement.textContent = currentYear;
        fetchData(parseInt(currentYear));
        //Botones para decrementar
        document.getElementById('decrementarAnio').addEventListener('click', function () {
            let anio = parseInt(anioElement.textContent, 10);
            anioElement.textContent = --anio;

            //mandamos el año y actualiza las graficas
            fetchData(anio);
        });
        //Botones para incrementar 
        document.getElementById('incrementarAnio').addEventListener('click', function () {
            let anio = parseInt(anioElement.textContent, 10);
            anioElement.textContent = ++anio;

            //mandamos el año y actualiza las graficas
            fetchData(anio);
        });
    });

    //pasar num a meses
    function convertirNumeroAMes(numero) {
        const meses = {
            1: 'Enero',
            2: 'Febrero',
            3: 'Marzo',
            4: 'Abril',
            5: 'Mayo',
            6: 'Junio',
            7: 'Julio',
            8: 'Agosto',
            9: 'Septiembre',
            10: 'Octubre',
            11: 'Noviembre',
            12: 'Diciembre'
        };

        return meses[numero];
    }
    // Colores para los gráficos
    const colors = {
        background: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
        ],
        border: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
        ]
    };

    function obtenerDatos(datos) {
        
        return {
            titulos: datos.map(item => convertirNumeroAMes(item.mes)),
            tImporte: datos.map(item => item.tImporte),
            ganancias: datos.map(item => item.ganancia),
            nPagos: datos.map(item => item.nPagos),
            totalPagos: datos.map(item => item.totalPagos),
        };
    }

    function createConfig(type, labels, datasets) {
        return {
            type: type,
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Mes'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Cantidad'
                        }
                    }
                }
            }
        };
    }


    // Función para actualizar el gráfico
    function updateChart(type, labels, newDatasets) {
        const chart = charts[type];
        chart.data.labels = labels;
        chart.data.datasets = newDatasets.map((dataset, index) => createDataset(dataset.label, dataset.data, index));
        chart.update();
    }

    const createDataset = (label, data, backgroundColor, borderColor) => ({
        label: label,
        data: data,
        backgroundColor: backgroundColor,
        borderColor: borderColor,
        borderWidth: 1
    });




    let charts = {};



    async function fetchData(anio) {
        const botonDecrementar = document.getElementById('decrementarAnio');
        const botonIncrementar = document.getElementById('incrementarAnio');

        try {
            // Desactivar botones
            botonDecrementar.disabled = true;
            botonIncrementar.disabled = true;

            const url = "/pagos/ganacia/" + anio;
            const urlPagos = "/pagos/mes/" + anio; // URL para obtener datos de pagos
            const response = await fetch(url);
            const responsePagos = await fetch(urlPagos);

            if (!response.ok || !responsePagos.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            const dataPagos = await responsePagos.json();

            const datos = obtenerDatos(data);
            const datosPagos = obtenerDatos(dataPagos);

            const datasetsInscripciones = [
                createDataset('Número de inscripciones', datos.tImporte, '#4CAF50', 'rgba(54, 162, 235, 1)'),
                createDataset('Suma de importe', datos.ganancias, '#FFEB3B', 'rgba(255, 152, 0, 1)')
            ];

            const datasetsPagos = [
                createDataset('Numero Pagos', datosPagos.nPagos, '#4CAF50', 'rgba(75, 192, 192, 1)'),
                createDataset('Ganancias', datosPagos.totalPagos, '#FFEB3B', 'rgba(255, 152, 0, 1)')
            ];

            const configInscripciones = createConfig('line', datos.titulos, datasetsInscripciones);
            const configPagos = createConfig('line', datosPagos.titulos, datasetsPagos);

            // Verificar si los gráficos ya existen y destruirlos si es necesario
            if (charts.inscripcionNumero) {
                charts.inscripcionNumero.destroy();
            }
            if (charts.pagosNumero) {
                charts.pagosNumero.destroy();
            }

            // Crear y agregar gráficos al objeto charts
            const ctx1 = document.getElementById('inscripcionNumero').getContext('2d');
            const ctx2 = document.getElementById('pagosNumero').getContext('2d');

            charts.inscripcionNumero = new Chart(ctx1, configInscripciones);
            charts.pagosNumero = new Chart(ctx2, configPagos);

        } catch (error) {
            console.error('Error fetching data:', error);
        } finally {
            // Reactivar botones
            botonDecrementar.disabled = false;
            botonIncrementar.disabled = false;
        }
    }







}
