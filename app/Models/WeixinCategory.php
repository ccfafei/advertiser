<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeixinCategory extends Model
{
    protected $table = 'weixin_category';  
    protected $primaryKey = 'category_id';
    //protected $dateFormat = 'U';
    public $timestamps = false;
    
    
}
