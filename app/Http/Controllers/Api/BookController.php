<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Scopes\DraftScope;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use Littlesqx\Book\Application;

class BookController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
       

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\ArticleRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BookRequest $request)
    {
      // init app
      $app = new Application();

      // book's isbn10/isbn13 code
              $isbn = '9787115473899';
              return $isbn;
      // get a book entity
              try {
                  $book = $app->getBook($isbn);
                  if ($book) {
                      // use as an array
                      $book = $book->toJSON();
                      return $this->response->collection($book);
                      // or get json format
      //                $book->toJSON();
      //
      //                // also, get property directly is allowed
      //                $book->getTitle();
      //                $book->getPrice();
                  }
              } catch (\Exception $exception) {
                  // handle exception
              }

    }


}