<?php echo '
		<nav class="navbar navbar-inverse">
	    <div class="container-fluid">
	      <div class="navbar-header">
	        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
	          <span class="sr-only">Toggle navigation</span>
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	        </button>
	        <a class="navbar-brand" href="#">Iris</a>
	      </div>

	      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
	        <ul class="nav navbar-nav">
	          <li class="active"><a href="#">Inicio <span class="sr-only">(current)</span></a></li>
	          <!--<li><a href="#">KPIs</a></li>-->
	          <li class="dropdown">
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Reportes Semanales <span class="caret"></span></a>
	            <ul class="dropdown-menu" role="menu">
	              <li><a href="reportebasico.php">Última Semana</a></li>
	              <li class="divider"></li>
	              <li><a href="reportes_anteriores.php">Anteriores</a></li>
	            </ul>
	          </li>
	        </ul>
	        <!--<form class="navbar-form navbar-left" role="search">
	          <div class="form-group">
	            <input type="text" class="form-control" placeholder="Buscar en sitio...">
	          </div>
	          <button type="submit" class="btn btn-default">Buscar</button>-->
	        </form>
	        <ul class="nav navbar-nav navbar-right">
	          <li><a href="index.php?logout">Logout</a></li>
	          <li><a href="http://www.vende.io">Vende.io</a></li>
	        </ul>
	      </div>
	    </div>
	  </nav>';

?>