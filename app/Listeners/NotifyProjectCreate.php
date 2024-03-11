<?php

namespace App\Listeners;

use App\Events\ProjectCreate;
use App\Jobs\NotifyProjectCreateJob;

class NotifyProjectCreate
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
    public function handle(ProjectCreate $event): void
    {
        $members = $event->project->members()->get();
        $name = $event->project->name;
        $data = compact('name');

        // $members->each(function($user) use ($data){
        //     Mail::to($user)->send(new ProjectCreateMail($data));
        // });

        // Notification::send($members, new ProjectCreateNotification($data));
        NotifyProjectCreateJob::dispatch($members,$data);
    }
}
