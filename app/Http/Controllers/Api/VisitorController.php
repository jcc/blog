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
     */
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');

        $vistors = Visitor::query()->when($keyword, function ($query) use ($keyword) {
            $query->where('ip', 'like', "%{$keyword}%")
                ->orWhereHas('article', function ($query) use ($keyword) {
                    $query->where('title', 'like', "%{$keyword}%");
                });
        })
        ->orderBy('created_at', 'desc')->paginate(10);

        return $this->response->collection($vistors);
    }
}
