<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Profile;
use App\Models\User;
use App\Models\Data;
use DateTime;

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
        $user_data = Data::getAll("`user` = ?", [$user_id]);
        return $this->html(['username' => $username, 'profile' => $profile, 'user_data' => $user_data]);
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