<?php

namespace App\Listeners;

use App\Events\SalaryCreate;
use App\Jobs\NotifySalaryCreateJob;

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

        // Notification::send($employee, new SalaryNotification($data));
        NotifySalaryCreateJob::dispatch($employee, $data);
    }
}
