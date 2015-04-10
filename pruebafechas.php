<?php

$year = 2015;
$semana = 11;
$inicio_semana = new DateTime();
$inicio_semana->setISODate($year,$semana);
echo $inicio_semana->format('d-M-Y');


?>