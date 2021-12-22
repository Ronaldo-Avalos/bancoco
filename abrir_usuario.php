<?php
	include 'lib_php/conection.php';

	function handleError($error){
		echo "<script>alert('.$error.')
		window.location.href='crear_usuario.html'</script>";
		exit;
	}

	$valida = true;
	//se comprueba que todos los campos esten llenos
    if(empty($_POST['name'])){
		handleError('No se especificó Nombre');
	}

	if(empty($_POST['ape_mat'])){
		handleError('No se especificó segundo apellido');
	}

	if(empty($_POST['telefono'])){
		handleError('No se especificó numero de teléfono');
	}

	if(empty($_POST['ape_pat'])){
		handleError('No se especificó el primer apellido');
	}

	if(empty($_POST['usuario'])){
		handleError('No se especificó nombre de usuario.');
	}

    if(empty($_POST['contra1'])){
		handleError('No se especificó contraseña');
	}

	if(empty($_POST['correo'])){
		handleError('No se especificó correo electronico.');
	}

	if(empty($_POST['fecha'])){
		handleError('No se escribió la fecha de nacimiento.');
	}

	if (!strchr($_POST['correo'],"@") || !strchr($_POST['correo'],".")){
		handleError('No es un correo valido');
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
        global $con, $consulta;
        //hace consulta de la cuenta
		$sql = 'SELECT * FROM cat_clientes WHERE usuario = "'.$Pusuario.'"';
		//returna el resultado de select
        return $con->query($sql);
    }

	function revisar_telefono($Ptelefono){
        //hace conexion a la bd
        global $con, $consulta;
        //hace consulta del telefono
		$sql = 'SELECT * FROM cat_clientes WHERE telefono = "'.$Ptelefono.'"';
		//returna el resultado de select
        return $con->query($sql);
    }

	function revisar_correo($Pcorreo){
        //hace conexion a la bd
        global $con, $consulta;
        //hace consulta del correo
		$sql = 'SELECT * FROM cat_clientes WHERE correo = "'.$Pcorreo.'"';
		//returna el resultado de select
        return $con->query($sql);
    }

	//Se hacen las comprobaciones

	$resultado = revisar_usuario($Pusuario);
	$row = $resultado->fetch_assoc();
	if($row!=NULL){
		handleError('Ya se tiene ese usuario registrado');
	}
	

	$resultado = revisar_telefono($Ptelefono);
	$row = $resultado->fetch_assoc();
	if($row!=NULL){
		handleError('El telefono ya ha sido registrado');
	}

	$busqueda = revisar_correo($Pcorreo);
	$row = $busqueda->fetch_assoc();
	if($row!=NULL){
		handleError('El correo ya ha sido registrado');
	}

	//se revisa la edad
	date_default_timezone_set('America/Mexico_City');
	$fecha_nac = new DateTime($Pfecha_nacimiento);
	$fecha_hoy = new DateTime("now");
	$tiempo = $fecha_nac->diff($fecha_hoy);
	if($tiempo->y < 18){
		handleError('Es necesario ser mayor de 18 para tener una cuenta bancaria.');
	}


    if ($valida == true){

		//Se envian los datos con la funcion crear_usuario()
		$stmt = mysqli_prepare($con, "CALL crear_usuario(?, ?, ?, ?, ?, ?, ?, ?, ?, @countRow)") or die(mysqli_error());
		mysqli_stmt_bind_param($stmt, 'ssssissss', $Pnombres, $Pprimer_apellido, $Psegundo_apellido, $Ptelefono, $Psexo, $Pfecha_nacimiento, $Pcorreo, $Pusuario, $Ppass);
		mysqli_stmt_execute($stmt);

		mysqli_close($con);

		echo "<script>alert('El usuario se ha creado con exito')
		window.location.href='login.php'</script>";
    }
?>