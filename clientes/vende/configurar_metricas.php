<div class="container-fluid" style="border-top-style: solid; border-color: #E7E7E6; border-width: 3px;">
	<legend>Asignar métricas a Vista-Cliente</legend>

		<div class="row form-group">
			<label class="col-md-offset-2 col-md-2 control-label">Seleccionar periodo: </label>
			<div class="col-md-4 ">
				<select class="form-control" id="select_periodo">
					<option></option>
					<option>Junio 2015</option>
					<option>Julio 2015</option>
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
