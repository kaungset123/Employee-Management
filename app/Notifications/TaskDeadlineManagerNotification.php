<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskDeadlineManagerNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    public function __construct(protected $manager,protected $project,protected $task,protected $member)
    {
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
                    ->subject('Project member\'s task deadline notification!')
                    ->greeting('Hi '.$this->manager.' ,')
                    ->line("You are project leader of '{$this->project}' project.")
                    ->line("Your project-member {$this->member}'s task {$this->task}'s deadline is tomorrow!")
                    ->action('Check Now', url('http://ems.org/myproject'))
                    ->line('Thank you for using our application!');
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
