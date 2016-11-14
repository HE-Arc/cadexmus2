<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLigneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('lignes', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('projet_id')->unsigned();
            $table->string('sample');
            $table->integer('nobloc');
            $table->timestamps();
        });
		
		Schema::table('lignes', function($table) {
		$table->foreign('projet_id')->references('id')->on('projets');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lignes');
    }
}
