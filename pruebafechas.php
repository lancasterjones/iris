<?php

$year = 2015;
$semana = 2;
$inicio_semana = new DateTime();
$inicio_semana->setISODate($year,$semana);
echo "Mes: " . $inicio_semana->format('M');

?>