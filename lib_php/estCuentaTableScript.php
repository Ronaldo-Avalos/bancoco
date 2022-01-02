<?php

    include 'conection.php';

	session_start();

	if(empty($_SESSION['iduser']) || empty($_SESSION['selectedAccount'])) {
		header("Location: login.php?error=2");
  	}

	//Validamos que la cuenta sea suya
	$sql="SELECT COUNT(id_cuenta) FROM cat_cuentas WHERE no_cuenta = ".$_SESSION['selectedAccount']. " AND id_cliente = ".$_SESSION['iduser'];
	
	$result=mysqli_query($con,$sql);
	$row = $result->fetch_row();
  	$queryValue = $row[0];
	
	if ((int)$queryValue > 0 ){
		
		$sql="SELECT concepto, cuenta_origen, cuenta_receptora, DATE(fecha), monto FROM movimientos WHERE cuenta_origen = ".$_SESSION['selectedAccount']." OR cuenta_receptora = ".$_SESSION['selectedAccount']." order by fecha asc";
		
		if ($result=mysqli_query($con,$sql))
		{
			
		$tabla = array();
		$abono = 0;
		$cargo = 0;
		$saldo = 0;
			
		// Fetch one and one row
		while ($row=mysqli_fetch_row($result))
		{
		
			if($row[1] == $_SESSION['selectedAccount']){
				$saldo = $saldo - $row[4];
				$cargo = $row[4];
				$abono = 0;
			}else{
				$saldo = $saldo + $row[4];
				$cargo = 0;
				$abono = $row[4];
			}
			array_push($tabla, array($row[3], $row[0], $cargo, $abono, $saldo));
		}
		// Free result set
		mysqli_free_result($result);
		}

		mysqli_close($con);
		
		echo json_encode($tabla);
		
	}
		
?>