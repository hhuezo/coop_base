<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <style type="text/css">
        <!--
        .Estilo3 {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 12px;
        }

        .Estilo5 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        .Estilo7 {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 16px;
        }
        -->
    </style>
</head>

<body>
    <div align="center"><br>
    </div>
    <table width="70%" border="0" cellspacing="0" align="center">
        <tr>
            <td width="18%" rowspan="2">
                <div align="center"></div> <img src="{{ public_path() }}/img/logo.png" width="169" height="124">
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td width="81%">
                <div align="center">
                    <p class="Estilo7">ASOCIACIÓN COOPERATIVA DE EMPLEADOS SINDICALIZADOS DEL ISTA, DE RL</p>
                    <p class="Estilo7">REPORTE DE INGRESOS Y EGRESOS DEL
                        {{ date('d/m/Y', strtotime($FechaInicio)) }} AL
                        {{ date('d/m/Y', strtotime($FechaFinal)) }}</p>
                </div>
            </td>
            <td width="1%">&nbsp;</td>
        </tr>
    </table>
    <br>
    <table width="98%" border="1" cellspacing="0" align="center">
        <tr>
            <td width="4%">
                <div align="center" class="Estilo3">No</div>
            </td>
            <td width="9%">
                <div align="center" class="Estilo3">Fecha</div>
            </td>
            <td width="54%">
                <div align="center" class="Estilo3">Descripcion</div>
            </td>
            <td width="11%">
                <div align="center" class="Estilo3">Ingreso</div>
            </td>
            <td width="10%">
                <div align="center" class="Estilo3">Egreso</div>
            </td>
            <td width="12%">
                <div align="center" class="Estilo3">Total</div>
            </td>
        </tr>

        @php($i = 2)
        @php($total = $result_inicial->Total)
        @php($total_ingreso = $result_inicial->Total)
        @php($total_egreso = 0)



        <tr>
            <td>
                <div align="center" class="Estilo5">1</div>
            </td>
            <td>
                <div align="center" class="Estilo5">{{ date('d/m/Y', strtotime($result_inicial->Fecha)) }}</div>
            </td>
            <td class="Estilo5">{{ $result_inicial->Descripcion }}</td>
            <td>
                <div align="right" class="Estilo5">
                    @if ($result_inicial->Ingreso != '')
                        {{ "$ " . number_format($result_inicial->Ingreso, 2, '.', '') }}
                    @endif
                </div>
            </td>
            <td>
                <div align="right" class="Estilo5">
                    @if ($result_inicial->Egreso != '')
                        {{ "$ " . number_format($result_inicial->Egreso, 2, '.', '') }}
                    @endif
                </div>
            </td>
            <td>
                <div align="right" class="Estilo5">

                    @if ($result_inicial->Total != '')
                        {{ "$ " . number_format($result_inicial->Total, 2, '.', '') }}
                    @endif
                </div>
            </td>
        </tr>

        @foreach ($results as $result)
            @if ($result->Tipo == 1)
                @php($total += $result->Ingreso)
                @php($total_ingreso += $result->Ingreso)
            @else
                @php($total -= $result->Egreso)
                @php($total_egreso += $result->Egreso)
            @endif
            <tr>
                <td>
                    <div align="center" class="Estilo5">{{ $i }}</div>
                </td>
                <td>
                    <div align="center" class="Estilo5">{{ date('d/m/Y', strtotime($result->Fecha)) }}</div>
                </td>
                <td class="Estilo5">{{ $result->Descripcion }}</td>
                <td>
                    <div align="right" class="Estilo5">
                        @if ($result->Ingreso != '')
                            {{ "$ " . number_format($result->Ingreso, 2, '.', '') }}
                        @endif
                    </div>
                </td>
                <td>
                    <div align="right" class="Estilo5">
                        @if ($result->Egreso != '')
                            {{ "$ " . number_format($result->Egreso, 2, '.', '') }}
                        @endif
                    </div>
                </td>
                <td>
                    <div align="right" class="Estilo5">
                        {{ "$ " . number_format($total, 2, '.', '') }}</div>
                </td>
            </tr>
            @php($i++)
        @endforeach

        <tr>
            <td colspan="3">&nbsp;</td>
            <td class="Estilo3">
                <div align="right">
                    {{ "$ " . number_format($total_ingreso, 2, '.', '') }}</div>
            </td>
            <td class="Estilo3">
                <div align="right">
                    {{ "$ " . number_format($total_egreso, 2, '.', '') }}</div>
            </td>
            <td class="Estilo3">
                <div align="right">
                    {{ "$ " . number_format($total, 2, '.', '') }}</div>
            </td>
        </tr>






    </table>
</body>

</html>
