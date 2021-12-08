<?php
    //header('refresh:5, url=');

    $unico = false;
    $numero = 0;

    while ($unico == false){
        $numero = random_int(100000000,999999999);
        $numero = "4976109".$numero;
        
        $unico = true;
    }

    echo $numero;
