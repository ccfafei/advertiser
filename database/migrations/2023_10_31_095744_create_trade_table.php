<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTradeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trade', function(Blueprint $table)
		{
			$table->increments('trade_id');
			$table->integer('trade_ts')->index('idx_ts')->comment('日期');
			$table->string('customer_name', 50)->nullable()->index('idx_customer')->comment('客户名称');
			$table->integer('customer_id')->nullable()->comment('客户id');
			$table->string('media_name', 50)->nullable()->index('idx_media')->comment('媒体名称');
			$table->integer('media_id')->nullable()->comment('媒体id');
			$table->string('contribution', 100)->nullable()->index('idx_contribution')->comment('稿件名称');
			$table->string('project', 100)->nullable()->comment('项目链接');
			$table->integer('words')->nullable()->comment('字数');
			$table->decimal('price', 10)->nullable()->comment('单价');
			$table->decimal('customer_price', 10)->nullable()->comment('报价');
			$table->decimal('media_price', 10)->nullable()->comment('媒体款');
			$table->decimal('profit', 10)->nullable()->comment('利润');
			$table->boolean('is_received')->default(0)->index('idx_is_receive')->comment('是否回款');
			$table->boolean('is_paid')->default(0)->index('idx_is_paid')->comment('是否出款');
			$table->boolean('is_check')->default(0)->index('idx_is_check')->comment('是否有效');
			$table->string('leader', 40)->nullable()->index('idx_learder')->comment('负责人');
			$table->text('remark', 65535)->nullable()->comment('备注');
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
		Schema::drop('trade');
	}

}
