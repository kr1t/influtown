<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['tel', 'user_id', 'problem', 'influencer_id', 'status'];

    protected $appends = ['created_at_text'];

    public function images()
    {
        return $this->hasMany('App\ReportImage');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function getCreatedAtTextAttribute()
    {
        return $this->created_at ? \Carbon\Carbon::parse($this->created_at)->format('d/m/Y H:i:s') : '-';
    }

    public function influencer()
    {
        return $this->belongsTo('App\Influencer');
    }
}