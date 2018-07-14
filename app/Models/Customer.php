<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Customer extends Model
{
    protected $table = 'customer';   
    protected $primaryKey = 'customer_id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    
   
}
