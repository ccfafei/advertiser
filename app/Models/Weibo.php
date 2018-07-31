<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weibo extends Model
{
    protected $table = 'weibo';  
    protected $primaryKey = 'weibo_id';
    //protected $dateFormat = 'U';
    public $timestamps = true;
    
    
}
