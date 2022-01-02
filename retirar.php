<?php
	
	include 'lib_php/conection.php';

	function handleError($error){
		echo "<script>alert('.$error.')
		window.location.href='retiro_efectivo.php'</script>";
		exit;
	}

    //Se validan los datos
    if(empty($_POST['origen'])){
		handleError('No se especificó Cuenta de origen');
	}

	if(empty($_POST['dinero'])){
		handleError('No se especificó la cantidad a retirar');
	}

	if(empty($_POST['nip'])){
		handleError('No se escribió clave NIP');
	}

	$Pnip = $_POST['nip'];
	$Pmonto = $_POST['dinero']; 
	$Pcuenta_origen = $_POST['origen'];
	settype($Pmonto, "integer");
    $consulta = " ";

	if($Pmonto > 10000){
		handleError('La cantidad a retirar supera el limite de retiro. (10,000)');
	}

	if($Pmonto <= 0 ){
		handleError('La cantidad para retirar debe ser mayor a 0.');
	}

    function revisar_nip($Pcuenta_origen, $Pnip){
        //hace conexion a la bd
        global $con, $consulta;
        //hace consulta de la cuenta
		$sql = 'SELECT * FROM cat_cuentas WHERE no_cuenta = '.$Pcuenta_origen.' AND nip = '.$Pnip;
		//returna el resultado de select
        return $con->query($sql);
    }

	function revisar_dinero($Pcuenta_origen){
        //hace conexion a la bd
        global $con, $consulta;
        //hace consulta de la cuenta
		$sql = 'SELECT * FROM cat_cuentas WHERE no_cuenta = '.$Pcuenta_origen;
		//returna el resultado de select
        return $con->query($sql);
    }

	//revisa que el nip sea correcto
	$resultado = revisar_nip($Pcuenta_origen, $Pnip);
	$row = $resultado->fetch_assoc();
	//si no se regresa fila de cuenta, algo es incorrecto.
	if($row==NULL){
		handleError('Se introdujo NIP incorrecto');
	}

	$resultado = revisar_dinero($Pcuenta_origen);
	$row = $resultado->fetch_assoc();

	if($row['saldo'] - $Pmonto < 0){
		handleError('Se introdujo una suma mayor a la cantidad de la cuenta.');
	}

	$stmt = mysqli_prepare($con, "CALL retiro(?, ?, @rowCount)");
	mysqli_stmt_bind_param($stmt, 'si', $Pcuenta_origen, $Pmonto);
	mysqli_stmt_execute($stmt);
	
	mysqli_close($con);

	echo "<script>alert('Transaccion exitosa. Regresando a Dashboard')
	window.location.href='user_dashboard.php'</script>";
	