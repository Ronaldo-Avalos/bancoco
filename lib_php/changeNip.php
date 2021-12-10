<?php  
    include 'conection.php';

	session_start();

	if(empty($_SESSION['iduser']) || empty($_SESSION['selectedAccount'])) {
		header("Location: login.php?error=2");
  	}
	
	//Validate nip
	$nip = $_GET['nip'];
	
	if(strlen($nip) != 4 || !is_int($nip)){
		$sql = "UPDATE cat_cuentas SET nip = ? WHERE no_cuenta = ? AND id_cliente = ?";

		$call = mysqli_prepare($con, 'UPDATE cat_cuentas SET nip = ? WHERE no_cuenta = ? AND id_cliente = ?');
		mysqli_stmt_bind_param($call, 'ssi', $nip, $_SESSION['selectedAccount'], $_SESSION['iduser']);
		

		if (mysqli_stmt_execute($call) === TRUE) {
		  echo "El NIP de actualizó correctamente";
				exit;
		} else {
		  echo "Error al actualizar el NIP";
				exit;
		}
	}else{
		echo "NIP no valido";
		exit;
	}
?>