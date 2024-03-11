<?php

namespace App\Listeners;

use App\Events\TaskCreate;
use App\Jobs\NotifyTaskCreateJob;

class NotifyTaskCreate
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
    public function handle(TaskCreate $event): void
    {
        $member = $event->task->user()->get();
        $name = $event->task->user->name;
        $projectName = $event->task->project->name;
        $projectId = $event->task->project->id;
        $data = compact('name','projectName','projectId');

        // Notification::send($members, new TaskCreateNotification($data));
        NotifyTaskCreateJob::dispatch($member, $data);
    }
}
