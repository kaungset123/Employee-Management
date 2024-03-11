<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Models\Rating;
use App\Models\Project;
use App\Models\Department;
use App\Models\Leave;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Illuminate\support\str;

use App\Constants\ProjectStatus;
use App\Models\SalaryCriteria;

    function calculateProgress($user_id,$project_id)
    {
        $userExist = Task::where(['user_id' => $user_id,'project_id' => $project_id])->count();

        if($userExist < 1){
            $user = User::findOrFail($user_id);
            return [
                'deadlineWarning' => null,
                'totalTask' => 0,
                'remainingTask' => 0,
                'progressPercentage' => 0,
                'user' => $user
            ];
        }else {
            $totalTask = Task::where(['user_id' => $user_id,'project_id' => $project_id])->count();

            $completeTask = Task::where(['user_id' => $user_id,'project_id' => $project_id])->where('status',2)->count();

            $remainingTask = $totalTask - $completeTask;

            $user = User::findOrFail($user_id);

            $progressPercentage =  ($totalTask > 0) ? (($completeTask / $totalTask ) * 100) : 0 ;

            $deadlineWarning = deadLineWarning($project_id,$user_id);

            return [
                'deadlineWarning' => $deadlineWarning,
                'totalTask' => $totalTask,
                'remainingTask' => $remainingTask,
                'progressPercentage' => $progressPercentage,
                'user' => $user
            ];
        }
        
    }

    function calculateProjectProgress($project_id)
    {
        $all = Task::where('project_id',$project_id)->count();
      
        $completed = Task::where('project_id',$project_id)->where('status',2)->count();
  
        $remain = $all - $completed ;
        $project = Project::findOrFail($project_id);
    
        $progress = ($all > 0) ? (($completed / $all) * 100) : 0 ;
       
        if ($progress == 100) {
            Project::where('id', $project_id)->update(['status' => ProjectStatus::COMPLETED]);
        }

        $deadlineWarning = deadLineWarning($project_id);
        
        return [
            'deadlineWarning' => $deadlineWarning,
            'total' => $all,           
            'remain' => $remain,
            'progress' => $progress,
            'project' => $project
        ];
    }

    function deadLineWarning($projectId,$taskId = null,$user_id = null)
    {
        if ($user_id !== null) {
            $task = Task::where('id',$taskId)->where('project_id', $projectId)
                ->where('user_id', $user_id)
                ->orderBy('end_date', 'desc')
                ->firstOrFail();
    
            $differenceInDays = Carbon::now()->diffInDays($task->end_date) + 1;
        } else {
            $project = Project::findOrFail($projectId);
    
            $differenceInDays = Carbon::now()->diffInDays($project->end_date);
        }

        $warningThreshold = 7;
        $isDeadlineNear = $differenceInDays <= $warningThreshold;
    
        return [
            'difference_in_days' => $differenceInDays,
            'is_deadline_near' => $isDeadlineNear,
        ];
    }

    function taskDeadLine($project_id,$taskId,$user_id)
    {
        $task = Task::where('id',$taskId)->where('project_id', $project_id)
        ->where('user_id', $user_id)
        ->orderBy('end_date', 'desc')
        ->first();
        // Use $task as needed
        $differenceInDays = Carbon::now()->diffInDays($task->end_date) + 1;
        $warningThreshold = 7;
        $isDeadlineNear = $differenceInDays <= $warningThreshold;

        return [
            'difference_in_days' => $differenceInDays,
            'is_deadline_near' => $isDeadlineNear,
        ];   
    }

    function admin_dash()
    {
        $allCount = Project::count();
        $runningCount = Project::select('id')->where('status',1)->count();
        $complete_count = Project::select('id')->where('status',3)->count();
        $departments = Department::select('id','name')->get();
        
        $dpms = [];
        foreach($departments as $department){
            $dpms[] = [
                'users' => $department->users,
                'memberCount' => $department->users->count(),
                'department_name' => $department->name,
                'department_id' => $department->id
                ] ;            
        }
       
        return [
            'departments' => $dpms,
            'all_count' => $allCount,
            'run_count' => $runningCount,
            'complete_count' => $complete_count,
        ];

    }

    if (!function_exists('calculateAverageRating')) 
    {
        function calculateAverageRating($ratedUserId)
        {
            $user = User::findOrFail($ratedUserId);
            
            if (!is_numeric($ratedUserId)) {
                return null;
            }
    
            $averageRating = Rating::where('rated_id', $ratedUserId)
                ->avg('rating');
            
    
            $rating = number_format($averageRating, 1);

            return [
                'user' => $user,
                'rating' => $rating
            ];
        }
    }
    
    if(!function_exists('ratingAvailableCheck'))
    {
        function ratingAvailableCheck($rater_id,$rated_id)
        {
            $existingRating = Rating::where('rater_id', $rater_id)
            ->where('rated_id', $rated_id)
            ->where('created_at', '>', Carbon::now()->subMonth())
            ->first();

            return $existingRating;
        }
    }

    if(!function_exists('leaveLimitCalculation'))
    {
        function leaveLimitCalculation($user_id,$startDate,$endDate,$half_day)
        {
            $currentYear = now()->year;
            
            $totalDayOld = Leave::where('user_id', $user_id)
                           ->where('status',1)
                           ->whereYear('created_at', $currentYear)
                           ->sum('total_days');
    
            $totalNewDay = '';
            $is_half_day = '';
            $start_date = Carbon::parse($startDate);
            $end_date = Carbon::parse($endDate);
    
            if($half_day == null){
                $is_half_day = 1 ; 
            }else{
                $is_half_day = 0.5 ;
            }

            $total_day = $start_date->diffInDays($end_date) + 1;

            if($total_day > 1 ){
                $totalNewDay = $total_day;
            }elseif($total_day == 1){
                $totalNewDay = $total_day * $is_half_day;
            }
    
            $limitTotalDay = $totalDayOld + $totalNewDay; // calculate limited 
            return [
                'limitTotalDay' =>  $limitTotalDay,
                'totalNewDay' => $totalNewDay 
            ];
        }
    }

    if(!function_exists('leaveSearchbar'))
    {
        function leaveSearchbar($leavesQuery,$query,$department_name,$created_at)
        {
            if ($query) {
                $leavesQuery->whereHas('user', function ($subQuery) use ($query) {
                    $subQuery->where('name', 'like', "%$query%");
                });
            }

            if ($department_name) {
                $leavesQuery->whereHas('user.department', function ($subQuery) use ($department_name) {
                    $subQuery->where('name', 'like', "%$department_name%");
                });
            }

            if ($created_at) {
                $leavesQuery->whereDate('start_date', $created_at);
            }

            return  $leavesQuery;      
        }
    }

    if(!function_exists('leaveBalanceSearchbar'))
    {
        function leaveBalanceSearchbar($leavesQuery,$query,$department_name,$created_at)
        {
            if ($query) {
                $leavesQuery->whereHas('user', function ($subQuery) use ($query) {
                    $subQuery->where('name', 'like', "%$query%");
                });
            }

            if ($department_name) {
                $leavesQuery->whereHas('user.department', function ($subQuery) use ($department_name) {
                    $subQuery->where('name', 'like', "%$department_name%");
                });
            }

            if ($created_at) {
                $leavesQuery->whereYear('start_date', $created_at);
            }

            return  $leavesQuery;      
        }
    }

    if(!function_exists('attendanceSearchbar'))
    {
        function attendanceSearchbar($attendanceQuery,$query,$department_name,$created_at)
        {
            if ($query) {
                $attendanceQuery->whereHas('user', function ($subQuery) use ($query) {
                    $subQuery->where('name', 'like', "%$query%");
                });
            }

            if ($department_name) {
                $attendanceQuery->whereHas('user.department', function ($subQuery) use ($department_name) {
                    $subQuery->where('name', 'like', "%$department_name%");
                });
            }

            if ($created_at) {
                $attendanceQuery->whereDate('created_at', $created_at);
            }

            return  $attendanceQuery;    
        }
    }
    
    if(!function_exists('userSearchbar'))
    {
        function userSearchbar($query,$department_name,$created_at)
        {
            $usersQuery = User::orderBy('created_at', 'desc')->withTrashed('id', 'img', 'name', 'email', 'department_id', 'created_by', 'updated_by', 'created_at','deleted_at');

            if ($query) {
                $usersQuery->where('users.name', 'like', "%$query%");
            }

            if ($created_at) {
                $usersQuery->whereDate('users.created_at', $created_at);
            }

            if ($department_name) {
                $usersQuery->whereHas('department', function ($query) use ($department_name) {
                    $query->where('name', 'like', "%$department_name%");
                });
            }

            return  $usersQuery;      
        }
    }

    if(!function_exists('leaveBalanceSearch'))
    {
        function leaveBalanceSearch($leavesQuery,$query,$department_name,$created_at)
        {
            // dd($leavesQuery);
            if ($query) {
                $leavesQuery->whereHas('user', function ($userQuery) use ($query) {
                    $userQuery->where('name', 'like', '%' . $query . '%');
                });
            }
    
            if ($department_name) {
                $leavesQuery->whereHas('user.department', function ($departmentQuery) use ($department_name) {
                    $departmentQuery->where('name', 'like', '%' . $department_name . '%');
                });
            }
    
            if ($created_at) {
                $leavesQuery->whereDate('created_at', $created_at);
            }

            return $leavesQuery;
        }
    }

    if(!function_exists('projectSearchbar'))
    {
        function projectSearchbar($query,$member_name,$created_at,$projectQuery)
        {
            if($query) {
                $projectQuery->where('name', 'like', "%$query%");
            }
    
            if($member_name) {
                $projectQuery->whereHas('members', function ($subQuery) use ($member_name) {
                    $subQuery->where('name', 'like', "%$member_name%");
                });  
            }
    
            if($created_at) {
                $projectQuery->whereDate('start_date', $created_at);
            }
    
            return $projectQuery;        
        }
    }

    if(!function_exists('leaveBalanceCount'))
    {
        function leaveBalanceCount($userId,$created_at = null)
        {
            $year = null ;
            if($created_at == null){           
                $year =  now()->year;             
            }else{
                $year = $created_at;
            }
            // dd($year);
           return Leave::with(['user.department'])
                ->selectRaw('user_id, COUNT(CASE WHEN status = 1 THEN 1 END) as total_count')
                ->selectRaw('user_id, COUNT(CASE WHEN name = "annual leave" AND status = 1 THEN 1 END) as annual_leave')
                ->selectRaw('user_id, COUNT(CASE WHEN name = "other leave" AND status = 1 THEN 1 END) as other_leave')
                ->where('user_id', $userId) 
                ->whereYear('start_date',$year)
                ->groupBy('user_id')
                ->first();
        }
    }

    if(!function_exists('leaveBalanceQuery'))
    {
        function leaveBalanceQuery($leavesQuery,$user_ids)
        {
           return  Leave::whereIn('user_id', $user_ids)
                    ->select('user_id',
                    DB::raw('MAX(name) as name'),
                    DB::raw('MAX(start_date) as start_date'),
                    DB::raw('MAX(end_date) as end_date'),
                    DB::raw('MAX(total_days) as total_days'),
                    DB::raw('MAX(status) as status')
                    )
                    ->groupBy('user_id');
        }
    }

    if(!function_exists('overtimeCalculation'))
    {
        function overtimeCalculation($clock_in,$clock_out)
        {
            $clockInTime = Carbon::parse($clock_in);
            $clockOutTime = Carbon::parse($clock_out);

            // Calculate the difference in minutes
            $workedHours = $clockOutTime->diffInMinutes($clockInTime);

            // Calculate overtime
            $regularHours = 8 * 60; 
            $overtimeMinutes = max(0, $workedHours - $regularHours);

            $overtimeHours = floor($overtimeMinutes / 60);
            return $overtimeHours;
        }
    }

    if(!function_exists('salarySearchbar'))
    {
        function salarySearchbar($leavesQuery,$query,$department_name,$created_at)
        {
            if ($query) {
                $leavesQuery->whereHas('user', function ($subQuery) use ($query) {
                    $subQuery->where('name', 'like', "%$query%");
                });
            }

            if ($department_name) {
                $leavesQuery->whereHas('user.department', function ($subQuery) use ($department_name) {
                    $subQuery->where('name', 'like', "%$department_name%");
                });
            }

            if ($created_at) {
                $leavesQuery->whereDate('created_at', $created_at);
            }

            return  $leavesQuery;      
        }
    }

    if(!function_exists('salaryCalculation'))
    {
        function salaryCalculation($user_id,Carbon $date)
        {
            $month = $date->month;
            $year = $date->year;
            
            $user = User::findOrFail($user_id);
            $basicSalary = $user->basic_salary;
            $otRate = $user->ot_rate;
            $hourlyRate = $user->hourly_rate;
            $netSalary = 0;
        
            $otTimes = Attendance::withTrashed()
                ->where('user_id', $user_id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->sum('overtime');
        
            $otPay = $otTimes * $otRate;
        
            $annualLeave = Leave::withTrashed()
                ->where('user_id', $user_id)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->where(['name'=>'annual leave','status'=>1])
                ->sum('total_days');
    
            $totalLeaveDays = Leave::withTrashed()
                ->where('user_id', $user_id)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->where(['name'=>'other leave','status'=>1])
                ->sum('total_days');

            $deduction = $totalLeaveDays * $hourlyRate * 8;
        
            $salary = $basicSalary + $otPay ;
            $netSalary = ($basicSalary + $otPay) - $deduction;

            // net salary with bonus
            $bonusTime = ($month === 12);
            $bonus = 0 ;
            $averageRating = 0 ;
            $rating_bonus = 0;

            if($bonusTime) {   
                $bonus = ($annualLeave == 0 && $totalLeaveDays == 0) ? $basicSalary : 0 ;
    
                $averageRating = Rating::where('rated_id', $user_id)
                    ->avg('rating');
                $averageRating = number_format($averageRating, 1);
    
                $user_rating = ceil($averageRating);
    
                $criterias = SalaryCriteria::select('rating_point','bonus_amount')->get();
    
                foreach($criterias as $criteria) {
                    if($criteria->rating_point == $user_rating) {
                        $rating_bonus = $criteria->bonus_amount;
                    }else {
                        $rating_bonus = 0 ;
                    }
                }

                $netSalary = $netSalary + $bonus + $rating_bonus ;
            }
        
            return [
                'date' => $date,
                'annual_leave' => $annualLeave,
                'salary' => $salary,
                'user_id' => $user_id,
                'net_salary' => $netSalary,
                'ot_time' => $otTimes,
                'ot_amount' => $otPay,
                'deduction' => $deduction,
                'leave' => $totalLeaveDays,
                'bonus' => $bonus,
                'rating' => $averageRating,
                'rating_bonus' => $rating_bonus
            ];           
        }
    }

//Img
    if(!function_exists('imgExtension'))
    {
        function imgExtension($imgFile)
        {
            if (!empty($imgFile)) {
                $extension = $imgFile->getClientOriginalExtension();
                $file = $imgFile;
                $randomStr = date('Ymshis') . Str::random(20);
                $filename = strtolower($randomStr) . '.' . $extension;
                $file->storeAs('uploads',$filename,'public',);
                $img = $filename;  
                return $img;         
            }
        }
    }

    if(!function_exists('imgChecker'))
    {
        function imgChecker($user,$imgFile,$old_img)
        {
            $img = "";
            if (!empty($imgFile)) {
                $img = $user->img;
                if(!empty($img)){
                    $img_path = public_path('storage/uploads/'. $img);
                    if(file_exists($img_path)){
                         unlink($img_path);
                    }              
                }
                
                $extension = $imgFile->getClientOriginalExtension();
                $file = $imgFile;
                $randomStr = date('Ymshis') . Str::random(20);
                $filename = strtolower($randomStr) . '.' . $extension;
                $file->storeAs('uploads',$filename,'public',);
                $img = $filename;                     
            }else{              
                $img= $old_img;
            }
            return $img;
        }
    }



    

    

