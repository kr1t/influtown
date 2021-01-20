<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Influencer extends Model
{
    protected $fillable = ['gender', 'age', 'type', 'dislike', 'follow', 'profile_url', 'budget', 'name', 'nickname', 'user_id', 'expiry'];

    protected $casts = [
        'type' => 'Array',
    ];

    protected $appends = [
        'full_name', 'gender_text', 'age_text', 'type_text', 'follow_text'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }

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
                $a = 'ต่ำกว่า 18 ปี';
                break;
            case 2;
                $a = '18-23 ปี';
                break;
            case 3;
                $a = '24-27 ปี';
                break;
            case 4;
                $a = '28-30 ปี';
                break;
            case 5;
                $a = '30 ปี ขึ้นไป';
                break;
        }

        return $a;
    }
    public function getTypeTextAttribute()
    {
        $s = [];
        $t = [
            'เสื้อผ้าและกีฬา',
            'เครื่องสำอางค์',
            'อาหาร',
            'ท่องเที่ยว',
            'เทคโนโลยี แก็ดเจ็ด เกม'
        ];
        foreach ($this->type as $index => $type) {
            array_push($s, $t[$index]);
        }
        return $s;
    }


    public function getFollowTextAttribute()
    {
        $t = [
            'ต่ำกว่า 1000',
            '1,000 - 10,000',
            '10,001 - 50,000',
            '50,001 - 100,000',
            '100,001 - 1,000,000',
            '1,000,000 ขึ้นไป'
        ];
        $follow = $this->follow;
        $a = '';
        switch ($follow) {
            case 1;
                $a = $t[0];
                break;
            case 2;
                $a = $t[1];
                break;
            case 3;
                $a = $t[2];
                break;
            case 4;
                $a = $t[3];
                break;
            case 5;
                $a = $t[4];
                break;
            case 6;
                $a = $t[5];
                break;
        }

        return $a;
    }
}