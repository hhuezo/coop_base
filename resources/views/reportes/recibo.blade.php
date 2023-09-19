<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <style type="text/css">
        <!--
        .Estilo1 {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 10;
        }

        .Estilo2 {
            font-family: Arial, Helvetica, sans-serif
        }

        .Estilo6 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10;
        }

        .Estilo7 {
            font-size: 10
        }

        .Estilo8 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }
        -->
    </style>
</head>

<body>
    <table width="98%" border="0">
        <tr>
            <td colspan="7"><span class="Estilo2"><strong>RECIBO Nº
                    </strong><strong>{{ $recibo->Numero }}</strong></span></td>
        </tr>
        <tr>
            <td colspan="2">
                <div align="center"><img src="{{ public_path() }}/img/logo.png" width="102" height="87"></div>
            </td>
            <td colspan="5">
                <div align="center" class="Estilo1"><u>ASOCIACIÓN COOPERATIVA DE EMPLEADOS SINDICALIZADOS DEL ISTA, DE
                        RL</u></div>
            </td>
        </tr>
        <tr>
            <td height="31">&nbsp;</td>
            <td colspan="4">&nbsp;</td>
            <td colspan="2"><span class="Estilo6">$<strong>{{ $recibo->Pago }}</strong></span></td>
        </tr>

        <tr>
            <td width="4%">&nbsp;</td>
            <td colspan="4">&nbsp;</td>
            <td width="12%">&nbsp;</td>
            <td width="9%">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="4"><span class="Estilo6">RECIBI DE
                    <strong>{{ $recibo->solicitud->persona->Nombre }}</strong></span></td>
            <td colspan="2">&nbsp;</td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td colspan="4"><span class="Estilo6">LA SUMA DE <strong>{{ $cantidad }} DOLARES
                        {{ substr($decimal, 2, 2) }}/100 CENTAVOS</strong></span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td colspan="4"><span class="Estilo6">EN CONCEPTO DE
                    <strong>{{ $recibo->solicitud->tipo->Nombre }}</strong></span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td><span class="Estilo7"></span></td>
            <td width="25%"><span class="Estilo7"></span></td>
            <td width="31%"><span class="Estilo7"></span></td>
            <td width="6%"><span class="Estilo7"></span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td><span class="Estilo7"></span></td>
            <td>
                <div align="right" class="Estilo6">CAPITAL </div>
            </td>
            <td><span class="Estilo6"><strong> $ {{ $recibo->Capital + $recibo->Total }}</strong></span></td>
            <td colspan="3"><span class="Estilo7"><span class="Estilo6">&nbsp;</strong></span></span></td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td><span class="Estilo7"></span></td>
            <td>
                <div align="right" class="Estilo6">ABONO A CAPITAL </div>
            </td>
            <td><span class="Estilo6"><strong>$ {{ $recibo->Capital }}</strong></span></td>
            <td colspan="3"><span class="Estilo7"><span class="Estilo6">SALDO PENDIENTE
                        <strong>${{ $recibo->Total }}</strong></span></span></td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td><span class="Estilo7"></span></td>
            <td>
                <div align="right" class="Estilo6">INTERESES</div>
            </td>
            <td><span class="Estilo6"><strong>$ {{ $recibo->Interes }}</strong></span></td>
            <td><span class="Estilo7"></span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td><span class="Estilo7"></span></td>
            <td>
                <div align="right" class="Estilo6">TOTAL</div>
            </td>
            <td><span class="Estilo6"><strong>$ {{ number_format($recibo->Interes + $recibo->Capital, 2, '.', '') }}
                    </strong></span></td>
            <td colspan="3">&nbsp;</td>
        </tr>

        <tr>
            <td height="45">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3"><span class="Estilo8">SAN SALVADOR, {{ date('d', strtotime($recibo->Fecha)) }} DE
                    {{ $mes }} DE {{ date('Y', strtotime($recibo->Fecha)) }}</span></td>
            <td colspan="3" class="Estilo6">&nbsp;</td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3" class="Estilo6">
                <div align="center">________________________</div>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td width="13%">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3" class="Estilo6">
                <div align="center">
                    <p align="center">TESORERO/A Ó AUXILIAR </p>
                </div>
            </td>
        </tr>

    </table>

</body>

</html>
