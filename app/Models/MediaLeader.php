<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaLeader extends Model
{
    protected $table = 'media_leader';   
    protected $primaryKey = 'leader_id';
    public $timestamps = false;
}
