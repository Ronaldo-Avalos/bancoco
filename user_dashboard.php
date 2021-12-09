<?php 
	include 'lib_php/conection.php';

	session_start();

	if(empty($_SESSION['iduser'])) {
		header("Location: login.php?error=2");
	  }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Usuario</title>
    <link rel="stylesheet" href="css/styles_User.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/fontawesome-all.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>	
  <body class="grid-container">
    <header class="header"> 
    <!-- Nav -->
    <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
        <div class="container">

            <!-- Logo -->
            <a class="navbar-brand logo-image" href="../index.php"><img src="images/logo.svg" alt="alternative"></a> 

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav ms-auto navbar-nav-scroll">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php #contacto">Tengo un problema</a>
                    </li>
                </ul>
                <span class="nav-item">
                    <a  class="btn-solid-sm" href="login.php?cerrar=1">Cerrar sesión</a>
                </span>
            </div> 
        </div>
    </nav> <!--Fin de Nav -->

    <div class="titulo">
      <h1 id="greeting">¡Bienvenido!</h1>  <!--CAMBIAR USUARIO-->
		
      <h6>Hola! desde aquí puedes realizar tus operaciones</h6>  
    </div>
  </header>
  <aside class="sidebar"> </aside>
      
  <article class="main">
     
      <div class="saldo">
        <div class="cuenta">
          <p class="txt" style="color: #212529;">Selecciona tu Cuenta:</p> 
            <select id="combo_cuenta">
				<?php

				$sql="SELECT no_cuenta FROM cat_cuentas WHERE id_cliente=".$_SESSION['iduser'];

				if ($result=mysqli_query($con,$sql))
				{
				// Fetch one and one row
				while ($row=mysqli_fetch_row($result))
				{
					echo '<option>'.$row[0].'</option>';
				}
				// Free result set
				mysqli_free_result($result);
				}

				mysqli_close($con);
				?>
            </select>
        </div>
        <div class="sal">
          <h5>Saldo</h5>   <!--CAMBIAR-->
          <p id="accountMoney"></p>  <!--CAMBIAR-->
        </div>
              
      <div class="botones">
        <a href="#" class="btn">Transferencia</a >
        <a href="#" class="btn">Retirar en efectivo</a >
        <a href="#" class="btn">Cancelar Cuenta</a >
        <a href="#" class="btn">Cambiar NIP</a >
        <a href="#" class="btn">Crear una nueva cuenta</a >
    </div> 
  </div>
      <dv class="tabla">
        <div class="tab">
          <table class="table table-striped">
              <thead> 
              <th>Movimientos de la cuenta:  </th>
          </thead>
          <tbody>
              <tr>
                <th scope="row">1</th>
                <td>Movimiento</td>  <!--CAMBIAR-->
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>Movimiento</td>  <!--CAMBIAR-->
              </tr>
              <tr>
                <th scope="row">3</th>
                <td >Movimiento</td>  <!--CAMBIAR-->
                
              </tr>
            </tbody>
            </table>
      </div>


      </dv>
      <div class="img">
        <img src="/images/people.svg" alt="">

      </div>
	</article> 

    <footer class="footer"> </footer>
  </body>
	
	<script>
		window.onload = function() {
			
			if($('#combo_cuenta option').length > 0){
				var element = document.getElementById('combo_cuenta');
				var event = new Event('change');
				element.dispatchEvent(event);
			}
			
			$('#greeting').load('lib_php/greeting.php');
			
			
			
		};
		
		$('#combo_cuenta').change(function() {
			$.ajax({
				url: "lib_php/getAccountData.php",
				data: {
					account: $(this).val()
				},
				success: function( result ) {
					$( "#accountMoney" ).html(result);
					}
			});
		});
	</script>
</html>
