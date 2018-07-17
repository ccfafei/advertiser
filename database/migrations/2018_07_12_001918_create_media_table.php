<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->increments('media_id');
            $table->string('media_name')->unique()->comment('媒体名称');
            $table->tinyInteger('category')->comment('媒体分类id');
            $table->tinyInteger('channel')->comment('频道id');
            $table->decimal('price', 5, 2)->comment('单价');
            $table->string('collection')->comment('收录');
            $table->string('cases')->comment('案例');
            $table->tinyInteger('leader')->comment('负责人id');
            $table->text('remark')->comment('备注');                  
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
        Schema::dropIfExists('media');
    }
}
