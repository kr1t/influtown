<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Influencer extends Model
{
    protected $fillable = ['gender', 'age', 'type', 'dislike', 'follow', 'profile_url', 'budget', 'name', 'nickname', 'user_id'];

    protected $casts = [
        'type' => 'Array',
    ];

    public function images()
    {
        return $this->hasMany('App\InfluencerImage');
    }
}