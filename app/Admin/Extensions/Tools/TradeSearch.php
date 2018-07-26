<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class TradeSearch extends AbstractTool
{
    
    public function render()
    {

        $options = [
            'all'=>'请选择',
            '0'   => '未审核',
            '1'     => '审核通过',
            '2'     => '审核不通过',
        ];

        return view('admin.tools.search', compact('options'));
    }
}