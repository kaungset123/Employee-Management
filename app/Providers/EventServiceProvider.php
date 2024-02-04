<?php

namespace App\Providers;

use App\Events\AttendanceCreate;
use App\Events\ProjectCreate;
use App\Events\RequestAccepted;
use App\Events\RequestCreate;
use App\Events\RequestRejected;
use App\Events\SalaryCreate;
use App\Events\SalaryCreateAdmin;
use App\Events\TaskCreate;
use App\Listeners\NotifyAttendanceCreate;
use App\Listeners\NotifyProjectCreate;
use App\Listeners\NotifyRequestAccepted;
use App\Listeners\NotifyRequestCreate;
use App\Listeners\NotifyRequestRejected;
use App\Listeners\NotifySalaryCreate;
use App\Listeners\NotifySalaryCreateAdmin;
use App\Listeners\NotifyTaskCreate;
use App\Listeners\SalaryCreateAdminNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ProjectCreate::class => [
            NotifyProjectCreate::class,
        ],
        SalaryCreate::class => [
            NotifySalaryCreate::class,
        ],
        TaskCreate::class => [
            NotifyTaskCreate::class,
        ],
        AttendanceCreate::class => [
            NotifyAttendanceCreate::class,
        ],
        RequestAccepted::class => [
            NotifyRequestAccepted::class,
        ],
        RequestRejected::class => [
            NotifyRequestRejected::class,
        ],
        RequestCreate::class => [
            NotifyRequestCreate::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
