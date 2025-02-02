<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Models\Profile;
use App\Models\User;
use App\Models\Data;
use DateTime;
use App\Models\Folder;


class ProfileController extends AControllerBase
{

    static string $PICTURE_DIR = 'public/profile/';
    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        // TODO: Implement index() method.
    }

    public function authorize($action): bool
    {
        session_start();
        $auth = $this->app->getAuth();
        $req = $this->request();
        switch ($action) {
            case "editProfile":
            case "editAction":
                if (!$auth->isLogged()) {
                    return false;
                }
                $logged_id = $auth->getLoggedUserId();
                $profile_id = $req->getValue('user_id');
                return $logged_id == $profile_id;
            default:
                return true;
        }
    }

    public function profile() : Response
    {
        $req = $this->request();
        $user_id = $req->getValue('id');
        $username = User::getAll("`id` = ?", [$user_id])[0]->getUsername();
        $profile = Profile::getAll("`user` = ?", [$user_id])[0];
        return $this->html(['user_id'=> $user_id, 'username' => $username, 'profile' => $profile]);
    }

    public function profileData()
    {
        $req = $this->request();
        $user_id = $req->getValue('user_id');
        $user_data = Data::getAll("`user` = ?", [$user_id]);
        $folders = Folder::getAll("`owner` = ?", [$user_id]);
        return $this->html(['user_data' => $user_data, 'folders' => $folders]);
    }

    public function profileFolder()
    {
        $req = $this->request();
        $folder = Folder::getOne($req->getValue('folder'));
        $folder_data = $folder->getAllFromFolder();
        return $this->html(['folder_data' => $folder_data, 'folder' => $folder]);
    }

    public function editProfile() : Response
    {
        $req = $this->request();
        $user_id = $req->getValue('user_id');
        $username = User::getAll("`id` = ?", [$user_id])[0]->getUsername();
        $profile = Profile::getAll("`user` = ?", [$user_id])[0];
        if (is_null($req->getValue('submit_profile')))
        {
            return $this->html(['user_id' => $user_id, 'username' => $username, 'profile' => $profile]);
        }

        $new_username = $req->getValue('username');
        $new_desc = $req->getValue('description');
        $new_profile_pic_file = $req->getFiles()['profile_pic'];

        if (is_null($new_username))
        {
            return $this->html(['user_id' => $user_id, 'username' => $username, 'profile' => $profile, 'errors' => 'Username cannot be empty']);
        }
        else if ($new_username != $username)
        {
            $fetched_user = User::getAll("`username` = ?", [$new_username]);
            if ($fetched_user && $fetched_user[0]->getUsername() == $username && $fetched_user[0]->getId() != $user_id)
            {
                return $this->html(['user_id' => $user_id, 'username' => $username, 'profile' => $profile, 'errors' => 'User already exists']);
            }
            $new_user = User::getOne($user_id);
            $new_user->setUsername($new_username);
            $new_user->save();
            $username = $new_user->getUsername();
        }
        $profile->setDescription($new_desc);
        $new_file_location = $this::$PICTURE_DIR.rand(0, 255).'-'.$new_profile_pic_file['name'];
        move_uploaded_file($new_profile_pic_file['tmp_name'], $new_file_location);
        unlink($profile->getProfilePic());
        $profile->setProfilePic($new_file_location);
        $profile->save();
        return $this->html(['user_id' => $user_id, 'username' => $username, 'profile' => $profile]);
    }

    public function editAction() : Response
    {
        $req = $this->request();
        $user_id = $req->getValue('user_id');
        $username = User::getAll("`id` = ?", [$user_id])[0]->getUsername();
        $profile = Profile::getAll("`user` = ?", [$user_id])[0];

        $new_username = $req->getValue('username');
        $new_desc = $req->getValue('description');
        $new_profile_pic_file = $req->getFiles()['profile_pic'];

        if (is_null($new_username))
        {
            return $this->html(['user_id' => $user_id, 'username' => $username, 'profile' => $profile, 'errors' => 'Username cannot be empty']);
        }
        else if ($new_username != $username)
        {
            $fetched_user = User::getAll("`username` = ?", [$new_username]);
            if ($fetched_user && $fetched_user[0]->getUsername() == $username && $fetched_user[0]->getId() != $user_id)
            {
                return $this->html(['user_id' => $user_id, 'username' => $username, 'profile' => $profile, 'errors' => 'User already exists']);
            }
            $new_user = User::getOne($user_id);
            $new_user->setUsername($new_username);
            $new_user->save();
            $username = $new_user->getUsername();
        }
        $profile->setDescription($new_desc);
        if ($new_profile_pic_file['name'] != "") {
            $new_file_location = $this::$PICTURE_DIR.rand(0, 255).'-'.$new_profile_pic_file['name'];
            move_uploaded_file($new_profile_pic_file['tmp_name'], $new_file_location);
            unlink($profile->getProfilePic());
            $profile->setProfilePic($new_file_location);
        }
        $profile->save();
        return new RedirectResponse($this->url("profile",  ['id' => $user_id]));
    }

    public static function addProfile(User $user)
    {
        if ($user->getId() == null) {
            return;
        }

        $profile = new Profile();
        $profile->setUser($user->getId());
        $profile->setDateCreated((new DateTime())->format('Y-m-d H:i:s'));
        $profile->save();
    }
}