<?php
	function crearPeriodos()
		{
			$mes_actual = date('m');
			$year       = date('Y');
			$ultimoRegistro = $year - 1;

			for($x = $mes_actual; $x >= 1; $x--)
			{				
				echo "<option value='" . $year . $x . "'>" .  $year . $x . "</option>";
				if($x == 1)
				{
					for($x = 12; $x >= $mes_actual; $x--)
					{
						$periodo =  $ultimoRegistro . $x ;
						echo "<option value='" . $periodo . "'>" . $periodo . "</option>";
					}
					break;
				}
			}
			
		}
?>
<div class="container-fluid" style="border-top-style: solid; border-color: #E7E7E6; border-width: 3px;">
	<legend>Asignar métricas a Vista-Cliente</legend>

		<div class="row form-group">
			<label class="col-md-offset-2 col-md-2 control-label">Seleccionar cliente: </label>
			<div class="col-md-4 ">
				<select class="form-control" id="select_cte_metricas">
					<option></option>
					<option>LOB</option>
					<option>TECNOLITE</option>
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
				<button id="btn-metricas" class="btn btn-success" onclick="guardarConfiguracion();">
					Guardar <i class="fa" style="margin-left: 1 %;" id="icono_btn_metri"></i>
				</button>
			</div>
		</div>
</div>

<script>
	traerMetricas();
</script>