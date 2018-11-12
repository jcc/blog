<?php

namespace App\Http\Controllers\Api;

use App\Book;
use App\Scopes\DraftScope;
use Illuminate\Http\Request;
use Littlesqx\Book\Application;
use Skywing\Douban\Douban;

class BookController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');

        $books = Book::checkAuth()->when($keyword, function ($query) use ($keyword) {
            $query->where('title', 'like', "%{$keyword}%")
                ->orWhere('subtitle', 'like', "%{$keyword}%");
        })
            ->orderBy('sort', 'desc')->paginate(15);

        return $this->response->collection($books);

    }

    public function store(Request $request)
    {
        //  9787121215728 https://images.weserv.nl/?url=
        $req = $request->all();
        $douban = new Douban();
        $book = $douban->getBook($req['isbn13']);
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
        // init app
//        $app = new Application();
//        $book = $app->getBook($req['isbn13']);
//        if ($book) {
//            $book = $book->toArray();
//            $book['author'] = rtrim(implode(",", $book['author']), ',');
//            $book['tags'] = rtrim(implode(",", $book['tags']), ',');
//            $book['isbn13'] = $book['isbn'];
//            $book['image'] = $book['cover'];
//            $book['image_proxy'] = 'https://images.weserv.nl/?url=' . $book['cover'];
//            $book['pubdate'] = $book['publication_date'];
//            unset($book['cover']);
//            unset($book['isbn']);
//            unset($book['publication_date']);
////            dump($book);
//            $new_book = Book::create($book);
//            return $this->response->withNoContent();
//        }

    }

    public function destroy($id)
    {
        Book::checkAuth()->findOrFail($id)->delete();

        return $this->response->withNoContent();
    }

}