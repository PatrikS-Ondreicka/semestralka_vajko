<?php

/** @var Array $data */
/** @var \App\Core\LinkGenerator $link */
?>

<form>
    <div class="container login_container col-lg-6 col-sm-12">
        <div class="form-group">
            <label for="login_text_form">User Login</label>
            <input class="form-control" type="text" id="login_text_form" name="login_text_form" required>
        </div>
        <div class="form-group">
            <label for="login_pass_form">User Password</label>
            <input class="form-control" type="password" id="login_pass_form" name="login_pass_form" required>
        </div>
        <div class="form-group col-lg-4 col-sm-12">
            <input class="form-control" type="submit" value="Login">
        </div>
    </div>
</form>
