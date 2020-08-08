<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';  
    protected $primaryKey = 'media_id';
    //protected $dateFormat = 'U';
    public $timestamps = true;

    // 媒体分类
    public function categoryRelation(){
        return $this->hasOne('App\Models\MediaCategory','category_id','category');
    }


    // 频道
    public function channelRelation(){
        return $this->hasOne('App\Models\MediaChannel','channel_id','channel');
    }


    //  负责人
    public function leaderRelation(){
        return $this->hasOne('App\Models\MediaLeader','leader_id','leader');
    }
    
    
}
