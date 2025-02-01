<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Location;
use App\Models\Data;
use App\Models\Report;

class AdmController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        // TODO: Implement index() method.
    }

    public function admin(): Response
    {
        return $this->html();
    }

    public function adminLocations(): Response
    {
        return $this->html();
    }

    public function adminData(): Response
    {
        return $this->html();
    }

    public function adminReports(): Response
    {
        return $this->html();
    }
}