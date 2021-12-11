<?php 
	include '../../lib_php/conection.php';

	session_start();

	if(empty($_SESSION['iduser']) || empty($_SESSION['selectedAccount'])) {
		header("Location: ../../login.php?error=2");
	  }

	
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">

    <title>Bancoco</title>
    
    <!-- styles -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/fontawesome-all.min.css" rel="stylesheet">
	<link href="../../css/styles.css" rel="stylesheet">
	<link href="transferStyle.css" rel="stylesheet">
	
</head>
<body data-bs-spy="scroll" data-bs-target="#navbarExample">
    
   <!-- Nav -->
   <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
	<div class="container">

		<!-- Logo -->
		<a class="navbar-brand logo-image" href="../../index.php"><img src="../../images/logo.svg" alt="alternative"></a> 

		<div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
			<ul class="navbar-nav ms-auto navbar-nav-scroll">
				<li class="nav-item">
					<a class="nav-link" href="../../index.php #contacto">Tengo un problema</a>
				</li>
			</ul>
			<span class="nav-item">
				<a  class="btn-solid-sm" href="../../user_dashboard.php">Regresar</a>
			</span>
		</div> 
	</div>
</nav> <!--Fin de Nav -->
<div class="center">

		 <!-- Formulario de transferencia-->
        <div class="center">
					<h1>Tranferencia bancaria</h1>
		
					<form action="../../lib_php/transferScript.php" method=post>
					  <div class="txt_field">
						<input type="text" value="<?php echo $_SESSION['selectedAccount'];?>" readonly required>
						<span></span>
						<label style="top: 0%;" for="pwd">Cuenta Origen</label>
					  </div>
					  <div class="txt_field">
						<input type="text" name="cuenta_destino" required>
						<span></span>
						<label for="pwd">Cuenta destino</label>
					  </div>
					  <div class="txt_field">
						<input type="number" name="importe" required>
						<span></span>
						<label for="pwd">Importe</label>
					  </div>
					  <div class="txt_field">
						<input type="text" name="concepto" maxlength="40" required>
						<span></span>
						<label for="pwd">Concepto</label>
					  </div>

					  <input type="submit" class="btn-solid-sm" value="Transferir" ></input>

					</form>		  
	   </div>   
	   
</body>
</html>