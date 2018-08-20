<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueryImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('query_image', function (Blueprint $table) {
            $table->integer('query_id')->unsigned();
            $table->integer('image_id')->unsigned();

            // является уникальным
            $table->boolean('is_unique')->default(true);

            $table->foreign('query_id')->references('id')->on('query');
            $table->foreign('image_id')->references('id')->on('image');

            $table->primary(['query_id', 'image_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('query_image');
    }
}
