<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->increments('customer_id');
            $table->string('company')->unique()->comment('公司名称');
            $table->integer('develop_ts')->comment('开发日期');
            $table->string('name')->comment('联系人');
            $table->string('phone')->comment('电话');
            $table->string('qq')->comment('qq/微信');
            $table->string('project')->comment('项目');
            $table->string('is_cooperate')->comment('是否合作');
            $table->tinyInteger('type')->comment('类型');
            $table->tinyInteger('status')->comment('状态:0禁用，1启用');
            $table->text('remark')->comment('备注');                  
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer');
    }
}
