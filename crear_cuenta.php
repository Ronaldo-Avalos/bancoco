<?php

    session_start();
    $_SESSION['iduser'] = 0;

    if(isset($_SESSION['iduser'])){
		if ($_SESSION['iduser']==NULL){
			header('refresh:5, url=login.php');
            echo "<h2>Es necesario iniciar sesion.</h2><br/>";
            exit();
		}
	}

    header('refresh:5, url=user_dashboard.html');

    $conect = mysqli_connect("localhost", "root", "", "bancoco") or die("Error de conexion.");
    //$conect = mysqli_connect("tektor.com.mx","tektorco_usrbank","f!H7#H0yI.vU","tektorco_bancocodb");

    $unico = false;
    $numero = "";
    $consulta = " ";

    function revisar_cuentas($Pid_cliente){
        //hace conexion a la bd
        global $conect, $consulta;
        //hace consulta de la cuenta
		$sql = 'SELECT * FROM cat_cuentas WHERE id_cliente = '.$Pid_cliente;
		//returna el resultado de select
        return $conect->query($sql);
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
        echo "<h2>Solo se pueden tener 4 cuentas activas.</h2>";
        exit();
    }

    function revisar_unico($numero){
        //hace conexion a la bd
        global $conect, $consulta;
        //hace consulta de la cuenta
		$sql = 'SELECT * FROM cat_cuentas WHERE no_cuenta = '.$numero;
		//returna el resultado de select
        return $conect->query($sql);
    }

    while ($unico == false){
        //crea el numero random
        $numero = random_int(10000000,99999999);
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
    $Pnip = random_int(1000, 9999);
    $PoutRow = '';

    echo ("Cuenta: ".$Pno_cuenta);
    echo ("<br>NIP: ".$Pnip);

    //se suben los datos
    $stmt = mysqli_prepare($conect, "CALL crear_cuenta(?, ?, ?, @rowCount)");
	mysqli_stmt_bind_param($stmt, 'iss', $Pid_cliente, $Pno_cuenta, $Pnip);
	mysqli_stmt_execute($stmt);

    echo "<br><br><h2>Cuenta creada con exito.</h2>";

    mysqli_close($conect);

?>