<?php

namespace App\Notifications;

use App\{Like, Post};
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostLiked extends Notification implements ShouldQueue
{
    use Queueable;

    protected $post;

    protected $like;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Post $post, Like $like)
    {
        $this->post = $post;
        $this->like = $like;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject(config('app.name') . ': post was liked')
                    ->greeting('Hello, ' . $notifiable->name)
                    ->line('Your post ' . $this->post->title . ' was liked by ' . $this->like->user->name)
                    ->action('View Post', url('/posts/' . $this->post->id))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'post' => [
                'id' => $this->post->id,
                'title' => $this->post->title
            ],
            'liker' => [
                'id' => $this->like->user->id,
                'name' => $this->like->user->name
            ]
        ];
    }
}
