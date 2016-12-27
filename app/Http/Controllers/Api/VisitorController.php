<?php

namespace App\Http\Controllers\Api;

use App\Repositories\VisitorRepository;
use App\Transformers\VisitorTransformer;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->respondWithPaginator($this->visitor->page(), new VisitorTransformer);
    }

}
