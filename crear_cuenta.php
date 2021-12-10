<?php

    session_start();
    $link = "login.php";

    if($_SESSION["iduser"] == NULL){
        header('refresh:5, url=login.php');
        echo "<b>Es necesario iniciar sesion.</b><br/>";
        <?php
        exit();
    }

    header('refresh:5, url=user_dashboard.html');

    //$conect = mysqli_connect("localhost", "root", "", "bancoco") or die("Error de conexion.");
    $conect = mysqli_connect("tektor.com.mx","tektorco_usrbank","f!H7#H0yI.vU","tektorco_bancocodb");

    $unico = false;
    $numero = "";
    $consulta = " ";

    function revisar($numero){
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
        $busqueda = revisar($numero);
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
