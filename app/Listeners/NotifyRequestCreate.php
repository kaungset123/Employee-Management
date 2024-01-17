<?php

namespace App\Listeners;

use App\Events\RequestCreate;
use App\Models\User;
use App\Notifications\RequestCreateNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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
        // if($requester->hasRole('amdin'))
        // {
        //     $users = User::get();
        //     foreach($users as $user) {
        //         if($user->hasRole('')) {
        //             $victim = 
        //         }
        //     }
        // }
        $users = $event->leave->user->department->users;
        $requester_name = $event->leave->user->name;
        $leave = $event->leave->name;

        // dd($requester);
        if($requester->hasRole('HR') || $requester->hasRole('employee'))
        {
            //dd(auth()->user()->name);
            foreach ($users as $user) {
                // dd($user);
                if($user->hasRole('manager')) {
                    $victim = $user;
                    $requested = $user->name;
                }
            }
        }
        else
        {
            $users = User::get();
            foreach ($users as $user) {
                if($user->hasRole('admin')) {
                    $victim = $user;
                    $requested = $user->name;
                }
            }
        } 
        // dd($victim);
        $data = compact('requester_name','leave','requested');
        // dd($requested);
        Notification::send($victim, new RequestCreateNotification($data));
    }
}
