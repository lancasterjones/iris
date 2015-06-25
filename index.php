<!DOCTYPE html>
<html lang='es'>
	<head>
		<title>.::IRIS::.</title>
		<?php  include 'includes/head.php';	?>     
	</head>
	<body style="background-color: #F5F5F2; ">
		<?php
			if (version_compare(PHP_VERSION, '5.3.7', '<')) {
		    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
		} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
		    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
		    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
		    require_once("libraries/password_compatibility_library.php");
		}

		// include the configs / constants for the database connection
		require_once("config/db.php");

		// load the login class
		require_once("classes/Login.php");

		// create a login object. when this object is created, it will do all login/logout stuff automatically
		// so this single line handles the entire login process. in consequence, you can simply ...
		$login = new Login();

		// ... ask if we are logged in here:
		if ($login->isUserLoggedIn() == true) 
		{
		    $companyName = $_SESSION['user_email'] ;
		    $mes = date('n');

		    switch ($companyName) {
		    	case 'Vende':
		    		echo " <script> location.href='administrador.php';  </script> ";
		    		break;
		    	case 'LOB':
		    		echo " <script> location.href='reporte_mensual.php';  </script> ";
		    		break;
		    	case 'TECNOLITE':
		    		echo " <script> location.href='board.php?mes=<?php $mes; ?>';  </script> ";
		    		break;
		    	default:
		    		echo " <script> alert('error'); </script> ";
		    		break;
		    }
		} 
		else 
		{
		    include("views/not_logged_in.php");
		}
?>
		
	</body>
</html>
