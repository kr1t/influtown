<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Influencer extends Model
{
    protected $fillable = ['gender', 'age', 'type', 'dislike', 'follow', 'profile_url', 'budget', 'name', 'nickname', 'user_id'];

    protected $casts = [
        'type' => 'Array',
    ];

    protected $appends = [
        'full_name', 'gender_text', 'age_text'
    ];


    public function images()
    {
        return $this->hasMany('App\InfluencerImage');
    }

    public function getFullNameAttribute()
    {
        return "{$this->name}";
    }

    public function getGenderTextAttribute()
    {
        $gender = $this->gender;
        $g = '';
        switch ($gender) {
            case 'M';
                $g = 'ชาย';
                break;

            case 'F';
                $g = 'หญิง';
                break;

            case 'L';
                $g = 'LGBT';
                break;
        }

        return $g;
    }

    public function getAgeTextAttribute()
    {
        $age = $this->age;
        $a = '';
        switch ($age) {
            case 1;
                $a = 'ต่ำกว่า18';
                break;
            case 2;
                $a = '18-23';
                break;
            case 3;
                $a = '24-27';
                break;
            case 4;
                $a = '28-30';
                break;
            case 5;
                $a = '30ขึ้นไป';
                break;
        }

        return $a;
    }
}
