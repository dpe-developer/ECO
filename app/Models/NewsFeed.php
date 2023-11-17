<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsFeed extends Model
{
    protected $table = 'news_feeds';

    protected $fillable = [
        'content'
    ];

    /**
     * Relations
     */
    public function newsFeedFiles()
    {
        return $this->hasMany('App\Models\NewsFeedFile', 'news_feed_id');
    }

    public function getAnnouncementDuration()
    {
        $secondsAgo = $this->created_at->diffInSeconds(now());
        $minutesAgo = $this->created_at->diffInMinutes(now());
        $hoursAgo = $this->created_at->diffInHours(now());
        $daysAgo = $this->created_at->diffInDays(now());
        $duration = $secondsAgo . " seconds ago";
        if($hoursAgo > 24) {
            $duration = $daysAgo . " day ago";
            if($daysAgo > 1){
                $duration = $daysAgo . " days ago";
            }
        }elseif($minutesAgo > 60) {
            $duration = $hoursAgo . " hours ago";
        }elseif($secondsAgo > 60) {
            $duration = $minutesAgo . " minutes ago";
        }
        return $duration;
    }
}
