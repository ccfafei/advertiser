<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeiboCategory extends Model
{
    protected $table = 'weibo_category';  
    protected $primaryKey = 'category_id';
    //protected $dateFormat = 'U';
    public $timestamps = true;
    
    
}
