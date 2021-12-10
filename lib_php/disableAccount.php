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
		
		$call = mysqli_prepare($con, 'UPDATE cat_cuentas SET activa = false WHERE no_cuenta = ? AND id_cliente = ?');
		mysqli_stmt_bind_param($call, 'si', $_SESSION['selectedAccount'], $_SESSION['iduser']);
		

		if (mysqli_stmt_execute($call) === TRUE) {
		  echo "La cuenta se cerró correctamente";
				exit;
		} else {
		  echo "Error al intentar cerrar la cuenta";
				exit;
		}
	}else{
		echo "La cuenta que intentas cerrar no te pertenece";
		exit;
	}
?>