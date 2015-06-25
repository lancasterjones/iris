<!DOCTYPE html>
<html>
    <head>
        <?php include 'includes/head.php'; ?>
    </head>
    <body>


        <?php
        // show potential errors / feedback (from login object)
        if (isset($login)) {
            if ($login->errors) {
                foreach ($login->errors as $error) {
                    echo $error;
                }
            }
            if ($login->messages) {
                foreach ($login->messages as $message) {
                    echo $message;
                }
            }
        }
        ?>
        
        <div class="container-fluid">
            <div class="col-md-offset-3 col-md-6">
                <div class="jumbotron">
                    <div class="row" style="margin-top: 1%;">
                        <div class="pull-right">
                            <img src="includes/vende.png">
                        </div>
                    </div>
                    <form class="form-horizontal" method="post" action="index.php" role="form" name="loginform">
                        <div class="row">
                            <!--Input ingresar usuario-->
                            <div class='form-group'>
                                <label class="col-md-offset-3 col-md-2 control-label " for="login_input_username">
                                    Usuario: 
                                </label>
                                <div class="col-md-5">
                                    <input placeholder="Usuario" id="login_input_username" class="form-control" type="text" name="user_name" required />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!--Input ingresar contraseña-->
                            <div class='form-group'>
                                <label class="col-md-offset-3 col-md-2 control-label" for="login_input_password">
                                    Contraseña: 
                                </label>
                                <div class="col-md-5">
                                    <input id="login_input_password" class="form-control" type="password" name="user_password" placeholder="Password" autocomplete="off" required />
                                </div>
                            </div>
                        </div>

                        <!--boton ingresar-->
                        <div class="col-md-offset-4 col-md-4" style="margin-bottom: 1%;">
                            <button class="btn btn-success btn-block" name="login"> 
                                Ingresar<span style="margin-left: 2%;" class="glyphicon glyphicon-lock"></span>
                            </button>
                        </div> 
                    </form>
                </div>  <!--jumbotron-->  
            </div>      
        </div>
    </body>
</html>

