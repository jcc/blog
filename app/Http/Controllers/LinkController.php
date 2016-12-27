<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\LinkRepository;

class LinkController extends Controller
{
    protected $link;

    public function __construct(LinkRepository $link)
    {
        $this->link = $link;
    }

    /**
     * Display the link resource.
     * 
     * @return mix
     */
    public function index()
    {
        $links = $this->link->page();

        return view('link.index', compact('links'));
    }
}
