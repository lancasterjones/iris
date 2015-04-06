<?php
	//se inicia sesión
	session_start();
?>
<!DOCTYPE html>
<html lang='es'>
	<head>
		<title>Bienvenido || LOB</title>
		<?php 
			  include 'includes/head.php';
		?>     
	</head>
	<body>
		<div id="divForm" align="center" class='container'>
			<div class="container">
				</br></br></br>
				<img class="pull-left" src="includes/vende.png">
				<div class="pull-right"><h2>IRIS</h2></div>
				<h1>Bienvenido</h1>	</br>
				<h4>Ingresa tu usuario y contraseña para poder acceder a la aplicación.</h4>			
			</div>
			</br><hr></br>

			<form action="validacion.php" method="post" class="form-horizontal" role='form'>
				<!--Formulario para usuario-->
				<div class='form-group'>
				    <label class="control-label col-sm-5" for="usuario">Usuario:</label>
				    <div class="col-sm-4">			    
				    	<input class="form-control" name="usuario" type="text" id="usuario" placeholder="Usuario">    
				    </div>
			  	</div>	
			  	<!--Formulario para contraseña-->
			  	<div class="form-group">			
					<label class="control-label col-sm-5" for="password">Contraseña:</label>
					<div class="col-sm-4">
				    	<input class="form-control" name="pas" type="password" id="password" placeholder="Password">
				    </div>				    
				</div></br>
				<!--Botón ingresar-->
				<div style="max-width: 200px;">
					<button ="ingresar" class="btn btn-success btn-block">
					<span class="glyphicon glyphicon-lock"></span>  Ingresar
					</button>
				</div>
					<hr>
			</form>	
			</div>
		</div>
		
	</body>
</html>
