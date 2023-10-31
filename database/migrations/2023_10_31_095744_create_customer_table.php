<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer', function(Blueprint $table)
		{
			$table->increments('customer_id');
			$table->string('company', 191)->unique()->comment('公司名称');
			$table->timestamp('develop_ts')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('开发日期');
			$table->string('name', 191)->comment('联系人');
			$table->string('phone', 191)->comment('电话');
			$table->string('qq', 191)->comment('qq/微信');
			$table->string('project', 191)->comment('项目');
			$table->string('is_cooperate', 191)->comment('是否合作');
			$table->string('leader', 40);
			$table->boolean('type')->nullable()->comment('类型');
			$table->boolean('status')->comment('状态:0禁用，1启用');
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
		Schema::drop('customer');
	}

}
