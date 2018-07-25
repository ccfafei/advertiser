<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class TradeSearch extends AbstractTool
{
    

    protected $action;
    
    public function __construct($action = 1)
    {
        $this->action = $action;
    }



    public function render()
    {

        $options = [
            '0'   => '未审核',
            '1'     => '审核通过',
            '2'     => '审核不通过',
        ];

        return view('admin.tools.search', compact('options'));
    }
}