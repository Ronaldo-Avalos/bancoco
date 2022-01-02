<?php
    
    session_start();

    if(empty($_SESSION['iduser'])) {
		header("Location: login.php?error=2");
	}

    function handleError($error){
		echo "<script>alert('.$error.')
		window.location.href='user_dashboard.php'</script>";
		exit;
	}

    include 'lib_php/conection.php';

    $unico = false;
    $numero = "";
    $consulta = " ";

    function revisar_cuentas($Pid_cliente){
        //hace conexion a la bd
        global $con, $consulta;
        //hace consulta de la cuenta
		$sql = 'SELECT * FROM cat_cuentas WHERE id_cliente = "'.$Pid_cliente.'"';
		//returna el resultado de select
        return $con->query($sql);
    }

    //Se revisan la cantidad de cuentas para que el usuario solo pueda tener 4
    $resultado = revisar_cuentas($_SESSION['iduser']);
    $cont_cuentas = 0;

    while ($row = $resultado->fetch_assoc()){
        if($row['activa'] == 1){
            $cont_cuentas ++;
        }
    }
    if($cont_cuentas >= 4){
        handleError('Solo se pueden tener 4 cuentas activas.');
    }

    function revisar_unico($numero){
        //hace conexion a la bd
        global $con, $consulta;
        //hace consulta de la cuenta
		$sql = 'SELECT * FROM cat_cuentas WHERE no_cuenta = '.$numero;
		//returna el resultado de select
        return $con->query($sql);
    }

    while ($unico == false){
        //crea el numero random
        $numero = rand(10000000,99999999);
        //revisa que el numero no se haya escrito antes
        $busqueda = revisar_unico($numero);
        $row = $busqueda->fetch_assoc();
        //si no se regresa fila de registro la cuenta es unica.
        if($row==NULL){
            $unico = true;
        }
    }

    $Pno_cuenta = $numero;
    $Pid_cliente = $_SESSION["iduser"];
    //$Pid_cliente = 18;
    $Pnip = rand(1000, 9999);
    $PoutRow = '';

    //se suben los datos
    $stmt = mysqli_prepare($con, "CALL crear_cuenta(?, ?, ?, @rowCount)");
	mysqli_stmt_bind_param($stmt, 'iss', $Pid_cliente, $Pno_cuenta, $Pnip);
	mysqli_stmt_execute($stmt);

    $alertString = 'Cuenta creada con exito. \r\nCuenta: '.$Pno_cuenta.' \r\nNIP: '.$Pnip;
    echo "<script>alert(\"$alertString\")
    window.location.href='user_dashboard.php'</script>";
    
    mysqli_close($con);

?>
