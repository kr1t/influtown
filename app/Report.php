<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['tel', 'user_id', 'problem', 'influencer_id'];
    public function images()
    {
        return $this->hasMany('App\ReportImage');
    }
}