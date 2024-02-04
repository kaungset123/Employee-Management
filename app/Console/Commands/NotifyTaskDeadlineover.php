<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Notifications\TaskDeadlineOverManagerNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class NotifyTaskDeadlineover extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-task-deadlineover';

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
        $currentDateTime = Carbon::now();

        $startTime = $currentDateTime->copy()->subMinute();
        $endTime = $currentDateTime->copy()->addMinute();

        $tasks = Task::select('user_id','project_id','name', 'end_date','status')->where('status', '!=' , 2)->with(['user','project'])->whereBetween('end_date', [$startTime, $endTime])
        ->get();

        // $this->table(
        //     ['name','end_date'],
        //     $tasks->toArray()
        // );

        foreach($tasks as $task) {
            $projectManager = $task->project->projectManager;
            $projectName = $task->project->name;
            $userName = $task->user->name;
            $endTime = Carbon::parse($task->end_date)->format('g:i A');

            if ($projectManager) {
                Notification::route('mail', $projectManager->email)
                ->notify(new TaskDeadlineOverManagerNotification($projectManager->name, $projectName, $task->name, $userName, $endTime));
            }
        }
    }
}
