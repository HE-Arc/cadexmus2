<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('notes', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('ligne_id')->unsigned();
            $table->float('duree');
            $table->integer('position');
            $table->timestamps();
        });
		
		Schema::table('notes', function (Blueprint $table) {
			$table->foreign('ligne_id')->references('id')->on('lignes');
			});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notes');
    }
}
