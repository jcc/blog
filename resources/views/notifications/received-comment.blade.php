<?php
$comment = App\Comment::find($notification->data['id']);
$type = $notification->data['commentable_type'] === 'articles' ? lang('Articles') : lang('Discussions');
$commentable_id = $notification->data['commentable_id'];

if ($comment && $comment->commentable) {
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
} else {
    $message = lang('Be Banned Comment');
}

?>

<li :class="'{{ empty($notification->read_at) }}' ? 'bold' : ''">
    @if ($comment && $comment->commentable)
        <i :class="'{{ empty($notification->read_at) }}' ? 'ion-ios-chatboxes' : 'ion-ios-chatboxes-outline'"></i>
        <a class="text-info" href="{{ url('user', ['username' => $comment->user->name]) }}">{{ $comment->user->name }}</a>
        {{ lang('Commented') }} {{ $type }}
        <a class="text-info" href="{{ $url }}">{{ $comment->commentable->title }}</a>
    @elseif ($comment && !$comment->commentable)
        <s>{{ strtolower($type) }} {{ $message }}</s>
    @else
        <s>{{ strtolower($type) }} {{ lang('Deleted') }}</s>
    @endif
</li>
