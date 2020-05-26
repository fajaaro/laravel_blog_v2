<?php

namespace App\Listeners;

use App\Events\PostPosted;
use App\Mail\SendEmailToAdminAfterPostPosted;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NotifyAdminWhenPostPosted
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PostPosted $event)
    {
        User::where('is_admin', 1)
            ->get()
            ->map(function (User $user) use ($event) {
                Mail::to($user)->queue(new SendEmailToAdminAfterPostPosted($event->post));
            });
    }
}
