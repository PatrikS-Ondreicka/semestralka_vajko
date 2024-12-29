<?php

/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

    $username = $data['username'];
    $profile = $data['profile'];
    $user_data = $data['user_data'];
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

            <div class="content-list">
                <h3>Created Data</h3>
                <ul>
                    <?php foreach ($user_data as $weather_data): ?>
                    <li><?= $weather_data->getId() ?></li>
                    <?php endforeach; ?>
                </ul>
                <p>No content has been created yet.</p>
            </div>
        </div>
    </div>
</div>

