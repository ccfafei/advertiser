<?php

namespace App\Admin\Controllers;

use App\Models\Customer;
use App\Models\Media;
use App\Models\MediaLeader;
use App\Models\MediaCategory;
use App\Models\MediaChannel;

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
    
    //通过客户名获取相关信息
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
}