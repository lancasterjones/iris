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
    $cliente = $_SESSION['user_email'];
    $current_year   = $_REQUEST['year'];
    $mes_actual     = $_REQUEST['mes'];

    function periodoActual()
        {
            $meses = array("Enero", "Febrero", "Marzo", "Abril", 
                "Mayo", "Junio", "Julio", "Agosto", "Septiembre", 
                            "Octubre", "Noviembre", "Diciembre");

            $fecha = $meses[$GLOBALS['mes_actual']-1] . " " . $GLOBALS['current_year'];
            echo $fecha;
        }

  
?>


<div class="col-sm-2">
		<legend> 
            <?php periodoActual(); ?>
        </legend>
</div>