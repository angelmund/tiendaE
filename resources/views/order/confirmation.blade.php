<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido</title>
    <link href="{{asset('assets/css/styles.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/estilos.css')}}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #e0e1dd;
        }
        .confirmation-container {
            max-width: 750px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .confirmation-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .order-details {
            margin-bottom: 20px;
        }
        .order-details h5 {
            color: #343a40;
        }
        .icon-lg{
            font-size: 5rem;
            color: green;
            font-weight: bold;

        }
        .card{
            transform: none !important;
            transition: none !important;
        }
    </style>
</head>
<body>
    <div class="container confirmation-container">
        <div class="subtitulo">
            <h3>¡Gracias por tu pedido!</h3>
        </div>
        <div class="subtitulo">
            <h2 class="text-center"><i class="bi bi-check2-circle icon-lg"></i></h2><br>
            <p>Tu pedido ha sido recibido y está en proceso.</p>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-5 me-1 card">
                <div class="order-details">
                    <h5>Detalles del Pedido</h5>
                    <p><strong>Número de Pedido:</strong> {{ $pedido->idPedido }}</p>
                    <p><strong>Fecha:</strong> {{ $pedido->fecha->format('d/m/Y') }}</p>
                    <p><strong>Total:</strong> ${{ number_format($pedido->total, 2) }}</p>
                </div>
            </div>
            <div class="col-5 card">
                <div class="order-details">
                    <h5>Detalles del Cliente</h5>
                    <p><strong>Nombre:</strong> {{ $pedido->cliente->nombre_completo }}</p>
                    <p><strong>Teléfono:</strong> {{ $pedido->cliente->telefono }}</p>
                    <p><strong>Dirección:</strong> {{ $pedido->cliente->direccion }}</p>
                    <p><strong>E-mail:</strong> {{ $pedido->cliente->correo }}</p>
                </div>
            </div>            
        </div>

        <div class="order-items mt-2">
            <h5>Artículos</h5>
            <table class="table table-striped-columns">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($detallesPedido as $detalle)
                        <tr>
                            <td>{{ $detalle->producto->nombre }}</td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>${{ number_format($detalle->precio, 2) }}</td>
                            <td>${{ number_format($detalle->cantidad * $detalle->precio, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="confirmation-footer text-center">
            <a href="{{ route('tienda') }}" class="btn btn-dark">Volver a la tienda</a>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
