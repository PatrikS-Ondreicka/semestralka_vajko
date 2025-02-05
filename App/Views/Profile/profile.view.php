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

<div class="card profile-container">
        <div class="row">
            <div class="profile-header col-md-5 col-12">
                <img src="<?= $profile->getProfilePic(); ?>" alt="Profile Picture" class="profile-image">
                <div>
                    <h2><?= $username ?></h2>
                    <p><strong>Description:</strong> <?= $profile->getDescription() ?></p>
                </div>
            </div>
            <div class="profile-content col-md-7 col-12">
                <div>
                    <p><strong>Account Created:</strong><br> <?= (new DateTime($profile->getDateCreated()))->format('Y-m-d H:i:s'); ?></p>
                </div>
                <div>
                    <a href="<?= $link->url("profile.profileData", ['user_id' => $user_id])?>" class=" i_button i_info"><i class="bi bi-eye-fill"></i>View</a>
                    <?php if ($user_id == $auth->getLoggedUserId()): ?>
                        <a class="i_button i_restricted" href="<?= $link->url("profile.editProfile", ['user_id' => $user_id])?>"><i class="bi bi-pencil-square"></i>Edit</a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
</div>

