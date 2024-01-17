<?php

namespace App\Listeners;

use App\Events\TaskCreate;
use App\Notifications\TaskCreateNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

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
        $members = $event->task->user()->get();
        $name = $event->task->user->name;
        $projectName = $event->task->project->name;
        $projectId = $event->task->project->id;
        $data = compact('name','projectName','projectId');

        Notification::send($members, new TaskCreateNotification($data));
    }
}
