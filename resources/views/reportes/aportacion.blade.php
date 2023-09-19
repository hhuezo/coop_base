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
            <td colspan="7"><span class="Estilo2"><strong> Nº
                    </strong><strong>{{ $aportacion->Numero }}</strong></span></td>
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

        <td height="31">&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td colspan="2"><span class="Estilo6">
                RECIBI DE <strong>{{ $aportacion->socio->Nombre }}</strong> LA SUMA DE
                $<strong>{{ $aportacion->Cantidad }}</strong>.
                EN CONCEPTO DE APORTACIÓN CORRESPONDIENTE AL MES DE <strong> {{ $mes }} DE
                    {{ date('Y', strtotime($aportacion->Fecha)) }}
                </strong>
            </span></td>
        </tr>

        <tr>

            <td height="31" colspan="6"><span class="Estilo8">SAN SALVADOR,
                    {{ date('d/m/Y', strtotime($aportacion->Fecha)) }}</span></td>

        </tr>





    </table>
</body>

</html>
