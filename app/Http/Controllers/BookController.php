<?php

namespace App\Http\Controllers;

class BookController extends Controller
{
    /**
     * Display the articles resource.
     *
     * @return mixed
     */
    public function index()
    {

        return view('book.index');
    }


}
