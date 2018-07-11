<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';   
    protected $dateFormat = 'U';
    public $timestamps = true;
}
