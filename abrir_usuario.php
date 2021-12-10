<?php

	header('refresh:5, url=crear_usuario.php');

	$Pcon = mysqli_connect("tektor.com.mx","tektorco_usrbank","f!H7#H0yI.vU","tektorco_bancocodb");
	//$Pcon = mysqli_connect("localhost","root","","bancoco") or die ("No se encuentra la base de datos");

	$valida = true;
	//se comprueba que todos los campos esten llenos
    if(empty($_POST['name'])){
		echo "<b>No se especifico Nombre</b><br>";
		$valida = false;
	}

	if(empty($_POST['ape_mat'])){
		echo "<b>No se especifico Segundo apellido</b><br>";
		$valida = false;
	}

	if(empty($_POST['telefono'])){
		echo "<b>No se especifico Numero de telefono</b><br>";
		$valida = false;
	}

	if(empty($_POST['ape_pat'])){
		echo "<b>No se especifico Primer apellido</b><br>";
		$valida = false;
	}

	if(empty($_POST['usuario'])){
		echo "<b>No se especifico Nombre de usuario.</b><br>";
		$valida = false;
	}

    if(empty($_POST['contra1'])){
		echo "<b>No se especifico Contraseña</b><br>";
		$valida = false;
	}

	if(empty($_POST['correo'])){
		echo "<b>No se especifico Correo electronico.</b><br>";
		$valida = false;
	}

	if(empty($_POST['fecha'])){
		echo "<b>No se escribio la Fecha de nacimiento.</b><br>";
		$valida = false;
	}

	if (!strchr($_POST['correo'],"@") || !strchr($_POST['correo'],".")){
        echo "<b>No es un correo valido</b><br/>";
        $valida = false;
    }

	if($valida == false){
		exit();
	}

	//se crean las variables y se empieza a comprobar que telefono, correo y usuario no existan

	$Pnombres = $_POST['name']; 
	$Psexo = $_POST['sexo'];
	settype($Psexo, "integer");
    $Pprimer_apellido = $_POST['ape_pat'];
    $Psegundo_apellido = $_POST['ape_mat'];
    $Pusuario = $_POST['usuario'];
    $Ppass = $_POST['contra1'];
    $Pcorreo = $_POST['correo'];
	settype($Pcorreo, "string");
    $Pfecha_nacimiento = $_POST['fecha'];
	settype($Pfecha_nacimiento, "string");
    $Ptelefono = $_POST['telefono'];
    $Psexo = $_POST['sexo'];

	function revisar_usuario($Pusuario){
        //hace conexion a la bd
        global $Pcon, $consulta;
        //hace consulta de la cuenta
		$sql = 'SELECT * FROM cat_clientes WHERE usuario = '.$Pusuario;
		//returna el resultado de select
        return $Pcon->query($sql);
    }

	function revisar_telefono($Ptelefono){
        //hace conexion a la bd
        global $Pcon, $consulta;
        //hace consulta del telefono
		$sql = 'SELECT * FROM cat_clientes WHERE telefono = '.$Ptelefono;
		//returna el resultado de select
        return $Pcon->query($sql);
    }

	function revisar_correo($Pcorreo){
        //hace conexion a la bd
        global $Pcon, $consulta;
        //hace consulta del correo
		$sql = 'SELECT * FROM cat_clientes WHERE correo = "'.$Pcorreo.'"';
		//returna el resultado de select
        return $Pcon->query($sql);
    }

	//Se hacen las comprobaciones

	$resultado = revisar_usuario($Pusuario);
	$row = $resultado->fetch_assoc();
	if($row!=NULL){
		$valida = false;
		echo "<h2> Ya se tiene ese usuario registrado </h2>";
	}

	$resultado = revisar_telefono($Ptelefono);
	$row = $resultado->fetch_assoc();
	if($row!=NULL){
		$valida = false;
		echo "<h2> El telefono ya ha sido registrado</h2>";
	}

	$busqueda = revisar_correo($Pcorreo);
	$row = $busqueda->fetch_assoc();
	if($row!=NULL){
		$valida = false;
		echo "<h2> El correo ya ha sido registrado</h2>";
	}

	//se revisa la edad
	date_default_timezone_set('America/Mexico_City');
	$fecha_nac = new DateTime($Pfecha_nacimiento);
	$fecha_hoy = new DateTime("now");
	$tiempo = $fecha_nac->diff($fecha_hoy);
	if($tiempo->y < 18){
		echo "<h2>Es necesario ser mayor de 18 para tener una cuenta bancaria.</h2>";
		$valida = false;
	}


    if ($valida == true){

		//Se envian los datos con la funcion crear_usuario()
		$stmt = mysqli_prepare($Pcon, "CALL crear_usuario(?, ?, ?, ?, ?, ?, ?, ?, ?, @countRow)") or die(mysqli_error());
		mysqli_stmt_bind_param($stmt, 'ssssissss', $Pnombres, $Pprimer_apellido, $Psegundo_apellido, $Ptelefono, $Psexo, $Pfecha_nacimiento, $Pcorreo, $Pusuario, $Ppass);
		mysqli_stmt_execute($stmt);

		//Para errores:	echo("Error description: " . $Pcon->error);
		
		echo "<br><br><br><h2>El usuario se ha creado con exito</h2>";

		header('refresh:5, url=login.html');

		mysqli_close($Pcon);
    }
?>