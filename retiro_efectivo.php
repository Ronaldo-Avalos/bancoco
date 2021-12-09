<?php
    session_start();
    
    $link = "login.php";
    //Se verifica que el usuario este con sesion iniciada
    if($_SESSION["usuario"] == NULL){
        echo "<b>Es necesario iniciar sesion.</b><br/>";
        ?> <html>
            <button type="button" onclick="location.href='login.php'">Iniciar sesion</button>
            </html>
        <?php
        exit();
    }

    $Pid_usuario = $_SESSION["usuario"];

    // Se hace conexion con la base de datos
    //$conect = mysqli_connect("localhost", "root", "", "bancoco") or die("Error de conexion.");
    $conect = mysqli_connect("tektor.com.mx","tektorco_usrbank","f!H7#H0yI.vU","tektorco_bancocodb") or die("Error de conexion");

    //funcion que saca las cuentas del usuario
    function sacar_cuentas($Pid_usuario){
        global $conect, $consulta;
        //hace consulta de la cuenta
		$sql = 'SELECT * FROM cat_cuentas WHERE id_cliente = '.$Pid_usuario;
		//returna el resultado de select
        return $conect->query($sql);
    }

    //se sacan los resultados de la consulta
    $resultado = sacar_cuentas($Pid_usuario);
	
?>

<!DOCTYPE html>
<HTML>
<head>
    <meta charset="utf-8"/>
    <META NAME="Author" CONTENT="Oscar Dalí Nattaniel Romero Raygoza">
    <META NAME="Rights" CONTENT="Oscar Dalí Nattaniel Romero Raygoza">
    <META NAME="Description" CONTENT="Esta es la pagina de presupuesto.">
    <META NAME="Keywords" CONTENT="javascript, curso, diseño web, programacion, México">
    <META NAME="Date" CONTENT="Monday, 08 November, 2021">
    <title> Apertura de cuenta </title>
    <!-- styles -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/fontawesome-all.min.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">

</head>
<body data-bs-spy="scroll" data-bs-target="#navbarExample">
    <!-- Nav -->
    <!--
    <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
        <div class="container">

          
            <a class="navbar-brand logo-image" href="index.php"><img src="images/logo.svg" alt="alternative"></a> 

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav ms-auto navbar-nav-scroll">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php#header">Misión </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#vision">Visión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#somos">Quienes somos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#sevicios">Servicios</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">Mas...</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown01">
                            <li><a class="dropdown-item" href="index.php#contacto">Servicio al cliente</a></li>
                            <li><div class="dropdown-divider"></div></li>
                            <li><a class="dropdown-item" href="index.php#contacto">Contacto</a></li>
                            <li><div class="dropdown-divider"></div></li>
                            <li><a class="dropdown-item" href="crear_cuenta.html">Apertura de cuenta</a></li>
                            <li><div class="dropdown-divider"></div></li>
                            <li><a target="_blank" class="dropdown-item" href="Login/login.php">Estado de cuenta</a></li>
                        </ul>
                    </li>
                </ul>
                <span class="nav-item">
                    <a  target="" class="btn-solid-sm" href="Login/login.php">Acceso</a>
                </span>
            </div> 
        </div>
    </nav>--> <!--Fin de Nav -->

    <div> <!--Inicio del formulario para transferir-->
        <form method="post" action="retirar.php">
            <label for="origen">Cuenta de origen: </label><br>
            <!-- Aqui se ponen las cuentas del usuario desde la variable raw-->
            <select name="origen" id="origen">
                <!--Se corre un while para imprimir las cuentas-->
                <?php 
                    while($row = $resultado->fetch_assoc()){ 
                ?>
                    <!--Imprime los resultados de no_cuenta como valor en el select y como texto para que el usuario lo vea-->
                    <option value=<?php echo $row['no_cuenta']; ?> > <?php echo($row['no_cuenta']); ?> </option>
                    <?php } ?>
            </select><br>
            <label for="dinero">Cantidad para retirar: </label><br>
            <input type="number" name="dinero" id="dinero"><br>
            <label for="nip">Ingresa tu NIP: </label><br>
            <input type="text" id="nip" name="nip"><br>
            <input type="submit" value="Realizar retiro">
        </form>
    </div>
    </body>
</HTML>