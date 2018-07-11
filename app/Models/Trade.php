<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $table = 'trade';   
    protected $dateFormat = 'U';
    public $timestamps = true;
}
