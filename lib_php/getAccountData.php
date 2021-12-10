<?php
    
    include 'conection.php';

	session_start();

	if(empty($_SESSION['iduser'])) {
		header("Location: login.php?error=2");
  	}

	if (isset($_GET['account'])){
		
		$sql="SELECT saldo FROM cat_cuentas WHERE no_cuenta=".$_GET['account']." && id_cliente = ".$_SESSION['iduser'];
		
		if ($result=mysqli_query($con,$sql))
		{
		// Fetch one and one row
		$money = 0;
		while ($row=mysqli_fetch_row($result))
		{
			$money = $row[0];
		}
		// Free result set
		mysqli_free_result($result);
		}

		mysqli_close($con);
		
		$_SESSION['selectedAccount'] = $_GET['account'];
		$_SESSION['selectedAccountMoney'] = $money;
		
		echo $money;
		
		}
?>