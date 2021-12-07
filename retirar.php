<?php
    //Se validan los datos
    $valida = true;
    if if(empty($_POST['origen'])){
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

    