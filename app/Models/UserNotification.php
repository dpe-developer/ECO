<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Auth;;

class UserNotification extends Model
{
    protected $table = 'user_notifications';

    protected $fillable = [
        'user_id',
        'entity_id',
        'notification_type',
        'is_seen',
    ];

    public static function isNotSeen($notificationType, $entityId)
    {
        if(self::where([
            ['notification_type', $notificationType],
            ['user_id', Auth::user()->id],
            ['entity_id', $entityId],
        ])->doesntExist()){
            return true;
        }
        return false;
    }
    
}
