<?php

    //Script de seguridad
     $debug = 0;
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

    $login = new Login();

    // ... ask if we are logged in here:
    if ($login->isUserLoggedIn() == false) {
       echo "
          <script>
              location.href='index.php';
          </script>
       ";

    } 



  include 'includes/head.php';
        

// show potential errors / feedback (from registration object)
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo $error;
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo $message;
        }
    }
}
?>

<div class="container" style="width: 50%;">
    <!-- register form -->
    <form method="post" action="register.php" class="form-horizontal" role="form" name="registerform">
        <fieldset>
            <legend>Registro de nuevos usuarios</legend>
            <div class='form-group'>
                <!-- the user name input field uses a HTML5 pattern check -->
                <label class="col-lg-2 control-label" for="login_input_username">Usuario: </label>
                <div class="col-lg-6">
                    <input id="login_input_username" class="form-control" type="text" name="user_name" required />
                </div>
            </div>

            <div class='form-group'>
                <!-- the email input field uses a HTML5 email type check -->
                <label class="col-lg-2 control-label" for="login_input_email">Compañía: </label>
                <div class="col-lg-6">
                     <input id="login_input_email" class="form-control" type="text" name="user_email" required />
                </div>
            </div>
            <div class='form-group'>
                <label class="col-lg-2 control-label" for="login_input_password_new">Contraseña: </label>
                <div class="col-lg-6">
                    <input id="login_input_password_new" class="form-control" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />
                </div>
            </div>
            <div class='form-group'>
                <label class="col-lg-2 control-label" for="login_input_password_repeat">Repetir Contraseña: </label>
                <div class="col-lg-6">
                    <input id="login_input_password_repeat" class="form-control" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
                </div>
            </div>
            <div class="form-group">
              <div class="col-lg-6 col-lg-offset-2">
                <!-- Link para volver -->     
                <ul class="pager">
                  <li><a href="index.php">Regresar</a></li>
                </ul> 
                <input type="submit"  class="btn btn-success pull-right" name="register" value="Registrar" />
              </div>
            </div>
        </fieldset>
    </form>
</div>
