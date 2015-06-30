<?php
	require_once("../../config/db.php");
    require_once("../../classes/Login.php");
    $login = new Login();

      if ($login->isUserLoggedIn() == false) 
      {
         echo "<script>
                location.href='index.php';
              </script>";

      } 

    $cliente = $_SESSION['user_email'];
	//recolectar variables
	$mes  = $_REQUEST['mes'];
	$year = $_REQUEST['year'];

	if($mes < 10) $fecha = $year . "0" . $mes;
	else $fecha = $year . $mes;

	//conexión a base de datos
	$servidor = "104.236.137.39";
	$db_name  = "admin_sistemaproductos";
	$usuario  = "admin_fotos";
	$pass     = "9Fdvi3D4LR";

	$conect = new mysqli($servidor, $usuario, $pass, $db_name)
			  or die("Imposible conectar a DB");

	//crear consulta

	$query_info    = "SELECT * FROM metricas 
						WHERE cliente = '$cliente' AND fecha = $fecha";
	$consulta_info = mysqli_query($conect, $query_info);
	while($row_info = mysqli_fetch_array($consulta_info))
	{
		$visitas    = $row_info['visitas'];
		$conversion = $row_info['conversion'];
		$ticket     = $row_info['ticket'];
	}

?>

<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-heading">
			<legend class="panel-title"></legend>
		</div>
		<div class="panel-body">
			<table class="table table-hover">
				<tbody>
					<tr>
						<td>
							<i class="fa fa-users" style="color: #ff9900; font-size: 25px;"></i>
							<h5>N° de visitantes</h5>
						</td>
						<td>
							<h4><?php echo $visitas; ?></h4>
						</td>
					</tr>
					<tr>
						<td>
							<i class="fa fa-smile-o" style="color: #ff9900; font-size: 25px;"></i>
							<h5>% de conversión</h5>
						</td>
						<td>
							<h4><?php echo $conversion; ?>%</h4>
						</td>
					</tr>
					<tr>
						<td>
							<i class="fa fa-money" style="color: #ff9900; font-size: 25px;"></i>
							<h5>Ticket promedio</h5>
						</td>
						<td>
							<h4>$<?php echo $ticket; ?></h4>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>