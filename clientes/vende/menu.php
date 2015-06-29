<?php
	ini_set('display_errors', 'On');
    error_reporting(E_ALL);

	require_once("../../config/db.php");
    require_once("../../classes/Login.php");
    $login = new Login();

		if ($login->isUserLoggedIn() == false) 
		{
			echo "<script>
		        location.href='index.php';
		        </script>";
		}

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
	$cliente = $_SESSION['user_email'];
	$link = "administrador.php?m=" . $mes . "&y=" . $year . "&c=" . $cliente;

	$url = $_SERVER['REQUEST_URI'];
	$host = $_SERVER['HTTP_HOST'];
?>
<nav class="navbar navbar-inverse sidebar" role="navigation">
    <div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Iris</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li>
					<a href='<?php echo $link; ?>'>
						Inicio
						<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-home"></span>
					</a>
				</li>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						Clientes 
						<span class="caret"></span> 
						<span style="font-size: 16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-th"></span>
					</a>
					<ul class="dropdown-menu forAnimate" role="menu">
						<li>
							<a href="<?php echo "vista_cliente.php?m=" . $mes . "&y=" . $year . "&c=LOB";?>" onclick="console.log($this.html());">
								Lob
							</a>
						</li>
						<li>
							<a href="<?php echo "vista_cliente.php?m=" . $mes . "&y=" . $year . "&c=TECNOLITE";?>">
								Tecno lite
							</a>
						</li>
					</ul>
				</li>
			
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

	console.log("<?php echo $url; ?>");
	console.log("<?php echo $host; ?>");

</script>