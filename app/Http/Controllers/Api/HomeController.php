<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Comment;
use App\User;
use App\Visitor;

class HomeController extends ApiController
{
    public function statistics()
    {
        $users = User::query()->count();
        $visitors = Visitor::query()->sum('clicks');
        $articles = Article::query()->count();
        $comments = Comment::query()->count();

        $data = compact('users', 'visitors', 'articles', 'comments');

        return $this->response->json($data);
    }
}
