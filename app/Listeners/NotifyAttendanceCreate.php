<?php

namespace App\Listeners;

use App\Events\AttendanceCreate;
use App\Models\Attendance;
use App\Notifications\AttendanceCreateNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifyAttendanceCreate
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
    public function handle(AttendanceCreate $event): void
    {
        $user = $event->attendance->user()->get();
        $name = $event->attendance->user->name;
        $data = compact('name');
        
        Notification::send($user, new AttendanceCreateNotification($data));
    }
}
