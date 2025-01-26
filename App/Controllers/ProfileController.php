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

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        // TODO: Implement index() method.
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
        $new_profile_pic = $req->getValue('profile_pic');

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
        $profile->setProfilePic($new_profile_pic);
        $profile->save();
        return $this->html(['user_id' => $user_id, 'username' => $username, 'profile' => $profile]);
    }

    public function editAction() : Response
    {
        $req = $this->request();
        return new RedirectResponse($this->url("profile",  ['id' => $req->getValue('id')]));
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