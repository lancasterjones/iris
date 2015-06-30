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

	 function periodoActual()
    {
        $meses = array("Enero", "Febrero", "Marzo", "Abril", 
            "Mayo", "Junio", "Julio", "Agosto", "Septiembre", 
                        "Octubre", "Noviembre", "Diciembre");

        $fecha = $meses[$GLOBALS['mes_actual']-1] . " " . $GLOBALS['current_year'];
        echo $fecha;
    }

	//conexión a base de datos
	$servidor = "104.236.137.39";
	$db_name  = "admin_sistemaproductos";
	$usuario  = "admin_fotos";
	$pass     = "9Fdvi3D4LR";

	$conect = new mysqli($servidor, $usuario, $pass, $db_name)
			  or die("Imposible conectar a DB");

	//crear consulta

?>

<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-heading">
			<legend class="panel-title"><?php periodoActual(); ?></legend>
		</div>
		<div class="panel-body">
			<table class="table table-hover">
				<tbody>
					<tr>
						<td>
							<i class="fa fa-users" style="color: #ff9900; font-size: 25px;"></i>
							<h4>N° de visitantes</h4>
						</td>
						<td>
							<h4></h4>
						</td>
					</tr>
					<tr>
						<td>
							<i class="fa fa-smile-o" style="color: #ff9900; font-size: 25px;"></i>
							<h4>% de conversión</h4>
						</td>
						<td>
							<h4>3%</h4>
						</td>
					</tr>
					<tr>
						<td>
							<i class="fa fa-money" style="color: #ff9900; font-size: 25px;"></i>
							<h4>Ticket promedio</h4>
						</td>
						<td>
							<h4>$3,598.60</h4>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>