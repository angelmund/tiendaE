import { alertaInfo, confirmarInfo } from './alertas';

var dt; // Variable global para almacenar la instancia de DataTables

if ($('#example').length > 0) {
    $(".fechaDivs").hide();
    $(".folioDivs").hide();
    $('.filtrar').hide();

    function cargarDatos() {
        dt = $('#example').DataTable({
            language: {
                sProcessing: 'Procesando...',
                sLengthMenu: 'Mostrar _MENU_ ',
                sZeroRecords: 'No se encontraron resultados que coincidan con lo que escribió',
                sEmptyTable: 'Ningún dato disponible en esta tabla',
                sInfo: 'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
                sInfoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
                sInfoFiltered: '(filtrado de un total de _MAX_ registros)',
                sInfoPostFix: '',
                sSearch: 'Buscar:',
                sUrl: '',
                sInfoThousands: ',',
                sLoadingRecords: 'Cargando...',
                oPaginate: {
                    sFirst: 'Primero',
                    sLast: 'Último',
                    sNext: 'Siguiente',
                    sPrevious: 'Anterior'
                },
                oAria: {
                    sSortAscending: ': Activar para ordenar la columna de manera ascendente',
                    sSortDescending: ': Activar para ordenar la columna de manera descendente'
                },
                paginate: {
                    previous: 'Anterior',
                    next: 'Siguiente'
                }
            },
            sProcessing: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
                {
                    extend: 'csv',
                    className: 'btn btn-success',
                    text: '<i class="fas fa-file-excel"></i>',
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-danger',
                    text: '<i class="fas fa-file-pdf"></i>',
                    titleAttr: 'Exportar a PDF'
                },
                {
                    extend: 'print',
                    className: 'btn btn-info',
                    text: '<i class="fas fa-print"></i>',
                    titleAttr: 'Imprimir'
                },
            ],
            order: [[0, 'desc']],
            responsive: true,
            autoWidth: false,

        });

        // // Inicializar el rango de fechas con flatpickr
        // flatpickr("#fechaIncio, #fechaFinal", {
        //     dateFormat: "d/m/Y",
        //     allowInput: true,
        // });

        // Agrega un evento change al select
        $(".status_id").on("change", function () {
            // Obtén el valor seleccionado
            var tipoBusqueda = $(this).val();

            // Oculta todos los divs por defecto
            $(".fechaDivs").hide();
            $(".folioDivs").hide();
            $('.filtrar').hide();

            // Muestra u oculta los divs según la opción seleccionada
            if (tipoBusqueda === "Fecha") {


                $(".fechaDivs").show();
                $('#fechaInicio').val('');
                $('#fechaFinal').val('');
                $('#folioI').val('');
                $('#folioF').val('');
            }
            if (tipoBusqueda === "Folio") {

                $(".folioDivs").show();
                $('.filtrar').show();
                $('#fechaInicio').val('');
                $('#fechaFinal').val('');
                $('#folioI').val('');
                $('#folioF').val('');
            }

        });

        $('#fechaInicio, #fechaFinal').on('change', function () {
            var fechaInicio = $('#fechaInicio').val();
            var fechaFinal = $('#fechaFinal').val();

            if (fechaInicio == '' || fechaFinal == '') {
                alertaInfo("Ingrese fecha de inicio y fin");
            } else {
                filtrarPorRangoDeFechas(fechaInicio, fechaFinal);
            }
        });


        $('#filtrar').on('click', function () {
            var folioInicio = $('#folioI').val();
            var folioFinal = $('#folioF').val();
            if (folioInicio == '' || folioFinal == '') {
                alertaInfo("Ingrese folio de inicio y folio final");
            } else {
                // Aplicar filtro de rango de folios
                filtrarPorRangoDefolio(folioInicio, folioFinal);
            }
        });
        function filtrarPorRangoDeFechas(fechaInicio, fechaFinal) {
            var filteredDates = []; // Almacenar fechas que cumplen con el criterio de búsqueda

            // Convertir fechaInicio y fechaFinal al formato 'Y-m-d'
            // var fechaInicioFormatoCorrecto = moment(fechaInicio, 'DD/MM/YYYY').format('YYYY-MM-DD');
            // var fechaFinalFormatoCorrecto = moment(fechaFinal, 'DD/MM/YYYY').format('YYYY-MM-DD');

            // Iterar sobre cada fila de la columna de fechas
            dt.column(5).data().each(function (value) {
                var date = moment(value, 'DD/MM/YYYY').format('YYYY-MM-DD');
                if (date >= fechaInicio && date <= fechaFinal) {
                    filteredDates.push(value); // Almacenar fecha que cumple con el criterio de búsqueda
                    // console.log(filteredDates);
                }
            });
            if (filteredDates.length > 0) {
                // Aplicar la búsqueda de las fechas filtradas en toda la columna
                dt.column(5).search(filteredDates.join('|'), true, false).draw();
            } else {
                // Si no hay resultados, limpiar la búsqueda para mostrar el mensaje de "No se encontraron resultados"
                dt.column(0).search('^$', true, false).draw();
            }



        }
        function filtrarPorRangoDefolio(folioInicio, folioFinal) {
            var filteredFolios = []; // Almacenar folios que cumplen con el criterio de búsqueda

            // Convertir los folios a números enteros
            var inicio = parseInt(folioInicio);
            var final = parseInt(folioFinal);

            // Verificar si el folio de inicio es menor que el folio final
            if (inicio < final) {
                // Iterar sobre cada fila de la columna de folios
                dt.column(0).data().each(function (value) {
                    var folio = parseInt(value);
                    if (folio >= inicio && folio <= final) {
                        filteredFolios.push(value); // Almacenar folio que cumple con el criterio de búsqueda
                    }
                });
                // Aplicar la búsqueda de los folios filtrados en toda la columna
                if (filteredFolios.length > 0) {
                    dt.column(0).search(filteredFolios.join('|'), true, false).draw();
                } else {
                    // Si no hay resultados, limpiar la búsqueda para mostrar el mensaje de "No se encontraron resultados"
                    dt.column(0).search('^$', true, false).draw();
                }


            } else {
                alertaInfo("El folio de inicio debe ser menor al folio final");
            }
        }

        // Restablecer filtros cuando se cambia el tipo de búsqueda
        $(".status_id").on("change", function () {
            dt.search('').draw(); // Limpiar el filtro
        });



        // Asignar eventos a los botones
        $('#excelButton').on('click', function () {
            confirmarInfo("¿Quiere descargar el archivo Excel?", function () {
                dt.button('.buttons-csv').trigger();
            });
        });


        $('#pdfButton').on('click', function () {
            confirmarInfo("¿Quiere descargar el archivo Pdf?", function () {
                dt.button('.buttons-pdf').trigger();
            });
        });

        $('#printButton').on('click', function () {
            confirmarInfo("¿Desea imprimir el archivo?", function () {
                dt.button('.buttons-print').trigger();
            });
        });
    }

    cargarDatos();
}


