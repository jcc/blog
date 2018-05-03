<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Repositories\VisitorRepository;

class VisitorController extends ApiController
{
    protected $visitor;

    public function __construct(VisitorRepository $visitor)
    {
        parent::__construct();

        $this->visitor = $visitor;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->response->collection($this->visitor->pageWithRequest($request));
    }

}
