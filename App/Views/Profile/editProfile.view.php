<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

$user_id = $data["user_id"];
$username = $data['username'];
$profile = $data['profile'];
if (isset($data['errors']))
{
    $errors = $data["errors"];
}

?>

<h1>Edit Profile</h1>
<form action="<?= $link->url("profile.editProfile", ['user_id' => $user_id])?>" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Account Information</legend>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" value="<?= $username ?>" required><br><br>
        <div id="edit errors">
            <?php
            if (isset($data['errors'])) {
                foreach ($errors as $error) {
                    echo $error;
                }
            }
            ?>
        </div>
    </fieldset>
    <fieldset>
        <legend>Profile Information</legend>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" cols="50"><?= $profile->getDescription() ?></textarea><br><br>
        <label for="profile_pic">Profile Picture:</label><br>
        <input type="file" id="profile_pic" name="profile_pic" accept="image/*"><br><br>
        <img src="<?= $profile-> getProfilePic() ?>" alt="Current Profile Picture" width="150"><br>
    </fieldset>
    <input name='submit_profile' type="submit" value="Save Changes">
</form>