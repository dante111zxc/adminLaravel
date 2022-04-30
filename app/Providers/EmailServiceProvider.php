<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class EmailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerEmailVerify();

    }


    //Mẫu email gửi cho người dùng kích hoạt tài khoản, custom lại từ package auth bootstrap ui
    protected function registerEmailVerify(){
        VerifyEmail::toMailUsing(function (User $user, string $verificationUrl) {
            return (new MailMessage)
                ->from(env('MAIL_FROM_ADDRESS'), 'Paimonshop - Hệ thống nạp game chiết khấu')
                ->view('public.template.email.register-email-verify', [
                    'user' => $user,
                    'verificationUrl' => $verificationUrl
                ])
                ->subject(Lang::get('Kích hoạt tài khoản thành viên - Paimonshop.com'));
        });
    }
}
