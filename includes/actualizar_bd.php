<?php
	//conectar con magento
		include 'includes/db_magento_connect.php';
	//traer información
		include "includes/querymasvendidos.php";
		$result = mysqli_query($connm,$query);		

	//almacenar esa info en arreglo

	//imprimir esa información
		print_r($result)

	//conectar bd vende

	//llenar tabla vende con arreglo
	
?>