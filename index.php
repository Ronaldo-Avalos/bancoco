<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">

    <title>Bancoco</title>
    
    <!-- styles -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/fontawesome-all.min.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	
</head>
<body data-bs-spy="scroll" data-bs-target="#navbarExample">
    
    <!-- Nav -->
    <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
        <div class="container">

            <!-- Logo -->
            <a class="navbar-brand logo-image" href="index.php"><img src="images/logo.svg" alt="alternative"></a> 

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav ms-auto navbar-nav-scroll">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#header">Misión </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#vision">Visión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#somos">Quienes somos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sevicios">Servicios</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">Mas...</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown01">
                            <li><a class="dropdown-item" href="#contacto">Servicio al cliente</a></li>
                            <li><div class="dropdown-divider"></div></li>
                            <li><a class="dropdown-item" href="#contacto">Contacto</a></li>
                            <li><div class="dropdown-divider"></div></li>
                            <li><a class="dropdown-item" href="crear_usuario.html">Apertura de cuenta</a></li>
                            <li><div class="dropdown-divider"></div></li>
                            <li><a target="_blank" class="dropdown-item" href="Login/login.php">Estado de cuenta</a></li>
                        </ul>
                    </li>
                </ul>
                <span class="nav-item">
                    <a  target="" class="btn-solid-sm" href="login/login.php">Acceso</a>
                </span>
            </div> 
        </div>
    </nav> <!--Fin de Nav -->
    

      
    <!-- Header -->
            <!--Contador de visitas -->
                 <?php
                            // Archivo en donde se acumula el numero de visitas
                                 $archivo = "contador.txt";
                             // Abrimos el archivo para solamente leerlo (r de read)
                                 $abre = fopen($archivo, "r");
                             // Leemos el contenido del archivo
                                 $total = fread($abre, filesize($archivo));
                            // Cerramos la conexión al archivo
                                fclose($abre);
                            // Abrimos nuevamente el archivo
                                $abre = fopen($archivo, "w");
                            // Sumamos 1 nueva visita
                                 $total = $total + 1;
                            // Y reemplazamos por la nueva cantidad de visitas 
                                $grabar = fwrite($abre, $total);
                            // Cerramos la conexión al archivo
                                fclose($abre);

                    //USUARIOS ACTIVOS
                               // segundos tras los cuales un usuario es marcado como inactivo
                                $tiempo_logout = 600; 
                                $arr = file("usuarios.txt");
                                $contenido = $_SERVER['REMOTE_ADDR'].":".time().""; 
                                for ( $i = 0 ; $i < sizeof($arr) ; $i++ ){
                                            $tmp = explode(":",$arr[$i]);
                                    if (( $tmp[0] != $_SERVER['REMOTE_ADDR'] )  && (( time() - $tmp[1] ) < $tiempo_logout )){
                                            $contenido .= $_SERVER['REMOTE_ADDR']  .":".time()." ";
                                    }
                                }
                              $fp = fopen("usuarios.txt","w");
                                    fputs($fp,$contenido);
                                    fclose($fp);
                             $array = file("usuarios.txt");
                             $USUARIOS_ACTIVOS = count($array); //guardamos numero de usuarios activos
                ?>
    <header id="header" class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-5">
                    <div class="text-container">
                        <h1 class="h1-large">EL BANCO MAS MAMALÓN</h1>
                        <p class="p-large">¡Abre una cuenta bancaria y comienza ya! Administra tus finanzas fácil y rápido</p>
                        <p>Número de visitantes de la pagina: <?php echo $total ?> </p>
                        <p>Usuarios Activos: <?php echo $USUARIOS_ACTIVOS?></p> 
                        <a class="btn-solid-lg" href="crear_usuario.html">Abre tu cuenta </a>
                    </div> 
                </div> 
                   <div class="col-lg-6 col-xl-7">
                    <div class="image-container">
                        <img class="img-fluid" src="images/header-image1.png" alt="alternative">
                    </div>
                </div>
            </div> 
        </div>
    </header> 

        <!-- Descarga -->
        <div class="basic-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-container">
                        <h2>Descarga nuestro informe de proyecto</h2>
                        <p class="p-large">Da clic aquí para descargar nuestro informe en formato PDF y enterarte como se realizó este proyecto.</p>
                        <a class="btn-solid-lg" href="descargarchivo.php">Descargar</a>
                    </div> 
                </div>
            </div> 
        </div> 
    </div> 
   
    <!-- fin de descarga -->



    <!-- Visión-->
    <div id="vision" class="cards-1 bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Visión</h2>
                </div> 
            </div> 
            <div class="row">
                <div class="col-lg-12">
                    
                    <!-- tarjetas 1 -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Responsabilidad</h5>
                            <p>un mejor manejo de tus finanzas desde tu cuenta personal</p>
                        </div>
                    </div>

                    <!-- tarjeta 2-->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Futuro</h5>
                            <p>Un joven que sabe administrar sus finanzas se convierte en un hombre responsable con oportunidades</p>
                        </div>
                    </div>

                    <!-- tarjeta 3 -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Innovación</h5>
                            <p>Somos lideres de innovación que busca ayudar a los jóvenes a tener una educación financiera mejor a través de nuestro sistema bancario.</p>
                        </div>
                    </div>
                </div> 
            </div> 
        </div> 
    </div> 
 
    <!-- Quienes somos -->
    <div id="somos" class="basic-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-7">
                    <div class="image-container">
                        <img class="img-fluid" src="images/details-1.png" alt="alternative">
                    </div> 
                </div> 

                <div class="col-lg-6 col-xl-5">
                    <div class="text-container">
                        <div class="section-title">¿QUIENES SOMOS?</div>
                        <h2>UN BANCO MUY FRESCO MI PANA</h2>
                        <p>Somos una identidad bancaria con potencial de crecimiento en las areas de desarrollo financiero.</p>
                        <a class="btn-solid-reg" href="#">Conocenos más</a>
                    </div> 
                </div> 
            </div> 
        </div> 
    </div><!-- fin de somos-->

    <!-- Servicios -->
    <div id="sevicios" class="accordion-1">
        <div class="container">
            <div class="servi">
                <div>
                    <h2>Servicios</h2>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Administra tu dineero</h5>
                    <p>Crea una cuenta y empieza con tu administración</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Retira cuando quieras</h5>
                    <p>Retira en cual quiera de nuestras sucursales o en cajeros disponibles</p>
                </div>
            </div>

             <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Transfiere el dinero que quieras</h5>
                    <p>Transfiere a las personas que quieras sin comisiones y disfruta de la comodidad de tranferir con un simple toque</p>
                </div>
            </div>

        </div> 
    </div> 
    <!-- fin de servicios -->


    <!-- Contacto -->
    <div id="contacto" class="form-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="text-container">
                        <h2>CONTACTA CON NOSOTROS</h2>
                        <p>Puedes contactarnos llenando este formulario o mandando un correo a <a href="#contacto">Bancocoemail@gmail.com</a></p>
                        <ul class="list-unstyled li-space-lg">
                            <li class="d-flex">
                                <i class="fas fa-square"></i>
                                <div class="flex-grow-1">Haznos alguna pregunta</div>
                            </li>
                            <li class="d-flex">
                                <i class="fas fa-square"></i>
                                <div class="flex-grow-1">Déjanos algún comentario</div>
                            </li>
                            <li class="d-flex">
                                <i class="fas fa-square"></i>
                                <div class="flex-grow-1">Déjanos tus sugerencias </div>
                            </li>
                        </ul>
                    </div>
                </div> 
                <div class="col-lg-6">

                    <!-- Form -->
                    <form name="form1" method="post" action="recibecome.php">
                        <div class="form-group">
                            <input type="text" class="form-control-input" placeholder="Nombre" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control-input" placeholder="Correo" name="email" id="email" required>
                        </div>
                        <div class="form-group">
                        <select name="asunto" size="1" id="asunto" class="form-control-input" >
                                <option selected>Seleccione</option>
                                <option>Pregunta</option>
                                <option>Información</option>
                                <option>Comentario</option>
                                <option>Sugerencia</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <textarea name="mensaje" cols="25" placeholder="Mensaje..." rows="8" class="form-control-input  " id="mensaje" style="background-color: #FFFFFF; border: 1 solid #000000"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control-submit-button">Enviar</button>
                        </div>
                        
                    </form>
                </div> 
            </div> 
        </div> 
    </div>
    
    <!-- Scripts -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/swiper.min.js"></script> 
    <script src="js/scripts.js"></script>
</body>
</html>
