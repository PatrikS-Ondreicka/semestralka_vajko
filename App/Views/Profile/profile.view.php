<?php

/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */
/** @var \App\Core\IAuthenticator $auth */
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
use App\Models\User;

$user_id = $data['user_id'];
$username = $data['username'];
$profile = $data['profile'];

session_start();
?>

<div class="container profile-container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="profile-header d-flex align-items-center">
                <img src="<?= $profile->getProfilePic(); ?>" alt="Profile Picture" class="profile-image">
                <div>
                    <h2><?= $username ?></h2>
                    <p><strong>Description:</strong> <?= $profile->getDescription() ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Account Created:</strong> <?= (new DateTime($profile->getDateCreated()))->format('Y-m-d H:i:s'); ?></p>
                </div>
                <div class="col-md-6">
                    <?php if ($user_id == $auth->getLoggedUserId()): ?>
                        <a href="<?= $link->url("profile.editProfile", ['user_id' => $user_id])?>" class="btn btn-primary">Edit Profile</a>
                    <?php endif; ?>
                </div>
            </div>
            <a href="<?= $link->url("profile.profileData", ['user_id' => $user_id])?>">User data</a>
        </div>
    </div>
</div>

