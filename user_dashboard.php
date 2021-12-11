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
      <h1 id="greeting">¡Bienvenido!</h1>
      <h6 id="lbl_alert">¡Hola! desde aquí puedes realizar tus operaciones</h6>  
    </div>
  </header>
  <aside class="sidebar"> </aside>
      
  <article class="main">
     
      <div class="saldo">
        <div class="cuenta">
          <p class="txt" style="color: #212529;">Selecciona una cuenta:</p>
		  
			<div class="row align-middle">
			<div class="col align-middle" style="width: 70%;">
            <select id="combo_cuenta" style="width: 100%;">
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
			<div style="width: 30%;">
				<a href="#" id="btnNewAccount" class="btn btn-outline-secondary btn-sm"><strong>+</strong></a >
			</div>
				</div>
        </div>
        <div class="sal">
          <h5>Saldo</h5>   <!--CAMBIAR-->
          <p id="accountMoney" class="money" style="margin-bottom: 0px"></p>  <!--CAMBIAR-->
		  <a href='./pages/estadocuenta/estado_de_cuenta.php' class="btn btn-primary" style="width: 200px; border-radius: 0px 0px 17px 17px;">Estado de cuenta</a >
        </div>
      <div id="btnOperations">        
      
	  </div>
  </div>
      <dv class="tabla">
        <div class="tab">
          <table id="tblEstCuenta" class="table table-striped" style="height: 50px; overflow-y: scroll;">
		  <thead> 
		  <th>Fecha</th>
		  <th>Concepto</th>
		  <th>Cargo</th>
		  <th>Abono</th>
		  <th>Saldo</th>
          </thead>
          <tbody>
            </tbody>
            </table>
      </div>


      </dv>
      <!-- <div class="img-g">
        <img src="images/people.svg" alt="">

      </div> -->
	</article> 

  </body>
	
	<script>
		window.onload = function() {
			
			forceDivUpdate();
			
			$('#greeting').load('lib_php/greeting.php');
					
		};
		
		function forceDivUpdate(){
			if($('#combo_cuenta option').length > 0){
				var element = document.getElementById('combo_cuenta');
				var event = new Event('change');
				element.dispatchEvent(event);
			}else{
				$('#btnNewAccount').addClass("intermitente");
				$('#lbl_alert').html("¡Hola! Al parecer no tienes una cuenta bancoco, pulsa el botón de crear nueva cuenta para abir una.");
			}
		}
		
		//Change nip function
		function handleBtnNipClick(){
			let text;
		  	let newNip = prompt("Ingresa tu nuevo NIP (4 digitos):", "");
			
			const digits_only = string => [...string].every(c => '0123456789'.includes(c))
			
			newNip = newNip.replace(/\s/g, "");
			
		  	if ((!isNaN(parseInt(newNip))) && newNip.length == 4 && digits_only(newNip)) {
				$.ajax({
					url: "lib_php/changeNip.php",
					data: {
						nip: newNip
					},
					success: function( result ) {
						alert(result);
					}
				});
		  	} else {	
				alert("NIP no valido");
		  	}
		}
		
		//Disable account function
		function handleBtnDisableClick(){
			var r = confirm("¿Está seguro de que desea cerrar la cuenta? Esta acción no es reversible");
			if (r == true) {
				
			  $.ajax({
					url: "lib_php/disableAccount.php",
					success: function( result ) {
						alert(result);
						forceDivUpdate();
					}
				});
			}
		}
		
		function refreshTable(){
			$('#tblEstCuenta tbody').html("");
			$.ajax({
				url: "lib_php/estCuentaTableScript.php",
				success: function( result ) {
					
					var tableArray = JSON.parse(result);
					
					for (var i = 0; i < tableArray.length; i++) {
					   $('#tblEstCuenta tbody').append('<tr><td>'+tableArray[i][0]+'</td><td>'+tableArray[i][1]+'</td><td>'+tableArray[i][2]+'</td><td>'+tableArray[i][3]+'</td><td>'+tableArray[i][4]+'</td></tr>')
					}

					$.ajax({
					url: "lib_php/storeTable.php",
					data: {
						table: $('#tblEstCuenta tbody').html()
					}
					});
				}
    		});
			
		}
		
		$('#combo_cuenta').change(function() {
			$.ajax({
				url: "lib_php/getAccountData.php",
				data: {
					account: $(this).val()
				},
				success: function( result ) {
					var results = $.parseJSON(result);
					$( "#accountMoney" ).html(formatter.format(results[0]));
					if(results[1] == true){
									$( "#btnOperations" ).html("<div class='botones'><a href='./pages/transfer/transfer.php' class='btn'>Transferencia</a ><a href='#' class='btn'>Retirar en efectivo</a ><a href='#' class='btn' onclick='handleBtnNipClick()'>Cambiar NIP</a ></div> <div style='width: 200px; margin: 0 auto;'>  <a href='#' class='btn btn-danger' onclick='handleBtnDisableClick()' style = 'width: 100%;'>Cerrar Cuenta</a ></div>");
						
						refreshTable();
					}else{
						$( "#btnOperations" ).html("<p style='color:black; padding-top:20px; text-align:center; width:200px;'>Esta cuenta está desactivada</p>")
					}
				}
			});
			
		});
		
		const formatter = new Intl.NumberFormat('es-MX', {
		  style: 'currency',
		  currency: 'MXN',
		  minimumFractionDigits: 2
		})
	</script>
</html>
