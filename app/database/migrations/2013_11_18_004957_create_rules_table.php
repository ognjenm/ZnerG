<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rules', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_initialActivity');
			$table->unsignedInteger('id_nextActivity');
			$table->unsignedInteger('id_typesRule');
			$table->string('logic',256)->nullable();
			$table->integer('secuence')->nullable();
			$table->string('message',256)->nullable();
			$table->foreign('id_initialActivity')->references('id')->on('activitiesProcesses')->onDelete('cascade');
			$table->foreign('id_finalActivity')->references('id')->on('activitiesProcesses')->onDelete('cascade');
			$table->foreign('id_typesRule')->references('id')->on('typesRules')->onDelete('cascade');
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
		Schema::drop('rules');
	}

}