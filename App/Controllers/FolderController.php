<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Models\Folder;
use App\Models\InFolder;
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

    public function authorize($action): bool
    {
        session_start();
        $auth = $this->app->getAuth();
        $req = $this->request();
        switch ($action) {
            case "create":
                return $auth->isLogged();
            case "folderEdit":
            case "update":
            case "delete":
            case "place":
            case "remove":
                if (!$auth->isLogged()) {
                    return false;
                }
                $folder_id = $req->getValue('folder');
                $folder = Folder::getOne($folder_id);
                $logged_id = $auth->getLoggedUserId();
                return $folder->getOwner() == $logged_id;
            default:
                return true;
        }
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

    public function folderEdit() : Response
    {
        $req = $this->request();
        $folder = Folder::getOne($req->getValue('folder'));
        return $this->html(['folder' => $folder]);
    }

    public function update() : Response
    {
        $req = $this->request();
        $folder = Folder::getOne($req->getValue('folder'));
        $folder->setName($req->getValue('name'));
        $folder->setDescription($req->getValue('description'));
        $folder->setColor($req->getValue('color'));
        $folder->save();
        return new RedirectResponse($this->url("folder.folderEdit", ['folder' => $folder->getId()]));
    }

    public function delete() : Response
    {
        $req = $this->request();
        $folder = Folder::getOne($req->getValue('folder'));
        $owner = $folder->getOwner();
        $folder->delete();
        return new RedirectResponse($this->url("profile.profileData", ['user_id' => $owner]));
    }

    public function place() : Response
    {
        session_start();
        $req = $this->request();
        $folder_id = $req->getValue('folder');
        $data_id = $req->getValue('data_id');

        $in_folder = new InFolder();
        $in_folder->setFolder($folder_id);
        $in_folder->setData($data_id);
        $in_folder->save();

        $owner = $this->app->getAuth()->getLoggedUserId();
        return new RedirectResponse($this->url("profile.profileData", ['user_id' => $owner]));
    }

    public function remove() : Response
    {
        $req = $this->request();
        $folder = $req->getValue('folder');
        $data = $req->getValue('data');
        $in_folder = InFolder::getAll("`folder` = ? AND `data` = ?", [$folder, $data])[0];
        $in_folder->delete();
        $folder_data = Folder::getOne($folder)->getAllFromFolder();
        return new RedirectResponse($this->url("profile.profileFolder", ['folder_data' => $folder_data, 'folder' => $folder]));
    }
}