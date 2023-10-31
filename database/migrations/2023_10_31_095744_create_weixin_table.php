<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWeixinTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('weixin', function(Blueprint $table)
		{
			$table->increments('weixin_id');
			$table->timestamp('weixin_ts')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('weixin_name', 100)->index('weixin_name_unique')->comment('微信名称');
			$table->string('ID', 100)->nullable()->comment('id');
			$table->boolean('weixin_category')->comment('行业分类id');
			$table->integer('fans')->nullable()->default(0)->comment('粉丝数');
			$table->string('headline', 50)->nullable()->comment('头条');
			$table->string('secondline', 50)->nullable()->comment('次条');
			$table->string('thirdline', 50)->nullable()->comment('第三条');
			$table->string('cases', 1000)->nullable()->comment('案例');
			$table->integer('readers')->nullable()->comment('预估阅读数');
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
		Schema::drop('weixin');
	}

}
