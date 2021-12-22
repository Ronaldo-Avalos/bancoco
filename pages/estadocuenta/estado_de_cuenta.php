<?php

include '../../lib_php/conection.php';

	$table = exec('../../lib_php/estCuentaTableScript.php');
	
	session_start();

	if(empty($_SESSION['iduser']) || empty($_SESSION['selectedAccount'])) {
		header("Location: ../../login.php?error=2");
	  }

	require_once __DIR__ . './../../vendor/autoload.php';
	$mpdf = new \Mpdf\Mpdf();

	//obtenemos los datos de el usuario
	$sql="SELECT nombres, correo, telefono FROM cat_clientes WHERE id_cliente = ".$_SESSION['iduser']."";
		$result=mysqli_query($con,$sql);
		$row = $result->fetch_row();

	$sql="SELECT COUNT(id_movimiento) FROM movimientos WHERE cuenta_origen =  ".$_SESSION['selectedAccount']." OR cuenta_receptora = ".$_SESSION['selectedAccount'];
	$count=mysqli_query($con,$sql);
	$fila = $count->fetch_row();
  	$countVal = $fila[0];

	$texto_pdf = '
	
		<!doctype html>
		<html>
		<head>
		<meta charset="utf-8">
		<title>Estado de cuenta</title>
		</head>

			<style>
			* {
			  box-sizing: border-box;
			}

			.right {
			  float: right;
			  width: 40%;
			}

			.left {
			  float: left;
			  width: 50%;
			}

			table{
			  border-collapse: collapse;
			}
			th, td{
	            border-spacing: 0;
			    border: 1px solid black;
			}
			
            .hide {
                visibility: hidden;
                border: none;
            }
			</style>

		<body>
			<p style="margin-bottom: 0px;">ESTADO DE CUENTA</p>
			<hr style="width:720px;text-align:left;margin-left:0">
			<div class="row">
			<div class="left">
				<table>
			<tbody>
				<tr>
					<td width="106">
						Cliente:
					</td>
					<td width="298">
						'.$row[0].'
					</td>
				</tr>
				<tr>
					<td width="106">
						Correo:
					</td>
					<td width="298">
						'.$row[1].'
					</td>
				</tr>
				<tr>
				<td width="106">
						Teléfono:
					</td>
					<td width="298">
						'.$row[2].'
					</td>
				</tr>
			</tbody>
		</table>
			</div>
			<div class="right">
				<table>
			<tbody>
				<tr>
					<td width="153">
						Resumen del mes:
					</td>
					<td width="147">
						Todos
					</td>
				</tr>
				<tr>
					<td width="153">
						Fecha:
					</td>
					<td width="147">
						'.date("d/m/Y")."<br>".'
					</td>
				</tr>
				<tr>
					<td width="153">
						No. Movimientos:
					</td>
					<td width="147">
						'.$countVal.'
					</td>
				</tr>
				<tr>
					<td width="153">
						Saldo
					</td>
					<td width="147">
						$'.$_SESSION['selectedAccountMoney'].'
					</td>
				</tr>
				<tr>
					<td colspan="2" width="300">
						Cuenta:
					</td>
				</tr>
				<tr>
					<td colspan="2" width="300">
						'.$_SESSION['selectedAccount'].'
					</td>
				</tr>
			</tbody>
		</table>
			</div>
		</div>
			<p>&nbsp;</p>
			<p>Comentarios:</p>
			<table>
			<tbody>
				<tr>
					<td width="719">
						Para cualquier aclaraci&oacute;n favor de comunicarse con nuestro servicio t&eacute;cnico
					</td>
				</tr>
			</tbody>
		</table>
			<p>&nbsp;</p>

			<table width="720">
			<tbody>
				<tr>
					<td width="85">
						FECHA
					</td>
					<td width="381">
						MOVIMIENTO
					</td>
					<td width="78">
						CARGO
					</td>
					<td width="90">
						ABONO
					</td>
					<td width="87">
						SALDO
					</td>
				</tr>';

			$texto_pdf = $texto_pdf.$_SESSION['table'];
				
			$texto_pdf = $texto_pdf.'<tr>
			<td class="hide" width="85">
			&nbsp;
			</td>
			<td class="hide" width="381">
			&nbsp;
			</td>
			<td class="hide" width="78">
			&nbsp;
			</td>
			<td width="90">
			TOTAL:
			</td>
			<td width="87">
			$'.$_SESSION['selectedAccountMoney'].'
			</td>
			</tr>
			</tbody>
		</table>

			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p>Atentamente</p>
			<p>&nbsp;</p>
			<p>BANCOCO</p>
			<p>BANCOCO INC, S.A. DE C.V.</p>
		</body>
		</html>
	';
	
	echo $table;
	$mpdf->WriteHTML($texto_pdf);
	$mpdf->Output('ESTADO DE CUENTA.pdf', 'I');
?>