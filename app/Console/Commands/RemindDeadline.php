<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\RemindDeadlineNotification;
use Illuminate\Support\Facades\Notification;

class RemindDeadline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remind-deadline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind members the deadline ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Task::select('user_id','project_id','name','end_date','status')->whereDate('end_date', now()->addDay())->where('status', '!=' , 2)->with(['user','project'])->get();
        // $tasks = Task::select('user_id','project_id','name','end_date')->whereDate('end_date', now()->addDay())->where('status', '!=' , 2)->get();

        // $this->table(
        //     ['name', 'end_date'],
        //     $tasks->toArray()
        // );

        foreach($tasks as $task) {
             $user = $task->user;
             $userName = $user->name;
             $projectName = $task->project->name;
            if ($user) {
                Notification::route('mail', $user->email)
                ->notify(new RemindDeadlineNotification($task->name, $projectName,$userName));
            }
        }       
    }
}
