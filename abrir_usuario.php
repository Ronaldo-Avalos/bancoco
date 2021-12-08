<?php

	header('refresh:5, url=crear_usuario.html');

	$valida = true;

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


    if ($valida == true){
		//Se crean las variables para meter los datos
        $Pcon = mysqli_connect("tektor.com.mx","tektorco_usrbank","f!H7#H0yI.vU","tektorco_bancocodb");
		//$Pcon = new mysqli("localhost","root","","bancoco") or die ("No se encuentra la base de datos");;
        $Pnombres = $_POST['name']; 
		$Psexo = $_POST['sexo'];
		settype($Psexo, "integer");
        $Pprimer_apellido = $_POST['ape_pat'];
        $Psegundo_apellido = $_POST['ape_mat'];
        $Pusuario = $_POST['usuario'];
        $Ppass = $_POST['contra1'];
        $Pcorreo = $_POST['correo'];
        $Pfecha_nacimiento = $_POST['fecha'];
		settype($Pfecha_nacimiento, "string");
        $Ptelefono = $_POST['telefono'];
        $Psexo = $_POST['sexo'];

		//Se envian los datos con la funcion crear_usuario()
		$stmt = mysqli_prepare($Pcon, "CALL crear_usuario(?, ?, ?, ?, ?, ?, ?, ?, ?, '')") or die(mysqli_error());
		mysqli_stmt_bind_param($stmt, 'ssssissss', $Pnombres, $Pprimer_apellido, $Psegundo_apellido, $Ptelefono, $Psexo, $Pfecha_nacimiento, $Pcorreo, $Pusuario, $Ppass);
		mysqli_stmt_execute($stmt) or die("Error de envio de datos.");

		//Para errores:	echo("Error description: " . $Pcon->error);
		
		echo "<br><br><br><h2>El usuario se ha creado con exito</h2>";

		mysqli_close($Pcon);
    }
?>