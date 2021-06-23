<?php

namespace Cogroup\Cms\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
//Mailjet
use Mailjet\LaravelMailjet\Facades\Mailjet;

class ResetPasswordNotification extends Notification
{
  /**
   * @var string
   */
  public $url;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct($url)
  {
    $this->url = $url;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable)
  {
    $subject = trans('notifications.password.reset.subject', ['appname' => config('app.name')]);
    $url = $this->url;

    return (new MailMessage)
              ->subject($subject)
              ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
              ->action(Lang::get('Reset Password'), $url)
              ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
              ->line(Lang::get('If you did not request a password reset, no further action is required.'));
  }
}
