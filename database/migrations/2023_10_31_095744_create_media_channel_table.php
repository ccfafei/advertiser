<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediaChannelTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('media_channel', function(Blueprint $table)
		{
			$table->increments('channel_id');
			$table->string('channel_name', 191)->unique()->comment('分类名称名称');
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
		Schema::drop('media_channel');
	}

}
