<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWeixinCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('weixin_category', function(Blueprint $table)
		{
			$table->increments('category_id');
			$table->string('category_name', 191)->unique('weixin_category_unique')->comment('行业分类');
			$table->text('remark', 65535)->nullable()->comment('备注');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('weixin_category');
	}

}
