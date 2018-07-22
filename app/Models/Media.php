<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';  
    protected $primaryKey = 'media_id';
    //protected $dateFormat = 'U';
    public $timestamps = true;
    
    
}
