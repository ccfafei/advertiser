<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaLeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_leader', function (Blueprint $table) {
            $table->increments('leader_id');
            $table->string('leader_name')->unique()->comment('负责人');
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
        Schema::table('media_leader', function (Blueprint $table) {
            //
        });
    }
}
