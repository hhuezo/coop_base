<?php
if (isset($_GET["FechaInicio"])) {
    
$cn =  mysqli_connect("mysql", "u377565509_acoesi", "Alexander86*", "u377565509_acoesi") or
                die("error" . mysql_error()); 


 
     mysqli_set_charset($cn,"utf8");




$rs = mysqli_query($cn, "select ifnull(sum(Cantidad),0) as Aportaciones FROM aportaciones where Fecha between '" .
$_GET["FechaInicio"] . "' and '" . $_GET["FechaFinal"] . "'");
$row = mysqli_fetch_array($rs);
$Aportaciones = $row[0];


$rs = mysqli_query($cn, "select ifnull(sum(Monto),0) as Cantidad FROM solicitud WHERE Estado in (2,3) and Fecha between
'" . $_GET["FechaInicio"] . "' and '" . $_GET["FechaFinal"] . "'");
$row = mysqli_fetch_array($rs);
$Prestamos = $row[0];


$rs = mysqli_query($cn, "select ifnull(sum(Capital),0) as Capital,ifnull(sum(Interes),0) as Interes FROM recibo WHERE
Fecha between '" . $_GET["FechaInicio"] . "' and '" . $_GET["FechaFinal"] . "'");
$row = mysqli_fetch_array($rs);
$Capital = $row[0];
$Interes = $row[1];


$FechaInicio = $_GET["FechaInicio"];
//sumando egresos
$rs = mysqli_query($cn, "select ifnull(sum(Monto),0),(select ifnull(sum(Cantidad),0) from egreso "
. "where Fecha < '$FechaInicio' and Tipo=2) from solicitud where Estado in (2,3) and Fecha < '$FechaInicio'");
    $row = mysqli_fetch_array($rs);
    $total_egresos = $row[0] + $row[1];
    

    //sumando ingresos
    $rs = mysqli_query($cn, " select ifnull(sum(Cantidad),0),(select ifnull(sum(Cantidad),0) from egreso where Fecha
    < '$FechaInicio' and Tipo=1), (select ifnull(sum(Pago),0) from recibo where recibo.Fecha < '$FechaInicio' ) from
    aportaciones where Fecha < '$FechaInicio'");
  
 
    $row = mysqli_fetch_array($rs);
    $total_ingresos = $row[0] + $row[1] + $row[2];
 
 //egresos
    $rs_egresos = mysqli_query($cn, " SELECT rubro.Nombre,ifnull(sum(egreso.Cantidad),0) as Cantidad,rubro.Tipo FROM
    egreso INNER JOIN rubro ON (egreso.Rubro=rubro.Id) WHERE Fecha between '" . $_GET["FechaInicio"] . "'
    and '" . $_GET["FechaFinal"] . "' group by rubro.Id order by rubro.Id"); 
    $monto_inicial=$total_ingresos - $total_egresos; ?>
    <html>

    <head>
        <meta charset="UTF-8">
        <title></title>
        <style type="text/css">
            <!--
            .Estilo1 {
                font-family: Arial, Helvetica, sans-serif;
                font-weight: bold;
            }

            .Estilo2 {
                font-family: Arial, Helvetica, sans-serif;
            }
            -->
        </style>
    </head>

    <body>

        <table width="80%" border="0" cellspacing="0" align="center">
            <tr>
                <td width="18%" rowspan="2">
                    <div align="center"></div> <img src="../img/logo.png" width="169" height="124">
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td width="81%">
                    <div align="center">
                        <p class="Estilo1">ASOCIACIÓN COOPERATIVA DE EMPLEADOS SINDICALIZADOS DEL ISTA, DE RL</p>
                        <p class="Estilo1">REPORTE POR RUBRO EN EL PERIODO DE <?php echo substr($_GET['FechaInicio'], 8, 2) . '/' . substr($_GET['FechaInicio'], 5, 2) . '/' . substr($_GET['FechaInicio'], 0, 4) . ' AL ' . substr($_GET['FechaFinal'], 8, 2) . '/' . substr($_GET['FechaFinal'], 5, 2) . '/' . substr($_GET['FechaFinal'], 0, 4);
                        ?> </p>
                    </div>
                </td>
                <td width="1%">&nbsp;</td>
            </tr>
        </table>
        <br>


        <table width="80%" border="1" cellspacing="0" align="center">

            <tr>
                <td colspan="3">
                    <div align="center" class="Estilo1">DETALLE POR RUBRO </div>
                </td>
            </tr>
            <tr>
                <td width="64%">
                    <div align="center" class="Estilo1">DETALLE</div>
                </td>
                <td width="16%">
                    <div align="center" class="Estilo1">INGRESO</div>
                </td>
                <td width="20%">
                    <div align="center" class="Estilo1">EGRESO</div>
                </td>
            </tr>
            <tr>
                <td class="Estilo2">
                    <div>MONTO INICIAL DEL MES</div>
                </td>
                <td class="Estilo2">
                    <div align="right">$<?php echo number_format($monto_inicial, 2, '.', ' '); ?> </div>
                </td>
                <td class="Estilo2">
                    <div align="center"></div>
                </td>
            </tr>
            <tr>
                <td class="Estilo2">
                    <div>APORTACIONES</div>
                </td>
                <td class="Estilo2">
                    <div align="right">$<?php echo number_format($Aportaciones, 2, '.', ' '); ?> </div>
                </td>
                <td class="Estilo2">
                    <div align="right"></div>
                </td>
            </tr>
            <tr>
                <td class="Estilo2">
                    <div>PRESTAMOS</div>
                </td>
                <td class="Estilo2">
                    <div align="right"></div>
                </td>
                <td class="Estilo2">
                    <div align="right">$<?php echo number_format($Prestamos, 2, '.', ' '); ?> </div>
                </td>
            </tr>
            <tr>
                <td class="Estilo2">
                    <div>ABONO A CAPITAL</div>
                </td>
                <td class="Estilo2">
                    <div align="right">$<?php echo number_format($Capital, 2, '.', ' '); ?> </div>
                </td>
                <td class="Estilo2">
                    <div align="right"></div>
                </td>
            </tr>
            <tr>
                <td class="Estilo2">
                    <div>PAGO DE INTERES</div>
                </td>
                <td class="Estilo2">
                    <div align="right">$<?php echo number_format($Interes, 2, '.', ' '); ?> </div>
                </td>
                <td class="Estilo2">
                    <div align="right"></div>
                </td>
            </tr>
            <?php
				while($row = mysqli_fetch_array($rs_egresos))
				{
					?>
            <tr>
                <td class="Estilo2">
                    <div><?php echo $row['Nombre']; ?></div>
                </td>
                <td class="Estilo2">
                    <div align="right"><?php if ($row['Tipo'] == 1) {
                        echo '$' . number_format($row['Cantidad'], 2, '.', ' ');
                        $monto_inicial += $row['Cantidad'];
                    } ?> </div>
                </td>
                <td class="Estilo2">
                    <div align="right"><?php if ($row['Tipo'] == 2) {
                        echo '$' . number_format($row['Cantidad'], 2, '.', ' ');
                        $Prestamos += $row['Cantidad'];
                    } ?> </div>
                </td>

            </tr>
            <?php	
				}				
				?>
            <tr>
                <td class="Estilo1">
                    <div align="center">TOTAL</div>
                </td>
                <td class="Estilo1">
                    <div align="right">$<?php echo number_format($monto_inicial + $Interes + $Aportaciones + $Capital, 2, '.', ' '); ?> </div>
                </td>
                <td class="Estilo1">
                    <div align="right">$<?php echo number_format($Prestamos, 2, '.', ' '); ?> </div>
                </td>
            </tr>
        </table>
        <script type="text/javascript">
            window.onload = function() {
                window.print();
                //window.close();
            }
        </script>
    </body>

    </html>
    <?php
    mysqli_close($cn);
}
?>
