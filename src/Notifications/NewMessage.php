<?php

namespace Cogroup\Cms\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Cogroup\Cms\Models\User;
//Mail
use Illuminate\Notifications\Messages\MailMessage;
//Mailjet
use Mailjet\LaravelMailjet\Facades\Mailjet;
//Nexmo
use Illuminate\Notifications\Messages\NexmoMessage;
//Slack
use Illuminate\Notifications\Messages\SlackMessage;

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
    $action = trans('notifications.action');
    $thanks = trans('notification.thanks');

    return (new MailMessage)
              ->subject($subject)
              ->greeting($greeting)
              ->line($this->message)
              ->action($action, url('/'));
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

  /**
   * Get the broadcastable representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return BroadcastMessage
   */
  public function toBroadcast($notifiable)
  {
    return new BroadcastMessage([
      'from_id' => $this->fromUser->id,
      'from_name' => $this->fromUser->full_name,
      'to_id' => $notifiable->id,
      'to_name' => $notifiable->full_name,
      'subject' => sprintf(trans('notifications.subject'), config('app.name'), $this->fromUser->full_name),
      'message' => $this->message
    ]);
  }

  /**
   * Get the Nexmo / SMS representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return NexmoMessage
   */
  public function toNexmo($notifiable)
  {
    return (new NexmoMessage)
              ->content($this->message)
              ->unicode();
  }

  /**
   * Get the Slack representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return SlackMessage
   */
  public function toSlack($notifiable)
  {
    return (new SlackMessage)
              ->from($this->fromUser->full_name)
              ->to($notifiable->full_name)
              ->content($this->message);
  }
}
