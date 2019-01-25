<?php

namespace App;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Lang;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        /*  AARON
         *  NOTE1:  We override this method so that we can inject the closure to customize the mail content such as
         *          title, and reset password url.
         */
        $ResetPassNotification = new ResetPasswordNotification($token);
        $ResetPassNotification->toMailUsing(function ($notifiable, $token) {
            return (new MailMessage)
                ->subject(Lang::getFromJson('Admin Reset Password Notification'))
                ->line(Lang::getFromJson('You are receiving this email because we received a password reset request for your account.'))
                ->action(Lang::getFromJson('Reset Password'), url(config('app.url').route('admin.password.reset', $token, false)))
                ->line(Lang::getFromJson('If you did not request a password reset, no further action is required.'));

        });

        $this->notify($ResetPassNotification);
    }

}
