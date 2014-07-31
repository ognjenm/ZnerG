<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivitiesLevelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activitiesLevels', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->unsignedInteger('id_activitiesProcess');
			$table->unsignedInteger('id_level');
			$table->primary(array('id_activitiesProcess', 'id_level'));
			$table->foreign('id_activitiesProcess')->references('id')->on('activitiesProcesses')->onDelete('cascade');
			$table->foreign('id_level')->references('id')->on('levels')->onDelete('cascade');
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
		Schema::drop('activitiesLevels');
	}

}