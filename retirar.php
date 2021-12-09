<?php

header('refresh:5, url=retiro_efectivo.php');

    //Se validan los datos
    $valida = true;
    if(empty($_POST['origen'])){
		echo "<b>No se especifico Cuenta de origen</b><br>";
		$valida = false;
	}

	if(empty($_POST['dinero'])){
		echo "<b>No se especifico Cantidad a retirar</b><br>";
		$valida = false;
	}

	if(empty($_POST['nip'])){
		echo "<b>No se escribio clave NIP.</b><br>";
		$valida = false;
	}

	if($valida == false){
		exit();
	}

	//$conect = mysqli_connect("localhost", "root", "", "bancoco") or die("Error de conexion.");
    $conect = mysqli_connect("tektor.com.mx","tektorco_usrbank","f!H7#H0yI.vU","tektorco_bancocodb") or die("Error de conexion.");

	$Pnip = $_POST['nip'];
	$Pmonto = $_POST['dinero'];
	$Pcuenta_origen; 
	$Pcuenta_origen = $_POST['origen'];
	settype($Pmonto, "integer");
    $consulta = " ";
	date_default_timezone_set('America/Mexico_City');
	$Pfecha = date('y/m/d G:i:s');

	if($Pmonto > 10000){
		echo "<h2> La cantidad a retirar supera el limite de retiro.</h2>";
		$valida = false;
	}

	if($Pmonto <= 0 ){
		echo "<h2> La cantidad para retirar debe ser mayor a 0.</h2>";
		$valida = false;
	}

	if($valida == false){
		exit();
	}

    function revisar_nip($Pcuenta_origen, $Pnip){
        //hace conexion a la bd
        global $conect, $consulta;
        //hace consulta de la cuenta
		$sql = 'SELECT * FROM cat_cuentas WHERE no_cuenta = '.$Pcuenta_origen.' AND nip = '.$Pnip;
		//returna el resultado de select
        return $conect->query($sql);
    }

	function revisar_dinero($Pcuenta_origen){
        //hace conexion a la bd
        global $conect, $consulta;
        //hace consulta de la cuenta
		$sql = 'SELECT * FROM cat_cuentas WHERE no_cuenta = '.$Pcuenta_origen;
		//returna el resultado de select
        return $conect->query($sql);
    }

	//revisa que el numero no se haya escrito antes
	$resultado = revisar_nip($Pcuenta_origen, $Pnip);
	$row = $resultado->fetch_assoc();
	//si no se regresa fila de registro la cuenta es unica.
	if($row==NULL){
		$valida = false;
		echo "<h2>Se introdujo NIP incorrecto</h2>";
	}

	$resultado = revisar_dinero($Pcuenta_origen);
	$row = $resultado->fetch_assoc();

	if($row['saldo'] - $Pmonto < 0){
		$valida = false;
		echo "<h2> Se introdujo una suma mayor a la cantidad de la cuenta.</h2>";
	}

	if($valida == true){

		$stmt = mysqli_prepare($conect, "CALL retiro(?, ?, ?, @rowCount)");
		mysqli_stmt_bind_param($stmt, 'ssi', $Pfecha, $Pcuenta_origen, $Pmonto);
		mysqli_stmt_execute($stmt);

		echo "<h2>Transaccion exitosa. Regresando a Dashboard</h2>";
		
		mysqli_close($conect);
		
		header('refresh:5, url=user_dashboard.php');

		exit();
	}
	