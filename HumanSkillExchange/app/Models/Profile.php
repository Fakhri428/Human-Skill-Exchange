<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'location',
        'work_mode',
        'available_time',
        'portfolio_url',
        'social_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
