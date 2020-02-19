<?php

namespace Cogroup\Cms\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Cogroup\Cms\Models\User;

class NewMessage extends Notification
{
  use Queueable;

  /**
   * @var User
   */
  public $fromUser;

  /**
   * @var string
   */
  public $message;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(User $user, $message)
  {
    $this->fromUser = $user;
    $this->message = $message;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return config('cogroupcms.via');
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable)
  {
    $subject = sprintf(trans('notifications.subject'), config('app.name'), $this->fromUser->full_name);
    $greeting = sprintf(trans('notifications.greeting'), $notifiable->full_name);
    //$action = trans('notifications.action');

    return (new MailMessage)
              ->subject($subject)
              ->greeting($greeting)
              ->line($this->message);
              //->action($action, url('/'))
              //->line(trans('notification.thanks'));
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
      'from_id' => $this->fromUser->id,
      'from_name' => $this->fromUser->full_name,
      'to_id' => $notifiable->id,
      'to_name' => $notifiable->full_name,
      'subject' => sprintf(trans('notifications.subject'), config('app.name'), $this->fromUser->full_name),
      'message' => $this->message
    ];
  }
}
