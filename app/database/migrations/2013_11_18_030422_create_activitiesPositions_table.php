<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivitiesPositionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activitiesPositions', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->unsignedInteger('id_activitiesProcess');
			$table->unsignedInteger('id_position');
			$table->primary(array('id_activitiesProcess', 'id_position'));
			$table->foreign('id_activitiesProcess')->references('id')->on('activitiesProcesses')->onDelete('cascade');
			$table->foreign('id_position')->references('id')->on('positions')->onDelete('cascade');
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
		Schema::drop('activitiesPositions');
	}

}