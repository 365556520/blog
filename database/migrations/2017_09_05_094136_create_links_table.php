<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建表
        Schema::create('links', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('link_id');
            $table->string('link_name')->default('')->comment('//友情连接名称');
            $table->string('link_title')->default('')->comment('//友情连接标题');
            $table->string('link_url')->default('')->comment('//友情url连接');
            $table->integer('link_order')->default(0)->comment('//友情排序');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //删除表
        Schema::dropIfExists('links');
    }
}
