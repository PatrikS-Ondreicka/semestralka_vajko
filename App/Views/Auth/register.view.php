<?php

/** @var \App\Core\LinkGenerator $link */
?>

<form action="<?= $link->url("Auth.registerAction")?>" method="post">
    <div class="container login_container col-lg-6 col-sm-12">
        <div class="form-group">
            <label for="login_text_form">User Login</label>
            <input class="form-control" type="text" id="reg_text_form" name="reg_text_form" required>
        </div>
        <div class="form-group">
            <label for="reg_pass_form">Password</label>
            <input class="form-control" type="password" id="reg_pass_form" name="reg_pass_form" required>
        </div>
        <div class="form-group">
            <label for="reg_conpass_form">Confirm password</label>
            <input class="form-control" type="password" id="reg_conpass_form" name="reg_conpass_form" required>
        </div>
        <div class="form-group col-lg-4 col-sm-12">
            <input class="form-control" type="submit" value="register">
        </div>
    </div>

    <?php
        if (isset($_GET['error']))
        {
            foreach ($_GET['error'] as $error)
            {
                echo '<p class="error">' . $error . '</p>';
            }
        }
    ?>
</form>
