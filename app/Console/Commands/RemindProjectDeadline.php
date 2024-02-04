<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Models\User;
use App\Notifications\ProjectDeadlineNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;


class RemindProjectDeadline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remind-project-deadline';

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
        $projects = Project::select('id','name','end_date','status')->where('status' , '!=' , 2)->whereDate('end_date', now()->addWeek())->get();

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
                ->notify(new ProjectDeadlineNotification($user->name,$project->name));
            }
        }      
    }
}
