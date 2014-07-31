<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivitiesDepartmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activitiesDepartments', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->unsignedInteger('id_activitiesProcess');
			$table->unsignedInteger('id_department');
			$table->primary(array('id_activitiesProcess', 'id_department'));
			$table->foreign('id_activitiesProcess')->references('id')->on('activitiesProcesses')->onDelete('cascade');
			$table->foreign('id_department')->references('id')->on('departments')->onDelete('cascade');
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
		Schema::drop('activitiesDepartments');
	}

}