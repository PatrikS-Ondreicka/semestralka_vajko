<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Location;
use App\Models\Data;
use App\Models\User;
use App\Models\Report;
use App\Models\ReportType;

class AdmController extends AControllerBase
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
        $logged_id = $auth->getLoggedUserId();
        $logged_user = User::getOne($logged_id);
        return $logged_user->getRole() != 0;
    }

    public function admin(): Response
    {
        return $this->html();
    }

    public function adminLocations(): Response
    {
        $locations = Location::getAll();
        return $this->html(["locations" => $locations]);
    }

    public function adminData(): Response
    {
        $data = Data::getAll();
        $usernames = User::asValueKeyPairs();
        $locations = Location::asValueKeyPairs();
        return $this->html(["data" => $data, "usernames" => $usernames, "locations" => $locations]);
    }

    public function adminReports(): Response
    {
        $reports = Report::getAll();
        $usernames = User::asValueKeyPairs();
        $types = ReportType::asValueKeyPairs();
        return $this->html(["reports" => $reports, "usernames" => $usernames, "types" => $types]);
    }
}