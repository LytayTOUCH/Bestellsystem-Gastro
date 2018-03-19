<?php

namespace App\Models\Helper;

use App\Models\SiteSettings;
use App\User;
use Illuminate\Database\Eloquent\Model;

class UserLogs extends Model
{
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    /**
     * Create a new log entry for a user
     * @param $user_id The specified user id
     * @param null $action The commited action
     * @param null $log_message The log message
     * @return UserLogs Returned Model Object
     */
    public static function create($user_id, $action = null, $log_message = null)
    {
        if (SiteSettings::all()->first()->module_logging) {
            $userLogs = new UserLogs();
            $userLogs->user_id = $user_id;
            $userLogs->action = $action;
            $userLogs->log_message = $log_message;
            $userLogs->computer_adress = $_SERVER['REMOTE_ADDR'];
            $userLogs->save();
            return $userLogs;
        }
        return null;
    }
}
