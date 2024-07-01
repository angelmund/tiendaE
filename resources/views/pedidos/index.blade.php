<x-app-layout>
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 text-center">Pedidos</h1>

    {{-- <button type="button" id="editButton" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
      data-bs-toggle="modal" data-bs-target="#productos" data-remote="{{route('productos.create')}}"><i
        class="fas fa-plus"></i> Agregar Producto</button> --}}
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">
        <table id="tabla" class="table table-hover table-bordered table-dark">
          <thead class="">
            <tr>
              <th>Número de pedido</th>
              <th>Cantidad</th>
              <th>Precio</th>
              <th>Producto</th>
              <th>Imagen</th>
              <th>Categoria</th>
              <th>Total</th>
              <th>Estado del pedido</th>
              <th>Cliente</th>
              <th>Correo</th>
              <th>Tel&eacute;fono</th>
              <th>Direci&oacute;n</th>
              <th>Editar estado</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($pedidos as $pedido)
            <tr>
              <td>{{$pedido->pedido->idPedido}}</td>
              <td>{{$pedido->cantidad}}</td>
              <td>${{ number_format($pedido->precio, 0, '.', ',') }}</td>
              <td>{{$pedido->producto->nombre}}</td>
              <td>
                @if($pedido->producto->foto)

                <img src="{{ asset('/' . $pedido->producto->foto) }}" width="90" height="90">
                @else
                Sin imagen
                @endif

              </td>
              <td>
                {{$pedido->producto->categoria->categoria}}
              </td>
              <td>${{ number_format($pedido->pedido->total, 0, '.', ',') }}</td>
              <td> {{$pedido->estado->nombre}}</td>
              <td>{{$pedido->pedido->cliente->nombre_completo}}</td>
              <td>{{$pedido->pedido->cliente->correo}}</td>
              <td>{{$pedido->pedido->cliente->telefono}}</td>
              <td>{{$pedido->pedido->cliente->direccion}}</td>
              <td>
                <button type="button" class="btn btn-success btn-xs dt-add" data-bs-toggle="modal"
  data-bs-target="#editEstado{{$pedido->pedido->idPedido}}" data-id="{{$pedido->pedido->idPedido}}"
  id="btn_edit_{{$pedido->pedido->idPedido}}"
  data-remote="{{route('pedidos.edit', ['id' => $pedido->pedido->idPedido])}}">
  <i class='fas fa-pen'></i>
</button>
              </td>

            </tr>
            @include('estadoPedido.edit')
            @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>


  {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
  <script src="{{asset('assets/js/producto.js')}}"></script>
  <script>
    $(document).ready(function() {
            //$('#tabla').DataTable();
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
        });
  </script>
</x-app-layout>