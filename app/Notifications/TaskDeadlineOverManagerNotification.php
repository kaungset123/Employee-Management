<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskDeadlineOverManagerNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected $projectManager, protected $projectName, protected $taskName, protected $userName, protected $endTime)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Task Deadline Over Notification!')
                    ->greeting('Hi '.$this->projectManager.' ,')
                    ->line("In {$this->projectName},")
                    ->line("Deadline of the task named '{$this->taskName}' of your team-member '{$this->userName}' is over at {$this->endTime}!")
                    ->action('Check Now ', url('http://ems.org/myproject'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
