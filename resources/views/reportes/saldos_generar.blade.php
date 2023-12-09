<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Solicitudes Table</title>
</head>

<body>

    <div class="container mt-5">
        <h2>Saldos a {{ date('d/m/Y', strtotime($fecha)) }}</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Solicitud</th>
                    <th>Fecha</th>
                    <th>Nombre</th>
                    <th>Monto</th>
                    <th>Fecha ultimo Recibo</th>
                    <th>Capital</th>
                    <th>Saldo pendiente</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalMonto = 0;
                    $totalSaldo = 0;
                @endphp
                @foreach ($solicitudes as $solicitud)
                    <tr>
                        <td>{{ $solicitud->Numero }}</td>
                        <td>{{ $solicitud->Fecha }}</td>
                        <td>{{ $solicitud->Nombre }}</td>
                        <td>${{ $solicitud->Monto }}</td>
                        <td>{{ $solicitud->fecha_recibo }}</td>
                        @if ($solicitud->saldo)
                            <td>${{ $solicitud->saldo }}</td>
                            @php
                                $totalSaldo += $solicitud->saldo;
                            @endphp
                        @else
                            <td>${{ $solicitud->Monto }}</td>
                            @php
                                $totalSaldo += $solicitud->Monto;
                            @endphp
                        @endif
                        <td>${{ $solicitud->saldo($solicitud->Id, $fecha) }}</td>
                    </tr>
                    @php
                        $totalMonto += $solicitud->Monto;
                    @endphp
                @endforeach

                <tr>
                    <td colspan="3">Total</td>
                    <td>${{ number_format($totalMonto, 2, '.', ',') }}</td>
                    <td colspan="2"></td>
                    <td>${{ number_format($totalSaldo, 2, '.', ',') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
