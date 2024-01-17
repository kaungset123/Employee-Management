<?php

namespace App\Listeners;

use App\Events\SalaryCreate;
use App\Notifications\SalaryNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifySalaryCreate
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
    public function handle(SalaryCreate $event): void
    {
        $employee = $event->salary->user()->get();
        $name = $event->salary->user->name;
        $date = $event->salary->created_at;
        $data = compact('name','date');

        Notification::send($employee, new SalaryNotification($data));
    }
}
