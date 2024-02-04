<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Notifications\TaskDeadlineManagerNotification;
use Illuminate\Support\Facades\Notification;

class RemindTaskdeadlineManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remind-taskdeadline-manager';

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
        $tasks = Task::select('project_id','name','end_date','user_id','status')->whereDate('end_date', now()->addDay())->where('status', '!=' , 2)->with(['user','project'])->get();

        // $this->table(
        //     ['Project_id','Name','End_date'],
        //     $tasks->toArray()
        // );

        foreach($tasks as $task) {
            $manager = $task->project->projectManager;
            $manager_name = $manager->name;
            $project = $task->project->name;  
            $task_name = $task->name;  
            $member = $task->user->name;
            
            if ($manager) {
                Notification::route('mail', $manager->email)
                ->notify(new TaskDeadlineManagerNotification($manager_name, $project, $task_name, $member));
            }
        }
    }
}
