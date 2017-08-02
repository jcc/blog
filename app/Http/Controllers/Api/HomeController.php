<?php

namespace App\Http\Controllers\Api;

use App\Repositories\UserRepository;
use App\Repositories\VisitorRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;

class HomeController extends ApiController
{
    protected $user;
    protected $visitor;
    protected $article;
    protected $comment;

    public function __construct(
        UserRepository $user,
        VisitorRepository $visitor,
        ArticleRepository $article,
        CommentRepository $comment)
    {
        parent::__construct();

        $this->user = $user;
        $this->visitor = $visitor;
        $this->article = $article;
        $this->comment = $comment;
    }

    public function statistics()
    {
        $users = $this->user->getNumber();
        $visitors = (int) $this->visitor->getAllClicks();
        $articles = $this->article->getNumber();
        $comments = $this->comment->getNumber();

        $data = compact('users', 'visitors', 'articles', 'comments');

        return $this->response->json($data);
    }

}
