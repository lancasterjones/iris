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

<div class="container" align="center">

    <!-- register form -->
    <form method="post" action="register.php" class="form-horizontal" role="form" name="registerform">
        <div class='form-group'>
            <!-- the user name input field uses a HTML5 pattern check -->
            <label class="control-label col-sm-5" for="login_input_username">Usuario: </label>
            <input id="login_input_username" class="form-control" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />
        </div>

        <div class='form-group'>
            <!-- the email input field uses a HTML5 email type check -->
            <label class="control-label col-sm-5" for="login_input_email">Compañía</label>
            <input id="login_input_email" class="form-control" type="tet" name="user_email" required />
        </div>
        <div class='form-group'>
            <label class="control-label col-sm-5" for="login_input_password_new">Contraseña: (min. 6 characters)</label>
            <input id="login_input_password_new" class="form-control" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />
        </div>
        <div class='form-group'>
            <label class="control-label col-sm-5" for="login_input_password_repeat">Repetir Contraseña: </label>
            <input id="login_input_password_repeat" class="form-control" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
            <input type="submit"  name="register" value="Register" />
        </div>

    </form>

    <!-- backlink -->
    <a href="index.php">Back to Login Page</a>      
</div>
