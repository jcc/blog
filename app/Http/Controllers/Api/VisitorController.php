<?php

namespace App\Http\Controllers\Api;

use App\Visitor;
use Illuminate\Http\Request;

class VisitorController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @author Huiwang <905130909@qq.com>
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $vistors = Visitor::filter($request->all())->orderBy('created_at', 'desc')->paginate(10);

        return $this->response->collection($vistors);
    }
}
