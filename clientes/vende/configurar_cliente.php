<div class="container-fluid" style="border-top-style: solid; border-color: #E7E7E6; border-width: 3px;">
	<legend>Configurar Vista de Cliente</legend>
	<form>
		<div class="row form-group">
			<label class="col-md-offset-3 col-md-2 control-label">Seleccionar cliente: </label>
			<div class="col-md-4 ">
				<select class="form-control" id="select_cliente">
					<option></option>
					<option>LOB</option>
					<option>TECNOLITE</option>
				</select>
			</div>
		</div>

		<div class="row form-group">
			<label class="col-md-offset-3 col-md-2 control-label">Logo: </label>
			<div class="col-md-4">
				<input id="configurar_logo" type="text" class="form-control" placeholder="url">
			</div>
		</div>

		<div class="row form-group">
			<label class="col-md-offset-3 col-md-2 control-label">Fotos: </label>
			<div class="col-md-4">
				<input id="configurar_foto" type="text" class="form-control" placeholder="url">
			</div>
		</div>

		<div class="row form-group">
			<label class="col-md-offset-3 col-md-2 control-label">Color-pedidos: </label>
			<div class="col-md-4">
				<input id="configurar_pedidos" type="text" class="form-control" placeholder="#xxxxxx">
			</div>
		</div>

		<div class="row form-group">
			<label class="col-md-offset-3 col-md-2 control-label">Color-fraudes: </label>
			<div class="col-md-4">
				<input id="configurar_fraudes" type="text" class="form-control" placeholder="#xxxxxx">
			</div>
		</div>

		<div class="row form-group">
			<label class="col-md-offset-3 col-md-2 control-label">Color-ventas: </label>
			<div class="col-md-4">
				<input id="configurar_venta" type="text" class="form-control" placeholder="#xxxxxx">
			</div>
		</div>

		<div class="row form-group">
			<div class="col-md-offset-5">
				<button class="btn btn-success">Guardar</button>
			</div>
		</div>
	</form>
</div>

<script>
	deslizar();
	traerConfiguracion();
</script>