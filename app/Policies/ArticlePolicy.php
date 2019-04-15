<?php

namespace App\Policies;

use App\User;
use App\Article;

class ArticlePolicy extends Policy
{
    /**
     * Determine whether the user can comment to this article.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return bool
     */
	public function comment(User $user, Article $article) {
		return auth()->check() && !$article->is_draft;
	}
}
