<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('media', function(Blueprint $table)
		{
			$table->increments('media_id');
			$table->timestamp('media_ts')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('area', 100)->nullable()->comment('区域');
			$table->string('media_name', 100)->index('idx_media_name')->comment('媒体名称');
			$table->boolean('category')->comment('媒体分类');
			$table->boolean('channel')->comment('频道');
			$table->decimal('price', 10)->comment('单价');
			$table->string('collection', 1000)->comment('收录');
			$table->string('cases', 1000)->comment('案例');
			$table->string('leader', 191)->comment('负责人');
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
		Schema::drop('media');
	}

}
