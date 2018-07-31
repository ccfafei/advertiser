<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeiboLeader extends Model
{
    protected $table = 'weibo_leader';  
    protected $primaryKey = 'leader_id';
    //protected $dateFormat = 'U';
    public $timestamps = true;
    
    
}
