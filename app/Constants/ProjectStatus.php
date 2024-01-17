<?php
namespace App\Constants;

class ProjectStatus
{
    const NOT_STARTED = 0;
    const IN_PROGRESS = 1;
    const ON_HOLD = 2;
    const COMPLETED = 3;
    const CANCELLED = 4;


    /**
     * Get all constants defined in the class.
     *
     * @return array
     */
    public static function getConstants()
    {
        return [
            self::NOT_STARTED => 'Not Started',
            self::IN_PROGRESS => 'In Progress',
            self::ON_HOLD => 'On Hold',
            self::COMPLETED => 'Completed',
            self::CANCELLED => 'Cancelled',
        ];
    }
}

 
?>