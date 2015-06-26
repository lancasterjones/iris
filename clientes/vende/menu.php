<?php
	function registroMeses()
	{
		$mes_actual = date('n') - 1;
		$year       = date('Y');
		$ultimoRegistro = $year - 1;
		
		$spanish = array("Enero", "Febrero", "Marzo", "Abril", 
						 "Mayo", "Junio", "Julio", "Agosto", 
						 "Septiembre", "Octubre", "Noviembre", 
						 "Diciembre");

		for($x = $mes_actual; $x >= 0; $x--)
		{	
			$mes = $x + 1;
			echo "<li><a href='?m=" . $mes . "&y=" . $year ."';>" .
							    $spanish[$x] . " " . $year . "</li></a>";
			if($x == 0)
			{
				for($x = 11; $x >= $mes_actual; $x--)
				{
					$mes = $x + 1;
					echo "<li><a href='?m=" . $mes . "&y=" . $ultimoRegistro ."';>" . 
					$spanish[$x] . " " . $ultimoRegistro . "</li></a>";
				}
				break;
			}
		}
		
	}

	$mes  = date('n');
	$year = date('Y'); 
	$link = "board.php?m=" . $mes . "&y=" . $year;
?>
<nav class="navbar navbar-inverse sidebar" role="navigation">
    <div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Iris</a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a <?php 
						echo 'href="administrador.php"'; 
				

				?>   >Inicio<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-home"></span></a></li>
			<?php if($cliente == "Vende") {?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Clientes 
						<span class="caret"></span> 
						<span style="font-size: 16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-th"></span>
					</a>
					<ul class="dropdown-menu forAnimate" role="menu">
						<li><a href="reporte_mensual.php">Lob</a></li>
						<li><a href="reporte_mensual.php">Tecno lite</a></li>
					</ul>
				</li>
			<?php } // cierre if validar usuario vende?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						Meses <span class="caret"></span>
						<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-calendar"></span>
					</a>
					<ul class="dropdown-menu forAnimate" role="menu">				
						<?php registroMeses(); ?>					
					</ul>
				</li>
				<li>
					<a href="register.php" id="registrar">
						Registrar<i id="icon_reg" style="font-size: 16px;" class="glyphicon glyphicon-pencil hidden-xs pull-right"></i>
					</a>
				</li>		
				<li>
					<a href="#" id="anc_act" onclick="actualizar();">
						Sincronizar<i id="icon_act" style="font-size: 16px;" class="glyphicon glyphicon-refresh hidden-xs pull-right"></i>
					</a>
				</li>
				<li>
					<a href="index.php?logout">
						Salir <i class="glyphicon glyphicon-log-out hidden-xs pull-right"></i>
					</a>
				</li>
			</ul>
		</div>
	</div>
</nav>

<script>
	function actualizar(){
		$.get("includes/actualizar_bd.php");
		$('#icon_act').remove();
		$('#anc_act').append('<i id="icon_nvo" style="font-size: 16px;" class="glyphicon glyphicon-ok hidden-xs pull-right"></i>');
		return false;
	}
</script>