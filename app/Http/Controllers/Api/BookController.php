<?php

namespace App\Http\Controllers\Api;

use App\Book;
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


    public function store1(Request $request)
    {
        //  9787121215728 https://images.weserv.nl/?url=
        $req = $request->all();
        // init app
        $app = new Application();
        try {
            $book = $app->getBook($req['isbn13']);
            if ($book) {
                $book = $book->toArray();
                $book['author'] = rtrim(implode(",", $book['author']), ',');
                $book['tags'] = rtrim(implode(",", $book['tags']), ',');
                $book['isbn13'] = $book['isbn'];
                $book['image'] = $book['cover'];
                $book['image_proxy'] = 'https://images.weserv.nl/?url=' . $book['cover'];
                $book['pubdate'] = $book['publication_date'];
                unset($book['cover']);
                unset($book['isbn']);
                unset($book['publication_date']);
                dump($book);
                $new_book = Book::create($book);
                return $new_book;
                return $this->response->withNoContent();
            }
        } catch (\Exception $exception) {
            // handle exception
        }

    }

    public function store(Request $request)
    {
        //  9787121215728 https://images.weserv.nl/?url=
        $req = $request->all();
        // init app
        $app = new Application();

        $book = $app->getBook($req['isbn13']);
        if ($book) {
            $book = $book->toArray();
            $book['author'] = rtrim(implode(",", $book['author']), ',');
            $book['tags'] = rtrim(implode(",", $book['tags']), ',');
            $book['isbn13'] = $book['isbn'];
            $book['image'] = $book['cover'];
            $book['image_proxy'] = 'https://images.weserv.nl/?url=' . $book['cover'];
            $book['pubdate'] = $book['publication_date'];
            unset($book['cover']);
            unset($book['isbn']);
            unset($book['publication_date']);
//            dump($book);
            $new_book = Book::create($book);
            return $this->response->withNoContent();
        }

    }

}