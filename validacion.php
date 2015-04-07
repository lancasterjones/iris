<?php
	session_start();

	//conexión a base de datos de lob

	$db_host = '104.236.137.39';
    $db_usuario = 'admin_fotos';
    $db_password = "9Fdvi3D4LR";
    $db_basedatos = 'admin_sistemaproductos';
    $db_tabla = 'usuarios';

    //request de conexión
    $dblink = mysqli_connect($db_host, $db_usuario, $db_password, $db_basedatos) or die("No puede conectar " . mysql_error());

    //query
    $result = mysqli_query($dblink,"SELECT * FROM ".$db_tabla."");

    //almacenar en variable

    $row = mysqli_fetch_array($result);



    //si los datos del formulario, usuario y contraseña coinciden se da valor true a validacion
    //sino, false y redirecciona a index
	if($_POST['pas'] == $row['psw'] && $_POST['usuario'] == $row['usuario'])
	{
			$_SESSION['validacion'] = TRUE;
			echo "
				<script>
					location.href='reportebasico.php';
				</script>
			";
	
		
	}else
	{	
		$_SESSION['validacion'] = FALSE;
		echo "
			<script>
				alert('Intenta de nuevo por favor.');
				location.href='index.php';
			</script>
		";
	}
	
?>