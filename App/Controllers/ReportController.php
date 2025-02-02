<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Data;
use App\Models\ReportType;
use App\Models\Report;
use App\Models\User;

class ReportController extends AControllerBase
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
            case "add":
                return $auth->isLogged();
            case "delete":
                if (!$auth->isLogged()) {
                    return false;
                }
                $logged_id = $auth->getLoggedUserId();
                $logged_user = User::getOne($logged_id);
                return $logged_user->getRole() != 0;
            default:
                return true;
        }
    }

    public function add() : Response
    {
        $req = $this->request();
        $user_id = $req->getValue('user_id');
        $data_id = $req->getValue('data_id');
        $report_type = $req->getValue('report_type');

        if (User::getOne($user_id) == null) {
            return $this->redirect($this->url("report.error", ["message" => "User doesn't exist"]));
        }

        if (Data::getOne($data_id) == null) {
            return $this->redirect($this->url("report.error", ["message" => "Data doesn't exist"]));
        }

        if (ReportType::getOne($report_type) == null) {
            return $this->redirect($this->url("report.error", ["message" => "Invalid report type"]));
        }

        $report = new Report();
        $report->setUser($user_id);
        $report->setData($data_id);
        $report->setReportsType($report_type);
        $report->save();

        return $this->redirect($this->url("data.detail", ["dataId" => $data_id]));
    }

    public function delete() : Response
    {
        $req = $this->request();
        $report_id = $req->getValue('report_id');
        $report = Report::getOne($report_id);
        if ($report == null) {
            return $this->redirect($this->url("report.error", ["message" => "Report doesn't exists"]));
        }
        $report->delete();
        return $this->redirect($this->url("adm.adminReports"));
    }

    public function error()
    {
        $req = $this->request();
        $message = $req->getValue('message');
        return $this->html(["message" => $message]);
    }
}