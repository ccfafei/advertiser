<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaChannel extends Model
{
    protected $table = 'media_channel';   
    protected $primaryKey = 'channel_id';
    public $timestamps = false;
}
