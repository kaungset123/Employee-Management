<?php
namespace App\Services;

use App\Models\Task;

class TaskProgressService {
    public function calculateProgress($user_id)
    {
        $totalTask = Task::where('user_id',$user_id)->count();
        $completeTask = Task::where('user_id',$user_id)->where('status',2)->count();

        return ($totalTask > 0) ? (($completeTask / $totalTask ) * 100) : 0 ;
     }
}


?>