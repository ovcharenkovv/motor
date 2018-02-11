<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProgrammes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programmes', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('channel_id')->unsigned();
            $table->foreign('channel_id')
                ->references('id')->on('channels')
                ->onDelete('cascade');

            $table->dateTime('start');
            $table->dateTime('stop');

            $table->string('title');
            $table->string('descr');
            $table->date('date');
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
        Schema::drop('programme');
    }
}
