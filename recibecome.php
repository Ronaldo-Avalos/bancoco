<?php 
session_start();

include 'lib_php/conection.php';
$db = mysqli_select_db($con,'tektorco_bancocodb');

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$asunto =$_POST['asunto'];
$mensaje =$_POST['mensaje'];
  
  //verificamos los campos
  $valida = true;
  if (empty($_POST['nombre'])) {
    echo "<b>No se especifico nombre</b><br/>";
    $valida = false;
  }
  if (empty($_POST['email'])) {
   echo "<b>No se especifico E - mail</b><br/>"; 
   $valida = false; 
  }
 if (empty($_POST['asunto'])) {
   echo "<b>No se especifico asunto</b><br/>"; 
   $valida = false; 
  }
  if (empty($_POST['mensaje'])) {
   echo "<b>Por favor, no envie un mensaje en blanco</b><br/>";
   $valida = false;
  }

  // Validamos la direccion de correo electronico
  if (!strchr($_POST['email'],"@") || !strchr($_POST['email'],"."))
   {
    echo "<b>No es un correo valido</b><br/>";
    $valida = false;
   }

  // Si las comprobaciones son correctas
  if ($valida == true)
   {
    $date = date("d-m-Y H:i:s");
    $sql = mysqli_query($con, "INSERT INTO servico_cliente (nombre, email, asunto, mensaje, fecha y hora) VALUE ('$nombre','$email','$asunto','$mensaje','$date')");
    
    if (! $sql) {
 
     echo "Error con el sql";
   }
 else{
  header('location: index.php'); 
 }
    
   }
  
