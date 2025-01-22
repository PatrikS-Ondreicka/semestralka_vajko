<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Models\Folder;
use App\Models\Profile;
use App\Models\User;

class FolderController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        // TODO: Implement index() method.
    }

    public function create(): Response
    {
        session_start();
        $req = $this->request();
        $name = $req->getValue('name');
        $description = $req->getValue('description');
        $color = $req->getValue('color');
        $owner = $this->app->getAuth()->getLoggedUserId();

        $new_folder = new Folder();
        $new_folder->setName($name);
        $new_folder->setDescription($description);
        $new_folder->setColor($color);
        $new_folder->setOwner($owner);

        $new_folder->save();
        return new RedirectResponse($this->url("profile.profileData", ['user_id' => $owner]));
    }

    public function update() : Response
    {

    }

    public function delete() : Response
    {

    }

    public function place() : Response
    {
        session_start();
        $owner = $this->app->getAuth()->getLoggedUserId();
        return new RedirectResponse($this->url("profile.profileData", ['user_id' => $owner]));
    }

    public function remove() : Response
    {

    }
}