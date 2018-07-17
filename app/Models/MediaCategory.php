<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaCategory extends Model
{
    protected $table = 'media_category';   
    protected $primaryKey = 'category_id';
    public $timestamps = false;
}
