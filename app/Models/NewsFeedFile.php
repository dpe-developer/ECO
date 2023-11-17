<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsFeedFile extends Model
{
    protected $table = 'news_feed_files';

    protected $fillable = [
        'news_feed_id',
        'file_attachment_id',
        'file_type',
    ];

    /**
     * Relations
     */
    public function newsFeed()
    {
        return $this->belongsTo('App\Models\NewsFeed', 'news_feed_id');
    }

    public function fileAttachment()
    {
        return $this->belongsTo('App\Models\FileAttachment', 'file_attachment_id');
    }
    /**
     * END OF Relations
     */
}
