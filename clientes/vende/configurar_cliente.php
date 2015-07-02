<div class="container-fluid" style="border-top-style: solid; border-color: #E7E7E6; border-width: 3px;">
	<legend>Configurar Vista de Cliente</legend>

		<div class="row form-group">
			<label class="col-md-offset-2 col-md-2 control-label">Seleccionar cliente: </label>
			<div class="col-md-4 ">
				<select class="form-control" id="select_cliente">
					<option></option>
					<option>LOB</option>
					<option>TECNOLITE</option>
				</select>
			</div>
		</div>

		<div class="row form-group">
			<label class="col-md-offset-2 col-md-2 control-label">Registrar nuevo: </label>
			<div class="col-md-4">
				<input id="nuevo_cliente" type="text" class="form-control">
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