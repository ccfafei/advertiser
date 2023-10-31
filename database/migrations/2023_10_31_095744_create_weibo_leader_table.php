<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWeiboLeaderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('weibo_leader', function(Blueprint $table)
		{
			$table->increments('leader_id');
			$table->string('leader_name', 191)->unique('leader_name_unique')->comment('负责人');
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
		Schema::drop('weibo_leader');
	}

}
