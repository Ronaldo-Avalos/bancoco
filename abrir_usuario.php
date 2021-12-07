<?php
    if(empty($_POST['name'])){
		echo "<b>No se especifico Nombre</b><br>";
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
        $con = mysqli_connect("tektor.com.mx","tektorco_usrbank","f!H7#H0yI.vU","tektorco_bancocodb");
        $nombres = $_POST(name);
        $primer_apellido = $_POST(ape_pat);
        $segundo_apellido = $_POST(ape_mat);
        $usuario = $_POST(usuario);
        $pass = $_POST(contra1);
        $correo = $_POST(correo);
        $fecha_nacimiento = $_POST(fecha);
        $telefono = $_POST(telefono);
        $sexo = $_POST(sexo);

        $sql = "CALL "
    }