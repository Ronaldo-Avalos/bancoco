<?php
    
    include 'conection.php';

	session_start();

	if(empty($_SESSION['iduser'])) {
		header("Location: login.php?error=2");
  	}

	$sql="SELECT nombres, sexo FROM cat_clientes WHERE id_cliente=".$_SESSION['iduser'];

	if ($result=mysqli_query($con,$sql))
	{
	// Fetch one and one row
	$name = 0;
	$sexo = 0;
	while ($row=mysqli_fetch_row($result))
	{
		$name = $row[0];
		$sexo = $row[1];
	}
	// Free result set
	mysqli_free_result($result);
	}

	mysqli_close($con);

	if($sexo == 0){
		echo "¡Bienvenido ".$name."!";
	}else{
		echo "¡Bienvenida ".$name."!";
	}
?>