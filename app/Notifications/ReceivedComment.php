<?php

namespace App\Notifications;

use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReceivedComment extends Notification implements ShouldQueue
{
    use Queueable;

    protected $comment;

    /**
     * Create a new notification instance.
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

        $type = lang(substr(ucfirst($comment->commentable_type), 0, -1));

        $message = lang('Comment Content', [
            'type' => strtolower($type),
            'title' => $comment->commentable->title,
            'user' => $comment->user->name]);

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
                    ->subject(lang('New Comment', ['type' => strtolower($type)]))
                    ->markdown('mail.receive.comment', $data);
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
