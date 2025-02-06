<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Models\Data;
use App\Models\Folder;
use App\Models\InFolder;
use App\Models\Location;
use App\Models\Profile;
use App\Models\User;

class FolderController extends AControllerBase
{

    public array $supported_colors = ["#FF6666", "#66FF66", "#6666FF", "#FFFF99", "#FF66FF", "#66FFFF"];

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
                if ($folder == null) {
                    return true;
                }
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

        $errors = [];
        if ($name == null || $name == "")
        {
            $errors[] = "Folder name cannot be empty";
        }

        $folders_with_name = Folder::getAll("`name` = ? AND `owner` = ?", [$name, $owner]);
        if (count($folders_with_name) > 0)
        {
            $errors[] = "Folder with such name already exists";
        }

        if ($color == null || $color == "" || !in_array($color, $this->supported_colors))
        {
            $errors[] = "Unsupported color";
        }

        if (count($errors) == 0) {
            $new_folder = new Folder();
            $new_folder->setName($name);
            $new_folder->setDescription($description);
            $new_folder->setColor($color);
            $new_folder->setOwner($owner);
            $new_folder->save();
        }

        return new RedirectResponse($this->url("profile.profileData", ['user_id' => $owner, 'errors' => $errors]));
    }

    public function folderEdit() : Response
    {
        $req = $this->request();
        $errors = $req->getValue('errors');
        if ($errors == null)
        {
            $errors = [];
        }
        $folder = Folder::getOne($req->getValue('folder'));
        if ($folder == null) {
            return new RedirectResponse($this->url("folder.error", ['message' => "Unable to fetch folder"]));
        }
        return $this->html(['folder' => $folder, 'errors' => $errors]);
    }

    public function update() : Response
    {
        $req = $this->request();
        $folder_id = $req->getValue('folder');
        $folder = Folder::getOne($folder_id);
        $name = $req->getValue('name');
        $description = $req->getValue('description');
        $color = $req->getValue('color');

        $errors = [];
        if ($name == null || $name == "")
        {
            $errors[] = "Folder name cannot be empty";
        }

        if ($color == null || $color == "" || !in_array($color, $this->supported_colors))
        {
            $errors[] = "Unsupported color";
        }

        if (count($errors) == 0)
        {
            $folder->setName($name);
            $folder->setDescription($description);
            $folder->setColor($color);
            $folder->save();
        }
        return new RedirectResponse($this->url("folder.folderEdit", ['folder' => $folder_id, 'errors' => $errors]));
    }

    public function delete() : Response
    {
        $req = $this->request();
        $folder = Folder::getOne($req->getValue('folder'));
        if ($folder == null) {
            return new RedirectResponse($this->url("folder.error", ['message' => "Unable to delete folder"]));
        }
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

        if (Folder::getOne($folder_id) == null) {
            return new RedirectResponse($this->url("folder.error", ['message' => "Folder doesn't exist"]));
        }

        if (Data::getOne($data_id) == null) {
            return new RedirectResponse($this->url("folder.error", ['message' => "Data doesn't exist"]));
        }

        if (count(InFolder::getAll("`folder` = ? AND `data` = ?", [$folder_id, $data_id])) > 0) {
            return new RedirectResponse($this->url("folder.error", ['message' => "Data is already placed in folder"]));
        }

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
        $folder_id = $req->getValue('folder');
        $data_id = $req->getValue('data');

        if (Folder::getOne($folder_id) == null) {
            return new RedirectResponse($this->url("folder.error", ['message' => "Folder doesn't exist"]));
        }

        if (Data::getOne($data_id) == null) {
            return new RedirectResponse($this->url("folder.error", ['message' => "Data doesn't exist"]));
        }

        $in_folder = InFolder::getAll("`folder` = ? AND `data` = ?", [$folder_id, $data_id])[0];

        if ($in_folder == null) {
            return new RedirectResponse($this->url("folder.error", ['message' => "Data isn't placed in folder"]));
        }
        $in_folder->delete();

        $folder_data = Folder::getOne($folder_id)->getAllFromFolder();
        return new RedirectResponse($this->url("profile.profileFolder", ['folder_data' => $folder_data, 'folder' => $folder_id]));
    }

    public function exportAsCSV() {
        $req = $this->request();
        $folder_id = $req->getValue('folder');
        $folder = Folder::getOne($folder_id);
        if ($folder == null) {
            return new RedirectResponse($this->url("folder.error", ['message' => "Folder doesn't exist"]));
        }
        $filename = $folder->getName()."-export.csv";
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $data = $folder->getAllFromFolder();
        $output = fopen('php://output', 'w');
        $header = array("id", "temperature", "humidity", "wind_speed", "wind_direction", "precipitation", "loc_name", "lat", "lon");
        fputcsv($output, $header);
        foreach ($data as $row) {
            $location = Location::getOne($row->getLocation());
            $row_formated = array($row->getId(), $row->getHumidity(), $row->getWindSpeed(), $row->getWindDirection(), $row->getPrecipitation(), $location->getName(), $location->getLat(), $location->getLon());
            fputcsv($output, $row_formated);
        }
        fclose($output);
        exit();
    }

    public function error()
    {
        $req = $this->request();
        $message = $req->getValue('message');
        return $this->html(["message" => $message]);
    }
}