<?php

namespace App\Http\Controllers;

use App\Library\Services\PrepareResponse as Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }
}
