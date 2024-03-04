<?php

namespace App\Listeners;

use App\Events\RequestCreate;
use App\Models\User;
use App\Notifications\RequestCreateNotification;
use Illuminate\Support\Facades\Notification;

class NotifyRequestCreate
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
    public function handle(RequestCreate $event): void
    {
        $requested = '';
        $victim = null;
        $requester = auth()->user();

        $users = $event->leave->user->department->users;
        $requester_name = $event->leave->user->name;
        $leave = $event->leave->name;

        if($requester->hasRole('HR') || $requester->hasRole('employee'))
        {
            foreach ($users as $user) {
                if($user->hasRole('manager')) {
                    $victim = $user;
                    $requested = $user->name;
                }
            }
        }
        else{
            $users = User::get();
            foreach ($users as $user) {
                if($user->hasRole('admin')) {
                    $victim = $user;
                    $requested = $user->name;
                }
            }
        } 
        $data = compact('requester_name','leave','requested');
        Notification::send($victim, new RequestCreateNotification($data));
    }
}
