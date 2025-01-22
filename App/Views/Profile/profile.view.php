<?php

/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */
/** @var \App\Core\IAuthenticator $auth */

use App\Models\User;

$user_id = $data['user_id'];
$username = $data['username'];
$profile = $data['profile'];

session_start();
?>

<div class="container profile-container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="profile-header">
                <img src="https://via.placeholder.com/150" alt="Profile Picture" class="profile-image">
                <h2><?= $username ?></h2>
            </div>
            <div class="profile-info">
                <p><strong>Description: </strong><?= $profile->getDescription() ?></p>
                <p><strong>Account Created: </strong><?= (new DateTime($profile->getDateCreated()))->format('Y-m-d H:i:s'); ?></p>
            </div>
            <?php
                if ($user_id == $auth->getLoggedUserId())
                {
                    $edit_link = $link->url("profile.editProfile", ['user_id' => $user_id]);
                    echo    '<li class="nav_item">'.
                            '<a href='.$edit_link.'>Edit</a>'.
                            '</li>';
                }
            ?>
            <a href="<?= $link->url("profile.profileData", ['user_id' => $user_id])?>">User data</a>
        </div>
    </div>
</div>

