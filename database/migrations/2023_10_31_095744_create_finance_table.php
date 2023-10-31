<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFinanceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('finance', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('pay_ts')->comment('日期');
			$table->string('project', 191)->comment('项目');
			$table->decimal('money')->comment('金额');
			$table->string('bank_account', 191)->comment('账号');
			$table->string('bank_name', 191)->comment('打款人/收款人');
			$table->string('company_name', 191)->comment('公司名称');
			$table->boolean('type')->comment('进款/出款');
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
		Schema::drop('finance');
	}

}
