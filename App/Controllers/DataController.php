<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;

class DataController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        // TODO: Implement index() method.
    }

    public function data() : Response
    {
        return $this->html();
    }

    public function dataform() : Response
    {
        return $this->html();
    }

}