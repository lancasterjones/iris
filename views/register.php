<?php


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
                <label class="control-label col-sm-5" for="login_input_email">Compañía</label>
                <input id="login_input_email" class="form-control" type="text" name="user_email" required />
            </div>
            <div class='form-group'>
                <label class="control-label col-sm-5" for="login_input_password_new">Contraseña: </label>
                <input id="login_input_password_new" class="form-control" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />
            </div>
            <div class='form-group'>
                <label class="control-label col-sm-5" for="login_input_password_repeat">Repetir Contraseña: </label>
                <input id="login_input_password_repeat" class="form-control" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
                <input type="submit"  class="btn btn-success" name="register" value="Registrar" />
            </div>
        </fieldset>
    </form>

    <!-- Link para volver -->     
    <ul class="pager">
      <li><a href="index.php">Regresar</a></li>
    </ul> 
</div>
