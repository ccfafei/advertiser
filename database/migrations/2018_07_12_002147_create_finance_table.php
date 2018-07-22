<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pay_ts')->comment('日期');
            $table->string('project')->comment('项目');
            $table->decimal('money', 8, 2)->comment('金额');
            $table->string('bank_account')->comment('账号');
            $table->string('bank_name')->comment('打款人/收款人');
            $table->string('company_name')->comment('公司名称');
            $table->tinyInteger('type')->comment('进款/出款');
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
        Schema::dropIfExists('finance');
    }
}
