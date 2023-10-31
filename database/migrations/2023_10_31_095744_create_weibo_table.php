<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWeiboTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('weibo', function(Blueprint $table)
		{
			$table->increments('weibo_id');
			$table->timestamp('weibo_ts')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('weibo_name', 100)->index('idx_weibo_name')->comment('微博名称');
			$table->boolean('weibo_category')->comment('微博分类id');
			$table->integer('fans')->nullable()->comment('粉丝数');
			$table->decimal('direct_price', 10)->comment('直发价');
			$table->decimal('forward_price', 10)->comment('转发价');
			$table->string('cases', 1000)->comment('案例');
			$table->string('direct_microtask', 50)->comment('微任务直发');
			$table->string('forward_microtask', 50)->comment('微任务转发');
			$table->boolean('leader')->comment('负责人id');
			$table->text('remark', 65535)->nullable()->comment('备注');
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
		Schema::drop('weibo');
	}

}
