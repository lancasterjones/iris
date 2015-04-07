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

        <!-- login form box -->
        <form class="form-horizontal" method="post" action="index.php" role="form" name="loginform">
            <!--Input ingresar usuario-->
            <div class='form-group'>
                <label class="control-label col-sm-5" for="login_input_username">Usuario: </label>
                <div class="col-sm-4">
                    <input placeholder="Usuario" id="login_input_username" class="form-control" type="text" name="user_name" required />
                </div>
            </div>

            <!--Input ingresar contraseña-->
            <div class='form-group'>
                <label class="control-label col-sm-5" for="login_input_password">Contraseña: </label>
                <div class="col-sm-4">
                    <input id="login_input_password" class="form-control" type="password" name="user_password" placeholder="Password" autocomplete="off" required />
                </div>
            </div>

            <!--boton ingresar-->
            <div align="center" style="max-width: 200px;">                
                <button class="btn btn-success btn-block" name="login"> Ingresar
                <span class="glyphicon glyphicon-lock"></span></button>
            </div>
            </br>
            <hr>

        </form>
    </body>
</html>

