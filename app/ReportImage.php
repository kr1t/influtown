<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportImage extends Model
{
    protected $fillable = ['image_url', 'report_id'];
}
