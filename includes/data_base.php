<?php
	$db_host = '104.236.137.39';
    $db_usuario = 'admin_fotos';
    $db_password = "9Fdvi3D4LR";
    $db_basedatos = 'admin_sistemaproductos';
    $db_tabla = 'open_to_sell';
    $nombre_fichero = 'View';
    //conexión a base de datos
    $dblink = mysqli_connect($db_host, $db_usuario, $db_password, $db_basedatos) or die("No puede conectar " . mysql_error());
?>