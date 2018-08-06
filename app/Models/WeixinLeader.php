<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeixinLeader extends Model
{
    protected $table = 'weixin_leader';  
    protected $primaryKey = 'leader_id';
    //protected $dateFormat = 'U';
    public $timestamps = false;
    
    
}
