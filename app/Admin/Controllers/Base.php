<?php

namespace App\Admin\Controllers;

use App\Models\Customer;
use App\Models\Media;
use App\Models\MediaLeader;
use App\Models\MediaCategory;
use App\Models\MediaChannel;
use App\Models\WeiboCategory;
use App\Models\WeiboLeader;
use App\Models\WeixinCategory;
use App\Models\WeixinLeader;
class Base{
    
    //通过客户名获取相关信息
    public static function getCustomer($customer_name){
        $customer=[];
        $customer = Customer::where('company',$customer_name)->first();
        if($customer) {
            $customer =$customer->toArray();
        }  
        return $customer;
    }
    
    //通过媒体名获取相关信息
    public static function getMedia($media_name){
        $media=[];
        $media = Media::where('media_name',$media_name)->first();
        if($media) {
            $media =$media->toArray();
        }
        return $media;
    }
    
    
    
    //获取媒体分类
    public static function getCategory(){
        $categorys = MediaCategory::get();
        $arr=[];
        if($categorys){
            foreach($categorys as $category){
                $arr[$category->category_id] = $category->category_name;
            }
        }
        return $arr;
    }
    
    //获取负责人getLeader
    public static function getLeader(){
        $leaders = MediaLeader::get();
        $arr=[];
        if($leaders){
            foreach($leaders as $leader){
                $arr[$leader->leader_id] = $leader->leader_name;
            }
        }
        return $arr;
    }
    
    //获取频道列表
    public static function getChannel(){
        $channels = MediaChannel::get();
        $arr=[];
        if($channels){
            foreach($channels as $channel){
                $arr[$channel->channel_id] = $channel->channel_name;
            }
        }
        return $arr;
    }
    

    /**
     * 审核状态，进出款状态 ，在表格中显示不同样式
     * @param unknown $key 配置文件对应的key
     * @param unknown $status 对应状态码 0,1
     */
    public static function dispayStyle($key,$status){
        $sytles ="";
        $cfg = config('trade.'.$key);
        $status = (int)$status;
        if( $cfg === false)  return  $sytles = $status;
        if(empty($cfg[$status]))  return  $sytles = $status;
        
        switch ($status){
            case 0 :
                $lableColor = 'bg-red';
                break;
            case 1 :
                $lableColor = 'bg-green';
                break;
            case 2 :
                $lableColor = 'bg-yellow';
                break;
            case 3 :
                $lableColor = 'bg-blue';
                break;
            default:
                $lableColor = '';
                break;
        }
        return $sytles = "<lable class='label {$lableColor}'> {$cfg[$status]} </lable>";              
    }
    
      //获取媒体分类
    public static function getWeiboCategory(){
        $categorys = WeiboCategory::get();
        $arr=[];
        if($categorys){
            foreach($categorys as $category){
                $arr[$category->category_id] = $category->category_name;
            }
        }
        return $arr;
    }
    
    //获取负责人getLeader
    public static function getWeiboLeader(){
        $leaders = WeiboLeader::get();
        $arr=[];
        if($leaders){
            foreach($leaders as $leader){
                $arr[$leader->leader_id] = $leader->leader_name;
            }
        }
        return $arr;
    }
    
    
    //获取微信分类
    public static function getWeixinCategory(){
        $categorys = WeixinCategory::get();
        $arr=[];
        if($categorys){
            foreach($categorys as $category){
                $arr[$category->category_id] = $category->category_name;
            }
        }
        return $arr;
    }
    
    //获取负责人getLeader
    public static function getWeixinLeader(){
        $leaders =WeixinLeader::get();
        $arr=[];
        if($leaders){
            foreach($leaders as $leader){
                $arr[$leader->leader_id] = $leader->leader_name;
            }
        }
        return $arr;
    }
}