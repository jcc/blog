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
        $type = lang(ucfirst($comment->commentable_type));
        $message = '您发布的' . $type . '：' . $comment->commentable->title . ', 收到了一条来自' . $comment->user->name . '的评论：';
        $url = ($comment->commentable_type == 'articles')
                ? url('article', ['slug'=>$comment->commentable->slug])
                : url('discussion', ['id' => $comment->commentable->id]);
        return (new MailMessage)
                    ->greeting('尊敬的' . $notifiable->name)
                    ->subject('您收到了一条新的评论')
                    ->line($message)
                    ->line(json_decode($comment->content)->raw)
                    ->action('查看', $url);
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
