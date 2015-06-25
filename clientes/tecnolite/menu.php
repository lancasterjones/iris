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
?>

<div class="container-fluid">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="board.php">Iris</a>
	</div>
	<div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
		<ul class="nav navbar-nav">
			<li>
				<a href="board.php">
					Inicio<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-home"></span>
				</a>
			</li>
		
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					Otros Meses <span class="caret"></span>
						<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-calendar"></span>
				</a>
				<ul class="dropdown-menu forAnimate" role="menu">				
					<?php registroMeses(); ?>					
				</ul>
			</li>	

			<li >
				<a style="cursor: not-allowed;" href="#">
					Categorías
					<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicons-pie-chart">
						<i class="fa fa-pie-chart"></i>
					</span>
				</a>
			</li>		
			<li >
				<a id="menu_vendidos" href="#">
					Los Más Vendidos<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-star-empty"></span>
				</a>
			</li>
			<li >
				<a id="menu_vistos" href="#">
					Los Más Vistos<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-star"></span>
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

<script>
	deslizar();
</script>