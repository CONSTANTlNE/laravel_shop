<?php

namespace App\Listeners;

use App\Jobs\NewUserSmsNotificationJob;
use App\Mail\NewUserRegisteredEmail;
use App\Models\Admin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class SendNewUserNotification
{
    public function __construct()
    {
        //
    }

    public function handle(Registered $event): void
    {
        $admins = Admin::all();

        $mobiles = [];
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(
                new NewUserRegisteredEmail($event->user)
            );

            $mobiles[] = '995'.$admin->mobile;
        }

        NewUserSmsNotificationJob::dispatch($mobiles, $event->user);

    }
}
