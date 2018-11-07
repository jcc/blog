<?php

namespace App\Transformers;

use App\Book;
use League\Fractal\TransformerAbstract;

class BookTransformer extends TransformerAbstract
{

    public function transform(Book $book)
    {
        return [
            'id' => $book->id,
            'title' => $book->title,
            'subtitle' => $book->subtitle,
            'sort' => $book->sort,
            'status' => $book->status,
            'author' => $book->author,
            'tags' => $book->tags,
            'image_proxy' => $book->image_proxy,
            'catalog' => $book->catalog,
            'publisher' => $book->publisher,
            'isbn13' => $book->isbn13,
            'author_intro' => $book->author_intro,
            'summary' => $book->summary,
            'price' => $book->price,
            'pubdate' => $book->pubdate,
        ];
    }


}
