

var dt; // Variable global para almacenar la instancia de DataTables



function cargarDatos() {
    dt = $('#tabla').DataTable({
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

}

cargarDatos();



