
$(document).ready(function () {
    $('.crud-table').addClass('table table-striped table-bordered table-hover');


    $('#tabla_clientes').DataTable({
        language: {
            zeroRecords: 'No hay coincidencias',
            info: 'Mostrando _END_ resultados de _MAX_',
            infoEmpty: 'No hay datos disponibles',
            infoFiltered: '(Filtrado de _MAX_ registros totales)',
            search: 'Buscar',
            emptyTable: "No existen registros",
            paginate: {
                first: "Primero",
                previous: "Anterior",
                next: "Siguiente",
                last: "Anterior"
            },
        },
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5', text: '<i class="fa-lg text-success fa-solid fa-file-excel"></i>',
                exportOptions: {
                    columns: ':not(.exclude)'
                }
            },
            {
                extend: 'print', text: '<i class="fa-lg text-danger fa-solid fa-print"></i>',
                exportOptions: {
                    columns: ':not(.exclude)'
                }
            },
            {
                text: '<i class="fa-lg text-success fas fa-plus-circle"></i>',
                action: function () {
                    $('#registrar').modal('show');
                }
            },
        ],
        lengthMenu: [10, 25, 50, 100]
    });


    $('#tabla_servicios').DataTable({
        language: {
            zeroRecords: 'No hay coincidencias',
            info: 'Mostrando _END_ resultados de _MAX_',
            infoEmpty: 'No hay datos disponibles',
            infoFiltered: '(Filtrado de _MAX_ registros totales)',
            search: 'Buscar',
            emptyTable: "No existen registros",
            paginate: {
                first: "Primero",
                previous: "Anterior",
                next: "Siguiente",
                last: "Anterior"
            },
        },
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5', text: '<i class="fa-lg text-success fa-solid fa-file-excel"></i>',
                exportOptions: {
                    columns: ':not(.exclude)'
                }
            },
            {
                extend: 'print', text: '<i class="fa-lg text-danger fa-solid fa-print"></i>',
                exportOptions: {
                    columns: ':not(.exclude)'
                }
            },
            {
                text: '<i class="fa-lg text-success fas fa-plus-circle"></i>',
                action: function () {
                    $('#registrar_servicio').modal('show');

                }
            },
            {
                text: '<i class=" text-dark fa-lg fas fa-arrow-left"></i>',
                action: function () {
                    window.location.href = "clientes.php";
                }
            },
        ],
        lengthMenu: [10, 25, 50, 100]
    });


    $('#tabla_planilla').DataTable({
        order: [[0, 'desc']],
        language: {
            zeroRecords: 'No hay coincidencias',
            info: 'Mostrando _END_ resultados de _MAX_',
            infoEmpty: 'No hay datos disponibles',
            infoFiltered: '(Filtrado de _MAX_ registros totales)',
            search: 'Buscar',
            emptyTable: "No existen registros",
            paginate: {
                first: "Primero",
                previous: "Anterior",
                next: "Siguiente",
                last: "Anterior"
            },
        },
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5', text: '<i class="fa-lg text-success fa-solid fa-file-excel"></i>',
                exportOptions: {
                    columns: ':not(.exclude)'
                }
            },
            {
                extend: 'print', text: '<i class="fa-lg text-danger fa-solid fa-print"></i>',
                exportOptions: {
                    columns: ':not(.exclude)'
                }
            },
            {
                text: '<i class="fa-lg text-success fas fa-plus-circle"></i>',
                action: function () {
                    $('#registrarP').modal('show');
                }
            },
        ],
        lengthMenu: [10, 25, 50, 100]
    });


    $('#tabla_generarP').DataTable({
        language: {
            zeroRecords: 'No hay coincidencias',
            info: 'Mostrando _END_ resultados de _MAX_',
            infoEmpty: 'No hay datos disponibles',
            infoFiltered: '(Filtrado de _MAX_ registros totales)',
            search: 'Buscar',
            emptyTable: "No existen registros",
            paginate: {
                first: "Primero",
                previous: "Anterior",
                next: "Siguiente",
                last: "Anterior"
            },
        },
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5',
                text: '<i class="fa-lg text-success fa-solid fa-file-excel"></i>',
                exportOptions: {
                    columns: ':not(.exclude)'
                }
            },
            {
                extend: 'print',
                text: '<i class="fa-lg text-danger fa-solid fa-print"></i>',
                exportOptions: {
                    columns: ':not(.exclude)'
                },
            },
        ],
        lengthMenu: [10, 25, 50, 100]
    });


    $('#tabla_pendientes').DataTable({
        language: {
            zeroRecords: 'No hay coincidencias',
            info: 'Mostrando _END_ resultados de _MAX_',
            infoEmpty: 'No hay datos disponibles',
            infoFiltered: '(Filtrado de _MAX_ registros totales)',
            search: 'Buscar',
            emptyTable: "No existen registros",
            paginate: {
                first: "Primero",
                previous: "Anterior",
                next: "Siguiente",
                last: "Anterior"
            },
        },
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5', text: '<i class="fa-lg text-success fa-solid fa-file-excel"></i>',
                exportOptions: {
                    columns: ':not(.exclude)'
                }
            },
            {
                extend: 'print', text: '<i class="fa-lg text-danger fa-solid fa-print"></i>',
                exportOptions: {
                    columns: ':not(.exclude)'
                }
            },
        ],
        lengthMenu: [10, 25, 50, 100]
    });


    $('#tabla_logs').DataTable({
        language: {
            zeroRecords: 'No hay coincidencias',
            info: 'Mostrando _END_ resultados de _MAX_',
            infoEmpty: 'No hay datos disponibles',
            infoFiltered: '(Filtrado de _MAX_ registros totales)',
            search: 'Buscar',
            emptyTable: "No existen registros",
            paginate: {
                first: "Primero",
                previous: "Anterior",
                next: "Siguiente",
                last: "Anterior"
            },
        },
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5', text: '<i class="fa-lg text-success fa-solid fa-file-excel"></i>',
                exportOptions: {
                    columns: ':not(.exclude)'
                }
            },
            {
                extend: 'print', text: '<i class="fa-lg text-danger fa-solid fa-print"></i>',
                exportOptions: {
                    columns: ':not(.exclude)'
                }
            },
            {
                text: '<i class="fa-lg text-danger fas fa-trash"></i>',
                action: function () {
                    $('#eliminar_logs').modal('show');
                }
            }
        ],
        lengthMenu: [10, 25, 50, 100]
    });


    $('#tabla_administradores').DataTable({
        language: {
            zeroRecords: 'No hay coincidencias',
            info: 'Mostrando _END_ resultados de _MAX_',
            infoEmpty: 'No hay datos disponibles',
            infoFiltered: '(Filtrado de _MAX_ registros totales)',
            search: 'Buscar',
            emptyTable: "No existen registros",
            paginate: {
                first: "Primero",
                previous: "Anterior",
                next: "Siguiente",
                last: "Anterior"
            },
        },
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            {
                text: '<i class="fa-lg text-success fas fa-plus-circle"></i>',
                action: function () {
                    $('#registrar_administradores').modal('show');
                }
            },
        ],
        lengthMenu: [10, 25, 50, 100]
    });

    let tabla_financiamiento = $('#tabla_conexion_financiamiento').DataTable({
        language: {
            zeroRecords: 'No hay coincidencias',
            info: 'Mostrando _END_ resultados de _MAX_',
            infoEmpty: 'No hay datos disponibles',
            infoFiltered: '(Filtrado de _MAX_ registros totales)',
            search: 'Buscar',
            emptyTable: "No existen registros",
            paginate: {
                first: "Primero",
                previous: "Anterior",
                next: "Siguiente",
                last: "Anterior"
            },
        },
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5', text: '<i class="fa-lg text-success fa-solid fa-file-excel"></i>',
                exportOptions: {
                    columns: ':not(.exclude)'
                }
            },
            {
                extend: 'print', text: '<i class="fa-lg text-danger fa-solid fa-print"></i>',
                exportOptions: {
                    columns: ':not(.exclude)'
                },
                action: function(e, dt, node, config) {
                    all_cuotas = set_cuotas_in_table(); // Llamo a la funcion para obtener los inputs
                    // Recorro cada grupo de inputs
                    all_cuotas.forEach(cuotas_n => {
                        // Recorro cada elemento del grupo
                        for (let index = 0; index < cuotas_n.length; index++) {
                            // Obtengo el attr de posicion del elemento y lo convierto en array[int, int]
                            element_pos = cuotas_n[index].getAttribute('data-pos').split(',').map(function (item){
                                return parseInt(item, 10);
                            });
                            // Busco el elemento de la table segun pos y cambio su valor
                            tabla_financiamiento.rows(element_pos[0]).data()[0][element_pos[1]+8] = '$ ' + cuotas_n[index].value;
                        }
                    });
                    // Continuo con la impresion
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, node, config);
                }
            }
        ],
        lengthMenu: [10, 25, 50, 100]
    });


    $('#tabla_conexion').DataTable({
        language: {
            zeroRecords: 'No hay coincidencias',
            info: 'Mostrando _END_ resultados de _MAX_',
            infoEmpty: 'No hay datos disponibles',
            infoFiltered: '(Filtrado de _MAX_ registros totales)',
            search: 'Buscar',
            emptyTable: "No existen registros",
            paginate: {
                first: "Primero",
                previous: "Anterior",
                next: "Siguiente",
                last: "Anterior"
            },
        },
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5', text: '<i class="fa-lg text-success fa-solid fa-file-excel"></i>',
                exportOptions: {
                    columns: ':not(.exclude)'
                }
            },
            {
                extend: 'print', text: '<i class="fa-lg text-danger fa-solid fa-print"></i>',
                exportOptions: {
                    columns: ':not(.exclude)'
                }
            }
        ],
        lengthMenu: [10, 25, 50, 100]
    });
});
