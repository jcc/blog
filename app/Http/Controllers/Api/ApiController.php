<?php

namespace App\Http\Controllers\Api;

use App\Support\Response;
use App\Support\Transform;
use League\Fractal\Manager;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    protected $response;

    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        $manager = new Manager();

        $this->response = new Response(response(), new Transform($manager));
    }
}
