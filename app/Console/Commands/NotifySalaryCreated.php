<?php

namespace App\Console\Commands;

use App\Models\SalaryDetail;
use App\Models\User;
use App\Notifications\SalaryAdminNotification;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class NotifySalaryCreated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-salary-created';

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
        $userCount = User::where('department_id', '!=', null)->count();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        $salaryCount = SalaryDetail::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count() == $userCount ;
        $admins = User::role(['admin','super admin'])->get();

        if($salaryCount) {
            foreach($admins as $admin) {
                $adminName = $admin->name;
                Notification::route('mail', $admin->email)
                ->notify(new SalaryAdminNotification($adminName));
            }            
        }
    }
}
