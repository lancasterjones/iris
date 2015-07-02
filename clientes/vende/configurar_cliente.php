<?php
	//conexión a bd

	$server_vende  = "104.236.137.39";
	$usuario_vende = "admin_fotos";
	$pass_vende    = "9Fdvi3D4LR";
	$db_name_vende = "admin_sistemaproductos";

	$con_vende = new mysqli($server_vende, $usuario_vende, $pass_vende, $db_name_vende)
						or die("Error " . mysqli_error($con_tecnolite));

	$consulta = mysqli_query($con_vende, "SELECT sistema_multicliente.cliente
						    FROM admin_sistemaproductos.sistema_multicliente sistema_multicliente
							GROUP BY sistema_multicliente.cliente");

?>

<div class="container-fluid" style="border-top-style: solid; border-color: #E7E7E6; border-width: 3px;">
	<legend>Configurar Vista de Cliente</legend>

		<div class="row form-group">
			<label class="col-md-offset-2 col-md-2 control-label">Seleccionar cliente: </label>
			<div class="col-md-4 ">
				<select class="form-control" id="select_cliente">
					<option></option>

					<?php
						while($row = mysqli_fetch_array($consulta))
							{
								if($row['cliente'] != 'VENDE')
									echo "<option>" . $row['cliente'] . "</option>";
							}
					?>

				</select>
			</div>
		</div>

		<div class="row form-group">
			<label class="col-md-offset-2 col-md-2 control-label">Registrar nuevo: </label>
			<div class="col-md-4">
				<input id="nuevo_cliente" type="text" class="form-control" placeholder="Sólo mayúsculas">
			</div>
		</div>

		<div class="row form-group">
			<label class="col-md-offset-2 col-md-2 control-label">Logo: </label>
			<div class="col-md-4">
				<input id="configurar_logo" type="text" class="form-control" placeholder="url">
			</div>
		</div>

		<div class="row form-group">
			<label class="col-md-offset-2 col-md-2 control-label">Fotos: </label>
			<div class="col-md-4">
				<input id="configurar_foto" type="text" class="form-control" placeholder="url">
			</div>
		</div>

		<div class="row form-group">
			<label class="col-md-offset-2 col-md-2 control-label">Color-pedidos: </label>
			<div class="col-md-4">
				<input id="configurar_pedidos" type="text" class="form-control" placeholder="#xxxxxx">
			</div>
			<div class="col-md-1" id="muestra_pedidos" style="width: 45px;"></div>
		</div>

		<div class="row form-group">
			<label class="col-md-offset-2 col-md-2 control-label">Color-fraudes: </label>
			<div class="col-md-4">
				<input id="configurar_fraudes" type="text" class="form-control" placeholder="#xxxxxx">
			</div>
			<div class="col-md-1" id="muestra_fraudes" style="width: 45px;"></div>
		</div>

		<div class="row form-group">
			<label class="col-md-offset-2 col-md-2 control-label">Color-ventas: </label>
			<div class="col-md-4">
				<input id="configurar_venta" type="text" class="form-control" placeholder="#xxxxxx">
			</div>
			<div class="col-md-1" id="muestra_ventas" style="width: 45px;"></div>
		</div>

		<div class="row form-group">
			<div class="col-md-offset-5">
				<button id="btn-configuracion" class="btn btn-success" onclick="guardarConfiguracion();">
					Guardar <i class="fa" style="margin-left: 1 %;" id="icono_btn_conf"></i>
				</button>
			</div>
		</div>
</div>

<script>
	deslizar();
	traerConfiguracion();
</script>