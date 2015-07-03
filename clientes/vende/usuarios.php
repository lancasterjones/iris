<?php
	//conexión a base de datos
	$servidor = "104.236.137.39";
	$db_name  = "admin_sistemaproductos";
	$usuario  = "admin_fotos";
	$pass     = "9Fdvi3D4LR";

	$conect = new mysqli($servidor, $usuario, $pass, $db_name)
			  or die("Imposible conectar a DB");

	$query = "SELECT users.user_name AS usuario, 
					 users.user_email AS empresa
  			FROM admin_sistemaproductos.users users";
  	$consulta = mysqli_query($conect, $query);

?>

<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-heading">
			<legend class="panel-title">Accesos</legend>
		</div>
		<div class="panel-body">
			<table class="table table-hover">
				<thead>
					<th>
						<span class="label label-success"> Usuario </span>
					</th>
					<th>
						<span class="label label-success">Compañía </span>
					</th>
				</thead>
				<tbody>

					<?php
						while($row = mysqli_fetch_array($consulta))
							{	
					?>
								<tr>
									<td>
										<h5> <?php echo $row['usuario']; ?> </h5>
									</td>
									<td>
										<h5> <?php echo $row['empresa']; ?> </h5>
									</td>
								</tr>

					<?php
							}
					?>					
				</tbody>
			</table>
		</div>
	</div>
</div>