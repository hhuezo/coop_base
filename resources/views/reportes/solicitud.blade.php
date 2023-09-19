<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>solicitud</title>
    <style type="text/css">
        <!--
        .Estilo1 {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 10px;
        }

        .Estilo2 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
        }

        .Estilo3 {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 10px;
        }

        .Estilo5 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
        }

        .Estilo6 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10;
        }

        .Estilo7 {
            font-size: 10
        }
        -->
    </style>
</head>

<body>
    <table width="98%" border="0" cellspacing="1" cellpadding="1" align="center">
        <tr>
            <td colspan="5" class="Estilo1"><strong>CREDITO APROBADO Nº {{ $solicitud->NumeroCredito }}</strong></td>
        </tr>
        <tr>
            <td colspan="2">
                <div align="center"><img src="{{ public_path() }}/img/logo.png" width="97" height="74"></div>
            </td>
            <td colspan="3">
                <div align="center" class="Estilo1"><u>ASOCIACIÓN COOPERATIVA DE EMPLEADOS SINDICALIZADOS DEL ISTA, DE
                        RL</u></div>
            </td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
            <td colspan="2" rowspan="12">
                <table width="95%" border="1" cellspacing="1" cellpadding="1" align="center">
                    <tr>
                        <td colspan="4">
                            <div align="center" class="Estilo3">TABLA DE AMORTIZACION </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="21%">
                            <div align="center" class="Estilo3">PAGO</div>
                        </td>
                        <td width="27%">
                            <div align="center" class="Estilo3">INTERES</div>
                        </td>
                        <td width="29%">
                            <div align="center" class="Estilo3">PAGO CAPITAL</div>
                        </td>
                        <td width="23%">
                            <div align="center" class="Estilo3">SALDO</div>
                        </td>
                    </tr>

                    @foreach ($tabla_amortizacion as $obj)
                        <tr>
                            <td width="21%">
                                <div align="center" class="Estilo3">{{ $obj['Pago'] }}</div>
                            </td>
                            <td width="27%">
                                <div align="right" class="Estilo3">${{ $obj['interes'] }}</div>
                            </td>
                            <td width="29%">
                                <div align="right" class="Estilo3">${{ $obj['capital'] }}</div>
                            </td>
                            <td width="23%">
                                <div align="right" class="Estilo3">${{ $obj['saldo'] }}</div>
                            </td>
                        </tr>
                    @endforeach



                </table>
                <p>&nbsp;</p>
                <table width="100%" border="0">
                    <tr>
                        <td>
                            <div align="center" class="Estilo6">____________________</div>
                        </td>
                        <td>
                            <div align="center" class="Estilo6">____________________</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div align="center" class="Estilo6">PRESIDENTE/A 0 VICEPRESIDENTE/A </div>
                        </td>
                        <td>
                            <div align="center" class="Estilo6">COMISIÓN CREDITO </div>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="Estilo7"></span></td>
                        <td><span class="Estilo7"></span></td>
                    </tr>
                    <tr>
                        <td height="59" colspan="2" valign="bottom">
                            <div align="center" class="Estilo6">____________________</div>
                        </td>
                    </tr>
                    <tr>
                        <td height="23" colspan="2">
                            <div align="center" class="Estilo6">TESORERO/A </div>
                        </td>
                    </tr>
                </table>
                <p>&nbsp;</p>
            </td>
        </tr>

        <tr>
            <td colspan="3"><span class="Estilo2">SAN SALVADOR, {{ date('d', strtotime($solicitud->Fecha)) }} DE
                    {{ $mes }} DE {{ date('Y', strtotime($solicitud->Fecha)) }}</span></td>
        </tr>
        <tr>
            <td colspan="3"><span class="Estilo2">NOMBRE: {{ $solicitud->persona->Nombre }} </span></td>
        </tr>
        <tr>
            <td colspan="3"><span class="Estilo2">DUI: {{ $solicitud->persona->Dui }}</span></td>
        </tr>

        <tr>
            <td colspan="3"><span class="Estilo2">TIPO DE CREDITO: {{ $solicitud->tipo->Nombre }}</span></td>
        </tr>
        <tr>
            <td colspan="3"><span class="Estilo2">TASA DE INTERES MENSUAL:{{ $solicitud->Tasa }}%</span></td>
        </tr>
        <tr>
            <td colspan="3"><span class="Estilo2">MONTO OTORGADO: ${{ $solicitud->Monto }}</span></td>
        </tr>
        <tr>
            <td colspan="3"><span class="Estilo5">PAGO MENSUAL :
                    ${{ number_format($cuotaMensual, 2, '.', '') }}</span></td>
        </tr>
        <tr>
            <td colspan="3"><span class="Estilo2">MESES DE PLAZO: {{ $solicitud->Meses }}</span></td>
        </tr>
        <tr>
            <td colspan="3"><span class="Estilo2">FIADOR SOLIDARIO: {{ $solicitud->fiador->Nombre }}</span></td>
        </tr>
        <tr>
            <td colspan="3"><span class="Estilo2">DUI: {{ $solicitud->fiador->Dui }}</span></td>
        </tr>
        <tr>
            <td colspan="3"><span class="Estilo2">FIRMA:</span><span class="Estilo2"></span><span
                    class="Estilo2"></span></td>
        </tr>


        <tr>
            <td width="11%">&nbsp;</td>
            <td colspan="2">_____________________________________</td>
            <td width="15%">&nbsp;</td>
            <td width="30%">&nbsp;</td>
        </tr>







    </table>
</body>

</html>
