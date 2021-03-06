<?php
	//conexión a bd

	$server_vende  = "104.236.137.39";
	$usuario_vende = "admin_fotos";
	$pass_vende    = "9Fdvi3D4LR";
	$db_name_vende = "admin_sistemaproductos";

	$con_vende = new mysqli($server_vende, $usuario_vende, $pass_vende, $db_name_vende)
						or die("Error " . mysqli_error($con_tecnolite));

	$consulta = mysqli_query($con_vende, "SELECT metricas.cliente
						    FROM admin_sistemaproductos.metricas metricas
							GROUP BY metricas.cliente");

	function crearPeriodos()
		{
			$mes_actual = date('n');
			$year       = date('Y');
			$ultimoRegistro = $year - 1;
			$meses = array("","Enero", "Febrero", "Marzo", "Abril", 
						 "Mayo", "Junio", "Julio", "Agosto", 
						 "Septiembre", "Octubre", "Noviembre", 
						 "Diciembre");


			for($x = $mes_actual; $x >= 1; $x--)
			{		
				if($x < 10) $periodo = $year . "0" . $x;
				$fecha = $meses[$x] . " " . $year;

				echo "<option value='" . $periodo . "'>" .  $fecha  . "</option>";
				if($x == 1)
				{
					for($x = 12; $x >= $mes_actual; $x--)
					{
						if($x < 10) $periodo = $ultimoRegistro . "0" . $x;
						$fecha = $meses[$x] . " " . $ultimoRegistro;

						echo "<option value='" . $periodo . "'>" . $fecha . "</option>";
					}
					break;
				}
			}
			
		}
?>
<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-heading">	
			<legend class="panel-title">Asignar métricas a Vista-Cliente</legend>
	    </div>

	    <div class="panel-body">
			<div class="row form-group">
				<label class="col-md-offset-2 col-md-2 control-label">Seleccionar cliente: </label>
				<div class="col-md-4 ">
					<select class="form-control" id="select_cte_metricas">
						<option></option>

						<?php
							while($row = mysqli_fetch_array($consulta))
								{
									echo "<option>" . $row['cliente'] . "</option>";
								}
						?>

					</select>
				</div>
			</div>

			<div class="row form-group">
				<label class="col-md-offset-2 col-md-2 control-label">Seleccionar periodo: </label>
				<div class="col-md-4 ">
					<select class="form-control" id="select_periodo">
						<option></option>
						<?php crearPeriodos(); ?>
					</select>
				</div>
			</div>

			<div class="row form-group">
				<label class="col-md-offset-2 col-md-2 control-label">Registrar cliente: </label>
				<div class="col-md-4">
					<input id="configurar_metricas_cliente" type="text" class="form-control" placeholder="Sólo mayúsculas">
				</div>
			</div>

			<div class="row form-group">
				<label class="col-md-offset-2 col-md-2 control-label">Visitas: </label>
				<div class="col-md-4">
					<input id="configurar_visitas" type="text" class="form-control">
				</div>
			</div>

			<div class="row form-group">
				<label class="col-md-offset-2 col-md-2 control-label">Conversión: </label>
				<div class="col-md-4">
					<input id="configurar_conversion" type="text" class="form-control">
				</div>
			</div>

			<div class="row form-group">
				<label class="col-md-offset-2 col-md-2 control-label">Ticket Promedio: </label>
				<div class="col-md-4">
					<input id="configurar_ticket" type="text" class="form-control">
				</div>
			</div>


			<div class="row form-group">
				<div class="col-md-offset-5">
					<button id="btn-metricas" class="btn btn-success" onclick="guardarMetricas();">
						Guardar <i class="fa" style="margin-left: 1 %;" id="icono_btn_metri"></i>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	traerMetricas();
</script>