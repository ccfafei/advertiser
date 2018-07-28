<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $table = 'trade';   
    protected $primaryKey = 'trade_id';
    public $timestamps = true;
    
    //格式化时间
    public function setTradeTsAttribute($value)
    {
        $this->attributes['trade_ts'] = is_int($value) ? $value : strtotime($value);
    }
    
    public function getTradeTsAttribute()
    {
        return  $this->attributes['trade_ts'];
        
    }
    
    //利润
    public function setProfitAttribute($value)
    {
        $this->attributes['profit'] = isset($value) ? 
                $value :  $this->attributes['customer_price']- $this->attributes['media_price'];
    }
    
    public function getProfitAttribute()
    {
        return $this->attributes['profit'];
        
    }
    

    //客户id获取
    public function setCustomerIdAttribute($value)
    {
        if(!empty($this->attributes['customer_name'])){
            $customer_id =Customer::where('company',$this->attributes['customer_name'])->value('customer_id');
        }
        $this->attributes['customer_id'] = is_int($value) ?$value : $customer_id;
    }
    
    public function getCustomeIdAttribute()
    {
       return $this->attributes['customer_id'];
    }
    
    
    //媒体id
    public function setMediaIdAttribute($value)
    {
        $media_id=0;
        if(!empty($this->attributes['media_name'])){
            $media_id =Media::where('media_name',$this->attributes['media_name'])->value('media_id');
        }
        $this->attributes['media_id'] = is_int($value) ?$value : $media_id;
    }
    
    public function getMediaIdAttribute()
    {
        return $this->attributes['media_id'];
    }
}
