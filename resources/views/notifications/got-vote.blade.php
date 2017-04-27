<?php
$comment = App\Comment::find($notification->data['comment_id']);
$user = App\User::find($notification->data['issuer_id']);

$commentable_id = $notification->data['commentable_id'];

if ($comment &&  $comment->commentable) {
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
    
if($notification->data['vote_type'] == 'up_vote')
{
	$iconRead = 'ion-ios-arrow-thin-up';
	$iconNotRead =  'ion-arrow-up-a';
	$action = lang('Likes'); // Likes your comment
}
else
{
	$iconRead = 'ion-ios-arrow-thin-down';
	$iconNotRead =  'ion-arrow-down-a';
	$action = lang('Dislikes'); // Dislikes your comment
}

?>
<li :class="'{{ empty($notification->read_at) }}' ? 'bold' : ''">
    @if ($comment && $comment->commentable && $user)
        <i :class="'{{ empty($notification->read_at) }}' ? '{{ $iconNotRead }}' : '{{ $iconRead }}'"></i>
        <a class="text-info" href="{{ url('user', ['username' => $user->name]) }}">{{  $user->name }}</a> {{ $action }}
        <a class="text-info" href="{{ $url }}">{{ $comment->commentable->title }}</a>
    @else
        <s>{{ lang('Deleted') }}</s>
    @endif
</li>