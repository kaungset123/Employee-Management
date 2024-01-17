<?php
namespace App\Constants;

class TaskStatus
{
    const NOT_STARTED = 0;
    const IN_PROGRESS = 1;
    const COMPLETED = 2;


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
            self::COMPLETED => 'Completed',
        ];
    }
}

 
?>