<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaChannelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_channel', function (Blueprint $table) {
           $table->increments('channel_id');
            $table->string('channel_name')->unique()->comment('分类名称名称');
            $table->text('remark')->nullable()->comment('备注');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media_channel', function (Blueprint $table) {
            //
        });
    }
}
