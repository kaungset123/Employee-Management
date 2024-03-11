<?php

namespace App\Listeners;

use App\Events\RequestRejected;
use App\Jobs\NotifyRequestRejectedJob;

class NotifyRequestRejected
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
    public function handle(RequestRejected $event): void
    {
        $user = $event->leave->user()->get();
        $name = $event->leave->user->name;
        $date = $event->leave->created_at;
        $data = compact('name','date');

        // Notification::send($user, new RequestRejectedNotification($data));
        NotifyRequestRejectedJob::dispatch($user, $data);
    }
}
