<?php
	include 'http://iris.vende.io/classes/class_slider.php';
	if((include 'http://iris.vende.io/classes/class_slider.php') == 'OK')
	{
		echo "Archivo cargado";
	}
	$main = new slider();
	$main->crearSlider();
?>