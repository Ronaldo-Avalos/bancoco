<?php

$con = mysqli_connect("tektor.com.mx","tektorco_usrbank","f!H7#H0yI.vU","tektorco_bancocodb");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Error al conectarse a la base de datos: " . mysqli_connect_error();
  }
mysqli_set_charset($con,"utf8");
?>
	
	