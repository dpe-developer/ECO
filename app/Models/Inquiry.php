<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $table = 'inquiries';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'subject',
        'message',
    ];

    /**
     * Relations
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    /**
     * END OF Relations
     */
    
}
