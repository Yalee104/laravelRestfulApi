<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Lang;
use App\Notifications\ResetPassword as ResetPasswordNotification;

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
         *  NOTE1:  ResetPasswordNotification is NOT longer from laravel, we have created our own App/Notificaions/ResetPassword.php
         *          due to the fact we would like to use ShouldQueue in this commit and we face some limitation as explained in below note.
         *  NOTE2:  We create our own notifications because we do not want to modify laravel code to implement the ShouldQueue implementation
         *  NOTE3:  Even if we modify the laravel code the toMailUsing closure callback WILL NOT WORK since ShouldQueue CANNOT seriarize
         *          closure. This means we cannot use the closure to override the mail content.
         *
         *  NOTE4:  Current App/Notifications/ResetPassword design is not straightforward, consider changing to passing static method
         *          which it can serialize and call later when launched to mimic the closure of toMailUsing that laravel is using.
         *          this will make the code cleaner and more flexible.
         */

        //ResetPasswordNotification is App/Notifications/ResetPassword
        $ResetPassNotification = new ResetPasswordNotification($token);

        $ResetPassNotification->toMailSubject('Admin Reset Password Notification')
            ->toMailLine('You are receiving this email because we received a password reset request for your account.')
            ->toMailAction('Reset Password', url(config('app.url').route('admin.password.reset', $token, false)))
            ->toMailLine('If you did not request a password reset, no further action is required.');

        $this->notify($ResetPassNotification);
    }

}
