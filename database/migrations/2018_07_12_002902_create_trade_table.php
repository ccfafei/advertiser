<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade', function (Blueprint $table) {
            $table->increments('trade_id');
            $table->integer('trade_ts')->comment('日期');
			$table->string('customer_name')->index()->comment('客户名称');
			$table->integer('customer_id')->comment('客户id');
            $table->string('media_name')->index()->comment('媒体名称');
			$table->integer('media_id')->comment('媒体id');
            $table->string('contribution')->comment('稿件名称');
            $table->integer('words')->comment('字数');
            $table->decimal('price', 8, 3)->comment('单价');
            $table->decimal('customer_price', 8, 3)->comment('报价');
            $table->decimal('media_price', 8, 3)->comment('媒体款');
            $table->decimal('profit', 8, 3)->comment('利润'); 
            $table->tinyInteger('is_received')->comment('是否回款');
            $table->tinyInteger('is_paid')->comment('是否出款'); 
            $table->tinyInteger('is_check')->comment('是否有效');
            $table->text('remark')->nullable()->comment('备注');
            $table->timestamps();
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trade');
    }
}
