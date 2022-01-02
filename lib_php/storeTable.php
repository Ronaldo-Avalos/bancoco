<?php
    
    include 'conection.php';

	session_start();

	if(empty($_SESSION['iduser']) || empty($_SESSION['selectedAccount'])) {
		header("Location: login.php?error=2");
  	}

	$_SESSION['table'] = $_GET['table'];
?>
