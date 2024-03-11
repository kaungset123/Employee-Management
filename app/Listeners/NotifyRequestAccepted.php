<?php

namespace App\Listeners;

use App\Events\RequestAccepted;
use App\Jobs\NotifyRequestAcceptedJob;
use App\Notifications\RequestAcceptedNotification;
use Illuminate\Support\Facades\Notification;

class NotifyRequestAccepted
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RequestAccepted $event): void
    {
        $user = $event->leave->user()->get();
        $name = $event->leave->user->name;
        $date = $event->leave->created_at;
        $data = compact('name','date');

        // Notification::send($user, new RequestAcceptedNotification($data));
        NotifyRequestAcceptedJob::dispatch($user,$data);
    }
}
