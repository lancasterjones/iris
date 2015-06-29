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
    
    $con_logo   = new mysqli("104.236.137.39","admin_fotos","9Fdvi3D4LR","admin_sistemaproductos");
    $query_logo = "SELECT url_logo FROM sistema_multicliente WHERE cliente = 'VENDE'";
    $consulta_logo = mysqli_query($con_logo, $query_logo);
    while($row = mysqli_fetch_array()){
        $logo = $row['url_logo'];
    }
?>


<div class="col-sm-2">
		<img src="<?php echo $logo; ?>" style="width: 8em;">
</div>