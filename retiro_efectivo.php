<?php
    session_start();
    //$_SESSION['iduser'] = 6;
    $link = "login.php";
    //Se verifica que el usuario este con sesion iniciada
    if($_SESSION["iduser"] == NULL){
        echo "<b>Es necesario iniciar sesion.</b><br/>";
        ?> <html>
            <button type="button" onclick="location.href='login.php'">Iniciar sesion</button>
            </html>
        <?php
        exit();
    }

    $Pid_usuario = $_SESSION["iduser"];

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
    <META NAME="Description" CONTENT="Esta es la pagina de Retiro de efectivo.">
    <META NAME="Keywords" CONTENT="javascript, curso, diseño web, programacion, México">
    <META NAME="Date" CONTENT="Monday, 09 December, 2021">
    <title> Retiro de efectivo </title>
    <!-- styles -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/fontawesome-all.min.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
    <link href="css/styles_User.css" rel="stylesheet">
</head>
<body data-bs-spy="scroll" data-bs-target="#navbarExample">
 
    <div class="center"> <!--Inicio del formulario para transferir-->
    <h1>Realizar retiro</h1>
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

            <div class="txt_field">
                <input type="number" name="dinero" id="dinero">
                <span></span>
                 <label>Catidad a retirar</label>
            </div>
            <div class="txt_field">
                <input type="text" id="nip" name="nip">
                <span></span>
                 <label>Ingresa tu NIP:</label>
            </div>

            <input type="submit" value="Realizar retiro" class="btn-solid-sm">
        </form>

    </div>
    </body>
</HTML>

<!-- 
<label for="dinero">Cantidad para retirar: </label><br>
            <input type="number" name="dinero" id="dinero"><br>
            <label for="nip">Ingresa tu NIP: </label><br>
            <input type="text" id="nip" name="nip"><br>
            <input type="submit" value="Realizar retiro"> -->