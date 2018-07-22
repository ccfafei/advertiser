<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $table = 'finance';   
    public $timestamps = true;
    
    //格式化时间
    public function setPayTsAttribute($value)
    {
        $this->attributes['pay_ts'] = is_int($value) ? $value : strtotime($value);
    }
    
    public function getPayTsAttribute()
    {
        return date('Y-m-d', $this->attributes['pay_ts']);
    }
    
    
}
