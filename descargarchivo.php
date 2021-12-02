<?php
  header("Content-disposition: attachment; filename=historia_de_los_sumerios.pdf");
  header("Content-type: application/pdf");
  readfile("historia_de_los_sumerios.pdf");
?>