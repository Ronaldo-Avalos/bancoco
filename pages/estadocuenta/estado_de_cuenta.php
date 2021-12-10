<?php

include '../../lib_php/conection.php';

	session_start();

	if(empty($_SESSION['iduser']) || empty($_SESSION['selectedAccount'])) {
		header("Location: ../../login.php?error=2");
	  }

	require_once __DIR__ . './../../vendor/autoload.php';
	$mpdf = new \Mpdf\Mpdf();

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

			.row {
			  margin-left:-5px;
			  margin-right:-5px;
			}

			.column {
			  float: left;
			  padding: 5px;
			}

			/* Clearfix (clear floats) */
			.row::after {
			  content: "";
			  clear: both;
			  display: table;
			}

			table, th, td{
			  border-collapse: collapse;
			  border-spacing: 0;
			  border: 1px solid black;
			}

			</style>



		<body>
			<p><br />ESTADO DE CUENTA</p>
			<hr style="width:720px;text-align:left;margin-left:0">
			<p>&nbsp;</p>
			<div class="row">
			<div class="column">
				<table>
			<tbody>
				<tr>
					<td width="106">
						Cliente:
					</td>
					<td width="298">
						H&eacute;ctor Camberos
					</td>
				</tr>
				<tr>
					<td width="106">
						RFC:
					</td>
					<td width="298">
						MiRFC
					</td>
				</tr>
				<tr>
				<td width="106">
						Tel&eacute;fono:
					</td>
					<td width="298">
						(312) 152 -6873
					</td>
				</tr>
			</tbody>
		</table>
			</div>
			<div class="column">
				<table>
			<tbody>
				<tr>
					<td width="153">
						Resumen del mes:
					</td>
					<td width="147">
						Diciembre
					</td>
				</tr>
				<tr>
					<td width="153">
						Fecha:
					</td>
					<td width="147">
						16/3/2012
					</td>
				</tr>
				<tr>
					<td width="153">
						No. Movimientos:
					</td>
					<td width="147">
						5
					</td>
				</tr>
				<tr>
					<td width="153">
						Saldo
					</td>
					<td width="147">
						$1000
					</td>
				</tr>
				<tr>
					<td colspan="2" width="300">
						Cuenta:
					</td>
				</tr>
				<tr>
					<td colspan="2" width="300">
						3123 1332 9583 8343
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

			<table width="720" style="border: 1px solid black;">
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
				</tr>
				<tr>
					<td width="85">
						19/12/2021
					</td>
						<td width="381">
					Retiro del cajero autom&aacute;tico
						</td>
					<td width="78">
						$300
					</td>
						<td width="90">
					$0
						</td>
					<td width="87">
						$700
					</td>
				</tr>

			<tr>
			<td width="85">
			&nbsp;
			</td>
			<td width="381">
			&nbsp;
			</td>
			<td width="78">
			&nbsp;
			</td>
			<td width="90">
			TOTAL:
			</td>
			<td width="87">
			$2,000
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

	$mpdf->WriteHTML($texto_pdf);
	$mpdf->Output('ESTADO DE CUENTA.pdf', 'I');
?>