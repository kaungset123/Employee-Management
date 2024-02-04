<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use App\Models\User;
use App\Notifications\ProjectDeadlineOverNotification;
use Illuminate\Support\Facades\Notification;

class NotifyProjectDeadlineOver extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-project-deadline-over';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $projects = Project::select('id','name','end_date','status')->where('status' , '!=' , 2)->whereDate('end_date', now())->get();

        // $this->table(
        //     ['id','name','end_date','status'],
        //     $projects->toArray()
        // );

        foreach($projects as $project) {
            $projectMembers = $project->members;
            $additionalUser = User::role(['admin','super admin'])->get();
            $allUsers = $projectMembers->merge($additionalUser);
            foreach($allUsers as $user) {             
                Notification::route('mail', $user->email)
                ->notify(new ProjectDeadlineOverNotification($user->name,$project->name));
            }
        }    
    }
}
