<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vendor_id')->unsigned();
            $table->boolean('visible')->default(true);
            $table->boolean('download')->default(false);
            $table->string('hash')->unique();
            $table->string('title');
            $table->string('description');
            $table->string('original');
            $table->string('source');

            $table->index('visible');
            $table->index('download');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('image');
    }
}