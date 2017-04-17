<?php
$comment = App\Comment::find($notification->data['id']);
$type = $notification->data['commentable_type'] === 'articles' ? lang('Articles') : lang('Discussions');
$commentable_id = $notification->data['commentable_id'];

if ($comment) {
    switch($comment->commentable_type) {
        case 'articles':
            $article = App\Article::find($commentable_id);
            $url = url($article->slug);
            break;
        case 'discussions':
            $discussion = App\Discussion::find($commentable_id);
            $url = url('discussion', ['id' => $discussion->id]);
            break;
    }
}

?>
<div class="col-sm-12">
    @if ($comment)
    @if(empty($notification->read_at))
        <i class="ion-ios-chatboxes"></i>
    @else
        <i class="ion-ios-chatboxes-outline"></i>
    @endif
    <a class="text-info" href="{{ url('user', ['username' => $comment->user->name]) }}">{{ $comment->user->name }}</a> {{ lang('Commented') }} {{ $type }}
    <a class="text-info" href="{{ $url }}">{{ $comment->commentable->title }}</a>
    @else
        <s>{{ lang('Deleted') }}</s>
    @endif
</div>
