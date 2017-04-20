<?php

namespace App\Notifications;

use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MentionedUser extends Notification
{
    use Queueable;

    protected $comment;

    /**
     * Create a new notification instance.
     *
     * @param \App\Comment $comment
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $comment = $this->comment;

        $type = lang(ucfirst($comment->commentable_type));

        $message = '用户 ' . $comment->user->name . ' 在 《' . $comment->commentable->title . '》 评论中提及到你';

        $url = ($comment->commentable_type == 'articles')
                ? url('article', ['slug'=>$comment->commentable->slug])
                : url('discussion', ['id' => $comment->commentable->id]);

        $data = [
            'username' => $notifiable->name,
            'message'  => $message,
            'content'  => json_decode($comment->content)->raw,
            'url' => $url
        ];

        return (new MailMessage)
                    ->subject("有人在 {$type}【{$comment->commentable->title}】提及到您")
                    ->markdown('mail.mention.user', $data);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->comment->toArray();
    }
}
