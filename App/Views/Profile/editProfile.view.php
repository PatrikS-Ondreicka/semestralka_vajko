<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

$user_id = $data["user_id"];
$username = $data['username'];
$profile = $data['profile'];
$errors = $data['errors'];

?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1>Edit Profile</h1>
            <form action="<?= $link->url("profile.editProfile", ['user_id' => $user_id])?>" method="post" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" id="username" name="username" value="<?= $username ?>" class="form-control" required>
                            <?php if (isset($errors['username'])): ?>
                                <span class="text-danger"><?= $errors['username'] ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea id="description" name="description" rows="4" class="form-control"><?= $profile->getDescription() ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="profile_pic" class="form-label">Profile Picture:</label>
                            <input type="file" id="profile_pic" name="profile_pic" accept="image/*" class="form-control">
                        </div>
                        <img src="<?= $profile->getProfilePic() ?>" alt="Current Profile Picture" class="img-fluid rounded-circle mb-3" style="max-width: 150px;">
                        <input id="submit_profile" name="submit_profile" type="submit" class="btn btn-primary" value="Save Changes">
                    </div>
                    <div class="card-footer">
                        <p class="error_message"><?= $errors ?></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>