<?php
namespace App\Constants;

class LeaveRequestStatus
{
    const PENDING = 0;
    const ACCEPTED = 1;
    const REJECTED = 2;


    /**
     * Get all constants defined in the class.
     *
     * @return array
     */
    public static function getConstants()
    {
        return [
            self::PENDING => 'pending',
            self::ACCEPTED => 'accepted',
            self::REJECTED => 'rejected',
        ];
    }
}

 
?>