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
		
		unset($result);
		unset($row);
		unset($queryValue);

		$cuenta_destino = $_POST['cuenta_destino'];
		$importe = $_POST['importe'];
		$concepto = $_POST['concepto'];
		
		if($cuenta_destino == $_SESSION['selectedAccount']){
			echo "<script>alert('La cuenta receptora y de destino no pueden ser la misma')
			window.location.href='../pages/transfer/transfer.php'</script>";
			exit;
		}
		
		if($importe > $_SESSION['selectedAccountMoney']){
			echo "<script>alert('El saldo de tu cuenta es insuficiente para realizar la operacion')
			window.location.href='../pages/transfer/transfer.php'</script>";
			exit;
		}
		
		$sql="SELECT activa FROM cat_cuentas WHERE no_cuenta = ".$cuenta_destino."";
		$result=mysqli_query($con,$sql);
		$row = $result->fetch_row();
		$queryValue = $row[0];
		
		if($queryValue == null ){
			echo "<script>alert('La cuenta de destino no existe')
			window.location.href='../pages/transfer/transfer.php'</script>";
			exit;
		}elseif ($queryValue == false){
			echo "<script>alert('La cuenta de destino está cerrada, no se puede proceder con transacción')
			window.location.href='../pages/transfer/transfer.php'</script>";
			exit;
		}
		
		$call = mysqli_prepare($con, 'CALL transfer(?, ?, ?, ?, @countRow)');
		mysqli_stmt_bind_param($call, 'ssds', $_SESSION['selectedAccount'], $cuenta_destino, $importe, $concepto);
		mysqli_stmt_execute($call);

		$select = mysqli_query($con, 'SELECT @countRow');
		$result = mysqli_fetch_assoc($select);
		$countRow = $result['@countRow'];

		if ($countRow > 0) {
			echo "<script>alert('Transferencia realizada correctamente')
			window.location.href='../user_dashboard.php'</script>";
		}else{
			echo "<script>alert('Error en la transferencia')
			window.location.href='../user_dashboard.php'</script>";
		}
		
	}else{
		echo "<script>alert('La cuenta de origen no te pertenece')
			window.location.href='../pages/transfer/transfer.php'</script>";
	}
?>