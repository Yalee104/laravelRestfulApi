<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    public $token;
    public $mailActionTitle;
    public $mailActionUrl;
    public $mailSubject;
    public $mailInLine;
    public $mailOutLine;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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
        return (new MailMessage)
            ->subject(Lang::getFromJson($this->mailSubject ? :'Reset Password Notification'))
            ->line(Lang::getFromJson($this->mailInLine ? :'You are receiving this email because we received a password reset request for your account.'))
            ->action(Lang::getFromJson(     $this->mailActionTitle  ? :'Reset Password'),
                                        $this->mailActionUrl ? :url(config('app.url').route('password.reset', $this->token, false)))
            ->line(Lang::getFromJson($this->mailOutLine ? :'If you did not request a password reset, no further action is required.'));

    }

    /**
     * Set the mail action
     *
     * @param  string   $title
     * @param  string   $url
     * @return $this
     */
    public function toMailAction($title, $url)
    {
        $this->mailActionTitle = $title;
        $this->mailActionUrl = $url;

        return $this;
    }

    /**
     * Set the mail Subject
     *
     * @param  string   $subject
     * @return $this
     */
    public function toMailSubject($subject)
    {
        $this->mailSubject = $subject;
        return $this;
    }

    /**
     * Set the mail InLine and OutLine
     *
     * @param  string   $line
     * @return $this
     */
    public function toMailLine($line)
    {
        if (!$this->mailActionTitle) {
            $this->mailInLine = $line;
        }
        else {
            $this->mailOutLine = $line;
        }

        return $this;
    }

}
